<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\PaymentMethod; // Import model PaymentMethod
use App\Models\Promotion;
use App\Models\Province;
use App\Models\Region;
use App\Models\Ward;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function showCheckout(Request $request)
    {
        // Lấy danh sách sản phẩm đã chọn từ input
        $selectedProducts = json_decode($request->input('selected_products'), true);

        // Kiểm tra nếu không có sản phẩm nào được chọn
        if (empty($selectedProducts)) {
            return redirect()->route('cart.view')->with('error', 'Bạn chưa chọn sản phẩm nào để thanh toán.');
        }

        // Lấy thông tin người dùng
        $user = Auth::user();
        $userId = auth()->id(); // Lấy ID người dùng hiện tại

        // Khởi tạo danh sách sản phẩm và tổng tiền
        $products = [];
        $totalAmount = 0;

        // Kiểm tra và xử lý các sản phẩm đã chọn
        foreach ($selectedProducts as $selectedProduct) {
            $cartId = $selectedProduct["cart_id"] ?? null; // Lấy cart_id từ sản phẩm
            $storageVariantId = $selectedProduct['storage_variant_id'] ?? null;
            $colorVariantId = $selectedProduct['color_variant_id'] ?? null;

            Log::info('Thông tin sản phẩm:', [
                'cart_id' => $cartId,
                'storage_variant_id' => $storageVariantId,
                'color_variant_id' => $colorVariantId,
                'session_key' => "cart_{$userId}.$cartId"
            ]);

            // Kiểm tra nếu cart_id không hợp lệ (null là không hợp lệ, nhưng 0 thì hợp lệ)
            if (is_null($cartId)) {
                return redirect()->route('cart.view')->with('error', 'Thông tin sản phẩm không hợp lệ.');
            }

            // Tạo key session dựa trên cart_id và user_id
            $cartSessionKey = "cart_{$userId}.$cartId"; // Key session

            // Kiểm tra xem có tồn tại sản phẩm trong session hay không
            if (!session()->has($cartSessionKey)) {
                return redirect()->route('cart.view')->with('error', "Sản phẩm với ID giỏ hàng $cartId không tồn tại.");
            }

            // Lấy sản phẩm từ session
            $product = session($cartSessionKey); // Lấy sản phẩm từ session

            // Kiểm tra và xử lý thông tin biến thể nếu có
            if ($storageVariantId || $colorVariantId) {
                if (is_null($storageVariantId) || is_null($colorVariantId)) {
                    return redirect()->route('cart.view')->with('error', 'Thông tin biến thể sản phẩm không hợp lệ.');
                }
                // Gắn thêm thông tin variant vào sản phẩm
                $product['storage_variant_id'] = $storageVariantId;
                $product['color_variant_id'] = $colorVariantId;
            }

            // Thêm sản phẩm vào danh sách
            $products[] = $product;

            // Tính tổng tiền
            $totalAmount += $product['price'] * $product['quantity'];
        }

        // Xử lý mã giảm giá nếu có
        $couponCode = $request->input('coupon_code');
        $discount = 0;
        if ($couponCode) {
            $coupon = Promotion::where('code', $couponCode)
                ->where('status', 'active')
                ->where('start_date', '<=', now())
                ->where(function ($query) {
                    $query->whereNull('end_date')
                        ->orWhere('end_date', '>=', now());
                })
                ->first();

            if ($coupon) {
                $discount = $coupon->type === 'percent'
                    ? $totalAmount * ($coupon->discount_value / 100)
                    : $coupon->discount_value;

                $totalAmount = max($totalAmount - $discount, 0); // Không để tổng tiền âm
            } else {
                return redirect()->route('cart.view')->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn.');
            }
        }

        // Lấy danh sách phương thức thanh toán và tỉnh/thành phố
        $paymentMethods = PaymentMethod::all();
        $provinces = Province::all(['id', 'name']);

        // Truyền dữ liệu vào view
        return view('client.checkout.index', compact(
            'products',
            'paymentMethods',
            'totalAmount',
            'user',
            'provinces',
            'discount'
        ));
    }




    // CheckoutController.php
    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');

        // Kiểm tra mã giảm giá
        $coupon = Promotion::select('id', 'discount_value', 'code', 'type', 'min_order_value')
            ->where('code', $couponCode)
            ->where('status', 'active')
            ->where('start_date', '<=', Carbon::today())
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', Carbon::today());
            })
            ->first();

        if (!$coupon) {
            return response()->json(['status' => 'error', 'message' => 'Mã giảm giá không hợp lệ'], 400);
        }

        $totalAmount = $request->input('totalAmount');

        // Kiểm tra giá trị đơn hàng tối thiểu (nếu có)
        if ($coupon->min_order_value && $totalAmount < $coupon->min_order_value) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đơn hàng không đủ điều kiện áp dụng mã giảm giá'
            ], 400);
        }

        // Tính giảm giá
        $discountAmount = 0;
        if ($coupon->type === 'percentage') {
            $discountAmount = ($totalAmount * $coupon->discount_value) / 100;
        } elseif ($coupon->type === 'fixed_amount') {
            $discountAmount = $coupon->discount_value;
        }

        // Đảm bảo số tiền giảm không lớn hơn tổng số tiền đơn hàng
        $discountAmount = min($discountAmount, $totalAmount);

        $finalAmount = $totalAmount - $discountAmount;

        // Trả về JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Mã giảm giá hợp lệ',
            'promotion_id' => $coupon->id,
            'discount' => $discountAmount,
            'final_amount' => $finalAmount,
        ]);
    }



    public function getDistricts($provinceId)
    {
        if (!$provinceId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tỉnh không hợp lệ.',
            ]);
        }

        $districts = District::where('province_id', $provinceId)
            ->select('id', 'name')
            ->get();
        return response()->json([
            'status' => 'success',
            'districts' => $districts,
        ]);
    }

    public function getWards($districtId)
    {
        // Kiểm tra `districtId` hợp lệ
        if (!$districtId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Huyện không hợp lệ.',
            ]);
        }

        // Lấy danh sách xã/phường từ cơ sở dữ liệu
        $wards = Ward::where('district_id', $districtId)
            ->select('id', 'name')
            ->get();

        // Trả về phản hồi JSON
        return response()->json([
            'status' => 'success',
            'wards' => $wards,
        ]);
    }
    public function getShippingFee(Request $request)
    {
        // Lấy các thông tin từ request
        $provinceId = $request->province_id;
        $districtId = $request->district_id;
        $wardId = $request->ward_id; // Nếu cần thiết

        // Kiểm tra nếu các thông tin này tồn tại
        if (!$provinceId || !$districtId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Thông tin tỉnh hoặc huyện không hợp lệ.',
            ]);
        }

        // Lấy giá ship từ bảng `districts`
        $district = District::where('province_id', $provinceId)
            ->where('id', $districtId)
            ->first();

        // Kiểm tra nếu không tìm thấy
        if (!$district) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy huyện này.',
            ]);
        }

        // Lấy giá ship từ thông tin huyện
        $shippingFee = $district->shipping_fee;

        // Trả về giá ship
        return response()->json([
            'status' => 'success',
            'shipping_fee' => $shippingFee,
        ]);
    }
}

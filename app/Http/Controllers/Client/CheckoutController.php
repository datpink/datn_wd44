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
use App\Models\UserPromotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function showCheckout(Request $request)
    {
        $userPromotions = UserPromotion::with('promotion')
            ->where('user_id', auth()->id())
            ->get()
            ->sortBy(function ($promotion) {
                // Sắp xếp các mã giảm giá theo trạng thái hết hạn, chưa hết hạn lên đầu
                return \Carbon\Carbon::parse($promotion->promotion->end_date)->isPast() ? 1 : 0;
            });

        // Lấy danh sách sản phẩm đã chọn từ input
        $selectedProducts = json_decode($request->input('selected_products'), true);

        // Kiểm tra nếu không có sản phẩm nào được chọn
        if (empty($selectedProducts)) {
            return redirect()->route('cart
            
            
            .view')->with('error', 'Bạn chưa chọn sản phẩm nào để thanh toán.');
        }

        // Lấy thông tin người dùng
        $user = Auth::user();
        $userId = auth()->id(); // Lấy ID người dùng hiện tại

        // Khởi tạo danh sách sản phẩm và tổng tiền
        $products = [];
        $totalAmount = 0;

        // Kiểm tra và xử lý các sản phẩm đã chọn
        foreach ($selectedProducts as $selectedProduct) {
            $cartId = $selectedProduct["cart_id"] ?? null;
            if (is_null($cartId)) {
                return redirect()->route('cart.view')->with('error', 'Thông tin sản phẩm không hợp lệ.');
            }

            $cartSessionKey = "cart_{$userId}.$cartId";

            if (!session()->has($cartSessionKey)) {
                return redirect()->route('cart.view')->with('error', "Sản phẩm với ID giỏ hàng $cartId không tồn tại.");
            }

            // Lấy sản phẩm từ session
            $product = session($cartSessionKey);

            // Cập nhật số lượng từ request
            $newQuantity = $selectedProduct['quantity'] ?? $product['quantity'];
            $product['quantity'] = $newQuantity;
            $product['total_price'] = (float) $product['price'] * (int) $newQuantity;


            // Cập nhật lại session
            session([$cartSessionKey => $product]);

            $products[] = $product;
            $totalAmount += (float) $product['price'] * (int) $newQuantity;

        }

        $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập

        // Tách địa chỉ
        $province = $district = $ward = null;
        if ($user->address) {
            // Tách chuỗi địa chỉ thành các phần (Tỉnh - Huyện - Xã)
            $addressParts = explode(' - ', $user->address);

            // Đảm bảo có đủ 3 phần: tỉnh - huyện - xã
            if (count($addressParts) >= 3) {
                $provinceName = trim($addressParts[0]); // Loại bỏ khoảng trắng thừa
                $districtName = trim($addressParts[1]);
                $wardName = trim($addressParts[2]);

                // Tìm tỉnh, huyện, xã/phường từ cơ sở dữ liệu
                $province = Province::where('name', 'like', "%$provinceName%")->first();
                $district = District::where('name', 'like', "%$districtName%")->first();
                $ward = Ward::where('name', 'like', "%$wardName%")->first();
            }
        }
        // dd($products)
        // Lấy danh sách phương thức thanh toán và tỉnh/thành phố
        $paymentMethods = PaymentMethod::all();
        $provinces = Province::all(['id', 'name']);
        // dd($products);
        // Truyền dữ liệu vào view
        return view('client.checkout.index', compact(
            'products',
            'paymentMethods',
            'totalAmount',
            'user',
            'provinces',
            'province',
            'district',
            'ward',
            'userPromotions'
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

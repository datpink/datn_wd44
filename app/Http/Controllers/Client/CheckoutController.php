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
        // Lấy danh sách ID sản phẩm từ input 'selected_products'
        $selectedProducts = json_decode($request->input('selected_products'), true);

        // Kiểm tra nếu không có sản phẩm nào được chọn
        if (empty($selectedProducts)) {
            return redirect()->route('cart.view')->with('error', 'Bạn chưa chọn sản phẩm nào để thanh toán.');
        }

        $user = Auth::user();

        // Lấy thông tin chi tiết của các sản phẩm đã chọn
        $products = [];
        $totalAmount = 0;
        foreach ($selectedProducts as $productId) {
            if (session("cart.$productId")) {
                $product = session("cart.$productId");
                $products[] = $product;

                // Tính tổng số tiền
                $totalAmount += $product['price'] * $product['quantity'];
            }
        }

        // Lấy danh sách phương thức thanh toán từ cơ sở dữ liệu
        $paymentMethods = PaymentMethod::all();

        // Kiểm tra xem người dùng đã chọn mã giảm giá chưa
        $couponCode = $request->input('coupon_code');
        $discount = 0;

        if ($couponCode) {
            // Kiểm tra mã giảm giá từ database hoặc áp dụng logic giảm giá
            $coupon = Promotion::where('code', $couponCode)
                ->where('status', 'active')
                ->where('start_date', '<=', now())
                ->where(function ($query) {
                    $query->whereNull('end_date')
                        ->orWhere('end_date', '>=', now());
                })
                ->first();

            if ($coupon) {
                // Giảm theo phần trăm
                $discount = $totalAmount * ($coupon->discount_value / 100);
                $totalAmount -= $discount;  // Giảm tổng tiền
            }
        }

        // Lấy danh sách các tỉnh để hiển thị trong dropdown
        $provinces = Province::all(['id', 'name']);

        // Khai báo mức phí vận chuyển cho các miền
        // Giả sử bạn đã gán các tỉnh vào các miền trước đó
        // Ví dụ: các tỉnh miền Bắc có shippingFee = 30000, miền Trung = 40000, miền Nam = 50000

        // Truyền dữ liệu vào view
        return view('client.checkout.index', compact('products', 'paymentMethods', 'totalAmount', 'user', 'provinces', 'discount'));
    }






    // CheckoutController.php
    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');

        // Kiểm tra mã giảm giá
        $coupon = Promotion::select('id', 'discount_value', 'code') // Lấy thêm ID
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

        Log::info('Promotion ID:', ['promotion_id' => $coupon->id]);
        // Tính giảm giá
        $totalAmount = $request->input('totalAmount');
        $discountAmount = ($totalAmount * $coupon->discount_value) / 100;
        $finalAmount = $totalAmount - $discountAmount;

        // Trả về JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Mã giảm giá hợp lệ',
            'promotion_id' => $coupon->id, // Trả về ID mã giảm giá
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

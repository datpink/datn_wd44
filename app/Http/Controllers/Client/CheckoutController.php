<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod; // Import model PaymentMethod
use App\Models\Promotion;
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
            return redirect()->back()->with('error', 'Bạn chưa chọn sản phẩm nào để thanh toán.');
        }

        // Lấy thông tin chi tiết của các sản phẩm đã chọn
        $products = [];
        foreach ($selectedProducts as $productId) {
            if (session("cart.$productId")) {
                $products[] = session("cart.$productId");
            }
        }

        // Lấy thông tin người dùng đã đăng nhập
        $user = Auth::user();

        // Lấy danh sách phương thức thanh toán từ cơ sở dữ liệu
        $paymentMethods = PaymentMethod::all();

        // Chuyển đến view thanh toán và truyền dữ liệu
        return view('client.checkout.index', compact('products', 'user', 'paymentMethods'));
    }
    // CheckoutController.php
    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');

        // Ghi giá trị của $couponCode vào log
        Log::info('Coupon Code:', ['coupon_code' => $couponCode]);

        // Kiểm tra mã giảm giá trong cơ sở dữ liệu
        $coupon = Promotion::where('code', $couponCode)
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

        // Lấy tổng tiền giỏ hàng từ session (hoặc từ cơ sở dữ liệu nếu cần)
        $totalAmount = session('total_amount'); // Giả sử bạn đã lưu tổng giỏ hàng ở đây

        // Tính giảm giá (giảm theo phần trăm)
        $discountAmount = ($totalAmount * $coupon->discount_value) / 100;

        // Tính tổng tiền sau khi áp dụng giảm giá
        $finalAmount = $totalAmount - $discountAmount;

        // Lưu giá trị giảm giá và tổng tiền sau giảm vào session
        session(['discount_value' => $discountAmount, 'coupon_code' => $coupon->code, 'final_amount' => $finalAmount]);

        return response()->json([
            'status' => 'success',
            'message' => 'Mã giảm giá hợp lệ',
            'discount' => $discountAmount, // Trả về giá trị giảm giá
            'final_amount' => $finalAmount  // Trả về tổng tiền sau giảm giá
        ]);
    }


}

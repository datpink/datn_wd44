<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod; // Import model PaymentMethod
use App\Models\Promotion;
use App\Models\Region;
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
            return redirect()->route('cart.index')->with('error', 'Bạn chưa chọn sản phẩm nào để thanh toán.');
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
            $coupon = Promotion::where('code', $couponCode)->first();
            if ($coupon && $coupon->status == 'active' && $coupon->start_date <= Carbon::today() && ($coupon->end_date === null || $coupon->end_date >= Carbon::today())) {
                // Giả sử mã giảm giá sẽ giảm một tỷ lệ phần trăm
                $discount = $totalAmount * ($coupon->discount_value / 100);
                $totalAmount -= $discount;  // Giảm tổng tiền
            }
        }

        // Lấy thông tin miền từ request hoặc session
        $regionId = $request->input('region');  // Lấy thông tin vùng miền từ input của request
        // Nếu không có thông tin trong request, bạn có thể lấy từ session:
        // $regionId = $request->session()->get('region');

        // Khai báo mức phí vận chuyển cho các miền
        $shippingFee = 0;

        // Kiểm tra xem có thông tin vùng miền không
        if ($regionId) {
            // Lấy thông tin vùng miền từ cơ sở dữ liệu (sử dụng model Region)
            $region = Region::find($regionId);

            // Nếu vùng miền tồn tại, áp dụng phí vận chuyển tương ứng
            if ($region) {
                switch ($region->id) {
                    case 'north': // Miền Bắc
                        $shippingFee = 30000; // 30k
                        break;
                    case 'central': // Miền Trung
                        $shippingFee = 40000; // 40k
                        break;
                    case 'south': // Miền Nam
                        $shippingFee = 50000; // 50k
                        break;
                    default:
                        $shippingFee = 0; // Không tính phí nếu không có vùng miền
                        break;
                }
                $totalAmount += $shippingFee; // Cộng phí vận chuyển vào tổng tiền
            }
        }

        // Lấy danh sách các vùng miền từ cơ sở dữ liệu
        $regions = Region::all(); // Hoặc bạn có thể sử dụng một mảng dữ liệu trong trường hợp chưa có bảng trong DB

        // Chuyển đến view thanh toán và truyền dữ liệu
        return view('client.checkout.index', compact('products', 'paymentMethods', 'totalAmount', 'user', 'regions', 'discount', 'shippingFee', 'regionId'));
    }





    // CheckoutController.php
    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');
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
        Log::info('Request Input:', $request->all()); // Ghi lại tất cả các input trong request
        $totalAmount = $request->input('totalAmount');

        $totalAmount = $request->totalAmount;
        // Log::info('Total Amount:', ['total_amount' => $totalAmount]);
        // Giả sử bạn đã lưu tổng giỏ hàng ở đây

        // Tính giảm giá (giảm theo phần trăm)
        $discountAmount = ($totalAmount * $coupon->discount_value) / 100;

        // Tính tổng tiền sau khi áp dụng giảm giá
        $finalAmount = $totalAmount - $discountAmount;

        // Lưu giá trị giảm giá và tổng tiền sau giảm vào session
        session(['discount_value' => $discountAmount, 'coupon_code' => $coupon->code, 'final_amount' => $finalAmount]);
        Log::info('Coupon Code:', ['coupon_code' => $discountAmount]);
        return response()->json([
            'status' => 'success',
            'message' => 'Mã giảm giá hợp lệ',
            'discount' => $discountAmount, // Trả về giá trị giảm giá
            'final_amount' => $finalAmount  // Trả về tổng tiền sau giảm giá
        ]);
    }
}

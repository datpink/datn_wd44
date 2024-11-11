<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod; // Import model PaymentMethod
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $selectedProducts = $request->input('products');

        // Lấy thông tin chi tiết sản phẩm từ database dựa trên $selectedProducts
        $products = Product::whereIn('id', array_column($selectedProducts, 'id'))->get();

        // Truyền dữ liệu sang view checkout
        return view('checkout.index', compact('products', 'selectedProducts'));
    }

    public function store(Request $request)
    {
        // Xử lý logic thanh toán
        // Kiểm tra thông tin đầu vào, lưu trữ đơn hàng, ...

        // Ví dụ kiểm tra thông tin thanh toán
        $request->validate([
            'billing_first_name' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            // Thêm các trường khác cần thiết
        ]);

        // Thực hiện thanh toán, có thể sử dụng PayPal, Stripe hoặc phương thức thanh toán khác

        // Sau khi thành công, chuyển hướng đến trang cảm ơn
        return redirect()->route('thankyou')->with('success', 'Đơn hàng đã được đặt thành công!');
    }
}

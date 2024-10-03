<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product; // Đảm bảo đã import mô hình Product
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Lấy tất cả sản phẩm từ cơ sở dữ liệu
        $products = Product::paginate(6); // Bạn có thể thêm các điều kiện khác nếu cần
        return view('client.products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id); // Lấy sản phẩm theo ID
        return view('client.products.product-detail', compact('product'));
    }
}

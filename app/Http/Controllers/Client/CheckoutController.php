<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{

    public function checkout(Request $request)
    {
        // Lấy danh sách sản phẩm được chọn từ giỏ hàng
        $items = $request->input('items', []);

        // Lấy thông tin sản phẩm từ giỏ hàng dựa vào các id đã chọn
        $selectedItems = [];
        foreach ($items as $id => $value) {
            if (session()->has("cart.$id")) {
                $selectedItems[] = [
                    'id' => $id,
                    'name' => session("cart.$id.name"),
                    'quantity' => session("cart.$id.quantity"),
                    'price' => session("cart.$id.price"),
                    'total' => session("cart.$id.price") * session("cart.$id.quantity"),
                ];
            }
        }

        // Hiện thị trang thanh toán với danh sách sản phẩm được chọn
        return view('client.checkout', compact('selectedItems'));
    }


}

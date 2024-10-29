<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use function Laravel\Prompts\alert;

class CartController extends Controller
{

    public function view(){
        return view('client.you-cart.viewcart');
    }


    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $variantId = $request->input('variant_id', null); // Đặt giá trị mặc định là null nếu không có
        $quantity = $request->input('quantity');
        $selectedStorage = $request->input('selected_storage');
        $selectedColor = $request->input('selected_color');
        $productImage = $request->input('product_image');

        // Tìm sản phẩm
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['message' => 'Sản phẩm không tồn tại.'], 404);
        }

        // Kiểm tra số lượng
        if ($quantity <= 0) {
            return response()->json(['message' => 'Số lượng phải lớn hơn 0.'], 400);
        }

        // Lưu vào session
        $cart = session()->get('cart', []);

        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
        $existingItemKey = null; // Khóa sản phẩm nếu đã tồn tại
        foreach ($cart as $key => $item) {
            if ($item['id'] == $productId && $item['options']['variant_id'] == $variantId) {
                $existingItemKey = $key;
                break;
            }
        }

        // Nếu sản phẩm đã tồn tại, cập nhật số lượng
        if ($existingItemKey !== null) {
            $cart[$existingItemKey]['quantity'] += $quantity; // Cộng thêm số lượng
        } else {
            // Nếu chưa tồn tại, tạo item giỏ hàng
            $item = [
                'id' => $productId,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'options' => [
                    'variant_id' => $variantId,
                    'storage' => $selectedStorage,
                    'color' => $selectedColor,
                    'image' => $productImage,
                ],
            ];

            $cart[] = $item; // Thêm sản phẩm vào giỏ hàng
        }

        session()->put('cart', $cart); // Cập nhật giỏ hàng vào session

        return response()->json(['message' => 'Đã thêm vào giỏ hàng.']);
    }






    public function remove($id)
    {
        // Lấy giỏ hàng từ session
        $cart = session()->get('cart');

        // Kiểm tra xem sản phẩm có trong giỏ hàng không
        if (isset($cart[$id])) {
            // Xóa sản phẩm khỏi giỏ hàng
            unset($cart[$id]);
            session()->put('cart', array_values($cart)); // Cập nhật giỏ hàng vào session

            // Chuyển hướng về trang giỏ hàng với thông báo
            // in ra thông báo thành công
        }

        return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
    }


}

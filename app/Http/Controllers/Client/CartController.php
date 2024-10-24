<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        try {
            $product = null;
            if ($request->has('variant_id')) {
                $product = ProductVariant::find($request->variant_id);
            } elseif ($request->has('product_id')) {
                $product = Product::find($request->product_id);
            }

            if (!$product) {
                return response()->json(['message' => 'Sản phẩm không tồn tại.'], 404);
            }

            // Logic thêm vào giỏ hàng
            // Ví dụ: session()->push('cart', $product);
            // Hoặc với số lượng
            session()->push('cart', [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->input('quantity', 1)
            ]);

            return response()->json([
                'message' => 'Thêm vào giỏ hàng thành công.',
                'cart_count' => count(session()->get('cart', []))
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Có lỗi xảy ra. Vui lòng thử lại.'], 500);
        }
    }

    public function remove(Request $request)
    {
        $productId = $request->input('product_id');

        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);

        // Xóa sản phẩm khỏi giỏ hàng nếu nó tồn tại
        if (isset($cart[$productId])) {
            unset($cart[$productId]);

            // Cập nhật lại giỏ hàng trong session
            session()->put('cart', $cart);

            // Cập nhật lại tổng số lượng sản phẩm trong giỏ hàng
            $cartCount = count($cart);

            return response()->json([
                'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng.',
                'cart_count' => $cartCount
            ]);
        }

        return response()->json(['message' => 'Sản phẩm không tồn tại trong giỏ hàng.'], 404);
    }
}

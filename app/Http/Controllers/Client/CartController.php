<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Model\User;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\alert;

class CartController extends Controller
{

    public function view()
    {
        $discountCodes = [];

        if (auth()->check()) {
            $id = auth()->id();
            $user = auth()->user();

            dd(session("cart_{$id}"));
            // Lấy các mã giảm giá chưa dùng và có trạng thái active
            $discountCodes = $user->promotions()
                ->wherePivot('is_used', false)
                ->where('status', 'active')
                ->get();
        }

        return view('client.you-cart.viewcart', compact('discountCodes', 'id'));
    }


    public function temporary()
    {
        return view('client.you-cart.you-cart'); // Render lại view của giỏ hàng tạm
    }

    public function add(Request $request)
    {
        Log::info($request->all());

        $userId = auth()->id();
        if (!$userId) {
            return response()->json(['message' => 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.'], 401);
        }

        $productId = $request->input('product_id');
        $variantId = $request->input('variant_id'); // Có thể null nếu không có biến thể
        $quantity = $request->input('quantity', 1);
        $price = $request->input('price'); // Giá sản phẩm gửi từ frontend
        $imageUrl = $request->input('image_url');
        // Tạo hoặc cập nhật giỏ hàng
        $cart = session()->get("cart_{$userId}", []);

        // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng chưa
        $existingItemKey = null;
        foreach ($cart as $key => $item) {
            if (
                $item['id'] == $productId &&
                $item['options']['variant_id'] == $variantId // Kiểm tra cả biến thể
            ) {
                $existingItemKey = $key;
                break;
            }
        }
        $productVariant = ProductVariant::find($variantId);

        $attributeValues = $productVariant ? $productVariant->attributeValues : null;

        if ($existingItemKey !== null) {
            $cart[$existingItemKey]['quantity'] += $quantity; // Cập nhật số lượng
        } else {
            $cart[] = [
                'id' => $productId,
                'name' => Product::find($productId)->name ?? 'Sản phẩm không xác định',
                'price' => $price,
                'quantity' => $quantity,
                'options' => [
                    'variant_id' => $variantId,
                    'variant' => $attributeValues,
                    'image' => $imageUrl,
                ],
            ];
        }

        session()->put("cart_{$userId}", $cart);

        return response()->json(['message' => 'Đã thêm vào giỏ hàng.']);
    }









    public function removeFromCart($id)
    {
        $cart = session()->get('cart_' . auth()->id());
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart_' . auth()->id(), $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng',
            'cartCount' => count($cart) // Số lượng sản phẩm sau khi xóa
        ]);
    }
}

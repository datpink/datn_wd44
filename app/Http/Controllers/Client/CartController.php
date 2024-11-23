<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
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
        $userId = auth()->id();
        if (!$userId) {
            return response()->json(['message' => 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.'], 401);
        }

        $productId = $request->input('product_id');
        $variantIds = $request->input('variant_ids', []); // Lấy mảng variant_ids từ request
        $quantity = $request->input('quantity', 1);
        $price = $request->input('price');

        // Log kiểm tra dữ liệu
        info('Variant IDs:', ['variantIds' => $variantIds]);

        // Kiểm tra biến có đủ phần tử
        if (!is_array($variantIds) || count($variantIds) < 2) {
            return response()->json(['message' => 'Cần chọn cả dung lượng và màu sắc.'], 400);
        }

        // Gán giá trị từ mảng
        $storageVariantId = $variantIds[0] ?? null; // Dung lượng
        $colorVariantId = $variantIds[1] ?? null; // Màu sắc

        // Tạo hoặc cập nhật giỏ hàng
        $cart = session()->get("cart_{$userId}", []);

        $existingItemKey = null;
        foreach ($cart as $key => $item) {
            if (
                $item['id'] == $productId &&
                $item['options']['storage_variant_id'] == $storageVariantId &&
                $item['options']['color_variant_id'] == $colorVariantId
            ) {
                $existingItemKey = $key;
                break;
            }
        }

        if ($existingItemKey !== null) {
            $cart[$existingItemKey]['quantity'] += $quantity;
        } else {
            $item = [
                'id' => $productId,
                'name' => Product::find($productId)->name,
                'price' => $price,
                'quantity' => $quantity,
                'options' => [
                    'storage_variant_id' => $storageVariantId,
                    'color_variant_id' => $colorVariantId,
                    'storage' => $request->input('selected_storage'),
                    'color' => $request->input('selected_color'),
                    'image' => $request->input('product_image'),
                ],
            ];
            $cart[] = $item;
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

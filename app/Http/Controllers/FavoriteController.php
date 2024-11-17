<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{
    // // Add to favorites
    // public function addFavorite($productId)
    // {
    //     $user = Auth::user();
    //     $user->favorites()->attach($productId);
    //     return response()->json(['message' => 'Sản phẩm đã được thêm vào yêu thích']);
    // }

    // public function removeFavorite($productId)
    // {
    //     $user = Auth::user();
    //     $user->favorites()->detach($productId);
    //     return response()->json(['message' => 'Sản phẩm đã được xóa khỏi yêu thích']);
    // }


    public function addFavorite($productId)
    {
        $user = Auth::user();

        // Kiểm tra nếu người dùng đã đăng nhập
        if (!$user) {
            return response()->json(['message' => 'Bạn cần đăng nhập để thực hiện thao tác này'], 401);
        }

        $user->favorites()->attach($productId);
        return response()->json(['message' => 'Sản phẩm đã được thêm vào yêu thích']);
    }

    public function removeFavorite($productId)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Bạn cần đăng nhập để thực hiện thao tác này'], 401);
        }

        $user->favorites()->detach($productId);
        return response()->json(['message' => 'Sản phẩm đã được xóa khỏi yêu thích']);
    }
}

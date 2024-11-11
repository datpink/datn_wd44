<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // Add to favorites
    public function addFavorite($productId)
    {
        $user = Auth::user();
        $user->favorites()->attach($productId);
        return response()->json(['message' => 'Sản phẩm đã được thêm vào yêu thích']);
    }

    public function removeFavorite($productId)
    {
        $user = Auth::user();
        $user->favorites()->detach($productId);
        return response()->json(['message' => 'Sản phẩm đã được xóa khỏi yêu thích']);
    }
}

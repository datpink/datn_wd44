<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            // Tìm kiếm trong các model Product, Post và Category
            $products = Product::where('name', 'LIKE', "%{$query}%")->get();
            $posts = Post::where('title', 'LIKE', "%{$query}%")->get();
            $categories = Category::where('name', 'LIKE', "%{$query}%")->get();

            // Trả về kết quả tìm kiếm
            return response()->json([
                'products' => $products,
                'posts' => $posts,
                'categories' => $categories,
            ]);
        }

        return response()->json([]);
    }
}

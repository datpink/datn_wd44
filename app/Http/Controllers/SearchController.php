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

        // Tìm kiếm trong bảng sản phẩm
        $products = Product::where('name', 'LIKE', "%{$query}%")
                            ->orWhere('description', 'LIKE', "%{$query}%")
                            ->take(5) // Giới hạn số lượng kết quả trả về
                            ->get();
        
        // Tìm kiếm trong bảng bài viết
        $posts = Post::where('title', 'LIKE', "%{$query}%")
                     ->orWhere('tomtat', 'LIKE', "%{$query}%")
                     ->take(5)
                     ->get();
        
        // Tìm kiếm trong bảng danh mục
        $categories = Category::where('name', 'LIKE', "%{$query}%")
                              ->take(5)
                              ->get();
        
        // Kết hợp tất cả kết quả tìm kiếm
        return response()->json([
            'products' => $products,
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    // Chức năng gợi ý và tự động hoàn thành
    public function autocomplete(Request $request)
    {
        $query = $request->input('query');

        // Tìm kiếm gợi ý từ sản phẩm
        $suggestions = Product::where('name', 'LIKE', "%{$query}%")
                                ->take(5)
                                ->get()
                                ->pluck('name'); // Chỉ trả về tên sản phẩm

        return response()->json($suggestions);
    }
}

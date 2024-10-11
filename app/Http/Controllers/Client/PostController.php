<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;


class PostController extends Controller
{
    // Hiển thị danh sách tất cả bài viết
    public function index()
    {
        $posts = Post::join('users', 'posts.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name as author_name')
            ->paginate(9);

        return view('client.posts.index', compact('posts'));
    }
    public function show($id)
    {
        $product = Post::findOrFail($id); // Lấy sản phẩm theo ID
        return view('client.products.product-detail', compact('product'));
    }
}


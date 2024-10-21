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
        $post = Post::join('users', 'posts.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name as author_name')
            ->where('posts.id', $id)
            ->firstOrFail();

        return view('client.posts.post-detail', compact('post'));
    }
    public function search(Request $request)
    {
        $query = $request->input('s');
        $posts = Post::join('users', 'posts.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name as author_name')
            ->where('posts.title', 'LIKE', "%{$query}%")
            ->orWhere('posts.tomtat', 'LIKE', "%{$query}%")
            ->orWhere('posts.slug', 'LIKE', "%{$query}%")
            ->paginate(9); // Thêm phân trang nếu cần

        return view('client.posts.search-results', compact('posts'));
    }

}


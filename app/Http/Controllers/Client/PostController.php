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
        $post = Post::findOrFail($id); // Lấy bài viết theo ID
        return view('client.posts.post-detail', compact('post'));
    }
    public function search(Request $request)
{
    $query = $request->input('s');
    $posts = Post::where('title', 'LIKE', "%{$query}%")
    ->orWhere('tomtat', 'LIKE', "%{$query}%")
    ->orWhere('slug', 'LIKE', "%{$query}%")
    ->get();

    return view('client.posts.search-results', compact('posts'));
}

}


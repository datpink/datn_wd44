<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Hiển thị danh sách tất cả bài viết
    public function index()
    {
        // Lấy tất cả bài viết với thông tin tác giả
        $posts = Post::join('users', 'posts.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name as author_name')
            ->paginate(9);

        // Trả về view với danh sách bài viết
        return view('client.posts.index', compact('posts'));
    }

    // Lấy 5 bài viết mới nhất
    public function getLatestPosts()
    {
        return Post::join('users', 'posts.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name as author_name')
            ->orderBy('posts.created_at', 'desc')
            ->limit(5)
            ->get();
    }

    // Hiển thị chi tiết bài viết
    public function show($id)
    {
        $post = Post::join('users', 'posts.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name as author_name')
            ->where('posts.id', $id)
            ->firstOrFail();
        $post1 = Post::with('comments')->findOrFail($id);
        return view('client.posts.post-detail', compact('post','post1'));
    }
    public function storeComment(Request $request, $id)
{
    $request->validate([
        'author' => 'required|string|max:255',
        'email' => 'required|email',
        'comment' => 'required|string',
    ]);

    $post = Post::findOrFail($id);

   Comment::create([
    'post_id' => $post->id,
    'user_id' => auth()->id(), // Hoặc giá trị khác để đặt user_id
    'author_name' => $request->input('author'),
    'email' => $request->input('email'),
    'content' => $request->input('comment'),
]);

    

    // Điều hướng đúng về trang chi tiết bài viết
    return redirect()->route('post.show', ['id' => $post->id])->with('success', 'Bình luận đã được gửi!');
}

    // Tìm kiếm bài viết
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


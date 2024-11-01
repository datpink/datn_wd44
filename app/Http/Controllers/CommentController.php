<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        // Validate dữ liệu từ form bình luận
        $request->validate([
            'author' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string'
        ]);

        // Lấy bài viết từ ID
        $post = Post::findOrFail($postId);

        // Tạo mới bình luận liên quan đến bài viết
        $post->comments()->create([
            'user_id' => auth()->id(), // Đảm bảo người dùng đã đăng nhập, nếu không cần kiểm tra trước
            'content' => $request->input('comment') // Chuyển 'comment' thành 'content' theo tên trường trong `$fillable`
        ]);

        // Chuyển hướng lại trang chi tiết bài viết với thông báo thành công
        return redirect()->route('post.show', $postId)->with('success', 'Bình luận của bạn đã được đăng.');
    }
}

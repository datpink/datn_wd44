<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommentReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentReplyController extends Controller
{
    public function editReply($commentId, $replyId)
    {
        $reply = CommentReply::findOrFail($replyId);
        return view('admin.comments.edit_reply', compact('reply', 'commentId'));
    }

    public function updateReply(Request $request, $commentId, $replyId)
    {
        $validated = $request->validate([
            'reply' => 'required|string',
        ]);

        $reply = CommentReply::findOrFail($replyId);
        $reply->update(['reply' => $validated['reply']]);

        return redirect()->route('comments.index')->with('updateReply', 'Phản hồi đã được cập nhật.');
    }


    // Phương thức xóa phản hồi
    public function destroy($id)
    {
        $reply = CommentReply::findOrFail($id);

        // Kiểm tra quyền hạn
        if ($reply->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa phản hồi này.');
        }

        // Xóa mềm phản hồi
        $reply->delete();

        return redirect()->back()->with('success', 'Phản hồi đã được xóa thành công.');
    }
}

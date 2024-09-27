<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommentReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        DB::beginTransaction();

        try {
            $reply = CommentReply::findOrFail($replyId);
            $reply->update(['reply' => $validated['reply']]);
            DB::commit();

            return redirect()->route('comments.index')->with('updateReply', 'Phản hồi đã được cập nhật.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('comments.index')->with('error', 'Có lỗi xảy ra: ' . $th->getMessage());
        }
    }

    // Phương thức xóa phản hồi
    public function destroy($id)
    {
        $reply = CommentReply::findOrFail($id);

        // Kiểm tra quyền hạn
        if ($reply->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa phản hồi này.');
        }

        DB::beginTransaction();

        try {
            // Xóa mềm phản hồi
            $reply->delete();
            DB::commit();

            return redirect()->back()->with('success', 'Phản hồi đã được xóa thành công.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $th->getMessage());
        }
    }
}
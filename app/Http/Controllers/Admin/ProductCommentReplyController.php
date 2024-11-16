<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCommentReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductCommentReplyController extends Controller
{
    // Hiển thị form chỉnh sửa trả lời của bình luận sản phẩm
    public function editReply($commentId, $replyId)
    {
        $reply = ProductCommentReply::findOrFail($replyId);
        return view('admin.product_comments.edit_reply', compact('reply', 'commentId'));
    }

    // Cập nhật trả lời của bình luận sản phẩm
    public function updateReply(Request $request, $commentId, $replyId)
    {
        $validated = $request->validate([
            'reply' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $reply = ProductCommentReply::findOrFail($replyId);
            $reply->update(['reply' => $validated['reply']]);
            DB::commit();

            return redirect()->route('product-comments.index')->with('updateReply', 'Phản hồi đã được cập nhật.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('product-comments.index')->with('error', 'Có lỗi xảy ra: ' . $th->getMessage());
        }
    }

    // Phương thức xóa phản hồi của bình luận sản phẩm
    public function destroy($id)
    {
        $reply = ProductCommentReply::findOrFail($id);

        // Kiểm tra quyền sở hữu
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

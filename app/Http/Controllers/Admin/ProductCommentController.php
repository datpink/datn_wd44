<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductComment;
use App\Models\CommentReply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductCommentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $productComments = ProductComment::with(['user', 'product', 'replies']) // Đổi thành 'replies'
            ->when($search, function ($query, $search) {
                $query->where('content', 'LIKE', "%{$search}%");
            })
            ->get();

        return view('admin.product_comments.list', compact('productComments'));
    }

    public function destroy($id)
    {
        $comment = ProductComment::findOrFail($id);
        $comment->delete();

        return redirect()->route('product-comments.index')->with('destroyComment', true);
    }

    public function respond(Request $request, $id)
    {
        try {
            $request->validate([
                'response' => 'required|string|max:500'
            ]);
            $comment = ProductComment::findOrFail($id);
            $comment->replies()->create([
                'user_id' => auth()->id(),
                'reply' => $request->response,
            ]);

            return redirect()->route('product-comments.index')->with('respond', 'Phản hồi đã được gửi.');
        } catch (\Throwable $th) {

            return $th->getMessage();
            return redirect()->route('comments.index')->with('respondError', 'Có lỗi xảy ra khi gửi phản hồi.');
        }
    }

    public function updateReply(Request $request, ProductComment $comment, CommentReply $reply)
    {
        $request->validate([
            'reply' => 'required|string|max:500'
        ]);

        $reply->update(['reply' => $request->reply]);

        return redirect()->route('product-comments.index')->with('updateReply', true);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Danh Sách Bình Luận';
        $comments = Comment::with(['user', 'post', 'commentReplys.user']);
        $search = $request->input('search');

        if ($search) {
            $comments->where(function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('post', function ($q) use ($search) {
                        $q->where('title', 'like', '%' . $search . '%');
                    })
                    ->orWhere('content', 'like', '%' . $search . '%');
            });
        }
        $comments = $comments->paginate(10);
        return view('admin.comments.list', compact('comments', 'title'));
    }


    public function respond(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'response' => 'required|string',
            ]);

            $comment = Comment::findOrFail($id);
            $comment->commentReplys()->create([
                'reply' => $request->input('response'),
                'user_id' => auth()->id(), // Lưu người dùng hiện tại
            ]);

            return redirect()->route('comments.index')->with('respond', 'Phản hồi đã được gửi.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('comments.index')->with('respondError', 'Phản hồi đã được gửi.');
        }
    }

    public function destroy($id)
    {
        $comment = Comment::with(['commentReplys'])->findOrFail($id);
        $comment->commentReplys()->delete(); // Soft delete các phản hồi
        $comment->delete(); // Soft delete bình luận
        return redirect()->route('comments.index')->with('destroyComment', 'Bình luận đã được xóa.');
    }

    public function trash()
    {
        $title = 'Thùng Rác';
        // Lấy tất cả các bình luận đã bị xóa mềm cùng với các phản hồi đã bị xóa mềm và người dùng của phản hồi
        $comments = Comment::with(['user', 'post', 'commentReplys' => function ($query) {
            $query->withTrashed()->with('user');
        }])->onlyTrashed()->get();

        // Để kiểm tra cấu trúc dữ liệu (chỉ dùng khi debug)
        // dd($comments->toArray());

        return view('admin.comments.trash', compact('comments', 'title'));
    }

    public function restore(string $id)
    {
        $comment = Comment::with(['commentReplys'])->onlyTrashed()->findOrFail($id);
        $comment->restore(); // Khôi phục bình luận

        // Khôi phục các phản hồi nếu cần
        $comment->commentReplys()->withTrashed()->restore();

        return redirect()->route('comments.trash')->with('success', 'Bình luận đã được khôi phục thành công!');
    }

    public function deletePermanently($id)
    {
        $comment = Comment::onlyTrashed()->findOrFail($id);
        // if ($comment->products()->exists()) {
        //     return redirect()->route('comments.trash')->with('deletePermanently', 'Xóa vĩnh viễn thành công');
        //     // return redirect()->route('comments.trash')->with('error', 'Không thể xóa cứng thương hiệu này vì nó có sản phẩm liên quan.');
        // }
        $comment->forceDelete();

        return redirect()->route('comments.trash')->with('deletePermanently', 'Xóa vĩnh viễn thành công');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}

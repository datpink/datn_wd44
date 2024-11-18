<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Tìm kiếm bình luận
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

        // Lọc theo ngày tạo bình luận
        if ($request->has('comment_date') && $request->comment_date) {
            $comments->whereDate('created_at', $request->comment_date);
        }

        // Lọc theo ngày phản hồi
        if ($request->has('reply_date') && $request->reply_date) {
            $comments->whereHas('commentReplys', function ($query) use ($request) {
                $query->whereDate('created_at', $request->reply_date);
            });
        }

        // Lọc theo trạng thái phản hồi
        if ($request->has('responded') && $request->responded !== '') {
            if ($request->responded === '1') {
                $comments->whereHas('commentReplys'); // Đã phản hồi
            } else {
                $comments->whereDoesntHave('commentReplys'); // Chưa phản hồi
            }
        }

        // Phân trang và lấy danh sách bình luận
        $comments = $comments->paginate(10);

        return view('admin.comments.list', compact('comments', 'title'));
    }

    public function respond(Request $request, $id)
    {
        // dd($request->all());
        // dd(123);
        try {
            $validated = $request->validate([
                'response' => 'required|string',
            ]);

            $comment = Comment::findOrFail($id);
            $comment->commentReplys()->create([
                'reply' => $validated['response'],
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('comments.index')->with('respond', 'Phản hồi đã được gửi.');
        } catch (\Throwable $th) {

            return $th->getMessage();
            // return redirect()->route('comments.index')->with('respondError', 'Có lỗi xảy ra khi gửi phản hồi.');
        }
    }

    public function destroy($id)
    {
        $comment = Comment::with(['commentReplys'])->findOrFail($id);

        DB::beginTransaction();

        try {
            $comment->commentReplys()->delete(); // Soft delete các phản hồi
            $comment->delete(); // Soft delete bình luận
            DB::commit();

            return redirect()->route('comments.index')->with('destroyComment', 'Bình luận đã được xóa.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('comments.index')->with('error', 'Có lỗi xảy ra khi xóa bình luận.');
        }
    }

    public function trash()
    {
        $title = 'Thùng Rác';
        $comments = Comment::with([
            'user',
            'post',
            'commentReplys' => function ($query) {
                $query->withTrashed()->with('user');
            }
        ])->onlyTrashed()->get();

        return view('admin.comments.trash', compact('comments', 'title'));
    }

    public function restore(string $id)
    {
        DB::beginTransaction();

        try {
            $comment = Comment::with(['commentReplys'])->onlyTrashed()->findOrFail($id);
            $comment->restore(); // Khôi phục bình luận
            $comment->commentReplys()->withTrashed()->restore(); // Khôi phục phản hồi

            DB::commit();
            return redirect()->route('comments.trash')->with('success', 'Bình luận đã được khôi phục thành công!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('comments.trash')->with('error', 'Có lỗi xảy ra khi khôi phục bình luận.');
        }
    }

    public function deletePermanently($id)
    {
        DB::beginTransaction();

        try {
            $comment = Comment::onlyTrashed()->findOrFail($id);
            $comment->forceDelete(); // Xóa vĩnh viễn

            DB::commit();
            return redirect()->route('comments.trash')->with('deletePermanently', 'Xóa vĩnh viễn thành công');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('comments.trash')->with('error', 'Có lỗi xảy ra khi xóa vĩnh viễn bình luận.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Trả về view để tạo bình luận mới nếu cần thiết
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xử lý lưu bình luận mới nếu cần thiết
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Trả về view để xem chi tiết bình luận nếu cần thiết
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Trả về view để chỉnh sửa bình luận nếu cần thiết
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Xử lý cập nhật bình luận nếu cần thiết
    }
}

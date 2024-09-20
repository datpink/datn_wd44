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
    public function index()
    {
        $comments = Comment::with(['user', 'post', 'commentReplys.user'])->get();
        return view('admin.comments.list', compact('comments'));
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
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->route('comments.index')->with('destroyComment', 'Bình luận đã được xóa.');
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

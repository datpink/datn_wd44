<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostPart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('category', 'parts')->orderBy('id', 'desc')->get();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        // dd($request->all());
        DB::beginTransaction();

        try {
            $user_id = Auth::user()->id;
            $post = Post::create([
                'category_id'   => $request->category_id,
                'title'         => $request->title,
                'summary'       => $request->summary,
                'user_id'       => $user_id,
                'created_at'    => now(),
            ]);
            foreach ($request->post_parts as $part) {
                $data = [
                    'post_id'   => $post->id,
                    'type'      => $part['type'],
                    'content'   => $part['content'] ?? null,
                    'order'     => $part['order'],
                ];

                if ($part['type'] === 'image' && isset($part['image'])) {
                    $path = Storage::put('images', $part['image']);
                    $data['image'] = $path;
                }

                PostPart::create($data);
            }

            DB::commit();

            return redirect()->route('posts.index')
                             ->with('success', 'Thêm mới tin hành công!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating article: ' . $e->getMessage());
            return back()->withErrors('Error creating article: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */

    // public function show(Post $post)
    // {
    //     $post->load('parts'); // Eager load parts
    //     return view('admin.posts.index', compact('article'));
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'summary' => 'required',
            'category_id' => 'required',
            'post_parts.*.type' => 'required',
            'post_parts.*.order' => 'nullable|integer',
            'post_parts.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post->update([
            'title' => $request->input('title'),
            'summary' => $request->input('summary'),
            'category_id' => $request->input('category_id'),
            'user_id' => auth()->user()->id,
        ]);

        foreach ($request->post_parts as $index => $partData) {
            $postPart = $post->parts()->updateOrCreate(
                ['id' => $partData['id'] ?? null],
                [
                    'type' => $partData['type'],
                    'content' => $partData['content'] ?? null,
                    'order' => $partData['order'],
                ]
            );

            if ($request->file("post_parts.$index.image")) {
                $imagePath = $request->file("post_parts.$index.image")->store('post_images', 'public');
                $postPart->update(['image' => $imagePath]);
            }
        }

        return redirect()->route('posts.index')->with('success', 'Cập nhật bài viết thành công!');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('posts.trash')->with('success', 'Bài viết đã được khôi phục.');
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Bài viết đã được xóa.');
    }
    public function trash()
    {
        $trash = $posts = Post::onlyTrashed()->with(['parts' => function ($query) {
            $query->withTrashed(); // Đảm bảo lấy các phần bị xóa mềm
        }])->get();
        return view('admin.posts.trash', compact('trash'));
    }


    public function forceDelete($id)
    {
        $post = Post::withTrashed()->find($id);
        $post->forceDelete();

        return redirect()->route('posts.trash')->with('success', 'Bài viết đã được xóa vĩnh viễn.');
    }
}

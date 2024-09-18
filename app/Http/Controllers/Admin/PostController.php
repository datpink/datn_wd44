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

    public function show(Post $post)
    {
        $post->load('parts'); // Eager load parts
        return view('admin.posts.index', compact('article'));
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Article $article)
    // {
    //     $categories = Category::all();
    //     return view('articles.edit', compact('article', 'categories'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'category_id' => 'required|exists:categories,id',
    //         'content' => 'required|string',
    //         'article_parts.*.type' => 'required|in:text,image',
    //         'article_parts.*.content' => 'nullable|string',
    //         'article_parts.*.order' => 'required|integer',
    //         'article_parts.*.image_path' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);
    //     $article = Post::findOrFail($id);

    //     $article->update([
    //         'title' => $request->input('title'),
    //         'category_id' => $request->input('category_id'),
    //         'content' => $request->input('content'),
    //     ]);

    //     $existingPartIds = $request->input('article_parts.*.id', []);
    //     PostPart::where('article_id', $article->id)
    //         ->whereNotIn('id', $existingPartIds)
    //         ->delete();

    //     $parts = $request->input('article_parts', []);

    //     foreach ($parts as $index => $part) {
    //         $articlePart = ArticlePart::where('article_id', $article->id)
    //             ->where('id', $part['id'] ?? null)
    //             ->first();

    //         if ($part['type'] === 'image') {
    //             $imagePath = $request->hasFile('article_parts.' . $index . '.image_path')
    //                 ? $request->file('article_parts.' . $index . '.image_path')->store('images', 'public')
    //                 : ($articlePart ? $articlePart->image_path : null);
    //         } else {
    //             $imagePath = null;
    //         }

    //         if ($articlePart) {
    //             $articlePart->update([
    //                 'type' => $part['type'],
    //                 'content' => $part['content'] ?? null,
    //                 'order' => $part['order'],
    //                 'image_path' => $imagePath,
    //             ]);
    //         } else {
    //             ArticlePart::create([
    //                 'article_id' => $article->id,
    //                 'type' => $part['type'],
    //                 'content' => $part['content'] ?? null,
    //                 'order' => $part['order'],
    //                 'image_path' => $imagePath,
    //             ]);
    //         }
    //     }

    //     return redirect()->route('articles.index')->with('success', 'Article updated successfully!');
    // }



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

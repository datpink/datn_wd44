<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function index()
    {
        $title = 'Danh Sách Bài Viết';
        $posts = Post::with('category')->latest()->paginate(10);
        return view('admin.posts.index', compact('posts', 'title'));
    }

    public function create()
    {
        $title = 'Thêm Mới Bài Viết';
        $categories = Category::all(); // Lấy tất cả danh mục
        return view('admin.posts.create', compact('categories', 'title'));
    }

    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts',
            'tomtat' => 'nullable|string',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

        DB::beginTransaction();

        try {
            // Tạo bài viết mới
            $post = new Post($request->all());

            // Xử lý hình ảnh
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $post->image = $imageName;
            }

            $post->is_featured = $request->has('is_featured');
            $post->save();

            DB::commit();
            return redirect()->route('posts.index')->with('success', 'Bài viết đã được thêm thành công.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('posts.index')->with('error', 'Có lỗi xảy ra khi thêm bài viết.');
        }
    }

    public function edit($id)
    {
        $title = 'Chỉnh Sửa Bài Viết';
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories', 'title'));
    }

    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $id,
            'tomtat' => 'nullable|string',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

        DB::beginTransaction();

        try {
            // Cập nhật bài viết
            $post = Post::findOrFail($id);
            $post->fill($request->all());

            // Xử lý hình ảnh
            if ($request->hasFile('image')) {
                // Xóa hình ảnh cũ nếu có
                if ($post->image) {
                    File::delete(public_path('images/' . $post->image));
                }

                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $post->image = $imageName;
            }

            $post->is_featured = $request->has('is_featured');
            $post->save();

            DB::commit();
            return redirect()->route('posts.index')->with('success', 'Bài viết đã được cập nhật thành công.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('posts.index')->with('error', 'Có lỗi xảy ra khi cập nhật bài viết.');
        }
    }

    // Xóa mềm bài viết
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        DB::beginTransaction();

        try {
            $post->delete(); // Thực hiện xóa mềm
            DB::commit();
            return redirect()->route('posts.index')->with('success', 'Bài viết đã được xóa mềm thành công.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('posts.index')->with('error', 'Có lỗi xảy ra khi xóa bài viết.');
        }
    }

    // Hiển thị thùng rác
    public function trash()
    {
        $title = 'Thùng Rác';
        $trash = Post::onlyTrashed()->get(); // Lấy tất cả bài viết đã bị xóa mềm
        return view('admin.posts.trash', compact('trash', 'title'));
    }

    // Khôi phục bài viết
    public function restore($id)
    {
        DB::beginTransaction();

        try {
            $post = Post::withTrashed()->findOrFail($id);
            $post->restore(); // Khôi phục bài viết
            DB::commit();
            return redirect()->route('posts.trash')->with('success', 'Bài viết đã được khôi phục thành công.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('posts.trash')->with('error', 'Có lỗi xảy ra khi khôi phục bài viết.');
        }
    }

    // Xóa vĩnh viễn bài viết
    public function forceDelete($id)
    {
        DB::beginTransaction();

        try {
            $post = Post::withTrashed()->findOrFail($id);
            $post->forceDelete(); // Xóa vĩnh viễn bài viết
            DB::commit();
            return redirect()->route('posts.trash')->with('success', 'Bài viết đã được xóa vĩnh viễn.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('posts.trash')->with('error', 'Có lỗi xảy ra khi xóa vĩnh viễn bài viết.');
        }
    }
}
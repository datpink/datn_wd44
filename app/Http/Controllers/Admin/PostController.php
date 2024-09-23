<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->latest()->get();
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all(); // Lấy tất cả danh mục
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts',
            'tomtat' => 'nullable|string',
            'content' => 'required|string', // Kiểm tra trường này
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

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

        return redirect()->route('posts.index')->with('success', 'Bài viết đã được thêm thành công.');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $id,
            'tomtat' => 'nullable|string',
            'content' => 'required|string', // Đảm bảo có trường này
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

        // Cập nhật bài viết
        $post = Post::findOrFail($id);
        $post->fill($request->all());

        // Xử lý hình ảnh
        if ($request->hasFile('image')) {
            // Xóa hình ảnh cũ nếu có
            if ($post->image) {
                \File::delete(public_path('images/' . $post->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $post->image = $imageName;
        }

        $post->is_featured = $request->has('is_featured');

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Bài viết đã được cập nhật thành công.');
    }

    // Xóa mềm bài viết
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete(); // Thực hiện xóa mềm
        return redirect()->route('posts.index')->with('success', 'Bài viết đã được xóa mềm thành công.');
    }

    // Hiển thị thùng rác
    public function trash()
    {
        $trash = Post::onlyTrashed()->get(); // Lấy tất cả bài viết đã bị xóa mềm
        return view('admin.posts.trash', compact('trash'));
    }

    // Khôi phục bài viết
    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore(); // Khôi phục bài viết
        return redirect()->route('posts.trash')->with('success', 'Bài viết đã được khôi phục thành công.');
    }

    // Xóa vĩnh viễn bài viết
    public function forceDelete($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->forceDelete(); // Xóa vĩnh viễn bài viết
        return redirect()->route('posts.trash')->with('success', 'Bài viết đã được xóa vĩnh viễn.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Danh Sách Bài Viết';

        // Lấy danh sách bài viết với điều kiện tìm kiếm và lọc
        $query = Post::with('category');

        // Tìm kiếm theo từ khóa trong tiêu đề hoặc tóm tắt
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('tomtat', 'like', '%' . $request->search . '%');
            });
        }

        // Lọc theo nổi bật
        if ($request->filled('is_featured')) {
            $query->where('is_featured', $request->is_featured);
        }

        // Lọc theo ngày tạo (từ ngày và đến ngày)
        if ($request->has('date') && $request->date) {
            $query->whereDate('created_at', $request->date);
        }

        // Sắp xếp bài viết theo mới nhất
        $posts = $query->latest()->paginate(10);

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
            'title' => 'required|string|max:255', // Tiêu đề là bắt buộc và tối đa 255 ký tự
            'slug' => 'required|string|max:255|unique:posts,slug,' . ($post->id ?? 'NULL'), // Slug phải duy nhất, ngoại trừ bản ghi hiện tại
            'tomtat' => 'nullable|string', // Tóm tắt là tùy chọn, nếu có phải là chuỗi
            'content' => 'required|string', // Nội dung là bắt buộc và phải là chuỗi
            'category_id' => 'required|exists:categories,id', // Kiểm tra category_id có tồn tại trong bảng categories
            'user_id' => 'required|integer', // user_id là bắt buộc và phải là số nguyên
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ảnh là tùy chọn, nếu có phải là ảnh và không quá 2MB
            'is_featured' => 'nullable|boolean', // is_featured là tùy chọn, nếu có phải là giá trị boolean
        ], [
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.string' => 'Tiêu đề phải là chuỗi.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'slug.required' => 'Slug là bắt buộc.',
            'slug.string' => 'Slug phải là chuỗi.',
            'slug.max' => 'Slug không được vượt quá 255 ký tự.',
            'slug.unique' => 'Slug này đã tồn tại, vui lòng chọn slug khác.',
            'tomtat.string' => 'Tóm tắt phải là chuỗi.',
            'content.required' => 'Nội dung là bắt buộc.',
            'content.string' => 'Nội dung phải là chuỗi.',
            'category_id.required' => 'Danh mục là bắt buộc.',
            'category_id.exists' => 'Danh mục không hợp lệ.',
            'user_id.required' => 'ID người dùng là bắt buộc.',
            'user_id.integer' => 'ID người dùng phải là số nguyên.',
            'image.image' => 'Ảnh phải là file hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'image.max' => 'Ảnh không được vượt quá 2MB.',
            'is_featured.boolean' => 'Nổi bật phải là giá trị boolean.',
        ]);


        DB::beginTransaction();

        try {
            // Tạo bài viết mới
            $post = new Post();
            $post->title = $request->title;
            $post->slug = $request->slug;
            $post->tomtat = $request->tomtat;
            $post->content = $request->content;
            $post->category_id = $request->category_id;
            $post->user_id = $request->user_id;

            // Xử lý hình ảnh
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images');
                $post->image = $imagePath;
            }

            // Cập nhật is_featured
            $post->is_featured = $request->has('is_featured') ? 1 : 0;

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
            'title' => 'required|string|max:255', // Tiêu đề bắt buộc, chuỗi, tối đa 255 ký tự
            'slug' => 'required|string|max:255|unique:posts,slug,' . $id, // Slug phải duy nhất, bỏ qua bản ghi hiện tại
            'tomtat' => 'nullable|string', // Tóm tắt tùy chọn, nếu có phải là chuỗi
            'content' => 'required|string', // Nội dung bắt buộc và phải là chuỗi
            'category_id' => 'required|exists:categories,id', // Kiểm tra category_id có tồn tại trong bảng categories
            'user_id' => 'required|integer', // user_id bắt buộc và phải là số nguyên
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ảnh là tùy chọn, nếu có phải là ảnh và không quá 2MB
            'is_featured' => 'nullable|boolean', // is_featured tùy chọn, nếu có phải là giá trị boolean
        ], [
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.string' => 'Tiêu đề phải là chuỗi.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'slug.required' => 'Slug là bắt buộc.',
            'slug.string' => 'Slug phải là chuỗi.',
            'slug.max' => 'Slug không được vượt quá 255 ký tự.',
            'slug.unique' => 'Slug này đã tồn tại, vui lòng chọn slug khác.',
            'tomtat.string' => 'Tóm tắt phải là chuỗi.',
            'content.required' => 'Nội dung là bắt buộc.',
            'content.string' => 'Nội dung phải là chuỗi.',
            'category_id.required' => 'Danh mục là bắt buộc.',
            'category_id.exists' => 'Danh mục không hợp lệ.',
            'user_id.required' => 'ID người dùng là bắt buộc.',
            'user_id.integer' => 'ID người dùng phải là số nguyên.',
            'image.image' => 'Ảnh phải là file hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'image.max' => 'Ảnh không được vượt quá 2MB.',
            'is_featured.boolean' => 'Nổi bật phải là giá trị boolean.',
        ]);


        DB::beginTransaction();

        try {
            $post = Post::findOrFail($id);
            // Cập nhật bài viết
            $post->title = $request->title;
            $post->slug = $request->slug;
            $post->tomtat = $request->tomtat;
            $post->content = $request->content;
            $post->category_id = $request->category_id;
            $post->user_id = $request->user_id;

            if ($request->hasFile('image')) {
                if ($post->image) {
                    Storage::delete($post->image);
                }
                $imagePath = $request->file('image')->store('images');
                $post->image = $imagePath;
            }
            $post->is_featured = $request->has('is_featured') ? 1 : 0;

            $post->save();

            DB::commit();
            return redirect()->route('posts.index')->with('success', 'Bài viết đã được cập nhật thành công.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('posts.index')->with('error', 'Có lỗi xảy ra khi cập nhật bài viết.');
        }
    }


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

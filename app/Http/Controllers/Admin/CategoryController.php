<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Danh Mục Bài Viết';
        $query = Category::query();

        // Tìm kiếm theo tên hoặc tên cha
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('parent', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
        }

        // Lọc theo ngày tạo
        if ($request->has('created_at') && $request->created_at) {
            $query->whereDate('created_at', $request->created_at);
        }

        // Lọc theo trạng thái
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Phân trang và lấy danh sách danh mục
        $categories = $query->paginate(10);

        return view('admin.categories.index', compact('categories', 'title'));
    }

    public function create()
    {
        $title = 'Thêm Mới Danh Mục';
        $parentCategories = Category::whereNull('parent_id')->with('children')->get();

        return view('admin.categories.create', compact('parentCategories', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();

        try {
            $category = new Category();
            $category->name = $request->name;
            $category->parent_id = $request->parent_id;
            $category->description = $request->description;
            $category->status = $request->status;

            $category->save();
            DB::commit();

            return redirect()->route('categories.index')
                ->with('success', 'Danh mục đã được thêm mới.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('categories.index')->with('error', 'Có lỗi xảy ra: ' . $th->getMessage());
        }
    }

    public function edit(Category $category)
    {
        $title = 'Cập Nhật Danh Mục';
        return view('admin.categories.edit', compact('category', 'title'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'max:255',
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();

        try {
            $category->name = $request->name;
            $category->description = $request->description;
            $category->status = $request->status;

            $category->save();
            DB::commit();

            return redirect()->route('categories.index')->with('success', 'Danh mục đã được cập nhật.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('categories.index')->with('error', 'Có lỗi xảy ra: ' . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if (Category::where('parent_id', $category->id)->exists()) {
            return redirect()->route('categories.index')
                ->with('error', 'Không thể xóa danh mục này vì nó là danh mục cha của một hoặc nhiều danh mục khác.');
        }

        DB::beginTransaction();

        try {
            $category->delete();
            DB::commit();

            return redirect()->route('categories.index')->with('deleteCategory', 'Xóa danh mục thành công');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('categories.index')->with('error', 'Có lỗi xảy ra: ' . $th->getMessage());
        }
    }

    public function trash()
    {
        $title = 'Thùng Rác';
        $categories = Category::onlyTrashed()->get();
        return view('admin.categories.trash', compact('categories', 'title'));
    }

    public function restore($id)
    {
        DB::beginTransaction();

        try {
            $category = Category::withTrashed()->findOrFail($id);
            $category->restore();
            DB::commit();

            return redirect()->route('categories.trash')
                ->with('restoreCategory', 'Khôi phục danh mục thành công');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('categories.trash')->with('error', 'Có lỗi xảy ra: ' . $th->getMessage());
        }
    }

    public function forceDelete($id)
    {
        DB::beginTransaction();

        try {
            $category = Category::onlyTrashed()->findOrFail($id);

            if (Category::where('parent_id', $category->id)->exists()) {
                return redirect()->route('categories.trash')
                    ->with('error', 'Không thể xóa cứng danh mục này vì nó là danh mục cha của một hoặc nhiều danh mục khác.');
            }

            $category->forceDelete();
            DB::commit();

            return redirect()->route('categories.trash')
                ->with('forceDeleteCategory', 'Xóa cứng danh mục thành công');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('categories.trash')->with('error', 'Có lỗi xảy ra: ' . $th->getMessage());
        }
    }
}
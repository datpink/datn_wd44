<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function index(Request $request)
    {
        $title = 'Danh Sách Danh Mục';

        $query = Category::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('parent', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
        }

        $categories = $query->paginate(10);

        return view('admin.categories.index', compact('categories', 'title'));
    }

    public function create()
    {
        // Assuming you want to get all categories that could be parents
        $parentCategories = Category::whereNull('parent_id')->with('children')->get();

        return view('admin.categories.create', compact('parentCategories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $category = new Category();
        $category->name = $request->name;

        $category->parent_id = $request->parent_id;
        $category->description = $request->description;
        $category->status = $request->status;

        $category->save();

        return redirect()->route('categories.index')
            ->with('success', 'Danh mục đã được thêm mới.');
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
            // 'slug' => 'required|string|max:255|unique:catalogues,slug,' . $catalogue->id,
            'status' => 'required|in:active,inactive',
            // 'image' => 'nullable|image|max:2048',
        ]);

        $category->name = $request->name;
        // $category->slug = $request->slug;
        $category->status = $request->status;



        $category->save();

        return redirect()->route('categories.index')->with('success', 'Danh mục đã được cập nhật.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if (Category::where('parent_id', $category->id)->exists()) {
            return redirect()->route('categories.index')
                ->with('error', 'Không thể xóa danh mục này vì nó là danh mục cha của một hoặc nhiều danh mục khác.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Danh mục đã được xóa thành công!');
    }

    public function trash()
    {
        $title = 'Thùng Rác';
        $categories = Category::onlyTrashed()->get();
        return view('admin.categories.trash', compact('categories', 'title'));
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('categories.trash')
            ->with('success', 'Danh mục đã được khôi phục thành công!');
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        if (Category::where('parent_id', $category->id)->exists()) {
            return redirect()->route('categories.trash')
                ->with('error', 'Không thể xóa cứng danh mục này vì nó là danh mục cha của một hoặc nhiều danh mục khác.');
        }

        $category->forceDelete();

        return redirect()->route('categories.trash')
            ->with('success', 'Danh mục đã được xóa cứng thành công!');
    }
}

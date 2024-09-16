<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Danh Sách Thương Hiệu';
        $search = $request->input('search');

        $brands = Brand::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->paginate(10);

        return view('admin.brands.index', compact('brands', 'search', 'title'));
    }

    public function create()
    {
        $title = 'Thêm Mới Thương Hiệu';
        return view('admin.brands.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Brand::create($request->all());
        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã được tạo thành công.');
    }

    public function edit(Brand $brand)
    {
        $title = 'Cập Nhật Thương Hiệu';
        return view('admin.brands.edit', compact('brand', 'title'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $brand->update($request->all());
        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        // Nếu có sản phẩm thuộc về thương hiệu này, không cho phép xóa
        if ($brand->products()->exists()) {
            return redirect()->route('brands.index')->with('error', 'Không thể xóa thương hiệu này vì nó có sản phẩm liên quan.');
        }

        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã được xóa thành công!');
    }

    public function trash()
    {
        $title = 'Thùng Rác Thương Hiệu';
        $brands = Brand::onlyTrashed()->get();
        return view('admin.brands.trash', compact('brands', 'title'));
    }

    public function restore($id)
    {
        $brand = Brand::withTrashed()->findOrFail($id);
        $brand->restore();

        return redirect()->route('brands.trash')->with('success', 'Thương hiệu đã được khôi phục thành công!');
    }

    public function forceDelete($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);

        // Nếu có sản phẩm thuộc về thương hiệu này, không cho phép xóa cứng
        if ($brand->products()->exists()) {
            return redirect()->route('brands.trash')->with('error', 'Không thể xóa cứng thương hiệu này vì nó có sản phẩm liên quan.');
        }

        $brand->forceDelete();

        return redirect()->route('brands.trash')->with('success', 'Thương hiệu đã được xóa cứng thành công!');
    }
}
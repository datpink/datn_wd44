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
        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
    }

    public function show(Brand $brand)
    {
        return view('brands.show', compact('brand'));
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
        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully.');
    }
}
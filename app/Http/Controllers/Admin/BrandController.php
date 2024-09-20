<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $brands = Brand::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->paginate(10);
        
        return view('admin.brands.list', compact('brands'));
    }

    public function create()
    {
        // $title = 'Thêm Mới Thương Hiệu';
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $brands = $request->validate([
            'name' => 'required|max:255|min:3|unique:brands,name',
            'description' => 'max:255',
        ], [
            'name.required' => 'Tên thương hiệu là bắt buộc.',
            'name.max' => 'Tên thương hiệu không được vượt quá :max ký tự.',
            'name.min' => 'Tên thương hiệu phải có ít nhất :min ký tự.',
            'name.unique' => 'Tên thương hiệu đã tồn tại.',
            'description.max' => 'Mô tả không được vượt quá :max ký tự.',
        ]);

        Brand::create($brands);

        return redirect()->route('brands.index')->with('create', 'Thêm thành công');
    }

    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        // dd($brand);
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, string $id)
    {
        //
        $data = $request->validate([
            'name' => 'required|max:255|min:3|unique:brands,name,' . $id,
            'description' => 'max:255',
        ], [
            'name.required' => 'Tên thương hiệu là bắt buộc.',
            'name.max' => 'Tên thương hiệu không được vượt quá :max ký tự.',
            'name.min' => 'Tên thương hiệu phải có ít nhất :min ký tự.',
            'name.unique' => 'Tên thương hiệu đã tồn tại.',
            'description.max' => 'Mô tả không được vượt quá :max ký tự.',
        ]);

        DB::beginTransaction();
        try {
            // Tìm thương hiệu theo ID
            $brand = Brand::findOrFail($id);

            // Cập nhật dữ liệu thương hiệu
            $brand->update($data);

            DB::commit();
            return back()->with('update', 'Cập nhật thành công.');
        } catch (\Throwable $th) {
            // dd($th);
            DB::rollBack();
            return redirect()->route('brands.index')->with('updateError', 'Cập nhật thất bại.');
        }
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand->products()->exists()) {
            // return redirect()->route('brands.index')->with('error', 'Không thể xóa thương hiệu này vì nó có sản phẩm liên quan.');
            return back()->with('destroy', 'Xóa thành công');
        }

        $brand->delete();

        return back()->with('destroy', 'Xóa thành công');
    }

    public function trash()
    {
        // dd('ahihi');
        $brands = Brand::onlyTrashed()->get();
        return view('admin.brands.trash', compact('brands'));
    }

    public function restore($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        $brand->restore();

        return back();
    }

    public function deletePermanently($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        if ($brand->products()->exists()) {
            return redirect()->route('brands.trash')->with('deletePermanently', 'Xóa vĩnh viễn thành công');
            // return redirect()->route('brands.trash')->with('error', 'Không thể xóa cứng thương hiệu này vì nó có sản phẩm liên quan.');
        }
        $brand->forceDelete();

        return redirect()->route('brands.trash')->with('deletePermanently', 'Xóa vĩnh viễn thành công');
    }
}

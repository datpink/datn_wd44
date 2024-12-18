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
        $title = 'Danh sách Thương Hiệu';

        $search = $request->input('search');
        $brands = Brand::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->paginate(10);

        return view('admin.brands.list', compact('brands', 'title'));
    }

    public function create()
    {
        $title = 'Thêm Mới Thương Hiệu';
        return view('admin.brands.create', compact('title'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255|min:3|unique:brands,name',
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
            Brand::create($data);
            DB::commit();
            return redirect()->route('brands.index')->with('create', 'Thêm thành công');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('brands.index')->with('error', 'Có lỗi xảy ra: ' . $th->getMessage());
        }
    }

    public function edit(string $id)
    {
        $title = 'Chỉnh Sửa Thương Hiệu';
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand', 'title'));
    }

    public function update(Request $request, string $id)
    {
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
            $brand = Brand::findOrFail($id);
            $brand->update($data);
            DB::commit();
            return back()->with('update', 'Cập nhật thành công.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('brands.index')->with('updateError', 'Cập nhật thất bại.');
        }
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        // Kiểm tra nếu có sản phẩm liên kết với thương hiệu
        if ($brand->products()->count() > 0 ) {
            return back()->with('error', 'Không thể xóa thương hiệu vì có sản phẩm liên kết.');
        }

        DB::beginTransaction();

        try {
            $brand->delete();
            DB::commit();
            return back()->with('success', 'Xóa thương hiệu thành công.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $th->getMessage());
        }
    }


    public function trash()
    {
        $title = 'Thùng Rác Thương Hiệu';
        $brands = Brand::onlyTrashed()->get();
        return view('admin.brands.trash', compact('brands', 'title'));
    }

    public function restore($id)
    {
        DB::beginTransaction();

        try {
            $brand = Brand::onlyTrashed()->findOrFail($id);
            $brand->restore();
            DB::commit();
            return redirect()->route('brands.trash')->with('restoreBrand', 'Khôi phục thương hiệu thành công');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('brands.trash')->with('error', 'Có lỗi xảy ra: ' . $th->getMessage());
        }
    }

    public function deletePermanently($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);

        if ($brand->products()->exists()) {
            return redirect()->route('brands.trash')->with('error', 'Không thể xóa cứng thương hiệu này vì nó có sản phẩm liên quan.');
        }

        DB::beginTransaction();

        try {
            $brand->forceDelete();
            DB::commit();
            return redirect()->route('brands.trash')->with('deletePermanently', 'Xóa vĩnh viễn thành công');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('brands.trash')->with('error', 'Có lỗi xảy ra: ' . $th->getMessage());
        }
    }
}

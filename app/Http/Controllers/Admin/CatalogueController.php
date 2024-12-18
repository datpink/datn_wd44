<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Danh Sách Danh Mục';
        $query = Catalogue::query();

        // Tìm kiếm theo tên
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('parent', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
        }

        // Lọc theo ngày tạo
        if ($request->has('date') && $request->date) {
            $query->whereDate('created_at', $request->date);
        }

        // Lọc theo trạng thái
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Phân trang và lấy danh sách danh mục
        $catalogues = $query->paginate(10);

        return view('admin.catalogues.index', compact('catalogues', 'title'));
    }

    public function create()
    {
        $title = 'Thêm Mới Danh Mục';
        $parentCatalogues = Catalogue::whereNull('parent_id')->get();
        return view('admin.catalogues.create', compact('parentCatalogues', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:catalogues,name',
            'parent_id' => 'nullable|exists:catalogues,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.string' => 'Tên danh mục phải là chuỗi ký tự.',
            'name.max' => 'Tên danh mục không được quá 255 ký tự.',
            'name.unique' => 'Tên danh mục đã tồn tại.', // Thông báo lỗi khi trùng tên
            'parent_id.exists' => 'Danh mục cha không tồn tại.',
            'image.image' => 'Hình ảnh phải là một tập tin hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái phải là "active" hoặc "inactive".',
        ]);

        DB::beginTransaction();

        try {
            // Kiểm tra trùng lặp danh mục theo tên hoặc slug
            $slug = \Str::slug($request->name);
            $existingCatalogue = Catalogue::where('name', $request->name)
                ->orWhere('slug', $slug)
                ->first();

            if ($existingCatalogue) {
                return redirect()->back()->withErrors([
                    'error' => 'Tên danh mục hoặc slug đã tồn tại.'
                ])->withInput();
            }

            // Tạo mới danh mục
            $catalogue = new Catalogue();
            $catalogue->name = $request->name;
            $catalogue->slug = $slug;
            $catalogue->parent_id = $request->parent_id;
            $catalogue->description = $request->description;
            $catalogue->status = $request->status;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('catalogue_images', 'public');
                $catalogue->image = $imagePath;
            }

            $catalogue->save();
            DB::commit();

            return redirect()->route('catalogues.index')->with('success', 'Danh mục đã được thêm mới.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('catalogues.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }



    public function edit(Catalogue $catalogue)
    {
        $title = 'Cập Nhật Danh Mục';
        return view('admin.catalogues.edit', compact('catalogue', 'title'));
    }

    public function update(Request $request, Catalogue $catalogue)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:catalogues,name,' . $catalogue->id,
            'slug' => 'required|string|max:255|unique:catalogues,slug,' . $catalogue->id,
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.unique' => 'Tên danh mục đã tồn tại.', // Thông báo lỗi khi trùng tên
            'name.string' => 'Tên danh mục phải là chuỗi ký tự.',
            'name.max' => 'Tên danh mục không được quá 255 ký tự.',
            'slug.required' => 'Slug là bắt buộc.',
            'slug.unique' => 'Slug đã tồn tại.',
            'slug.max' => 'Slug không được quá 255 ký tự.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái phải là "active" hoặc "inactive".',
            'image.image' => 'Hình ảnh phải là một tập tin hình ảnh.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
        ]);

        DB::beginTransaction();

        try {
            // Cập nhật thông tin danh mục
            $catalogue->name = $request->name;
            $catalogue->slug = $request->slug;
            $catalogue->status = $request->status;

            // Kiểm tra và lưu ảnh nếu có
            if ($request->hasFile('image')) {
                // Xóa ảnh cũ nếu có
                if ($catalogue->image) {
                    Storage::disk('public')->delete($catalogue->image);
                }
                // Lưu ảnh mới
                $catalogue->image = $request->file('image')->store('catalogue_images', 'public');
            }

            // Lưu danh mục
            $catalogue->save();
            DB::commit();

            return redirect()->route('catalogues.index')->with('success', 'Danh mục đã được cập nhật.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('catalogues.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        $catalogue = Catalogue::findOrFail($id);

        if (Catalogue::where('parent_id', $catalogue->id)->exists()) {
            return redirect()->route('catalogues.index')
                ->with('error', 'Không thể xóa danh mục này vì nó là danh mục cha của một hoặc nhiều danh mục khác.');
        }
        // Kiểm tra nếu danh mục có sản phẩm
        $count = $catalogue->products()->count();
        if ($count > 0) {
            return redirect()->route('catalogues.index')
                ->with('error', 'Không thể xóa danh mục này vì có '.$count .' sản phẩm đang thuộc danh mục.');
        }

        DB::beginTransaction();

        try {
            $catalogue->delete();
            DB::commit();

            return redirect()->route('catalogues.index')->with('destroyCatalogue', 'Xóa danh mục thành công');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('catalogues.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $title = 'Thùng Rác';
        $catalogues = Catalogue::onlyTrashed()->get();
        return view('admin.catalogues.trash', compact('catalogues', 'title'));
    }

    public function restore($id)
    {
        DB::beginTransaction();

        try {
            $catalogue = Catalogue::withTrashed()->findOrFail($id);
            $catalogue->restore();
            DB::commit();

            return redirect()->route('catalogues.trash')->with('restoreCatalogue', 'Khôi phục danh mục thành công');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('catalogues.trash')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        $catalogue = Catalogue::onlyTrashed()->findOrFail($id);

        if (Catalogue::where('parent_id', $catalogue->id)->exists()) {
            return redirect()->route('catalogues.trash')
                ->with('error', 'Không thể xóa cứng danh mục này vì nó là danh mục cha của một hoặc nhiều danh mục khác.');
        }

        DB::beginTransaction();

        try {
            $catalogue->forceDelete();
            DB::commit();

            return redirect()->route('catalogues.trash')->with('forceDeleteCatalogue', 'Xóa cứng danh mục thành công');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('catalogues.trash')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}

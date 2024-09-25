<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Danh Sách Danh Mục';

        $query = Catalogue::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhereHas('parent', function ($q) use ($search) 
                  {
                    $q->where('name', 'like', '%' . $search . '%');
                  });
        }

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
            'name'          => 'required|string|max:255',
            'parent_id'     => 'nullable|exists:catalogues,id',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description'   => 'nullable|string',
            'status'        => 'required|in:active,inactive',
        ]);

        $catalogue = new Catalogue();
        $catalogue->name            = $request->name;
        $catalogue->slug            = \Str::slug($request->name);
        $catalogue->parent_id       = $request->parent_id;
        $catalogue->description     = $request->description;
        $catalogue->status          = $request->status;

        if ($request->hasFile('image')) {
            $imagePath        = $request->file('image')->store('catalogue_images', 'public');
            $catalogue->image = $imagePath;
        }

        $catalogue->save();

        return redirect()->route('catalogues.index')
                         ->with('success', 'Danh mục đã được thêm mới.');
    }

    public function edit(Catalogue $catalogue)
    {
        $title = 'Cập Nhật Danh Mục';

        return view('admin.catalogues.edit', compact('catalogue', 'title'));
    }

    public function update(Request $request, Catalogue $catalogue)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:catalogues,slug,' . $catalogue->id,
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        $catalogue->name = $request->name;
        $catalogue->slug = $request->slug;
        $catalogue->status = $request->status;

        if ($request->hasFile('image')) {

            if ($catalogue->image) {
                Storage::disk('public')->delete($catalogue->image);
            }

            $catalogue->image = $request->file('image')->store('catalogue_images', 'public');
        }

        $catalogue->save();

        return redirect()->route('catalogues.index')->with('success', 'Danh mục đã được cập nhật.');
    }

    public function destroy($id)
    {
        $catalogue = Catalogue::findOrFail($id);

        if (Catalogue::where('parent_id', $catalogue->id)->exists()) {
            return redirect()->route('catalogues.index')
                             ->with('error', 'Không thể xóa danh mục này vì nó là danh mục cha của một hoặc nhiều danh mục khác.');
        }

        $catalogue->delete();

        return redirect()->route('catalogues.index')->with('destroyCatalogue', 'Xóa danh mục thành công');
    }

    public function trash()
    {
        $title = 'Thùng Rác';
        $catalogues = Catalogue::onlyTrashed()->get();
        return view('admin.catalogues.trash', compact('catalogues', 'title'));
    }

    public function restore($id)
    {
        $catalogue = Catalogue::withTrashed()->findOrFail($id);
        $catalogue->restore();

        return redirect()->route('catalogues.trash')
                         ->with('restoreCatalogue', 'Khôi phục danh mục thành công');
    }

    public function forceDelete($id)
    {
        $catalogue = Catalogue::onlyTrashed()->findOrFail($id);

        if (Catalogue::where('parent_id', $catalogue->id)->exists()) {
            return redirect()->route('catalogues.trash')
                             ->with('error', 'Không thể xóa cứng danh mục này vì nó là danh mục cha của một hoặc nhiều danh mục khác.');
        }

        $catalogue->forceDelete();

        return redirect()->route('catalogues.trash')
                         ->with('forceDeleteCatalogue', 'Xóa cứng danh mục thành công');
    }
}

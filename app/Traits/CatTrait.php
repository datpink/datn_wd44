<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait CatTrait
{
    public function index(Request $request, $model, $view, $title)
    {
        $query = $model::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('parent', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
        }

        $items = $query->paginate(10);

        return view($view, compact('items', 'title'));
    }

    public function create($model, $view, $title)
    {
        $parents = $model::whereNull('parent_id')->get();
        return view($view, compact('parents', 'title'));
    }

    public function store(Request $request, $model)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:catalogues,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $item = new $model();
        $item->name = $request->name;
        $item->slug = \Str::slug($request->name);
        $item->parent_id = $request->parent_id;
        $item->description = $request->description;
        $item->status = $request->status;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('catalogue_images', 'public');
            $item->image = $imagePath;
        }

        $item->save();

        return redirect()->route('catalogues.index') // Thay đổi route theo cần thiết
            ->with('success', 'Danh mục đã được thêm mới.');
    }

    public function update(Request $request, $model, $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:catalogues,slug,' . $item->id,
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        $item->name = $request->name;
        $item->slug = $request->slug;
        $item->status = $request->status;

        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $item->image = $request->file('image')->store('catalogue_images', 'public');
        }

        $item->save();

        return redirect()->route('catalogues.index')->with('success', 'Danh mục đã được cập nhật.');
    }

    public function destroy($model, $id)
    {
        $item = $model::findOrFail($id);

        if ($model::where('parent_id', $item->id)->exists()) {
            return redirect()->route('catalogues.index')
                ->with('error', 'Không thể xóa danh mục này vì nó là danh mục cha của một hoặc nhiều danh mục khác.');
        }

        $item->delete();

        return redirect()->route('catalogues.index')->with('success', 'Danh mục đã được xóa thành công!');
    }

    // Các phương thức khác như trash, restore, forceDelete...
}
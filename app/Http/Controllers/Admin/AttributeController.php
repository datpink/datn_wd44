<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $title = 'Danh sách Thuộc Tính';
        $attributes = Attribute::all();
        return view('admin.attributes.index', compact('attributes', 'title'));
    }

    public function create()
    {
        $title = 'Thêm Mới Thuộc Tính';
        return view('admin.attributes.create', compact('title'));
    }

    public function store(Request $request)
    {
        // Thêm kiểm tra trùng tên thuộc tính và thông báo lỗi bằng tiếng Việt
        $request->validate([
            'name' => 'required|string|max:255|unique:attributes,name',
        ], [
            'name.required' => 'Tên thuộc tính là bắt buộc.',
            'name.string' => 'Tên thuộc tính phải là chuỗi.',
            'name.max' => 'Tên thuộc tính không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên thuộc tính đã tồn tại. Vui lòng chọn tên khác.',
        ]);

        Attribute::create($request->all());

        return redirect()->route('attributes.index')->with('success', 'Tạo mới thuộc tính thành công.');
    }

    public function edit($id)
    {
        $title = 'Chỉnh Sửa Thuộc Tính';
        $attribute = Attribute::findOrFail($id);
        return view('admin.attributes.edit', compact('attribute', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:attributes,name',
        ], [
            'name.required' => 'Tên thuộc tính là bắt buộc.',
            'name.string' => 'Tên thuộc tính phải là chuỗi.',
            'name.max' => 'Tên thuộc tính không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên thuộc tính đã tồn tại. Vui lòng chọn tên khác.',
        ]);

        $attribute = Attribute::findOrFail($id);
        $attribute->update($request->all());

        return redirect()->route('attributes.index')->with('success', 'Cập nhật thuộc tính thành công!');
    }

    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();

        return redirect()->route('attributes.index')->with('success', 'Xóa thành công.');
    }
}

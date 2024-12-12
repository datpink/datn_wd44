<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    // Hiển thị danh sách Attribute Values theo Attribute ID
    public function index($attributeId)
    {
        $title = 'Giá trị Thuộc Tính';
        $attribute = Attribute::findOrFail($attributeId);
        $attributeValues = AttributeValue::where('attribute_id', $attributeId)->get();

        return view('admin.attribute_values.index', compact('attribute', 'attributeValues', 'title'));
    }

    // Hiển thị form tạo mới Attribute Value
    public function create($attributeId)
    {
        $title = 'Thêm Mới Giá Trị Thuộc Tính';
        $attribute = Attribute::findOrFail($attributeId);
        return view('admin.attribute_values.create', compact('attribute', 'title'));
    }

    // Lưu dữ liệu Attribute Value vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'name' => 'required|string|max:255|unique:attribute_values,name', // Kiểm tra trùng tên trong bảng attribute_values
        ], [
            'attribute_id.required' => 'Thuộc tính là bắt buộc.',
            'attribute_id.exists' => 'Thuộc tính không tồn tại trong cơ sở dữ liệu.',
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên thuộc tính đã tồn tại.', // Thông báo khi tên bị trùng
        ]);



        AttributeValue::create([
            'attribute_id' => $request->attribute_id,
            'name' => $request->name,
        ]);

        return redirect()->route('attributes.attribute_values.index', $request->attribute_id)
            ->with('success', 'Attribute Value created successfully!');
    }

    // Hiển thị form chỉnh sửa Attribute Value
    public function edit($attributeId, $valueId)
    {
        $title = 'Chỉnh Sửa Giá Trị Thuộc Tính';
        // Tìm giá trị thuộc tính theo ID
        $value = AttributeValue::findOrFail($valueId);

        // Truyền giá trị thuộc tính và ID thuộc tính đến view
        return view('admin.attribute_values.edit', [
            'value' => $value,
            'attributeId' => $attributeId,
            'title' => $title,
        ]);
    }

    // Cập nhật thông tin Attribute Value
    public function update(Request $request, $attributeId, $valueId)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'name' => 'required|string|max:255|unique:attribute_values,name', // Kiểm tra trùng tên trong bảng attribute_values
        ], [
            'attribute_id.required' => 'Thuộc tính là bắt buộc.',
            'attribute_id.exists' => 'Thuộc tính không tồn tại trong cơ sở dữ liệu.',
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên thuộc tính đã tồn tại.', // Thông báo khi tên bị trùng
        ]);


        $value = AttributeValue::findOrFail($valueId);
        $value->name = $request->name;
        $value->save();

        return redirect()->route('attributes.attribute_values.index', $attributeId)
            ->with('success', 'Attribute value updated successfully.');
    }

    // Xóa Attribute Value
    public function destroy($attributeId, $valueId)
    {
        $value = AttributeValue::findOrFail($valueId);
        $value->delete();
        return redirect()->route('attributes.attribute_values.index', $attributeId)
            ->with('success', 'Attribute value deleted successfully.');
    }
}

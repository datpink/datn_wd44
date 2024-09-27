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
      $attribute = Attribute::findOrFail($attributeId);
      $attributeValues = AttributeValue::where('attribute_id', $attributeId)->get();
      
      return view('attribute_values.index', compact('attribute', 'attributeValues'));
  }

  // Hiển thị form tạo mới Attribute Value
  public function create($attributeId)
  {
      $attribute = Attribute::findOrFail($attributeId);
      return view('attribute_values.create', compact('attribute'));
  }

  // Lưu dữ liệu Attribute Value vào cơ sở dữ liệu
  public function store(Request $request)
  {
      $request->validate([
          'attribute_id' => 'required|exists:attributes,id',
          'name' => 'required|string|max:255',
      ]);

      AttributeValue::create([
          'attribute_id' => $request->attribute_id,
          'name' => $request->name,
      ]);

      return redirect()->route('attribute_values.index', ['attribute_id' => $request->attribute_id])
                       ->with('success', 'Attribute Value created successfully!');
  }

  // Hiển thị form chỉnh sửa Attribute Value
  public function edit($id)
  {
      $attributeValue = AttributeValue::findOrFail($id);
      $attribute = $attributeValue->attribute; // Lấy thông tin attribute liên kết

      return view('attribute_values.edit', compact('attributeValue', 'attribute'));
  }

  // Cập nhật thông tin Attribute Value
  public function update(Request $request, $id)
  {
      $request->validate([
          'name' => 'required|string|max:255',
      ]);

      $attributeValue = AttributeValue::findOrFail($id);
      $attributeValue->update([
          'name' => $request->name,
      ]);

      return redirect()->route('attribute_values.index', ['attribute_id' => $attributeValue->attribute_id])
                       ->with('success', 'Attribute Value updated successfully!');
  }

  // Xóa Attribute Value
  public function destroy($id)
  {
      $attributeValue = AttributeValue::findOrFail($id);
      $attributeId = $attributeValue->attribute_id; // Lưu lại attribute_id trước khi xóa
      $attributeValue->delete();

      return redirect()->route('attribute_values.index', ['attribute_id' => $attributeId])
                       ->with('success', 'Attribute Value deleted successfully!');
  }
}

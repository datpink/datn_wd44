<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    // Hiển thị danh sách biến thể của sản phẩm
    public function index(Product $product)
    {
        $title = 'Danh Sách Biến Thể';
        $variants = $product->variants; // Lấy tất cả biến thể của sản phẩm
        $hasVariants = $variants->isNotEmpty(); // Kiểm tra xem có biến thể hay không

        return view('admin.variants.index', compact('product', 'variants', 'hasVariants', 'title'));
    }

    // Hiển thị form thêm biến thể
    public function create(Product $product)
    {
        $title = 'Thêm Mới Biến Thể';
        // Giả sử bạn có model AttributeValue
        $attributeValues = AttributeValue::all(); // Lấy tất cả giá trị thuộc tính

        return view('admin.variants.create', compact('product', 'attributeValues', 'title'));
    }
    // Lưu biến thể mới
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'variant_name' => 'required|string',
            'price' => 'required|numeric',
            'sku' => 'required|string',
            'stock' => 'required|integer',
            'attributes' => 'required|array|min:1', // Đảm bảo là mảng và có ít nhất 1 phần tử
            'attributes.*' => 'integer|exists:attribute_values,id', // Đảm bảo là số nguyên và tồn tại

        ]);

        // Tạo biến thể mới
        $variant = new ProductVariant([
            'variant_name' => $request->variant_name,
            'price' => $request->price,
            'sku' => $request->sku,
            'stock' => $request->stock,
            'status' => 'inactive', // Mặc định là không kích hoạt
        ]);
    
        // Lưu biến thể vào cơ sở dữ liệu
        $product->variants()->save($variant);
    
        // Thêm thuộc tính vào biến thể qua bảng trung gian
        if ($request->has('attributes') && is_array($request->attributes)) {
            $validAttributes = array_filter($request->attributes, function ($value) {
                return is_numeric($value); // Kiểm tra xem giá trị có phải là số không
            });
            if (count($validAttributes) > 0) {
                $variant->attributes()->attach($validAttributes);
            }
        }
    
        return redirect()->route('products.variants.index', $product->id)->with('success', 'Biến thể đã được thêm thành công.');
    }

    // Chỉnh sửa biến thể
    public function edit(ProductVariant $variant)
    {
        $title = 'Chỉnh Sửa Biến Thể';
        return view('admin.variants.edit', compact('variant', 'title'));
    }

    // Cập nhật biến thể
    public function update(Request $request, ProductVariant $variant)
    {
        $request->validate([
            'variant_name' => 'required|string',
            'price' => 'required|numeric',
            'sku' => 'required|string',
            'stock' => 'required|integer',
        ]);

        $variant->update($request->all());

        return redirect()->route('products.variants.index', $variant->product_id)->with('success', 'Biến thể đã được cập nhật thành công.');
    }

    // Xóa biến thể

    // Cập nhật trạng thái biến thể
    public function updateStatus(ProductVariant $variant)
    {
        $variant->status = $variant->status === 'active' ? 'inactive' : 'active';
        $variant->save();

        return redirect()->route('products.variants.index', $variant->product_id)->with('success', 'Trạng thái biến thể đã được cập nhật thành công.');
    }
    public function getAttributeValues($attributeId)
    {
        $values = AttributeValue::where('attribute_id', $attributeId)->get();
        return response()->json($values);
    }
}

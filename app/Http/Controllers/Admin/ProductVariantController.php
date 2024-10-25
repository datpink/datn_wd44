<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'attributes' => 'required|array|min:1',
            'attributes.*' => 'integer|exists:attribute_values,id',
            'weight' => 'required|numeric',
            'dimension' => 'required|string',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);
        $imageUrl = $request->file('image_url') ? $request->file('image_url')->store('product_images', 'public') : null;
        // Kiểm tra và lọc các thuộc tính hợp lệ
        $validAttributes = array_filter($request->input('attributes', []), 'is_numeric');
    
        if (empty($validAttributes)) {
            return redirect()->route('products.variants.index', $product->id)
                ->with('error', 'Không thể thêm biến thể do thiếu thuộc tính hợp lệ.');
        }
    
        // Tạo biến thể mới và lưu vào cơ sở dữ liệu
        $variant = new ProductVariant($request->only(['variant_name', 'price', 'sku', 'stock', 'weight', 'dimension']) + [
            'status' => 'inactive', // Mặc định là không kích hoạt
            'image_url' => $imageUrl,

        ]);
    
        // Lưu biến thể vào cơ sở dữ liệu
        $product->variants()->save($variant);
    
        // Chèn các thuộc tính trực tiếp vào bảng trung gian
        try {
            foreach ($validAttributes as $validAttributeId) {
                DB::table('product_variant_attributes')->insert([
                    'product_variant_id' => $variant->id,
                    'attribute_value_id' => $validAttributeId,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to insert into product_variant_attributes: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm thuộc tính.');
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

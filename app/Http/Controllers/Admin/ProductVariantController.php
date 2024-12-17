<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


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

        // Lấy ID của thuộc tính 'Color' và 'Storage'
        $colorAttributeId = Attribute::where('name', 'Color')->value('id');
        $storageAttributeId = Attribute::where('name', 'Storage')->value('id');

        // Lấy các giá trị thuộc tính từ bảng attribute_values
        $colors = AttributeValue::where('attribute_id', $colorAttributeId)->get();
        $storages = AttributeValue::where('attribute_id', $storageAttributeId)->get();

        // Lấy tất cả giá trị thuộc tính (nếu cần)
        $attributeValues = AttributeValue::all();

        return view('admin.variants.create', compact('product', 'colors', 'storages', 'attributeValues', 'title'));
    }
    // Lưu biến thể mới cahs 1

    //     public function store(Request $request, Product $product)
    // {
    //     $request->validate([
    //         'variant_name' => 'required|string',
    //         'price' => 'required|numeric',
    //         'sku' => 'required|string|unique:product_variants,sku',
    //         'stock' => 'required|integer',
    //         'attributes' => 'required|array|min:1',
    //         'attributes.*' => 'integer|exists:attribute_values,id',
    //         'weight' => 'required|numeric',
    //         'dimension' => 'required|string',
    //         'image_url' => 'nullable|image|mimes:jpg,jpeg,png',
    //     ]);

    //     // Xử lý ảnh nếu có
    //     $imageUrl = $request->file('image_url') ? $request->file('image_url')->store('product_images', 'public') : null;

    //     // Kiểm tra và lọc các thuộc tính hợp lệ
    //     $validAttributes = array_filter($request->input('attributes', []), 'is_numeric');

    //     if (empty($validAttributes)) {
    //         return redirect()->route('products.variants.index', $product->id)
    //             ->with('error', 'Không thể thêm biến thể do thiếu thuộc tính hợp lệ.');
    //     }

    //     // Tạo biến thể mới và lưu vào cơ sở dữ liệu
    //     $variant = new ProductVariant($request->only(['variant_name', 'price', 'sku', 'stock', 'weight', 'dimension']) + [
    //         'status' => 'inactive', // Mặc định là không kích hoạt
    //         'image_url' => $imageUrl,
    //     ]);

    //     // Kiểm tra stock của sản phẩm
    //     if ($product->stock >= $request->stock) {
    //         // Lưu biến thể vào cơ sở dữ liệu
    //         $product->variants()->save($variant);

    //         // Trừ stock của sản phẩm chính
    //         $product->stock -= $request->stock;
    //         $product->save();

    //         // Chèn các thuộc tính trực tiếp vào bảng trung gian
    //         try {
    //             foreach ($validAttributes as $validAttributeId) {
    //                 DB::table('product_variant_attributes')->insert([
    //                     'product_variant_id' => $variant->id,
    //                     'attribute_value_id' => $validAttributeId,
    //                 ]);
    //             }
    //         } catch (\Exception $e) {
    //             Log::error('Failed to insert into product_variant_attributes: ' . $e->getMessage());
    //             return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm thuộc tính.');
    //         }

    //         return redirect()->route('products.variants.index', $product->id)->with('success', 'Biến thể đã được thêm thành công.');
    //     } else {
    //         return redirect()->back()->with('error', 'Sản phẩm không đủ stock để trừ.');
    //     }
    // }


    // Lưu biến thể mới cahs 2

    public function store(Request $request, Product $product)
    {
        // Validate input
        $request->validate([
            'variant_name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sku' => 'nullable|string|unique:product_variants,sku', // SKU là tùy chọn
            'stock' => 'required|integer|min:0',
            'attributes' => 'nullable|array',
            'attributes.*' => 'nullable|integer|exists:attribute_values,id',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Nếu SKU không được nhập, tạo SKU ngẫu nhiên
        $sku = $request->input('sku') ?: 'SKU-' . strtoupper(Str::random(9));

        // Xử lý ảnh nếu có
        $imageUrl = $request->file('image_url')
            ? $request->file('image_url')->store('product_images', 'public')
            : null;

        // Lọc các thuộc tính hợp lệ
        $validAttributes = array_filter($request->input('attributes', []), function ($value) {
            return is_numeric($value) && !is_null($value);
        });

        // Kiểm tra nếu không có thuộc tính nào được chọn
        if (empty($validAttributes)) {
            return back()->withInput()->withErrors(['attributes' => 'Bạn phải chọn ít nhất một thuộc tính.']);
        }

        // Kiểm tra trùng lặp biến thể dựa trên thuộc tính
        $existingVariant = DB::table('product_variants')
            ->select('product_variants.id')
            ->join('product_variant_attributes', 'product_variants.id', '=', 'product_variant_attributes.product_variant_id')
            ->where('product_variants.product_id', $product->id)
            ->whereIn('product_variant_attributes.attribute_value_id', $validAttributes)
            ->groupBy('product_variants.id')
            ->havingRaw('COUNT(DISTINCT product_variant_attributes.attribute_value_id) = ?', [count($validAttributes)])
            ->exists();

        if ($existingVariant) {
            return back()->withInput()->withErrors(['duplicate' => 'Biến thể đã tồn tại với tổ hợp thuộc tính này.']);
        }

        // Tạo biến thể mới
        $variant = new ProductVariant([
            'variant_name' => $request->variant_name,
            'price' => $request->price,
            'sku' => $sku,  // Dùng SKU đã tạo
            'stock' => $request->stock,
            'status' => 'inactive',
            'image_url' => $imageUrl,
        ]);

        // Lưu biến thể vào cơ sở dữ liệu
        $product->variants()->save($variant);

        // Cộng dồn stock của sản phẩm gốc từ biến thể
        $product->increment('stock', $request->stock);

        // Lưu các thuộc tính hợp lệ vào bảng trung gian nếu có
        if (!empty($validAttributes)) {
            $attributesData = array_map(function ($attributeId) use ($variant) {
                return [
                    'product_variant_id' => $variant->id,
                    'attribute_value_id' => $attributeId,
                ];
            }, $validAttributes);

            DB::table('product_variant_attributes')->insert($attributesData);
        }

        return redirect()->route('products.variants.index', $product->id)
            ->with('success', 'Biến thể đã được thêm thành công.');
    }






    // Chỉnh sửa biến thể
    public function edit(Product $product, ProductVariant $variant)
    {
        $title = 'Chỉnh Sửa Biến Thể';
        $products = Product::all();

        return view('admin.variants.edit', compact('product', 'variant', 'products', 'title'));
    }



    // // Cập nhật biến thể cahs 1
    // public function update(Request $request, Product $product, ProductVariant $variant)
    // {
    //     // Xác thực dữ liệu
    //     $request->validate([
    //         'variant_name' => 'required|string|max:255',
    //         'price' => 'required|numeric',
    //         'weight' => 'nullable|numeric',
    //         'dimension' => 'nullable|string|max:255',
    //         'stock' => 'required|integer',
    //         'sku' => 'required|string|unique:product_variants,sku,' . $variant->id,
    //         'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra hình ảnh
    //         'status' => 'required|in:active,inactive',
    //     ]);

    //     // Lưu giá trị stock cũ
    //     $oldStock = $variant->stock;

    //     // Cập nhật thông tin biến thể
    //     $variant->variant_name = $request->variant_name;
    //     $variant->price = $request->price;
    //     $variant->weight = $request->weight;
    //     $variant->dimension = $request->dimension;
    //     $variant->stock = $request->stock;
    //     $variant->status = $request->status;

    //     // Xử lý hình ảnh nếu có
    //     if ($request->hasFile('image_url')) {
    //         // Lưu hình ảnh và cập nhật đường dẫn
    //         $variant->image_url = $request->file('image_url')->store('images', 'public'); // Lưu vào thư mục public/images
    //     }

    //     // Lưu thay đổi
    //     $variant->save();

    //     // Cập nhật stock của sản phẩm
    //     if ($oldStock != $variant->stock) {
    //         // Tính sự khác biệt giữa stock mới và cũ
    //         $difference = $variant->stock - $oldStock;

    //         // Nếu stock của biến thể giảm, tăng stock của sản phẩm
    //         if ($difference < 0) {
    //             $product->stock += abs($difference); // Tăng stock của sản phẩm
    //         } else {
    //             // Nếu stock của biến thể tăng, giảm stock của sản phẩm
    //             $product->stock -= $difference; // Giảm stock của sản phẩm
    //         }

    //         // Lưu lại thay đổi
    //         $product->save();
    //     }

    //     return redirect()->route('products.variants.index', [$product, $variant])->with('success', 'Cập nhật biến thể thành công.');
    // }



    // // Cập nhật biến thể cahs 2
    // Cập nhật biến thể
    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        // Xác thực dữ liệu
        $request->validate([
            'variant_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            // 'weight' => 'nullable|numeric',
            // 'dimension' => 'nullable|string|max:255',
            'stock' => 'required|integer',
            'sku' => 'required|string|unique:product_variants,sku,' . $variant->id,
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra hình ảnh
            'status' => 'required|in:active,inactive',
        ]);

        // Lưu giá trị stock cũ
        $oldStock = $variant->stock;

        // Cập nhật thông tin biến thể
        $variant->variant_name = $request->variant_name;
        $variant->price = $request->price;
        // $variant->weight = $request->weight;
        // $variant->dimension = $request->dimension;
        $variant->stock = $request->stock;
        $variant->status = $request->status;

        // Xử lý hình ảnh nếu có
        if ($request->hasFile('image_url')) {
            // Lưu hình ảnh và cập nhật đường dẫn
            $variant->image_url = $request->file('image_url')->store('images', 'public'); // Lưu vào thư mục public/images
        }

        // Lưu thay đổi
        $variant->save();
        $product->updateTotalStock();

        return redirect()->route('products.variants.index', [$product, $variant])->with('success', 'Cập nhật biến thể thành công.');
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

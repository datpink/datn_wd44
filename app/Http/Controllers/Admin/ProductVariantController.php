<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function index()
    {
        // Hiển thị tất cả các bản ghi, bao gồm cả trạng thái 'inactive'
        $productVariants = ProductVariant::with('product')->latest()->get();
        return view('admin.product-variants.index', compact('productVariants'));
    }

    public function create()
    { 
        $products = Product::all();
        return view('admin.product-variants.create', compact(b'products'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|integer',
            'variant_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'sku' => 'required|string|max:255',
            'image_url' => 'nullable|file|image|max:2048'
        ]);

        // Tạo mới ProductVariant với trạng thái mặc định là 'active'
        ProductVariant::create(array_merge($validatedData, ['status' => 'active']));

        return redirect()->route('product-variants.index')->with('success', 'Product Variant created successfully.');
    }

    public function edit($id)
    {
        $productVariant = ProductVariant::findOrFail($id);
        $products = Product::all();

        return view('admin.product-variants.edit', compact('productVariant', 'products'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|integer',
            'variant_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'sku' => 'required|string|max:255',
            'image_url' => 'nullable|file|image|max:2048'
        ]);

        $productVariant = ProductVariant::findOrFail($id);
        $productVariant->update($validatedData);

        return redirect()->route('product-variants.index')->with('success', 'Product Variant updated successfully.');
    }

    // Cập nhật trạng thái thành 'inactive' thay vì xóa
    public function destroy($id)
    {
        $productVariant = ProductVariant::findOrFail($id);
        $productVariant->update(['status' => 'inactive']);

        return redirect()->route('product-variants.index')->with('success', 'Đã cập nhật trạng thái Biến thể sản phẩm thành không hoạt động.');
    }

    // Kích hoạt lại trạng thái thành 'active'
    public function activate($id)
    {
        $productVariant = ProductVariant::findOrFail($id);
        $productVariant->update(['status' => 'active']);
        return redirect()->route('product-variants.index')->with('success', 'Đã cập nhật trạng thái Biến thể sản phẩm thành hoạt động.');
    }
}
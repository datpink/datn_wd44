<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Brand;
use App\Models\Catalogue;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Danh Sách Sản Phẩm';
        $products = Product::with('brand', 'catalogue')->paginate(10); // Phân trang 10 sản phẩm trên 1 trang
        return view('admin.products.index', compact('products', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm Mới Sản Phẩm';
        $catalogues = Catalogue::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('catalogues', 'brands', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            DB::beginTransaction();
            $imagePath = null;
            if ($request->hasFile('image_url')) {
                $imagePath = Storage::put('images', $request->image_url);
            }

            // Tạo mới sản phẩm
            Product::create([
                'name' => $request->name,
                'catalogue_id' => $request->catalogue_id,
                'brand_id' => $request->brand_id,
                'slug' => $request->slug,
                'sku' => $request->sku,
                'price' => $request->price,
                'stock' => $request->stock,
                'weight' => $request->weight,
                'dimensions' => $request->dimensions,
                'image_url' => $imagePath,
                'description' => $request->description,
                'is_active' => $request->is_active,
                'is_featured' => $request->has('is_featured'), // Thêm trường is_featured
                'condition' => $request->condition, // Thêm trường condition
            ]);
            DB::commit();
            return redirect()->route('products.index')->with('success', 'Sản phẩm đã được thêm mới!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('errors', $th->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = 'Chi Tiết Sản Phẩm';
        $product = Product::with('brand', 'catalogue')->where('id', $id)->first();

        return view('admin.products.detail', compact('product', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Cập Nhật Sản Phẩm';
        $product = Product::findOrFail($id);
        $brands = Brand::all(); // Lấy tất cả thương hiệu
        $catalogues = Catalogue::all(); // Lấy tất cả danh mục

        return view('admin.products.edit', compact('product', 'brands', 'catalogues', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $productId)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:products,slug,' . $productId,
                'sku' => 'nullable|string|max:255',
                'price' => 'required|numeric',
                'weight' => 'nullable|numeric',
                'description' => 'nullable|string',
                'dimensions' => 'nullable|string|max:255',
                'is_featured' => 'nullable|boolean',
                'condition' => 'required|in:new,used,refurbished',
                // Các quy tắc xác thực khác
            ]);

            $product = Product::findOrFail($productId);

            $product->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'sku' => $request->sku,
                'price' => $request->price,
                'weight' => $request->weight,
                'dimensions' => $request->dimensions,
                'is_active' => $request->is_active,
                'is_featured' => $request->has('is_featured'),
                'condition' => $request->condition,
                'brand_id' => $request->brand_id,
                'description' => $request->description,
                'catalogue_id' => $request->catalogue_id,
            ]);

            if ($request->hasFile("image_url")) {
                $imagePath = Storage::put('images', $request->image_url);
                $product->update(['image_url' => $imagePath]);
            }

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Sản phẩm đã được cập nhật thành công.');
        } catch (\Throwable $th) {
            DB::rollBack();
            \Log::error('Update product error: ' . $th->getMessage());
            return back()->with('errors', $th->getMessage());
        }
    }
}

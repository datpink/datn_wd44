<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    //
    // Hiển thị danh sách biến thể sản phẩm
    public function index(Request $request)
    {
        // Lấy giá trị tìm kiếm nếu có
        $search = $request->input('search');

        // Lấy danh sách biến thể sản phẩm, áp dụng tìm kiếm nếu có
        $product_variants = ProductVariant::with('product')
            ->when($search, function ($query, $search) {
                return $query->where('variant_name', 'like', "%{$search}%")
                             ->orWhereHas('product', function ($query) use ($search) {
                                 $query->where('name', 'like', "%{$search}%");
                             });
            })
            ->paginate(10); // Phân trang, mỗi trang có 10 kết quả

        // Trả về view cùng với dữ liệu biến thể sản phẩm
        return view('admin.product_variants.index', compact('product_variants'));
    }

    public function create()
    {
        // Lấy danh sách các sản phẩm để gán vào select
        $products = Product::all();

        // Trả về view thêm biến thể sản phẩm cùng với danh sách sản phẩm
        return view('admin.product_variants.create', compact('products'));
    }

    // Lưu biến thể mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric',
            'dimension' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Giới hạn kích thước file ảnh là 2MB
            // 'description' => 'nullable|string',
            'status' => 'required',
        ]);

        // Khởi tạo biến thể sản phẩm mới
        $variant = new ProductVariant();
        $variant->product_id = $request->product_id;
        $variant->variant_name = $request->variant_name;
        $variant->sku = $request->sku;
        $variant->weight = $request->weight;
        $variant->dimension = $request->dimension;
        $variant->price = $request->price;
        $variant->stock = $request->stock;
        // $variant->description = $request->description;
        $variant->status = $request->status;

        // Kiểm tra và xử lý file ảnh nếu có upload 
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('product_variants', 'public'); // Lưu ảnh vào thư mục 'product_variants' trong storage
            $variant->image_url = $imagePath;
        }

        // Lưu biến thể sản phẩm vào cơ sở dữ liệu
        $variant->save();

        // Chuyển hướng về trang danh sách biến thể sản phẩm với thông báo thành công
        return redirect()->route('product_variants.index')->with('success', 'Biến thể sản phẩm đã được thêm mới thành công.');
    }

}

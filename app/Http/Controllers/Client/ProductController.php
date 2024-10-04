<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\Product; // Đảm bảo đã import mô hình Product
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Lấy tất cả sản phẩm từ cơ sở dữ liệu
        $products = Product::paginate(6); // Bạn có thể thêm các điều kiện khác nếu cần
        return view('client.products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id); // Lấy sản phẩm theo ID
        return view('client.products.product-detail', compact('product'));
    }

    public function productByCatalogues(string $slug)
    {
        $catalogues = Catalogue::where('slug', $slug)->firstOrFail();
        
        $childCategories = Catalogue::where('parent_id', $catalogues->id)
            ->where('status', 'active')
            ->pluck('id');

        // $childCategories->push($catalogues->id);
        // dd($childCategories);

        $productByCatalogues = Product::with('catalogue')
            ->whereIn('catalogue_id', $childCategories)
            ->where('is_active', 1)
            ->paginate(10);

        // dd($productByCatalogues);

        return view('client.products.by-catalogue', compact('productByCatalogues'));
    }
}

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
        $minDiscountPrice = Product::min('discount_price');
        $maxDiscountPrice = Product::max('discount_price');


        return view('client.products.index', compact('products', 'minDiscountPrice', 'maxDiscountPrice'));
    }

    public function show($id)
    {
        dd($id);
        $product = Product::findOrFail($id); // Lấy sản phẩm theo ID
        return view('client.products.product-detail', compact('product'));
    }

    public function productByCatalogues(string $parentSlug, $childSlug = null)
    {

        $minDiscountPrice = Product::min('discount_price');
        $maxDiscountPrice = Product::max('discount_price');

        $catalogues = Catalogue::where('slug', $parentSlug)->firstOrFail();

        // dd($catalogues);

        if ($childSlug) {
            // dd($childCatalogues);

            $childCatalogues = Catalogue::where('slug', $childSlug)
                ->where('parent_id', $catalogues->id)
                ->where('status', 'active')
                ->pluck('id');

            // dd($childCatalogues);
        } else {
            $childCatalogues = Catalogue::where('parent_id', $catalogues->id)
                ->where('status', 'active')
                ->pluck('id');
        }

        // dd($childCatalogues);

        // $childCatalogues->push($catalogues->id);

        $productByCatalogues = Product::with('catalogue')
            ->whereIn('catalogue_id', $childCatalogues)
            ->where('is_active', 1)
            ->paginate(10);

        // dd($productByCatalogues);

        return view('client.products.by-catalogue', compact('productByCatalogues', 'minDiscountPrice', 'maxDiscountPrice'));
    }

    public function filterByPrice(Request $request)
    {
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        // Kiểm tra và ép kiểu nếu cần
        $minPrice = (float) $minPrice;
        $maxPrice = (float) $maxPrice;

        // Lọc sản phẩm theo khoảng giá discount_price
        $products = Product::with('catalogue')
            ->whereBetween('discount_price', [$minPrice, $maxPrice])
            ->get();

        // dd($products);
        // dd($minPrice, $maxPrice);


        return response()->json(['products' => $products]);
    }
}

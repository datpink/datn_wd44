<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // Lấy tất cả sản phẩm từ cơ sở dữ liệu
        $products = Product::paginate(6); // Bạn có thể thêm các điều kiện khác nếu cần
        $minDiscountPrice = Product::min('discount_price');
        $maxDiscountPrice = Product::max('discount_price');

        // Update image URLs using Storage::url
        foreach ($products as $product) {
            $product->image_url = $product->image_url ? Storage::url($product->image_url) : null;
        }

        // return response()->json(['products' => $products]);
        return view('client.products.index', compact('products', 'minDiscountPrice', 'maxDiscountPrice'));
    }

    public function show($slug)
    {
        // Lấy sản phẩm theo slug cùng với hình ảnh và biến thể
        $product = Product::where('slug', $slug)
            ->with([
                'galleries',
                'variants' => function ($query) {
                    $query->where('status', 'active')
                        ->with('attributeValues.attribute');
                }
            ])
            ->firstOrFail();

        return view('client.products.product-detail', compact('product'));
    }
    public function getVariantPrice(Request $request)
    {
        // Lấy thông tin biến thể dựa trên ID
        $variant = ProductVariant::find($request->variant_id);

        if ($variant) {
            // Trả về giá của biến thể
            return response()->json([
                'success' => true,
                'price' => number_format($variant->price, 0, ',', '.')
            ]);
        } else {
            // Trả về lỗi nếu không tìm thấy biến thể
            return response()->json([
                'success' => false,
                'message' => 'Biến thể không tồn tại.'
            ]);
        }
    }

    public function productByCatalogues(string $parentSlug, $childSlug = null)
    {

        $minDiscountPrice = Product::min('discount_price');
        $maxDiscountPrice = Product::max('discount_price');
        $catalogues = Catalogue::where('slug', $parentSlug)->firstOrFail();
        // $parentCataloguesID = Catalogue::where('slug', $parentSlug)->pluck('id')->first();


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
        $parentCataloguesID = $childCatalogues;
        // dd($parentCataloguesID);
        // dd($childCatalogues);

        // $childCatalogues->push($catalogues->id);

        $productByCatalogues = Product::with('catalogue')
            ->whereIn('catalogue_id', $childCatalogues)
            ->where('is_active', 1)
            ->paginate(10);

        // dd($productByCatalogues);
        foreach ($productByCatalogues as $product) {
            $product->image_url = $product->image_url ? Storage::url($product->image_url) : null;
        }



        return view('client.products.by-catalogue', compact('productByCatalogues', 'minDiscountPrice', 'maxDiscountPrice', 'parentCataloguesID'));
    }

    public function filterByPrice(Request $request)
    {
        // return $request->all();
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        $parentCataloguesID = $request->query('parentCataloguesID');
        // dd($parentCataloguesID);

        // Kiểm tra và ép kiểu nếu cần
        $minPrice = (float) $minPrice;
        $maxPrice = (float) $maxPrice;

        // Lọc sản phẩm theo khoảng giá discount_price
        $products = Product::with('catalogue')
            ->whereBetween('discount_price', [$minPrice, $maxPrice]);

        if (is_string($parentCataloguesID)) {
            // Xóa dấu ngoặc vuông và phân tách
            $parentCataloguesID = trim($parentCataloguesID, '[]');
            $parentCataloguesID = explode(',', $parentCataloguesID);
        }

        // Kiểm tra và lọc sản phẩm theo danh mục cha
        if (!empty($parentCataloguesID) && is_array($parentCataloguesID)) {
            $products->whereIn('catalogue_id', $parentCataloguesID);
        }

        $products = $products->get();
        // dd($products);
        // dd($minPrice, $maxPrice);


        return response()->json(['products' => $products]);
    }
}

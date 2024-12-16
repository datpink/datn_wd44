<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Banner;
use App\Models\Catalogue;
use App\Models\OrderItem;
use App\Models\Post;
use App\Models\Product; // Import mô hình Product
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        $menuCatalogues = (new MenuController())->getCataloguesForMenu();
        $menuCategories = (new MenuController())->getCategoriesForMenu();
        $banners = Banner::where('status', 'active')->get();

        // Lấy tất cả quảng cáo
        $advertisements = Advertisement::where('status', 'active')->get();

        // Lấy sản phẩm nổi bật
        $featuredProducts = Product::where('is_featured', true)->where('is_active', true)->paginate(14);

        // Lấy sản phẩm theo tình trạng
        $productsByCondition = [
            'new' => Product::where('condition', 'new')->where('is_active', true)->get(),
            'used' => Product::where('condition', 'used')->where('is_active', true)->get(),
            'refurbished' => Product::where('condition', 'refurbished')->where('is_active', true)->get(),
        ];

        $featuredPosts = Post::join('users', 'posts.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name as author_name')
            ->where('is_featured', true)->get();

        $topSellingProducts = OrderItem::select('product_variant_id',DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_variant_id')
            ->orderBy('total_quantity', 'desc')
            ->take(10) // Lấy 5 sản phẩm bán chạy nhất
            ->get()
            ->map(function ($item) {
                return Product::find($item->product_variant_id); // Thay đổi nếu cần
            });
            // dd($topSellingProducts);
        return view('client.index', compact('menuCatalogues', 'menuCategories', 'banners', 'advertisements', 'featuredProducts', 'productsByCondition', 'featuredPosts', 'topSellingProducts'));
    }

}

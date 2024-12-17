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
use Illuminate\Http\Request;


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

            $topSellingProducts = OrderItem::select('product_variant_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_variant_id')
            ->orderBy('total_quantity', 'desc')
            ->take(10)
            ->get()
            ->map(function ($item) {
                $product = Product::find($item->product_variant_id);
                if (!$product) {
                    \Log::warning("Product with ID {$item->product_variant_id} not found.");
                }
                return $product;
            })
            ->filter();
                // dd($featuredProducts);
        return view('client.index', compact('menuCatalogues', 'menuCategories', 'banners', 'advertisements', 'featuredProducts', 'productsByCondition', 'featuredPosts', 'topSellingProducts'));
    }

    public function searchAll(Request $request)
    {
        // dd(123);
        //  dd($listProducts);
        $searchQuery = $request->input('searchAll');
        $listProducts = Product::where('is_active', 1);
        $listPosts = Post::query();
        if ($searchQuery) {
            $listProducts->where('name', 'like', '%' . $request->input('searchAll') . '%');
            $listPosts->where(function ($query) use ($searchQuery) {
                $query->where('title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('tomtat', 'like', '%' . $searchQuery . '%');
            });
        }
        // dd($listProducts->get(), $listPosts->get());

        $listProducts = $listProducts->paginate(8);

        $listPosts = $listPosts->paginate(8);
        // dd($listProducts, $listPosts);

        return view('client.search', compact('listProducts', 'listPosts', 'searchQuery'));
    }
}

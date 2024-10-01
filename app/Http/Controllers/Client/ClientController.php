<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Catalogue;
use App\Models\Post;
use App\Models\Product; // Import mô hình Product

class ClientController extends Controller
{
    public function index()
    {
        $menuCatalogues = (new MenuController())->getCataloguesForMenu();
        $menuCategories = (new MenuController())->getCategoriesForMenu();
        $banners = Banner::where('status', 'active')->get();

        // Lấy sản phẩm nổi bật
        $featuredProducts = Product::where('is_featured', true)->where('is_active', true)->get();

        // Lấy sản phẩm theo tình trạng
        $productsByCondition = [
            'new' => Product::where('condition', 'new')->where('is_active', true)->get(),
            'used' => Product::where('condition', 'used')->where('is_active', true)->get(),
            'refurbished' => Product::where('condition', 'refurbished')->where('is_active', true)->get(),
        ];

        $featuredPosts = Post::join('users', 'posts.user_id', '=', 'users.id')
                            ->select('posts.*', 'users.name as author_name')
                            ->where('is_featured', true)->get();

        return view('client.index', compact('menuCatalogues', 'menuCategories', 'banners', 'featuredProducts', 'productsByCondition', 'featuredPosts'));
    }
}

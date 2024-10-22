<?php 
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Post; // Assuming you have a Post model
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('s');
        $type = $request->input('type', 'all');

        $products = collect();
        $posts = collect();

        // Nếu người dùng chọn "product" hoặc "all", tìm kiếm sản phẩm
        if ($type === 'product' || $type === 'all') {
            $products = Product::query()
                ->where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->orWhere('sku', 'LIKE', "%{$query}%")
                ->get();
        }

        // Nếu người dùng chọn "post" hoặc "all", tìm kiếm bài viết
        if ($type === 'post' || $type === 'all') {
            $posts = Post::query()
                ->where('title', 'LIKE', "%{$query}%")
                ->orWhere('content', 'LIKE', "%{$query}%")
                ->get();
        }

        return view('client.layouts.menu1', compact('products', 'posts', 'query', 'type'));
    }
    public function autocomplete(Request $request)
{
    $query = $request->get('query');
    $products = Product::where('name', 'LIKE', "%{$query}%")->limit(5)->get();
    $posts = Post::where('title', 'LIKE', "%{$query}%")->limit(5)->get();

    $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
    foreach ($products as $product) {
        $output .= '<li><a href="'. route('client.products.product-detail', $product->slug) .'">'.$product->name.'</a></li>';
    }
    foreach ($posts as $post) {
        $output .= '<li><a href="'. route('client.posts.show', $post->slug) .'">'.$post->title.'</a></li>';
    }
    $output .= '</ul>';

    return $output;
}

}

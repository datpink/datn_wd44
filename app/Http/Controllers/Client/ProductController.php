<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\ProductCommentReply;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // Lấy sản phẩm theo slug
        $product = Product::where('slug', $slug)
        ->with(['variants' => function($query) {
            $query->where('status', 'active'); // Chỉ lấy biến thể có status là active
        }])            ->firstOrFail(); 

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
    public function search(Request $request)
{
    // Get the search query from the request
    $query = $request->input('s');

    // Initialize query builder for products
    $products = Product::query();

    // Add search conditions
    if ($query) {
        $products->where(function ($subQuery) use ($query) {
            $subQuery->where('name', 'LIKE', "%{$query}%")
                ->orWhere('sku', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->orWhere('catalogue_id', 'LIKE', "%{$query}%")
                ->orWhere('brand_id', 'LIKE', "%{$query}%")
                ->orWhere('price', 'LIKE', "%{$query}%")
                ->orWhere('discount_price', 'LIKE', "%{$query}%")
                ->orWhere('discount_percentage', 'LIKE', "%{$query}%")
                ->orWhere('stock', 'LIKE', "%{$query}%")
                ->orWhere('weight', 'LIKE', "%{$query}%")
                ->orWhere('dimensions', 'LIKE', "%{$query}%")
                ->orWhere('ratings_avg', 'LIKE', "%{$query}%");
        });
    }

    // Filter only active products
    $products->where('is_active', 1);

    // Paginate the results
    $products = $products->paginate(9);

    // Get the maximum discount price from the database
    $maxDiscountPrice = Product::max('discount_price');
    // Return the search results to a view
    return view('client.products.product-search-results', compact('products','maxDiscountPrice'));
}
    public function storeComment(Request $request, $productId)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        ProductComment::create([
            'product_id' => $productId,
            'user_id' => Auth::id(),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->back()->with('success', 'Bình luận của bạn đã được thêm!');
    }

    // Phương thức lưu phản hồi bình luận
    public function storeReply(Request $request, $commentId)
    {
        $request->validate([
            'reply' => 'required|string|max:500',
        ]);

        ProductCommentReply::create([
            'product_comment_id' => $commentId,
            'user_id' => Auth::id(),
            'reply' => $request->input('reply'),
        ]);

        return redirect()->back()->with('success', 'Phản hồi của bạn đã được thêm!');
    }
    // Cập nhật bình luận
    public function updateComment(Request $request, $productId, $commentId)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $comment = ProductComment::findOrFail($commentId);

        // Kiểm tra xem bình luận có thuộc về người dùng hiện tại hay không
        if ($comment->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa bình luận này.');
        }

        $comment->update([
            'comment' => $request->input('comment'),
        ]);

        return redirect()->back()->with('success', 'Bình luận đã được cập nhật!');
    }
    // Xóa bình luận
    public function deleteComment($productId, $commentId)
    {
        $comment = ProductComment::findOrFail($commentId);

        // Kiểm tra quyền sở hữu bình luận
        if ($comment->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa bình luận này.');
        }

        // Xóa các phản hồi liên quan đến bình luận
        ProductCommentReply::where('product_comment_id', $commentId)->delete();

        // Xóa bình luận
        $comment->delete();

        return redirect()->back()->with('success', 'Bình luận và các phản hồi đã được xóa!');
    }

    // Cập nhật phản hồi
    public function updateReply(Request $request, $commentId, $replyId)
    {
        $request->validate([
            'reply' => 'required|string|max:500',
        ]);

        $reply = ProductCommentReply::findOrFail($replyId);

        // Kiểm tra quyền sở hữu phản hồi
        if ($reply->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa phản hồi này.');
        }

        $reply->update([
            'reply' => $request->input('reply'),
        ]);

        return redirect()->back()->with('success', 'Phản hồi đã được cập nhật!');
    }

    // Xóa phản hồi
    public function deleteReply($commentId, $replyId)
    {
        $reply = ProductCommentReply::findOrFail($replyId);

        // Kiểm tra quyền sở hữu phản hồi
        if ($reply->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa phản hồi này.');
        }

        $reply->delete();
        return redirect()->back()->with('success', 'Phản hồi đã được xóa!');
    }
}

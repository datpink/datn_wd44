<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Catalogue;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\ProductCommentReply;
use App\Models\ProductReview;
use App\Models\ProductVariant;
use App\Models\ReviewResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Lấy query gốc từ bảng Product
        $query = Product::with("variants.attributeValues")->where('is_active', 1);

        // dd($products);
        $variants = Attribute::with('attributeValues')->get();
        $variant_values = AttributeValue::with('attribute', 'productVariants')->where('attribute_id', '1')->get();

        $variant_storage_values = AttributeValue::with('attribute')->where('attribute_id', '3')->get();
        // dd($variant_storage_values);

        // Sau khi sắp xếp, phân trang
        $products = $query->paginate(6);
        // dd($products);

        $minDiscountPrice = Product::min('discount_price');
        $maxDiscountPrice = Product::max('discount_price');

        // Update image URLs using Storage::url
        foreach ($products as $product) {
            $product->image_url = $product->image_url ? Storage::url($product->image_url) : null;
        }

        // dd($products);
        return view('client.products.index', compact('products', 'minDiscountPrice', 'maxDiscountPrice', 'variant_values', 'variant_storage_values'));
    }

    public function orderByPriceApi(Request $request)
    {
        $query = Product::with('favoritedBy')->where('is_active', 1);

        $minDiscountPrice = Product::min('discount_price');
        $maxDiscountPrice = Product::max('discount_price');

        $attributeValueId = $request->input('attribute_id');
        $attributeStorageId = $request->input('attribute_storage_value_id');


        // Xử lý sắp xếp
        $orderby = $request->input('orderby');
        if ($orderby) {
            switch ($orderby) {
                case 'price-asc':
                    $query->orderBy('discount_price', 'asc');
                    break;
                case 'price-desc':
                    $query->orderBy('discount_price', 'desc');
                    break;
                default:
                    $query->orderBy('id', 'desc');
                    break;
            }
        }


        $minPrice = $request->input('price_min');
        $maxPrice = $request->input('price_max');
        // dd($minPrice);

        if ($request->input('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $query->whereBetween('discount_price', [$minPrice, $maxPrice]);

        if ($attributeValueId && $attributeStorageId) {
            // Kiểm tra sản phẩm có cả 2 thuộc tính màu và dung lượng trong cùng một biến thể
            $query->whereHas('variants', function ($query) use ($attributeValueId, $attributeStorageId) {
                $query->whereHas('attributeValues', function ($query) use ($attributeValueId) {
                    $query->where('attribute_values.id', $attributeValueId); // Lọc theo màu
                })
                    ->whereHas('attributeValues', function ($query) use ($attributeStorageId) {
                        $query->where('attribute_values.id', $attributeStorageId); // Lọc theo dung lượng
                    });
            });
        } elseif ($attributeValueId) {
            // Chỉ lọc theo màu
            $query->whereHas('variants.attributeValues', function ($query) use ($attributeValueId) {
                $query->where('attribute_values.id', $attributeValueId);
            });
        } elseif ($attributeStorageId) {
            // Chỉ lọc theo dung lượng
            $query->whereHas('variants.attributeValues', function ($query) use ($attributeStorageId) {
                $query->where('attribute_values.id', $attributeStorageId);
            });
        }

        // Sau khi sắp xếp, phân trang
        $products = $query->paginate(6);
        // $products = $query->get();

        // Cập nhật image URLs sử dụng Storage::url
        foreach ($products as $product) {
            $product->image_url = $product->image_url ? Storage::url($product->image_url) : null;
        }

        // Trả về dữ liệu sản phẩm dưới dạng JSON
        return response()->json([
            'data' => $products,
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'prev_page_url' => $products->previousPageUrl(),
                'next_page_url' => $products->nextPageUrl(),
            ],
            'minDiscountPrice' => Product::min('discount_price'),
            'maxDiscountPrice' => Product::max('discount_price'),
        ]);
    }

    // public function filterByColor(Request $request)
    // {
    //     $attributeValueId = $request->input('attribute_value_id');
    //     $products = Product::with('variants.attributeValues') // Eager load các biến thể và giá trị thuộc tính
    //         ->whereHas('variants.attributeValues', function ($query) use ($attributeValueId) {
    //             $query->where('attribute_values.id', $attributeValueId); // Lọc các sản phẩm có attribute_value_id = 1
    //         })

    //         ->get();


    //     return response()->json(['data' => $products]);
    // }


    // public function filterByStorage(Request $request)
    // {

    //     $attributeStorageValueId = $request->input('attribute_storage_value_id');
    //     // return response()->json(['data' => $attributeStorageValueId]);

    //     $products = Product::with('variants.attributeValues') // Eager load các biến thể và giá trị thuộc tính
    //         ->whereHas('variants.attributeValues', function ($query) use ($attributeStorageValueId) {
    //             $query->where('attribute_values.id', $attributeStorageValueId); // Lọc các sản phẩm có attribute_value_id = 1
    //         })

    //         ->get();


    //     return response()->json([
    //         'data' => $products,
    //     ]);
    // }



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

        // Lấy các biến thể cụ thể dựa trên thuộc tính
        $storageVariants = $product->variants->filter(function ($variant) {
            return $variant->attributeValues->contains(function ($attributeValue) {
                return $attributeValue->attribute->name === 'Storage'; // Hoặc tên thuộc tính phù hợp
            });
        });

        $colorVariants = $product->variants->filter(function ($variant) {
            return $variant->attributeValues->contains(function ($attributeValue) {
                return $attributeValue->attribute->name === 'Color'; // Hoặc tên thuộc tính phù hợp
            });
        });

        $sizeVariants = $product->variants->filter(function ($variant) {
            return $variant->attributeValues->contains(function ($attributeValue) {
                return $attributeValue->attribute->name === 'Size'; // Hoặc tên thuộc tính phù hợp
            });
        });

        // Lấy danh sách sản phẩm liên quan theo `catalogue_id`
        $relatedProducts = Product::where('catalogue_id', $product->catalogue_id)
            ->where('id', '!=', $product->id) // Loại trừ sản phẩm hiện tại
            ->with('galleries') // Nếu muốn lấy hình ảnh sản phẩm liên quan
            ->limit(6) // Số lượng sản phẩm liên quan cần hiển thị
            ->get();

        // Truyền dữ liệu vào view
        return view('client.products.product-detail', compact(
            'product',
            'storageVariants',
            'colorVariants',
            'sizeVariants',
            'relatedProducts'
        ));
    }


    // public function getVariantPrice(Request $request)
    // {
    //     // Lấy thông tin biến thể dựa trên ID
    //     $variant = ProductVariant::find($request->variant_id);

    //     if ($variant) {
    //         // Trả về giá của biến thể
    //         return response()->json([
    //             'success' => true,
    //             'price' => number_format($variant->price, 0, ',', '.')
    //         ]);
    //     } else {
    //         // Trả về lỗi nếu không tìm thấy biến thể
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Biến thể không tồn tại.'
    //         ]);
    //     }
    // }

    public function productByCatalogues(string $parentSlug, $childSlug = null)
    {

        $minDiscountPrice = Product::min('discount_price');
        $maxDiscountPrice = Product::max('discount_price');
        $catalogues = Catalogue::where('slug', $parentSlug)->firstOrFail();
        // $parentCataloguesID = Catalogue::where('slug', $parentSlug)->pluck('id')->first();
        // dd($catalogues->id);
        $variants = Attribute::with('attributeValues')->get();
        // màu
        $variant_values = AttributeValue::with('attribute')->where('attribute_id', '1')->get();

        // dung lượng
        $variant_storage_values = AttributeValue::with('attribute')->where('attribute_id', '3')->get();

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
            ->paginate(2);

        // dd($productByCatalogues);
        foreach ($productByCatalogues as $product) {
            $product->image_url = $product->image_url ? Storage::url($product->image_url) : null;
        }



        return view('client.products.by-catalogue', compact('productByCatalogues', 'minDiscountPrice', 'maxDiscountPrice', 'parentCataloguesID', 'variants', 'variant_values', 'variant_storage_values', 'catalogues', 'childCatalogues'));
    }

    public function productByCataloguesApi(Request $request)
    {
        // dd($request->all());

        // return response()->json(['data' => $request->all()]);
        $attributeValueId = $request->input('attribute_id');
        $attributeStorageId = $request->input('attribute_storage_value_id');

        $parent_id = $request->input('parent_id');
        $child_id = json_decode($request->input('child_id'), true); // Chuyển đổi chuỗi JSON thành mảng


        $minDiscountPrice = Product::min('discount_price');
        $maxDiscountPrice = Product::max('discount_price');


        $orderby = $request->input('orderby');


        $variants = Attribute::with('attributeValues')->get();
        // màu
        $variant_values = AttributeValue::with('attribute')->where('attribute_id', '1')->get();

        // dung lượng
        $variant_storage_values = AttributeValue::with('attribute')->where('attribute_id', '3')->get();



        // Xử lý các danh mục con
        if ($child_id) {
            $childCatalogues = Catalogue::whereIn('id', $child_id)
                ->where('parent_id', $parent_id)
                ->where('status', 'active')
                ->pluck('id');
        } else {
            $childCatalogues = Catalogue::where('parent_id', $parent_id)
                ->where('status', 'active')
                ->pluck('id');
        }

        $productByCatalogues = Product::with('catalogue', 'variants.attributeValues', 'favoritedBy')
            ->whereIn('catalogue_id', $childCatalogues)
            ->where('is_active', 1);


        // Áp dụng bộ lọc theo attribute
        if ($attributeValueId && $attributeStorageId) {
            // Kiểm tra sản phẩm có cả 2 thuộc tính màu và dung lượng trong cùng một biến thể
            $productByCatalogues->whereHas('variants', function ($query) use ($attributeValueId, $attributeStorageId) {
                $query->whereHas('attributeValues', function ($query) use ($attributeValueId) {
                    $query->where('attribute_values.id', $attributeValueId); // Lọc theo màu
                })
                    ->whereHas('attributeValues', function ($query) use ($attributeStorageId) {
                        $query->where('attribute_values.id', $attributeStorageId); // Lọc theo dung lượng
                    });
            });
        } elseif ($attributeValueId) {
            // Chỉ lọc theo màu
            $productByCatalogues->whereHas('variants.attributeValues', function ($query) use ($attributeValueId) {
                $query->where('attribute_values.id', $attributeValueId);
            });
        } elseif ($attributeStorageId) {
            // Chỉ lọc theo dung lượng
            $productByCatalogues->whereHas('variants.attributeValues', function ($query) use ($attributeStorageId) {
                $query->where('attribute_values.id', $attributeStorageId);
            });
        }

        if ($request->input('search')) {
            $productByCatalogues->where('name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo giá nếu có
        $minPrice = $request->input('price_min');
        $maxPrice = $request->input('price_max');
        // dd($minPrice);

        $productByCatalogues->whereBetween('discount_price', [$minPrice, $maxPrice]);

        // Xử lý sắp xếp theo giá
        if ($orderby) {
            switch ($orderby) {
                case 'price-asc':
                    $productByCatalogues->orderBy('discount_price', 'asc');  // Sắp xếp từ thấp đến cao
                    break;
                case 'price-desc':
                    $productByCatalogues->orderBy('discount_price', 'desc');  // Sắp xếp từ cao đến thấp
                    break;
                case 'price-latest':
                    // Nếu muốn sắp xếp theo sản phẩm mới nhất, bạn có thể sắp xếp theo ngày tạo
                    $productByCatalogues->orderBy('created_at', 'desc');  // Sắp xếp theo ngày tạo mới nhất
                    break;
            }
        }

        // Lấy dữ liệu sản phẩm
        $productByCatalogues = $productByCatalogues->paginate(2);

        foreach ($productByCatalogues as $product) {
            $product->image_url = $product->image_url ? Storage::url($product->image_url) : null;
        }
        // dd($productByCatalogues);
        return response()->json([
            'data' => $productByCatalogues->items(),
            'pagination' => [
                'current_page' => $productByCatalogues->currentPage(),
                'last_page' => $productByCatalogues->lastPage(),
                'per_page' => $productByCatalogues->perPage(),
                'total' => $productByCatalogues->total(),
                'prev_page_url' => $productByCatalogues->previousPageUrl(),
                'next_page_url' => $productByCatalogues->nextPageUrl(),
            ],
        ]);
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

        // $products = $products->get();
        // // dd($products);
        // // dd($minPrice, $maxPrice);


        // return response()->json(['products' => $products]);
        // Thêm phân trang
        $products = $products->paginate(2); // 10 sản phẩm mỗi trang

        return response()->json([
            'products' => $products->items(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'total' => $products->total(),
        ]);
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
        $products = $products->paginate(6);

        // Get the maximum discount price from the database
        $maxDiscountPrice = Product::max('discount_price');
        // Return the search results to a view
        return view('client.products.product-search-results', compact('products', 'maxDiscountPrice'));
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
    public function storeReview(Request $request, $productId)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review' => 'nullable|string|max:1000',
        ]);

        // Kiểm tra xem người dùng đã có đơn hàng hay chưa
        $hasOrder = Order::where('user_id', Auth::id())
            ->where('status', 'delivered') // hoặc trạng thái phù hợp với yêu cầu
            ->exists();

        if (!$hasOrder) {
            return redirect()->back()->with('error', 'Bạn cần có ít nhất một đơn hàng để đánh giá sản phẩm.');
        }

        // Lưu đánh giá
        ProductReview::create([
            'product_id' => $productId,
            'user_id' => Auth::id(),
            'rating' => $request->input('rating'),
            'review' => $request->input('review'),
        ]);

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được thêm!');
    }

    // Phương thức lưu phản hồi đánh giá
    public function storeResponse(Request $request, $reviewId)
    {
        // Kiểm tra xem người dùng có phải là admin không
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->back()->with('error', 'Bạn không có quyền phản hồi đánh giá.');
        }

        $request->validate([
            'response' => 'required|string|max:1000',
        ]);

        ReviewResponse::create([
            'review_id' => $reviewId,
            'response' => $request->input('response'),
            'responder_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Phản hồi của bạn đã được thêm!');
    }


    public function productFavorite()
    {

        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm vào danh sách yêu thích.');
        }
        $user = Auth::user();
        $products = Product::whereHas('favoritedBy.favorites', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->paginate(12);
        // dd($products);

        return view('client.products.product-favorite', compact('products'));
    }


    public function addProductFavorite(Request $request)
    {

        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (!Auth::check()) {
            return response()->json([
                'error' => 'Bạn cần đăng nhập để thêm vào danh sách yêu thích.'
            ], 401); // Trả về mã lỗi 401 khi chưa đăng nhập
        }

        $user = Auth::user();
        // dd($user);
        $productId = $request->input('product_id');
        // Kiểm tra sản phẩm đã tồn tại trong danh sách yêu thích hay chưa
        $isFavorited = $user->favorites()->where('product_id', $productId)->exists();

        if ($isFavorited) {
            return response()->json([
                'error' => 'Sản phẩm đã có trong danh sách yêu thích.'
            ], 400); // Trả về mã lỗi 400 khi sản phẩm đã có trong danh sách yêu thích
        }

        $user->favorites()->attach($productId);

        return response()->json([
            'success' => 'Sản phẩm đã được thêm vào danh sách yêu thích.'
        ], 200); // Trả về mã lỗi 200 khi thành công
    }


    public function removeProductFavorite(Request $request)
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (!Auth::check()) {
            return response()->json([
                'error' => 'Bạn cần đăng nhập để xóa khỏi danh sách yêu thích.'
            ], 401); // Trả về mã lỗi 401 khi chưa đăng nhập
        }

        $user = Auth::user();
        $productId = $request->input('product_id');

        // Kiểm tra xem sản phẩm có tồn tại trong danh sách yêu thích hay không
        $isFavorited = $user->favorites()->where('product_id', $productId)->exists();

        if (!$isFavorited) {
            return response()->json([
                'error' => 'Sản phẩm không có trong danh sách yêu thích.'
            ], 400); // Trả về mã lỗi 400 nếu sản phẩm không có trong danh sách yêu thích
        }

        // Nếu sản phẩm có trong danh sách yêu thích, xóa nó
        $user->favorites()->detach($productId);

        return response()->json([
            'success' => 'Sản phẩm đã được xóa khỏi danh sách yêu thích.'
        ], 200); // Trả về mã lỗi 200 khi thành công
    }
}

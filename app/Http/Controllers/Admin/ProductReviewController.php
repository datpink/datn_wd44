<?php
namespace App\Http\Controllers\Admin;

use App\Models\ProductReview;
use App\Models\ReviewResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductReviewController extends Controller
{
    // Hiển thị danh sách đánh giá
    public function index(Request $request)
    {
        $search = $request->input('search');
        $productReviews = ProductReview::with(['user', 'product', 'responses'])
            ->when($search, function ($query, $search) {
                $query->where('review', 'LIKE', "%{$search}%");
            })
            ->get();

        return view('admin.product_reviews.list', compact('productReviews'));
    }

    // Xóa đánh giá
    public function destroy($id)
    {
        $review = ProductReview::findOrFail($id);
        $review->delete();

        return redirect()->route('product-reviews.index')->with('destroyReview', true);
    }

    // Phản hồi đánh giá
    public function respond(Request $request, $id)
    {
        try {
            $request->validate([
                'response' => 'required|string|max:500'
            ]);
            $review = ProductReview::findOrFail($id);
            $review->responses()->create([
                'responder_id' => auth()->id(),
                'response' => $request->response,
            ]);

            return redirect()->route('product-reviews.index')->with('respond', 'Phản hồi đã được gửi.');
        } catch (\Throwable $th) {
            return redirect()->route('product-reviews.index')->with('respondError', 'Có lỗi xảy ra khi gửi phản hồi.');
        }
    }
}

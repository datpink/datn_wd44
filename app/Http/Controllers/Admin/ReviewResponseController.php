<?php

namespace App\Http\Controllers\Admin;

use App\Models\ReviewResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReviewResponseController extends Controller
{
    // Hiển thị form chỉnh sửa phản hồi đánh giá
    public function editReply($reviewId, $responseId)
    {
        $response = ReviewResponse::findOrFail($responseId);
        return view('admin.product_reviews.edit_response', compact('response', 'reviewId'));
    }

    // Cập nhật phản hồi đánh giá
    public function updateReply(Request $request, $reviewId, $responseId)
    {
        $validated = $request->validate([
            'response' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $response = ReviewResponse::findOrFail($responseId);
            $response->update(['response' => $validated['response']]);
            DB::commit();

            return redirect()->route('product-reviews.index')->with('updateResponse', 'Phản hồi đã được cập nhật.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('product-reviews.index')->with('error', 'Có lỗi xảy ra: ' . $th->getMessage());
        }
    }

    // Xóa phản hồi đánh giá
    public function destroy($id)
    {
        $response = ReviewResponse::findOrFail($id);

        // Kiểm tra quyền sở hữu
        if ($response->responder_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa phản hồi này.');
        }

        DB::beginTransaction();

        try {
            // Xóa mềm phản hồi
            $response->delete();
            DB::commit();

            return redirect()->back()->with('success', 'Phản hồi đã được xóa thành công.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $th->getMessage());
        }
    }
}

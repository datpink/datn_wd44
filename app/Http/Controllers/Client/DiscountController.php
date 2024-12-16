<?php

// app/Http/Controllers/Client/DiscountController.php

namespace App\Http\Controllers\Client;

use Session;
use Response;
use pp\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Order;
use App\Models\UserPromotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{
    public function showPromotions()
    {
        $userPromotions = UserPromotion::with('promotion')
            ->where('user_id', auth()->id())
            ->get();

        return view('client.checkout.index', compact('userPromotions'));
    }
    // Thêm mã giảm giá vào tài khoản người dùng
    public function addPromotion(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:promotions,code', // Kiểm tra mã giảm giá có tồn tại
        ]);

        $promotion = Promotion::where('code', $request->code)->first();

        // Kiểm tra xem người dùng đã có mã giảm giá này chưa
        $existingPromotion = UserPromotion::where('user_id', auth()->id())
            ->where('promotion_id', $promotion->id)
            ->first();

        if ($existingPromotion) {
            return back()->with('error', 'Bạn đã sử dụng mã giảm giá này rồi!');
        }

        // Thêm mã giảm giá vào bảng user_promotions
        UserPromotion::create([
            'user_id' => auth()->id(),
            'promotion_id' => $promotion->id,
        ]);

        return back()->with('success', 'Mã giảm giá đã được thêm vào tài khoản của bạn!');
    }
    public function applyDiscount(Request $request)
    {
        $discountCode = $request->input('discount_code');
        $validDiscounts = [
            'DISCOUNT50' => 50000,  // Mã giảm giá với giá trị 50,000
            'DISCOUNT100' => 100000, // Mã giảm giá với giá trị 100,000
        ];

        // Kiểm tra mã giảm giá hợp lệ
        if (array_key_exists($discountCode, $validDiscounts)) {
            // Lưu mã giảm giá vào session hoặc làm bất kỳ điều gì bạn cần
            Session::put('discount_code', $discountCode);
            Session::put('discount_value', $validDiscounts[$discountCode]);

            return response()->json([
                'success' => true,
                'message' => 'Mã giảm giá đã được áp dụng!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không hợp lệ.',
            ]);
        }
    }




    
}

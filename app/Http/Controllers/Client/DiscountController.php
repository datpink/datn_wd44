<?php

// app/Http/Controllers/Client/DiscountController.php

namespace App\Http\Controllers\Client;

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

        return view('client.discounts.index', compact('userPromotions'));
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

    
}


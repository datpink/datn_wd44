<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\UserPoint;
use App\Models\UserPointTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{
    public function index()
    {
        // Lấy ID của người dùng hiện tại
        $userId = Auth::id();

        // Lấy tổng điểm của người dùng từ bảng user_points
        $userPoint = UserPoint::where('user_id', $userId)->first();

        // Lấy lịch sử giao dịch của người dùng từ bảng transactions
        $transactions = UserPointTransaction::where('user_point_id', $userPoint->id)
                            ->orderBy('id', 'desc')
                            ->paginate(10); // Phân trang với 10 giao dịch mỗi trang

        // Trả về view và truyền các biến cần thiết
        return view('client.points.index', [
            'userPoint' => $userPoint,
            'transactions' => $transactions
        ]);
    }

}

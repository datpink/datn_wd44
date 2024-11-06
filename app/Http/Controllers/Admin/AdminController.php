<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class AdminController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); // Xóa session
        $request->session()->regenerateToken(); // Regenerate CSRF token
        return redirect()->route('client.index')->withCookie(Cookie::forget('laravel_session'));
    }

    // Trang chính của admin
    public function index()
    {
        $title = 'Trang Quản Trị';
        $catalogueCount = Catalogue::count();
        $orderCount = Order::count();
        $userCount = User::count();
        $productCount = Product::count();

                // Lấy danh sách người dùng mua hàng gần đây
                $recentBuyers = Order::with('user')
                ->select('user_id', DB::raw('COUNT(*) as order_count'), DB::raw('MAX(created_at) as last_order_time'))
                ->groupBy('user_id')
                ->orderBy('last_order_time', 'desc')
                ->take(5)
                ->get();
    
            // Chuyển đổi last_order_time từ chuỗi thành Carbon
            foreach ($recentBuyers as $buyer) {
                $buyer->last_order_time = Carbon::parse($buyer->last_order_time);
            }
    

        return view('admin.index', compact('title', 'recentBuyers', 'catalogueCount', 'orderCount', 'userCount', 'productCount'));
    }

    // Hiển thị thông tin cá nhân của admin
    public function profile()
    {
        $title = 'Thông Tin Cá Nhân';
        return view('admin.profile', compact('title'));
    }

    // Quản lý người dùng (phân quyền)
    public function manageUsers()
    {
        $title = 'Quản Lý Người Dùng';
        $users = User::with('roles')->paginate(10); // Lấy danh sách người dùng kèm theo vai trò của họ
        return view('admin.users.index', compact('users', 'title'));
    }
}

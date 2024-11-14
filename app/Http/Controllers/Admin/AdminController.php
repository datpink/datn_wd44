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
        return redirect()->route('client.index')
            ->withCookie(Cookie::forget('laravel_session'));
    }

    // Trang chính của admin`
    public function index()
    {
        $title = 'Trang Quản Trị';

        $catalogueCount = Catalogue::count();
        $orderCount = Order::count();
        $userCount = User::count();
        $productCount = Product::count();

        // Lấy danh sách người dùng mua hàng gần đây
        $recentBuyers = Order::with('user')
            ->select(
                'user_id',
                DB::raw('COUNT(*) as order_count'),
                DB::raw('MAX(created_at) as last_order_time')
            )
            ->groupBy('user_id')
            ->orderBy('last_order_time', 'desc')
            ->take(5)
            ->get();

        // Chuyển đổi last_order_time từ chuỗi thành Carbon
        foreach ($recentBuyers as $buyer) {
            $buyer->last_order_time = Carbon::parse($buyer->last_order_time);
        }

        // Lấy doanh thu theo ngày, chỉ tính các đơn hàng đã giao và đã thanh toán
        $dailyRevenue = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as total, SUM(discount_amount) as discount')
            ->where('status', 'shipped') // Chỉ lấy đơn hàng đã giao
            ->where('payment_status', 'paid') // Chỉ lấy đơn hàng đã thanh toán
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Chuyển đổi dữ liệu thành mảng
        $dates = $dailyRevenue->pluck('date')->toArray();
        $totals = $dailyRevenue->pluck('total')->toArray();
        $discounts = $dailyRevenue->pluck('discount')->sum(); // Tính tổng giảm giá

        // Tính tổng doanh số
        $totalSales = Order::where('status', 'shipped')
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        return view('admin.index', compact(
            'title',
            'recentBuyers',
            'catalogueCount',
            'orderCount',
            'userCount',
            'productCount',
            'dates',
            'totals',
            'totalSales',
            'discounts'
        ));
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
        return view('admin.users.index', compact(
            'users',
            'title'
        ));
    }
}

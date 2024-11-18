<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\Order;
use App\Models\OrderItem;
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
        $dates = $dailyRevenue->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('d-m-Y');
        })->toArray();

        $totals = $dailyRevenue->pluck('total')->toArray();


        $discounts = $dailyRevenue->pluck('discount')->sum(); // Tính tổng giảm giá

        // Tính tổng doanh số
        $totalSales = Order::where('status', 'shipped')
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        // Lấy danh sách đơn hàng và các sản phẩm kèm theo
        $orders = Order::with(['user', 'items.productVariant.product']) // Đảm bảo lấy đúng thông tin sản phẩm
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();


        // Lấy số lượng đơn hàng theo trạng thái, chỉ lấy "processing" và "shipped" cho danh sách
        $ordersByStatusForList = Order::select('status', \DB::raw('COUNT(*) as count'))
            ->whereIn('status', ['processing', 'shipped']) // Chỉ lấy hai trạng thái này cho danh sách
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Đảm bảo đủ tất cả các trạng thái cần thiết
        $statusesForList = ['processing', 'shipped']; // Chỉ cần trạng thái này cho danh sách
        $ordersByStatusForList = array_replace(array_fill_keys($statusesForList, 0), $ordersByStatusForList);

        // Lấy số lượng đơn hàng cho tất cả các trạng thái để hiển thị trên biểu đồ
        $ordersByStatusForChart = Order::select('status', \DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Đảm bảo đủ tất cả các trạng thái cho biểu đồ
        $statusesForChart = ['processing', 'Delivering', 'shipped', 'canceled', 'refunded'];
        $ordersByStatusForChart = array_replace(array_fill_keys($statusesForChart, 0), $ordersByStatusForChart);


        // Truy vấn Top 10 sản phẩm bán chạy, bao gồm eager load product
        $topSellingProducts = OrderItem::select('product_variant_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_variant_id')
            ->orderByDesc('total_quantity') // Sắp xếp theo số lượng bán
            ->limit(10) // Lấy 10 sản phẩm bán chạy nhất
            ->with('productVariant.product') // Eager load quan hệ product từ product_variant
            ->get();

        // Lấy tên sản phẩm hoặc mã sản phẩm tương ứng với `product_variant_id`
        $topSellingProductNames = $topSellingProducts->map(function ($item) {
            // Kiểm tra sự tồn tại của product_variant và product trước khi truy cập thuộc tính name
            if ($item->productVariant && $item->productVariant->product) {
                return $item->productVariant->product->name;
            }
            return 'Không xác định';
        });


        $topSellingProductQuantities = $topSellingProducts->pluck('total_quantity');

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
            'discounts',
            'orders',
            'ordersByStatusForList',
            'ordersByStatusForChart',
            'topSellingProducts',
            'topSellingProductNames',
            'topSellingProductQuantities'
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

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
    public function index(Request $request)
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

        // Lấy tham số period từ query string
        $period = $request->input('period', 'today'); // Mặc định là 'today'

        // Khởi tạo các mốc thời gian
        $startDate = Carbon::today()->timezone('Asia/Ho_Chi_Minh'); // Chuyển đổi sang múi giờ Việt Nam
        $endDate = Carbon::today()->timezone('Asia/Ho_Chi_Minh'); // Chuyển đổi sang múi giờ Việt Nam

        // Xử lý khoảng thời gian dựa trên tham số period
        switch ($period) {
            case 'yesterday':
                $startDate = Carbon::yesterday();
                $endDate = Carbon::yesterday();
                break;
            case '7days':
                $startDate = Carbon::today()->subDays(6);
                break;
            case '15days':
                $startDate = Carbon::today()->subDays(14);
                break;
            case '30days':
                $startDate = Carbon::today()->subDays(29);
                break;
            case '1years':
                $startDate = Carbon::today()->subDays(364);
                break;
            default:
                // Mặc định là hôm nay
                $startDate = Carbon::today();
                break;
        }

        $dailyRevenue = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->whereDate('created_at', '>=', $startDate->toDateString())
            ->whereDate('created_at', '<=', $endDate->toDateString())
            ->where('status', 'delivered')
            ->where('payment_status', 'paid')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // dd($dailyRevenue);

        // Chuyển đổi dữ liệu thành mảng
        $dates = $dailyRevenue->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('d-m-Y');
        })->toArray();

        $totals = $dailyRevenue->pluck('total')->toArray();


        $discounts = $dailyRevenue->pluck('discount')->sum(); // Tính tổng giảm giá

        // Tính tổng doanh số
        $totalSales = Order::where('status', 'delivered') // Thay 'shipped' thành 'delivered'
            ->where('payment_status', 'paid') // Giữ nguyên trạng thái thanh toán
            ->sum('total_amount');


        // Lấy danh sách đơn hàng và các sản phẩm kèm theo
        $orders = Order::with(['user', 'items.productVariant.product']) // Đảm bảo lấy đúng thông tin sản phẩm
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();


        // Lấy số lượng đơn hàng theo trạng thái, chỉ lấy "processing" và "shipped" cho danh sách
        $ordersByStatusForList = Order::select('status', \DB::raw('COUNT(*) as count'))
            ->whereIn('status', ['pending_confirmation', 'delivered']) // Chỉ lấy hai trạng thái này cho danh sách
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Đảm bảo đủ tất cả các trạng thái cần thiết
        $statusesForList = ['pending_confirmation', 'delivered']; // Chỉ cần trạng thái này cho danh sách
        $ordersByStatusForList = array_replace(array_fill_keys($statusesForList, 0), $ordersByStatusForList);

        // Lấy số lượng đơn hàng cho tất cả các trạng thái để hiển thị trên biểu đồ
        $ordersByStatusForChart = Order::select('status', \DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Đảm bảo đủ tất cả các trạng thái cho biểu đồ
        $statusesForChart = [
            'pending_confirmation', // Chờ xác nhận
            'pending_pickup',       // Chờ lấy hàng
            'pending_delivery',     // Chờ giao hàng
            'delivered',            // Đã giao hàng
            'returned',             // Trả hàng
            'canceled'              // Đã hủy
        ];

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

        //lợi nhuận
        $profits = DB::table('product_variants')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->select(
                'product_variants.id as variant_id',
                'products.price as base_price',
                'product_variants.price as variant_price',
                DB::raw('(product_variants.price - products.price) as profit')
            )
            ->get();

        // Tính tổng lợi nhuận từ các biến thể
        $totalProfit = $profits->sum('profit'); // Tổng lãi từ danh sách biến thể

        // Tính lãi sau khi trừ giảm giá
        $netProfit = $totalProfit - $discounts; // Trừ tổng giảm giá

        return view('admin.index', compact(
            'title',
            'recentBuyers',
            'totalProfit',
            'profits',
            'netProfit',
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
            'period',
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

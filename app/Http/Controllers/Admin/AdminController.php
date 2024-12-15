<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;


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

        // Lấy tham số selectedPeriod từ query string
        $selectedPeriod = $request->input('selectedPeriod', '1day'); // Mặc định là '1day'

        // Khởi tạo mốc thời gian
        $periodStart = Carbon::today()->timezone('Asia/Ho_Chi_Minh'); // Chuyển đổi sang múi giờ Việt Nam

        // Xử lý khoảng thời gian dựa trên tham số selectedPeriod
        switch ($selectedPeriod) {
            case '1day':
                $periodStart = Carbon::today()->subDay(); // Lùi lại 1 ngày
                break;
            case '2weeks':
                $periodStart = Carbon::today()->subWeeks(2); // Lùi lại 2 tuần
                break;
            case '1month':
                $periodStart = Carbon::today()->subMonth(); // Lùi lại 1 tháng
                break;
            default:
                $periodStart = Carbon::today()->subDay(); // Mặc định là 1 ngày
                break;
        }

        // Lấy danh sách người dùng mua hàng gần đây trong khoảng thời gian đã xác định
        $recentBuyers = Order::with('user')
            ->select(
                'user_id',
                DB::raw('COUNT(*) as order_count'),
                DB::raw('MAX(created_at) as last_order_time')
            )
            ->where('created_at', '>=', $periodStart) // Lọc theo khoảng thời gian
            ->groupBy('user_id')
            ->orderBy('last_order_time', 'desc')
            ->take(1010)
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

        $dailyRevenue = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as total, SUM(discount_amount) as discount_amount')
            ->whereDate('created_at', '>=', $startDate->toDateString())
            ->whereDate('created_at', '<=', $endDate->toDateString())
            ->whereIn('status', ['delivered', 'confirm_delivered'])
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


        $discounts = $dailyRevenue->sum('discount_amount');

        // dd($totals, $discounts);

        // Tính tổng doanh số
        $totalSales = Order::whereIn('status', ['delivered', 'confirm_delivered'])
            ->where('payment_status', 'paid') // Giữ nguyên trạng thái thanh toán
            ->sum('total_amount');


        // Lấy tham số selectedOrderPeriod từ query string
        $selectedOrderPeriod = $request->input('selectedOrderPeriod', '1day'); // Mặc định là '1week'

        // Khởi tạo mốc thời gian
        $startDate = Carbon::today()->timezone('Asia/Ho_Chi_Minh');
        $endDate = Carbon::today()->timezone('Asia/Ho_Chi_Minh');

        // Xử lý khoảng thời gian dựa trên tham số selectedOrderPeriod
        switch ($selectedOrderPeriod) {
            case '1day':
                $startDate = Carbon::today();
                break;
            case '1week':
                $startDate = Carbon::today()->subWeeks(1);
                break;
            case '2weeks':
                $startDate = Carbon::today()->subWeeks(2);
                break;
            case '3weeks':
                $startDate = Carbon::today()->subWeeks(3);
                break;
            case '4weeks':
                $startDate = Carbon::today()->subWeeks(4);
                break;
            default:
                $startDate = Carbon::today();
                break;
        }

        // Truy vấn danh sách đơn hàng và các sản phẩm
        $orders = Order::with(['user', 'items.productVariant.product', 'items.product']) // Đảm bảo lấy đúng thông tin sản phẩm
            ->whereBetween('created_at', [$startDate, $endDate]) // Lọc theo khoảng thời gian
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // dd($orders);


        // Lấy tham số filterPeriod từ query string
        $filterPeriod = $request->input('filterPeriod', 'today'); // Mặc định là 'today'

        // Khởi tạo các mốc thời gian
        $filterStart = Carbon::today()->timezone('Asia/Ho_Chi_Minh');
        $filterEnd = Carbon::today()->timezone('Asia/Ho_Chi_Minh');

        // Xử lý khoảng thời gian dựa trên tham số filterPeriod
        switch ($filterPeriod) {
            case 'yesterday':
                $filterStart = Carbon::yesterday();
                $filterEnd = Carbon::yesterday();
                break;
            case '7days':
                $filterStart = Carbon::today()->subDays(6);
                $filterEnd = Carbon::today();
                break;
            case '15days':
                $filterStart = Carbon::today()->subDays(14);
                $filterEnd = Carbon::today();
                break;
            case '30days':
                $filterStart = Carbon::today()->subDays(29);
                $filterEnd = Carbon::today();
                break;
            case '1years':
                $filterStart = Carbon::today()->subDays(364);
                $filterEnd = Carbon::today();
                break;
            default:
                $filterStart = Carbon::today();
                break;
        }


        // Lấy số lượng đơn hàng theo trạng thái, chỉ lấy "processing" và "shipped" cho danh sách
        $ordersByStatusForList = Order::select('status', \DB::raw('COUNT(*) as count'))
            ->whereIn('status', ['pending_confirmation', 'delivered']) // Chỉ lấy hai trạng thái này cho danh sách
            ->whereBetween('created_at', [$filterStart->startOfDay(), $filterEnd->endOfDay()])
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Đảm bảo đủ tất cả các trạng thái cần thiết
        $statusesForList = ['pending_confirmation', 'delivered']; // Chỉ cần trạng thái này cho danh sách
        $ordersByStatusForList = array_replace(array_fill_keys($statusesForList, 0), $ordersByStatusForList);

        // Lấy số lượng đơn hàng cho tất cả các trạng thái để hiển thị trên biểu đồ
        $ordersByStatusForChart = Order::select('status', \DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [$filterStart->startOfDay(), $filterEnd->endOfDay()])
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Đảm bảo đủ tất cả các trạng thái cho biểu đồ
        $statusesForChart = [
            'pending_confirmation', // Chờ xác nhận
            'pending_pickup',       // Chờ lấy hàng
            'pending_delivery',     // Chờ giao hàng
            'delivered',            // Đã giao hàng
            'confirm_delivered',    // Chờ xác nhận giao
            'returned',             // Trả hàng
            'canceled'              // Đã hủy
        ];

        // dd($ordersByStatusForChart);

        $ordersByStatusForChart = array_replace(array_fill_keys($statusesForChart, 0), $ordersByStatusForChart);


        // Lấy tham số timePeriod từ query string
        $timePeriod = $request->input('timePeriod', 'today'); // Mặc định là 'today'

        // Khởi tạo các mốc thời gian
        $timeStart = Carbon::today()->timezone('Asia/Ho_Chi_Minh'); // Chuyển đổi sang múi giờ Việt Nam
        $timeEnd = Carbon::today()->timezone('Asia/Ho_Chi_Minh'); // Chuyển đổi sang múi giờ Việt Nam

        // Xử lý khoảng thời gian dựa trên tham số timePeriod
        switch ($timePeriod) {
            case 'yesterday':
                $timeStart = Carbon::yesterday();
                $timeEnd = Carbon::yesterday();
                break;
            case '7days':
                $timeStart = Carbon::today()->subDays(6);
                $timeEnd = Carbon::today();
                break;
            case '15days':
                $timeStart = Carbon::today()->subDays(14);
                $timeEnd = Carbon::today();
                break;
            case '30days':
                $timeStart = Carbon::today()->subDays(29);
                $timeEnd = Carbon::today();
                break;
            case '1years':
                $timeStart = Carbon::today()->subDays(364);
                $timeEnd = Carbon::today();
                break;
            default:
                // Mặc định là hôm nay
                $timeStart = Carbon::today();
                break;
        }

        // Truy vấn Top 10 sản phẩm bán chạy trong khoảng thời gian đã xác định
        $topSellingProducts = OrderItem::select('product_id', 'product_variant_id', DB::raw('SUM(quantity) as total_quantity'))
            ->whereBetween('created_at', [$timeStart->startOfDay(), $timeEnd->endOfDay()]) // Thêm điều kiện thời gian
            ->groupBy('product_id', 'product_variant_id') // Group theo cả product_id và product_variant_id
            ->orderByDesc('total_quantity') // Sắp xếp theo số lượng bán
            ->limit(10) // Lấy 10 sản phẩm bán chạy nhất
            ->with(['product', 'productVariant.product']) // Eager load quan hệ product và product từ product_variant
            ->get();

        // Lấy tên sản phẩm hoặc mã sản phẩm tương ứng và giới hạn tên
        $topSellingProductNames = $topSellingProducts->map(function ($item) {
            if ($item->productVariant && $item->productVariant->product) {
                // Nếu tồn tại productVariant và product
                return Str::limit($item->productVariant->product->name, 10, '...'); // Giới hạn tên 10 ký tự
            } elseif ($item->product) {
                // Nếu chỉ tồn tại product
                return Str::limit($item->product->name, 10, '...'); // Giới hạn tên 10 ký tự
            }
            return 'Không xác định'; // Không xác định nếu cả hai đều không tồn tại
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


        // Lấy tham số timeRange từ query string
        $timeRange = $request->input('timeRange', '4months'); // Mặc định là '4months'

        // Khởi tạo mốc thời gian
        $rangeStart = Carbon::today()->timezone('Asia/Ho_Chi_Minh'); // Chuyển đổi sang múi giờ Việt Nam

        // Xử lý khoảng thời gian dựa trên tham số timeRange
        switch ($timeRange) {
            case '4months':
                $rangeStart = Carbon::today()->subMonths(4); // Lùi lại 4 tháng
                break;
            case '8months':
                $rangeStart = Carbon::today()->subMonths(8); // Lùi lại 8 tháng
                break;
            case '1year':
                $rangeStart = Carbon::today()->subYear(); // Lùi lại 1 năm
                break;
            default:
                $rangeStart = Carbon::today()->subMonths(4); // Mặc định là 4 tháng
                break;
        }

        // Lấy ngày kết thúc là ngày hiện tại
        $rangeEnd = Carbon::today()->timezone('Asia/Ho_Chi_Minh');

        // Truy vấn thống kê từ cơ sở dữ liệu dựa trên khoảng thời gian đã xác định
        $statistics = Order::where('status', 'delivered')
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$rangeStart, $rangeEnd]) // Lọc theo khoảng thời gian
            ->groupBy('payment_method_id') // Nhóm theo phương thức thanh toán
            ->select('payment_method_id', DB::raw('SUM(total_amount) as total_amount'), DB::raw('COUNT(*) as total_orders'))
            ->get();

        // Lấy tên và mô tả phương thức thanh toán từ bảng payment_methods
        $paymentMethods = PaymentMethod::where('status', 'active')->get()->keyBy('id');

        // Kết hợp thông tin phương thức thanh toán với thống kê
        $statisticsWithPaymentMethod = $statistics->map(function ($statistic) use ($paymentMethods) {
            $paymentMethod = $paymentMethods->get($statistic->payment_method_id);
            $statistic->payment_method_name = $paymentMethod->name ?? 'Unknown';
            $statistic->payment_method_description = $paymentMethod->description ?? 'No description available';
            return $statistic;
        });

        // Lấy 10 sản phẩm có lượt xem cao nhất
        $topProducts = Product::orderBy('views', 'desc')->take(7)->get();

        // Cắt tên sản phẩm và bài viết nếu quá 10 ký tự
        $topProducts = $topProducts->map(function ($product) {
            $product->name = strlen($product->name) > 10 ? substr($product->name, 0, 5) . '...' : $product->name;
            return $product;
        });

        // Lấy 10 bài viết có lượt xem cao nhất
        $topPosts = Post::orderBy('views', 'desc')->take(7)->get();

        $topPosts = $topPosts->map(function ($post) {
            $post->title = strlen($post->title) > 10 ? substr($post->title, 0, 5) . '...' : $post->title;
            return $post;
        });


        return view('admin.index', compact(
            'title',
            'topProducts',
            'topPosts',
            'timePeriod',
            'filterPeriod',
            'timeRange',
            'selectedOrderPeriod',
            'selectedPeriod',
            'recentBuyers',
            'totalProfit',
            'profits',
            'netProfit',
            'statisticsWithPaymentMethod',
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

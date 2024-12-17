@extends('admin.master')

@section('title', 'Thống kê Dashboard')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <div class="content-wrapper-scroll">

        <!-- Content wrapper start -->
        <div class="content-wrapper">

            <!-- Row start -->
            <div class="row">
                <div class="col-xxl-3 col-sm-6 col-12">
                    <div class="stats-tile">
                        <div class="sale-icon shade-red">
                            <i class="bi bi-pie-chart"></i>
                        </div>
                        <div class="sale-details">
                            <h3 class="text-red">{{ $catalogueCount }}</h3>
                            <a href="{{ route('catalogues.index') }}">Danh Mục</a>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6 col-12">
                    <div class="stats-tile">
                        <div class="sale-icon shade-blue">
                            <i class="bi bi-emoji-smile"></i>
                        </div>
                        <div class="sale-details">
                            <h3 class="text-yellow">{{ $userCount }}</h3>
                            <a href="{{ route('users.index') }}">Tài Khoản</a>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6 col-12">
                    <div class="stats-tile">
                        <div class="sale-icon shade-yellow">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div class="sale-details">
                            <h3 class="text-blue">{{ $productCount }}</h3>
                            <a href="{{ route('products.index') }}">Sản Phẩm</a>

                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6 col-12">
                    <div class="stats-tile">
                        <div class="sale-icon shade-green">
                            <i class="bi bi-handbag"></i>
                        </div>
                        <div class="sale-details">
                            <h3 class="text-green">{{ $orderCount }}</h3>
                            <a href="{{ route('orders.index') }}">Đơn Hàng</a>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-sm-6 col-12">
                    <div class="stats-tile">
                        <div class="sale-icon shade-green">
                            <i class="bi bi-handbag"></i>
                        </div>
                        <div class="sale-details">
                            <h3 class="text-green">{{ $countPost }}</h3>
                            <a href="{{ route('posts.index') }}">Tin Tức</a>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-sm-6 col-12">
                    <div class="stats-tile">
                        <div class="sale-icon shade-green">
                            <i class="bi bi-handbag"></i>
                        </div>
                        <div class="sale-details">
                            <h3 class="text-green">{{ $ProductComment }}</h3>
                            <a href="{{ route('product-comments.index') }}">Bình Luận Sản Phẩm</a>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-sm-6 col-12">
                    <div class="stats-tile">
                        <div class="sale-icon shade-green">
                            <i class="bi bi-handbag"></i>
                        </div>
                        <div class="sale-details">
                            <h3 class="text-green">{{ $countComment }}</h3>
                            <a href="{{ route('comments.index') }}">Bình Luận Bài Viết</a>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-sm-6 col-12">
                    <div class="stats-tile">
                        <div class="sale-icon shade-green">
                            <i class="bi bi-handbag"></i>
                        </div>
                        <div class="sale-details">
                            <h3 class="text-green">{{ $countProductReview }}</h3>
                            <a href="{{ route('product-reviews.index') }}">Đánh Giá</a>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Row end -->

            <!-- Row start -->
            <div class="row">
                <div class="col-xxl-12  col-sm-12 col-12">
                    <!-- Row start -->
                    <div class="row">
                        <div class="col-xxl-12 col-sm-12 col-12">

                            <div class="card">
                                <div class="card-body">

                                    <!-- Row start -->
                                    <div class="row">
                                        <div class="col-xxl-3 col-sm-4 col-md-12">
                                            <div class="reports-summary">
                                                <h5 class="mb-4">Tổng Quan Doanh Thu</h5>
                                                <div class="reports-summary-block mb-3">
                                                    <i class="bi bi-circle-fill text-primary me-2"></i>
                                                    <div class="d-flex flex-column">
                                                        <h6>Tổng Doanh Số</h6>
                                                        <h5 class="text-primary">
                                                            {{ number_format($totalSales, 0, ',', '.') }}
                                                            VNĐ</h5>
                                                    </div>
                                                </div>
                                                <div class="reports-summary-block mb-3">
                                                    <i class="bi bi-circle-fill text-success me-2"></i>
                                                    <div class="d-flex flex-column">
                                                        <h6>Doanh Thu Tổng</h6>
                                                        <h5 class="text-success">
                                                            {{ number_format(array_sum($totals), 0, ',', '.') }} VNĐ</h5>
                                                    </div>
                                                </div>
                                                <div class="reports-summary-block mb-3">
                                                    <i class="bi bi-circle-fill text-danger me-2"></i>
                                                    <div class="d-flex flex-column">
                                                        <h6>Doanh Thu Sau Giảm Giá</h6>
                                                        <h5 class="text-danger">
                                                            {{ number_format(array_sum($totals) - $discounts, 0, ',', '.') }}
                                                            VNĐ</h5>
                                                    </div>
                                                </div>
                                                <div class="reports-summary-block mb-3">
                                                    <i class="bi bi-circle-fill text-blue me-2"></i>
                                                    <div class="d-flex flex-column">
                                                        <h6>Lợi Nhuận</h6>
                                                        <h5 class="text-danger">
                                                            {{ number_format($netProfit, 0, ',', '.') }}
                                                            VNĐ</h5>
                                                    </div>
                                                </div>
                                                {{-- <button class="btn btn-info w-100">Xem Báo Cáo</button> --}}
                                            </div>
                                        </div>
                                        <div class="col-xxl-9 col-sm-8 col-md-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="graph-day-selection mt-2" role="group">
                                                        <a href="?period=today"
                                                            class="btn {{ $period == 'today' ? 'btn active' : 'btn-primary' }}">Today</a>
                                                        <a href="?period=yesterday"
                                                            class="btn {{ $period == 'yesterday' ? 'btn active' : 'btn-primary' }}">Yesterday</a>
                                                        <a href="?period=7days"
                                                            class="btn {{ $period == '7days' ? 'btn active' : 'btn-primary' }}">7
                                                            days</a>
                                                        <a href="?period=15days"
                                                            class="btn {{ $period == '15days' ? 'btn active' : 'btn-primary' }}">15
                                                            days</a>
                                                        <a href="?period=30days"
                                                            class="btn {{ $period == '30days' ? 'btn active' : 'btn-primary' }}">30
                                                            days</a>
                                                        <a href="?period=1years"
                                                            class="btn {{ $period == '1years' ? 'btn active' : 'btn-primary' }}">1years</a>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <div id="revenueGraph" style="height: 400px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row end -->
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Row end -->
                </div>
            </div>
            <!-- Row end -->

            <div class="row">
                <div class="col-lg-7 col-sm-12 col-12">
                    <div class="card">
                        <!-- Header -->
                        <div class="card-header">
                            <h4 class="card-title mb-0">Sản Phẩm Bán Chạy</h4>
                        </div>

                        <!-- Body -->
                        <div class="card-body">
                            <!-- Bộ lọc thời gian -->
                            <div class="d-flex justify-content-end mb-3">

                                <div class="btn-group" role="group" aria-label="Filter Time Period">
                                    <div id="time-period-options">

                                        <a href="?timePeriod=today" data-time-period="today"
                                            class="btn btn-sm btn-primary">Hôm nay</a>
                                        <a href="?timePeriod=yesterday" data-time-period="yesterday"
                                            class="btn btn-sm btn-outline-primary">Hôm qua</a>
                                        <a href="?timePeriod=7days" data-time-period="7days"
                                            class="btn btn-sm btn-outline-primary">7 ngày</a>
                                        <a href="?timePeriod=15days" data-time-period="15days"
                                            class="btn btn-sm btn-outline-primary">15 ngày</a>
                                        <a href="?timePeriod=30days" data-time-period="30days"
                                            class="btn btn-sm btn-outline-primary">30 ngày</a>
                                        <a href="?timePeriod=1years" data-time-period="1years"
                                            class="btn btn-sm btn-outline-primary">1 year</a>
                                    </div>
                                </div>

                            </div>


                            <!-- Biểu đồ -->
                            <div id="basic-column-graph-datalables" style="height: 300px;">
                                <!-- Nội dung biểu đồ được render bởi JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Giao Dịch</div>
                        </div>
                        <div class="card-body">
                            <div id="transaction-time">
                                <a href="?timeRange=4months" data-time-range = "4months"
                                    class="btn btn-sm btn-outline-primary">4
                                    tháng</a>
                                <a href="?timeRange=8months" data-time-range = "8months"
                                    class="btn btn-sm btn-outline-primary">8
                                    tháng</a>
                                <a href="?timeRange=1year" data-time-range = "1year"
                                    class="btn btn-sm btn-outline-primary">1
                                    năm</a>
                            </div>
                            <div class="scroll370">
                                <div class="transactions-container" id="transactions-container">
                                    {{-- @foreach ($statisticsWithPaymentMethod as $statistic)
                                        <div class="transaction-block">
                                            <div class="transaction-icon shade-blue">
                                                <i class="bi bi-credit-card"></i>
                                            </div>
                                            <div class="transaction-details">
                                                <h4>{{ $statistic->payment_method_name }}</h4>
                                                <p class="text-truncate">{{ $statistic->payment_method_description }}</p>
                                            </div>
                                            <div class="transaction-amount text-blue">
                                                @if (floor($statistic->total_amount) == $statistic->total_amount)
                                                    {{ number_format($statistic->total_amount) }} VND
                                                @else
                                                    {{ number_format($statistic->total_amount, 2) }} VND
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <!-- Row start -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Đơn Hàng Mới</div>
                            <div class="mb-3" id="option-order-time">
                                <a href="?selectedOrderPeriod=1day" data-selected-order-time = "1day"
                                    class="btn btn-sm btn-outline-primary">Hôm nay</a>
                                <a href="?selectedOrderPeriod=1week" data-selected-order-time = "1week"
                                    class="btn btn-sm btn-outline-primary">1 tuần</a>
                                <a href="?selectedOrderPeriod=2weeks" data-selected-order-time = "2weeks"
                                    class="btn btn-sm btn-outline-primary">2 tuần</a>
                                <a href="?selectedOrderPeriod=3weeks" data-selected-order-time = "3weeks"
                                    class="btn btn-sm btn-outline-primary">3 tuần</a>
                                <a href="?selectedOrderPeriod=44weeks" data-selected-order-time = "44weeks"
                                    class="btn btn-sm btn-outline-primary">4 tuần</a>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table v-middle">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Người Dùng</th>
                                            <th>Sản Phẩm</th>
                                            <th>Ngày Mua</th>
                                            <th>Giá</th>
                                            <th>Trạng Thái Thanh Toán</th>
                                            <th>Trạng Thái Đơn Hàng</th>
                                        </tr>
                                    </thead>
                                    <tbody id="order-time-content">
                                        {{-- @foreach ($orders as $order)
                                            @foreach ($order->items as $item)
                                                <!-- Lặp qua các sản phẩm trong đơn hàng -->
                                                 <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>
                                                        <div class="media-box">
                                                            <div class="media-box-body">
                                                                <div class="text-truncate">
                                                                    {{ $order->user->name ?? 'Unknown' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="media-box">
                                                            <div class="media-box-body">
                                                                <div class="text-truncate">
                                                                    <!-- Kiểm tra nếu có productVariant, nếu không thì lấy từ product -->
                                                                    @if ($item->productVariant)
                                                                        {{ $item->productVariant->product->name ?? 'Unknown Product' }}
                                                                    @else
                                                                        {{ $item->product->name ?? 'Unknown Product' }}
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                                    <td>
                                                        @if (floor($order->total_amount) == $order->total_amount)
                                                            {{ number_format($order->total_amount) }} VND
                                                        @else
                                                            {{ number_format($order->total_amount, 2) }} VND
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($order->payment_status === 'unpaid')
                                                            <span class="badge rounded-pill bg-warning">Chưa thanh
                                                                toán</span>
                                                        @elseif ($order->payment_status === 'paid')
                                                            <span class="badge rounded-pill bg-success">Đã thanh
                                                                toán</span>
                                                        @elseif ($order->payment_status === 'refunded')
                                                            <span class="badge rounded-pill bg-danger">Hoàn trả</span>
                                                        @elseif ($order->payment_status === 'payment_failed')
                                                            <span class="badge rounded-pill bg-danger">Thanh toán thất
                                                                bại</span>
                                                        @else
                                                            <span class="badge rounded-pill bg-secondary">Không rõ</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($order->status === 'pending_confirmation')
                                                            <span class="badge rounded-pill bg-info">Chờ xác nhận</span>
                                                        @elseif ($order->status === 'pending_pickup')
                                                            <span class="badge rounded-pill bg-warning">Chờ lấy hàng</span>
                                                        @elseif ($order->status === 'pending_delivery')
                                                            <span class="badge rounded-pill bg-primary">Chờ giao
                                                                hàng</span>
                                                        @elseif ($order->status === 'returned')
                                                            <span class="badge rounded-pill bg-danger">Trả hàng</span>
                                                        @elseif ($order->status === 'delivered')
                                                            <span class="badge rounded-pill bg-secondary">Đã giao</span>
                                                        @elseif ($order->status === 'confirm_delivered')
                                                            <span class="badge rounded-pill bg-secondary">Đã giao</span>
                                                        @elseif ($order->status === 'canceled')
                                                            <span class="badge rounded-pill bg-secondary">Đã hủy</span>
                                                        @else
                                                            <span class="badge rounded-pill bg-secondary">Không rõ</span>
                                                        @endif
                                                    </td>
                                                </tr> 
                                            @endforeach
                                        @endforeach --}}
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row end -->

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Thống Kê Theo Trạng Thái</h4>
                        </div>
                        <div class="card-body">
                            <!-- Bộ lọc thời gian -->
                            <div class="mb-3 d-flex gap-2" id="time-period-options-status">
                                <a href="?filterPeriod=today" class="btn btn-sm btn-outline-primary"
                                    data-filter-period="today">Hôm nay</a>
                                <a href="?filterPeriod=yesterday" class="btn btn-sm btn-outline-primary"
                                    data-filter-period="yesterday">Hôm qua</a>
                                <a href="?filterPeriod=7days" class="btn btn-sm btn-outline-primary"
                                    data-filter-period="7days">7 ngày</a>
                                <a href="?filterPeriod=15days" class="btn btn-sm btn-outline-primary"
                                    data-filter-period="15days">15 ngày</a>
                                <a href="?filterPeriod=30days" class="btn btn-sm btn-outline-primary"
                                    data-filter-period="30days">30 ngày</a>
                                <a href="?filterPeriod=1years" class="btn btn-sm btn-outline-primary"
                                    data-filter-period="1years">1 năm</a>
                            </div>

                            <!-- Container cho biểu đồ -->
                            <div id="taskGraph"></div>



                            <!-- Biểu đồ thống kê -->
                            <div id="taskGraph" class="mb-4">
                                <!-- Nội dung biểu đồ (được render bởi JS hoặc PHP) -->
                            </div>

                            <!-- Danh sách thống kê -->
                            <ul class="list-group">
                                @foreach ($ordersByStatusForList as $status => $count)
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="task-icon bg-{{ $loop->index % 4 === 0 ? 'primary' : ($loop->index % 3 === 0 ? 'success' : 'danger') }} text-white rounded-circle d-flex justify-content-center align-items-center"
                                                style="width: 40px; height: 40px;">
                                                <i
                                                    class="bi bi-clipboard-{{ $status === 'shipped' ? 'check' : 'plus' }}"></i>
                                            </div>
                                            <span class="fw-bold">{{ ucfirst($status) }}</span>
                                        </div>
                                        <span class="badge bg-secondary rounded-pill">{{ $count }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Người Mua Gần Đây</div>
                        </div>
                        <div class="card-body">
                            <div>
                                <a href="?selectedPeriod=1day"
                                    class="btn btn-sm {{ $selectedPeriod == '1day' ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Hôm nay</a>
                                <a href="?selectedPeriod=2weeks"
                                    class="btn btn-sm {{ $selectedPeriod == '2weeks' ? 'btn-primary' : 'btn-outline-primary' }}">2
                                    Tuần</a>
                                <a href="?selectedPeriod=1month"
                                    class="btn btn-sm {{ $selectedPeriod == '1month' ? 'btn-primary' : 'btn-outline-primary' }}">1
                                    Tháng</a>
                            </div>
                            <div class="scroll370">
                                <div class="activity-container">
                                    @foreach ($recentBuyers as $buyer)

                                        <div class="activity-block">
                                            <div class="activity-user">
                                                <img src="{{ Storage::url($buyer->user->image) }}" alt="Activity User">
                                                <!-- Hình ảnh người dùng -->
                                            </div>

                                            <div class="activity-details">
                                                <h4>{{ $buyer->user->name }}</h4> <!-- Tên người dùng -->
                                                <h5>{{ $buyer->last_order_time->diffForHumans() }}</h5>
                                                <!-- Thời gian thực hiện đơn hàng -->
                                                <p>Đã Mua: {{ $buyer->order_count }} đơn hàng</p>
                                                <!-- Số lượng đơn hàng -->
                                                <span class="badge shade-green rounded-pill">Mới</span>
                                            </div>

                                        </div>

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="row">
                <!-- Biểu đồ lượt xem sản phẩm -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Lượt xem Sản phẩm</h5>
                            {{-- <div>
                                <a href="?selectedPeriod=1day"
                                    class="btn btn-sm {{ $selectedPeriod == '1day' ? 'btn-primary' : 'btn-outline-primary' }} me-1">
                                    Hôm nay
                                </a>
                                <a href="?selectedPeriod=2weeks"
                                    class="btn btn-sm {{ $selectedPeriod == '2weeks' ? 'btn-primary' : 'btn-outline-primary' }} me-1">
                                    2 Tuần
                                </a>
                                <a href="?selectedPeriod=1month"
                                    class="btn btn-sm {{ $selectedPeriod == '1month' ? 'btn-primary' : 'btn-outline-primary' }}">
                                    1 Tháng
                                </a>
                            </div> --}}
                        </div>
                        <div class="card-body">
                            <canvas id="productViewsChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>


                <!-- Biểu đồ lượt xem bài viết -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Lượt xem Bài viết</h5>
                            {{-- <div>
                                <a href="?selectedPeriod=1day"
                                    class="btn btn-sm {{ $selectedPeriod == '1day' ? 'btn-primary' : 'btn-outline-primary' }} me-1">
                                    Hôm nay
                                </a>
                                <a href="?selectedPeriod=2weeks"
                                    class="btn btn-sm {{ $selectedPeriod == '2weeks' ? 'btn-primary' : 'btn-outline-primary' }} me-1">
                                    2 Tuần
                                </a>
                                <a href="?selectedPeriod=1month"
                                    class="btn btn-sm {{ $selectedPeriod == '1month' ? 'btn-primary' : 'btn-outline-primary' }}">
                                    1 Tháng
                                </a>
                            </div> --}}
                        </div>
                        <div class="card-body">
                            <canvas id="postViewsChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

            </div>


        </div>

    </div>

    {{-- 
    Giao dịch
    --}}
    <script>
        document.addEventListener('DOMContentLoaded', function(e) {

            const transactionTime = document.querySelectorAll('#transaction-time a');

            const transactionsContainer = document.getElementById('transactions-container');

            function fetchDataTransaction(timeRange) {

                axios.get(`api/get-transaction-time?timeRange=${timeRange}`)
                    .then((res) => {

                        const transactions = res.data.statisticsWithPaymentMethod;

                        // Xóa nội dung cũ
                        transactionsContainer.innerHTML = '';

                        // Lặp qua dữ liệu và render từng phần tử
                        transactions.forEach(function(statistic) {
                            console.log(statistic);


                            const transactionBlock = `

                                    <div class="transaction-block">

                                        <div class="transaction-icon shade-blue">
                                            <i class="bi bi-credit-card"></i>

                                        </div>

                                        <div class="transaction-details">

                                            <h4>${statistic.payment_method_name}</h4>
                                            <p class="text-truncate">${statistic.payment_method_description}</p>

                                        </div>

                                        <div class="transaction-amount text-blue">

                                            ${ Math.floor(statistic.total_amount).toLocaleString('vi-VN')} VND

                                        </div>

                                    </div>

                                `;

                            // Thêm phần tử vào container
                            transactionsContainer.insertAdjacentHTML('beforeend',
                                transactionBlock);
                        });

                    })
                    .catch((err) => {

                        console.error(err);

                    })

            }

            // Hàm để set lại class active
            function setActiveTransaction(activeTransaction) {

                transactionTime.forEach(btn => {

                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-outline-primary');

                });

                // Thêm active cho nút được chọn
                activeTransaction.classList.add('btn-primary');
                activeTransaction.classList.remove('btn-outline-primary');

            }

            transactionTime.forEach(function(transaction) {

                transaction.addEventListener('click', function(e) {

                    e.preventDefault();
                    // check
                    // console.log(123);

                    const timeRange = this.dataset.timeRange;
                    // console.log(timeRange);

                    fetchDataTransaction(timeRange)

                    // Set lại class active
                    setActiveTransaction(this);

                })

            })

            fetchDataTransaction('4months');

            // Set active mặc định cho nút "4 tháng"
            const defaultButton = document.querySelector('#transaction-time a[data-time-range="4months"]');

            if (defaultButton) {

                setActiveTransaction(defaultButton);
            }

        })
    </script>


    {{-- thống kê đơn hàng mới nhất
 --}}

    <script>
        document.addEventListener('DOMContentLoaded', function(e) {

            const optionOrderTime = document.querySelectorAll('#option-order-time a');

            const orderTimeContent = document.getElementById('order-time-content');

            function fetchDataOrderTime(selectedOrderTime) {

                axios.get(`api/get-data-order-time?selectedOrderPeriod=${selectedOrderTime}`)
                    .then((response) => {

                        // console.log(response);

                        const dataOrderTime = response.data.orders;
                        let stt = 1;

                        dataOrderTime.forEach(orderItem => {

                            orderItem.items.forEach(item => {

                                const orderItemContent = `

                                        <tr>
                                            <td>
                                                ${stt++}
                                                
                                            </td>

                                            <td>

                                                <div class="media-box">
                                                    <div class="media-box-body">
                                                        <div class="text-truncate">

                                                            ${orderItem.user?.name ?? ''}

                                                        </div>
                                                    </div>
                                                </div>

                                            </td>

                                            <td>
                                                <div class="media-box">
                                                    <div class="media-box-body">
                                                        <div class="text-truncate">

                                                            ${item.productVariant?.product?.name ?? item.product?.name ?? ''}
                                                    
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>

                                            <td>
                                                ${new Date(orderItem.created_at).toLocaleDateString()}
                                            </td>

                                            <td>
                                                ${Number(orderItem.total_amount).toLocaleString('vi-VN')} VND
                                            </td>

                                            <td>

                                                ${orderItem.payment_status === 'unpaid' ? '<span class="badge bg-warning">Chưa thanh toán</span>' : ''}
                                                ${orderItem.payment_status === 'paid' ? '<span class="badge bg-success">Đã thanh toán</span>' : ''}
                                                ${orderItem.payment_status === 'refunded' ? '<span class="badge bg-danger">Hoàn trả</span>' : ''}
                                                ${orderItem.payment_status === 'payment_failed' ? '<span class="badge bg-danger">Thanh toán thất bại</span>' : ''}
                                                
                                                ${!['unpaid', 'paid', 'refunded', 'payment_failed'].includes(orderItem.payment_status) ? 
                                                    '<span class="badge bg-secondary">Không rõ</span>' : ''}

                                            </td>

                                            <td>

                                                ${orderItem.status === 'pending_confirmation' ? '<span class="badge bg-info">Chờ xác nhận</span>' : ''}
                                                ${orderItem.status === 'pending_pickup' ? '<span class="badge bg-warning">Chờ lấy hàng</span>' : ''}
                                                ${orderItem.status === 'pending_delivery' ? '<span class="badge bg-primary">Chờ giao hàng</span>' : ''}
                                                ${orderItem.status === 'returned' ? '<span class="badge bg-danger">Trả hàng</span>' : ''}
                                                ${orderItem.status === 'delivered' ? '<span class="badge bg-secondary">Đã giao</span>' : ''}
                                        
                                            </td>

                                        </tr>

                                    `;

                                document.querySelector(
                                        '#order-time-content')
                                    .insertAdjacentHTML('beforeend',
                                        orderItemContent);

                            });

                        });


                    })
                    .catch((error) => {

                        console.log(error);

                    })

            }

            function setActiveButton(activeButton) {

                optionOrderTime.forEach(btn => {

                    btn.classList.remove('btn-primary');

                    btn.classList.add('btn-outline-primary');

                });

                // Thêm active cho nút được chọn
                activeButton.classList.add('btn-primary');

                activeButton.classList.remove('btn-outline-primary');

            }

            optionOrderTime.forEach(function(orderTime) {

                orderTime.addEventListener('click', function(e) {

                    e.preventDefault();
                    // console.log(123);

                    const selectedOrderTime = orderTime.dataset.selectedOrderTime;

                    orderTimeContent.innerHTML = '';

                    fetchDataOrderTime(selectedOrderTime);

                    setActiveButton(this)

                })
            })

            fetchDataOrderTime('1day')

            // Set active mặc định cho nút "4 tháng"
            const defaultButton = document.querySelector('#option-order-time a[data-selected-order-time="1day"]');

            if (defaultButton) {

                setActiveButton(defaultButton);
            }

        })
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (@json($totals).length > 0 && @json($dates).length > 0) {
                var options = {
                    chart: {
                        height: 317,
                        type: 'area',
                        toolbar: {
                            show: false,
                        },
                    },
                    dataLabels: {
                        enabled: false // Tắt hiển thị dữ liệu trên biểu đồ
                    },
                    stroke: {
                        curve: 'smooth', // Đường cong mượt
                        width: 3
                    },
                    series: [{
                        name: 'Doanh thu',
                        data: @json($totals) // Dữ liệu tổng doanh thu từ cơ sở dữ liệu
                    }],
                    grid: {
                        borderColor: '#e0e6ed',
                        strokeDashArray: 5,
                        xaxis: {
                            lines: {
                                show: true // Hiển thị đường lưới trên trục X
                            }
                        },
                        yaxis: {
                            lines: {
                                show: false, // Tắt đường lưới trên trục Y
                            }
                        },
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 10,
                            left: 0
                        },
                    },
                    xaxis: {
                        categories: @json($dates), // Dữ liệu ngày tháng
                        labels: {
                            style: {
                                fontSize: '12px',
                                colors: ['#6c757d']
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            show: true, // Hiển thị nhãn trên trục Y
                            style: {
                                fontSize: '12px',
                                colors: ['#6c757d']
                            }
                        },
                    },
                    colors: ['#4267cd'], // Màu sắc cho biểu đồ
                    markers: {
                        size: 4,
                        colors: ['#4267cd'],
                        strokeColor: "#ffffff",
                        strokeWidth: 2,
                        hover: {
                            size: 7, // Kích thước khi di chuột qua
                        }
                    },
                    tooltip: {
                        enabled: true,
                        x: {
                            format: 'dd-MM-yyyy' // Định dạng ngày tháng trong tooltip
                        },
                        y: {
                            formatter: function(value) {
                                return value.toLocaleString('vi-VN', {
                                    style: 'currency',
                                    currency: 'VND'
                                });
                            }
                        }
                    }
                }

                var chart = new ApexCharts(
                    document.querySelector("#revenueGraph"),
                    options
                );

                chart.render();
            } else {
                console.log("Không có dữ liệu.");
            }
        });
    </script>


    <script>
        let chart; // Scope global để giữ reference biểu đồ

        // Hàm call API và render biểu đồ
        function fetchAndRenderChart(filterPeriod) {

            axios.get(`/api/thong-ke-theo-trang-thai?filterPeriod=${filterPeriod}`)

                .then(response => {

                    console.log(response.data);

                    const ordersByStatusForChart = response.data.ordersByStatusForChart;

                    const seriesData = [
                        ordersByStatusForChart['pending_confirmation'] || 0,
                        ordersByStatusForChart['pending_delivery'] || 0,
                        ordersByStatusForChart['delivered'] || 0,
                        ordersByStatusForChart['canceled'] || 0,
                        ordersByStatusForChart['returned'] || 0
                    ];

                    const labelsData = ['Chờ xác nhận', 'Chờ giao hàng', 'Đã giao hàng', 'Đã hủy', 'Trả hàng'];

                    if (chart) {

                        chart.destroy();
                    }

                    const options = {

                        chart: {
                            height: 300,
                            type: 'radialBar',
                            toolbar: {
                                show: false
                            }
                        },
                        plotOptions: {
                            radialBar: {
                                dataLabels: {
                                    name: {
                                        fontSize: '12px',
                                        fontWeight: 'bold',
                                        fontColor: 'black'
                                    },
                                    value: {
                                        fontSize: '21px',
                                        fontWeight: 'bold',
                                        fontColor: 'black'
                                    },
                                    total: {
                                        show: true,
                                        label: 'Đơn Hàng',
                                        fontWeight: 'bold',
                                        formatter: w => w.globals.series.reduce((a, b) => a + b, 0)
                                    }
                                }
                            }
                        },

                        series: seriesData,

                        labels: labelsData,

                        colors: ['#4267cd', '#32b2fa', '#f87957', '#FF00FF', '#00FF00']

                    };

                    chart = new ApexCharts(document.querySelector("#taskGraph"), options);
                    chart.render();

                })

                .catch(error => console.error('Error fetching data:', error));
        }

        // Hàm cập nhật active class cho nút filter được chọn
        function setActiveButtonStatus(button) {
            const timePeriodButtons = document.querySelectorAll('#time-period-options-status a');

            timePeriodButtons.forEach(btn => btn.classList.remove('btn-primary', 'btn-outline-primary'));
            if (button) {
                button.classList.remove('btn-outline-primary');
                button.classList.add('btn-primary');
            }
        }

        // Gán event listener cho các nút filter
        const timePeriodButtons = document.querySelectorAll('#time-period-options-status a');

        timePeriodButtons.forEach(button => {

            button.addEventListener('click', function(e) {

                e.preventDefault();

                const filterPeriod = this.dataset.filterPeriod;

                // Cập nhật active class cho nút được chọn

                setActiveButtonStatus(this);


                console.log('Filter Period:', filterPeriod); // Debug giá trị filterPeriod

                fetchAndRenderChart(filterPeriod);
            });
        });

        // Gọi hàm mặc định khi load trang với filter 'today'
        const defaultButtonStatus = document.querySelector('[data-filter-period="today"]');
        setActiveButtonStatus(defaultButtonStatus);

        fetchAndRenderChart('today');

        // document.addEventListener("DOMContentLoaded", function() {
        //     // Lấy dữ liệu ordersByStatus từ Laravel và chuyển thành mảng JSON
        //     const ordersByStatusForChart = @json($ordersByStatusForChart);

        //     // Tạo dữ liệu cho series và labels từ ordersByStatusForChart
        //     const seriesData = [
        //         ordersByStatusForChart['pending_confirmation'], // Chờ xác nhận
        //         ordersByStatusForChart['pending_delivery'], // Chờ giao hàng
        //         ordersByStatusForChart['delivered'], // Đã giao hàng
        //         ordersByStatusForChart['canceled'], // Đã hủy
        //         ordersByStatusForChart['returned'] // Trả hàng
        //     ];

        //     const labelsData = ['Chờ xác nhận', 'Chờ giao hàng', 'Đã giao hàng', 'Đã hủy', 'Trả hàng'];

        //     var options = {
        //         chart: {
        //             height: 300, // Thay đổi chiều cao của biểu đồ
        //             width: '100%',
        //             type: 'radialBar',
        //             toolbar: {
        //                 show: false,
        //             },
        //         },
        //         plotOptions: {
        //             radialBar: {
        //                 dataLabels: {
        //                     name: {
        //                         fontSize: '12px',
        //                         fontFamily: 'Roboto', // Sử dụng font Roboto
        //                         fontWeight: 'bold',
        //                         fontColor: 'black',
        //                     },
        //                     value: {
        //                         fontSize: '21px',
        //                         fontFamily: 'Roboto', // Sử dụng font Roboto
        //                         fontWeight: 'bold',
        //                         fontColor: 'black',
        //                     },
        //                     total: {
        //                         show: true,
        //                         label: 'Đơn Hàng',
        //                         fontFamily: 'Roboto', // Sử dụng font Roboto
        //                         fontWeight: 'bold',
        //                         formatter: function(w) {
        //                             return w.globals.series.reduce((a, b) => a + b, 0);
        //                         }
        //                     }
        //                 }
        //             }
        //         },
        //         series: seriesData,
        //         labels: labelsData,
        //         colors: ['#4267cd', '#32b2fa', '#f87957', '#FF00FF', '#00FF00'],
        //     };

        //     var chart = new ApexCharts(
        //         document.querySelector("#taskGraph"),
        //         options
        //     );
        //     chart.render();
        // });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const timePeriodButtons = document.querySelectorAll('#time-period-options a');

            let chart = null;

            // Hàm để làm nổi bật nút đang chọn
            function setActiveButton(selectedButton) {

                timePeriodButtons.forEach(button => {

                    button.classList.remove('btn-primary');

                    button.classList.add('btn-outline-primary');

                });

                selectedButton.classList.add('btn-primary');
                selectedButton.classList.remove('btn-outline-primary');

            }

            // Hàm để tải dữ liệu từ API và vẽ biểu đồ
            function fetchAndRenderChart(timePeriod) {

                axios.get(`api/san-pham-ban-chay?timePeriod=${timePeriod}`)

                    .then((res) => {

                        // Dữ liệu từ API
                        const topSellingProductQuantities = res.data.topSellingProductQuantities;
                        const topSellingProductNames = res.data.topSellingProductNames;

                        // Xóa biểu đồ cũ nếu tồn tại
                        if (chart) {
                            chart.destroy();
                        }

                        // Cấu hình và vẽ biểu đồ mới
                        const options = {
                            chart: {
                                height: 300,
                                type: 'bar',
                                dropShadow: {
                                    enabled: true,
                                    opacity: 0.1,
                                    blur: 5,
                                    left: -10,
                                    top: 10
                                },
                            },
                            plotOptions: {
                                bar: {
                                    dataLabels: {
                                        position: 'top',
                                    },
                                }
                            },
                            series: [{
                                name: 'Sản phẩm đã bán',
                                data: topSellingProductQuantities,
                            }],
                            xaxis: {
                                categories: topSellingProductNames,
                                position: 'top',
                                labels: {
                                    offsetY: -18,
                                },
                                axisBorder: {
                                    show: false
                                },
                                axisTicks: {
                                    show: false
                                },
                                crosshairs: {
                                    fill: {
                                        type: 'gradient',
                                        gradient: {
                                            colorFrom: '#435EEF',
                                            colorTo: '#95c5ff',
                                            stops: [0, 100],
                                            opacityFrom: 0.4,
                                            opacityTo: 0.5,
                                        }
                                    }
                                },
                                tooltip: {
                                    enabled: true,
                                    offsetY: -35,
                                }
                            },
                            yaxis: {
                                labels: {
                                    formatter: function(val) {
                                        return Math.round(val) + " Sản Phẩm"; // Hiển thị số nguyên
                                    }
                                }
                            },
                            grid: {
                                borderColor: '#e0e6ed',
                                strokeDashArray: 5,
                            },

                            colors: ['#435EEF', '#2b86f5', '#63a9ff', '#95c5ff', '#c6e0ff'],

                        };

                        chart = new ApexCharts(document.querySelector("#basic-column-graph-datalables"),
                            options);

                        chart.render();

                    })
                    .catch((error) => {

                        console.error('Error:', error);

                    });
            }

            // Sự kiện click cho các nút
            timePeriodButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const timePeriod = this.dataset.timePeriod;

                    // Làm nổi bật nút được chọn
                    setActiveButton(this);

                    // Lấy dữ liệu và hiển thị biểu đồ
                    fetchAndRenderChart(timePeriod);
                });
            });

            // Hiển thị mặc định dữ liệu của today
            const defaultButton = document.querySelector('[data-time-period="today"]');

            setActiveButton(defaultButton);

            fetchAndRenderChart('today');

        });

    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Dữ liệu thống kê sản phẩm

        const productLabels = @json($topProducts->pluck('name'));
        const productViews = @json($topProducts->pluck('views'));

        const ctxProduct = document.getElementById('productViewsChart').getContext('2d');
        new Chart(ctxProduct, {
            type: 'bar', // Loại biểu đồ
            data: {
                labels: productLabels, // Tên sản phẩm
                datasets: [{
                    label: 'Lượt xem',
                    data: productViews, // Lượt xem sản phẩm
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true // Bắt đầu từ 0
                    }
                }
            }
        });

        // Dữ liệu thống kê bài viết
        const postLabels = @json($topPosts->pluck('title'));
        const postViews = @json($topPosts->pluck('views'));

        const ctxPost = document.getElementById('postViewsChart').getContext('2d');
        new Chart(ctxPost, {
            type: 'bar', // Loại biểu đồ
            data: {
                labels: postLabels, // Tên bài viết
                datasets: [{
                    label: 'Lượt xem',
                    data: postViews, // Lượt xem bài viết
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });
    </script>

@endsection

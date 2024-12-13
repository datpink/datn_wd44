@extends('admin.master')

@section('title', 'Thống kê Dashboard')

@section('content')
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
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Sản Phẩm Bán Chạy</div>
                        </div>
                        <div class="card-body">
                            <div id="basic-column-graph-datalables"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Giao Dịch</div>
                        </div>
                        <div class="card-body">
                            <div class="scroll370">
                                <div class="transactions-container">
                                    @foreach ($statisticsWithPaymentMethod as $statistic)
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
                                    @endforeach
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
                                            <th>Phương Thức Thanh Toán</th>
                                            <th>Trạng Thái Đơn Hàng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            @foreach ($order->items as $item)
                                                <!-- Lặp qua các sản phẩm trong đơn hàng -->
                                                <tr>
                                                    <td>{{ $order->id }}</td>

                                                    <td>
                                                        <div class="media-box">
                                                            <div class="media-box-body">
                                                                <div class="text-truncate">
                                                                    {{ $order->user->name ?? 'Unknown' }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="media-box">
                                                            <div class="media-box-body">
                                                                <div class="text-truncate">
                                                                    {{ $item->productVariant->product->name ?? 'Unknown Product' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                                    <td>
                                                        @if(floor($order->total_amount) == $order->total_amount)
                                                            {{ number_format($order->total_amount) }} VND
                                                        @else
                                                            {{ number_format($order->total_amount, 2) }} VND
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
                                                        @elseif ($order->status === 'canceled')
                                                            <span class="badge rounded-pill bg-secondary">Đã hủy</span>
                                                        @else
                                                            <span class="badge rounded-pill bg-secondary">Không rõ</span>
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

                                                </tr>
                                            @endforeach
                                        @endforeach
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
                            <div class="card-title">Thống Kê Theo Trạng Thái</div>
                        </div>
                        <div class="card-body">
                            <div id="taskGraph"></div>
                            <ul class="task-list-container">
                                @foreach ($ordersByStatusForList as $status => $count)
                                    <li class="task-list-item">
                                        <div
                                            class="task-icon shade-{{ $loop->index % 4 === 0 ? 'blue' : ($loop->index % 3 === 0 ? 'green' : 'red') }}">
                                            <i class="bi bi-clipboard-{{ $status === 'shipped' ? 'check' : 'plus' }}"></i>
                                        </div>
                                        <div class="task-info">
                                            <h5 class="task-title">{{ ucfirst($status) }}</h5>
                                            <p class="amount-spend">{{ $count }}</p>
                                        </div>
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


        </div>
    </div>

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
                console.log("Không có dữ liệu để hiển thị biểu đồ.");
            }
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Lấy dữ liệu ordersByStatus từ Laravel và chuyển thành mảng JSON
            const ordersByStatusForChart = @json($ordersByStatusForChart);

            // Tạo dữ liệu cho series và labels từ ordersByStatusForChart
            const seriesData = [
                ordersByStatusForChart['pending_confirmation'], // Chờ xác nhận
                ordersByStatusForChart['pending_delivery'], // Chờ giao hàng
                ordersByStatusForChart['delivered'], // Đã giao hàng
                ordersByStatusForChart['canceled'], // Đã hủy
                ordersByStatusForChart['returned'] // Trả hàng
            ];

            const labelsData = ['Chờ xác nhận', 'Chờ giao hàng', 'Đã giao hàng', 'Đã hủy', 'Trả hàng'];

            var options = {
                chart: {
                    height: 300, // Thay đổi chiều cao của biểu đồ
                    width: '100%',
                    type: 'radialBar',
                    toolbar: {
                        show: false,
                    },
                },
                plotOptions: {
                    radialBar: {
                        dataLabels: {
                            name: {
                                fontSize: '12px',
                                fontFamily: 'Roboto', // Sử dụng font Roboto
                                fontWeight: 'bold',
                                fontColor: 'black',
                            },
                            value: {
                                fontSize: '21px',
                                fontFamily: 'Roboto', // Sử dụng font Roboto
                                fontWeight: 'bold',
                                fontColor: 'black',
                            },
                            total: {
                                show: true,
                                label: 'Đơn Hàng',
                                fontFamily: 'Roboto', // Sử dụng font Roboto
                                fontWeight: 'bold',
                                formatter: function(w) {
                                    return w.globals.series.reduce((a, b) => a + b, 0);
                                }
                            }
                        }
                    }
                },
                series: seriesData,
                labels: labelsData,
                colors: ['#4267cd', '#32b2fa', '#f87957', '#FF00FF', '#00FF00'],
            };

            var chart = new ApexCharts(
                document.querySelector("#taskGraph"),
                options
            );
            chart.render();
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var options = {
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
                            position: 'top', // top, center, bottom
                        },
                    }
                },
                series: [{
                    name: 'Sản phẩm đã bán',
                    data: @json($topSellingProductQuantities), // Dữ liệu số lượng bán
                }],
                xaxis: {
                    categories: @json($topSellingProductNames), // Dữ liệu tên sản phẩm
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
                fill: {
                    gradient: {
                        shade: 'light',
                        type: "horizontal",
                        shadeIntensity: 0.25,
                        gradientToColors: undefined,
                        inverseColors: true,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [50, 0, 100, 100]
                    },
                },
                yaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: false,
                        formatter: function(val) {
                            return val + " Sản Phẩm";
                        }
                    }
                },
                title: {
                    floating: true,
                    offsetY: 320,
                    align: 'center',
                    style: {
                        color: '#2e323c'
                    }
                },
                grid: {
                    borderColor: '#e0e6ed',
                    strokeDashArray: 5,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    },
                    yaxis: {
                        lines: {
                            show: false,
                        }
                    },
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0
                    },
                },
                colors: ['#435EEF', '#2b86f5', '#63a9ff', '#95c5ff', '#c6e0ff'],
            }

            var chart = new ApexCharts(document.querySelector("#basic-column-graph-datalables"), options);
            chart.render();
        });
    </script>

@endsection

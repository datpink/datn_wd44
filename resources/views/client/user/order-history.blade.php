@extends('client.master')

@section('title', 'Lịch Sử Đơn Hàng')

@section('content')
    <div class="container">
        <h1 class="text-center mb-5">Lịch Sử Đơn Hàng</h1>

        @if ($orders->isEmpty())
            <p class="text-center">Bạn chưa có đơn hàng nào.</p>
        @else
            @php
                $statusClasses = [
                    'processing' => 'bg-primary',
                    'shipped' => 'bg-info',
                    'canceled' => 'bg-danger',
                    'refunded' => 'bg-warning',
                    'Delivering' => 'bg-secondary',
                    'delivered' => 'bg-success',
                ];

                $statusLabels = [
                    'processing' => 'Đang Xử Lý',
                    'shipped' => 'Đã Gửi',
                    'canceled' => 'Đã Hủy',
                    'refunded' => 'Đã Hoàn Tiền',
                    'Delivering' => 'Đang Giao',
                    'delivered' => 'Đã Giao',
                ];
            @endphp

            <div class="accordion" id="orderAccordion">
                @foreach ($orders as $order)
                    @php
                        $statusClass = $statusClasses[$order->status] ?? 'bg-primary';
                        $statusLabel = $statusLabels[$order->status] ?? 'Không Xác Định';
                    @endphp

                    <div class="card mb-4">
                        <div class="card-header {{ $statusClass }}" id="heading{{ $order->id }}"
                            style="border-color: {{ $statusClass }}; background-color: {{ $statusClass }};">
                            <h5>
                                <span style="color: #000; font-weight: bold">Mã Đơn Hàng: #{{ $order->id }}</span>
                            </h5>
                        </div>

                        <div class="card-body">
                            <p><strong>Ngày Đặt Hàng:</strong>
                                {{ $order->created_at ? $order->created_at->format('d/m/Y') : 'N/A' }}</p>
                            <p><strong>Trạng Thái:</strong>
                                <span class="badge {{ $statusClass }} text-white">{{ $statusLabel }}</span>
                            </p>
                            <p><strong>Tổng Tiền:</strong> {{ number_format($order->items_sum_total, 0, ',', '.') }} VND</p>

                            <a href="{{ route('order.detail', $order->id) }}" class="btn btn-secondary">
                                @if ($order->status === 'canceled')
                                    Xem Chi Tiết Đơn Hủy
                                @else
                                    Xem Chi Tiết
                                @endif
                            </a>

                            @if ($order->status !== 'canceled')
                                <!-- Kiểm tra trạng thái đơn hàng -->
                                <button class="btn btn-danger cancelOrderButton">Hủy Đơn Hàng</button>
                                <div class="cancelOrderForm" style="display: none; margin-top: 20px;">
                                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <div class="form-group">
                                            <label for="cancellation_reason">Lý do hủy:</label>
                                            <textarea name="cancellation_reason" id="cancellation_reason" rows="4" class="form-control" required></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-danger">Xác Nhận Hủy</button>
                                    </form>
                                </div>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // Hiển thị/ẩn form hủy đơn hàng
            $('.cancelOrderButton').click(function() {
                var $form = $(this).siblings('.cancelOrderForm');
                $form.toggle(); // Ẩn hoặc hiện form
                // Đóng tất cả các accordion khác nếu form đang mở
                if ($form.is(':visible')) {
                    $('.cancelOrderForm').not($form).hide(); // Ẩn các form khác
                }
            });
        });
    </script>

@endsection

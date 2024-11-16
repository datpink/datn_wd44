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
                    'delivering' => 'bg-secondary',
                    'delivered' => 'bg-success',
                ];

                $statusLabels = [
                    'processing' => 'Đang Xử Lý',
                    'shipped' => 'Đã Gửi',
                    'canceled' => 'Đã Hủy',
                    'refunded' => 'Đã Hoàn Tiền',
                    'delivering' => 'Đang Giao',
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
                            <h5 class="mb-0 d-flex justify-content-between align-items-center">
                                <span style="color: #000; font-weight: bold">Mã Đơn Hàng: #{{ $order->id }}</span>
                                <button class="btn btn-link text-white accordion-toggle" type="button"
                                    data-toggle="collapse" data-target="#collapse{{ $order->id }}" aria-expanded="false"
                                    aria-controls="collapse{{ $order->id }}">
                                    <i class="fa fa-chevron-down chevron" aria-hidden="true"></i>
                                </button>
                            </h5>
                        </div>

                        <div id="collapse{{ $order->id }}" class="collapse" aria-labelledby="heading{{ $order->id }}"
                            data-parent="#orderAccordion">
                            <div class="card-body">
                                <p><strong>Ngày Đặt Hàng:</strong>
                                    {{ $order->created_at ? $order->created_at->format('d/m/Y') : 'N/A' }}</p>
                                <p><strong>Trạng Thái:</strong>
                                    <span class="badge {{ $statusClass }} text-white">{{ $statusLabel }}</span>
                                </p>
                                <p><strong>Tổng Tiền:</strong> {{ number_format($order->items_sum_total, 0, ',', '.') }}
                                    VND</p>
                                <a href="{{ route('order.detail', $order->id) }}" class="btn btn-secondary">
                                    Xem Chi Tiết
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.accordion-toggle').click(function() {
                $(this).find('.chevron').toggleClass('fa-chevron-up fa-chevron-down');
            });

            // Đảm bảo rằng mũi tên đổi chiều khi mở hoặc đóng
            $('.collapse').on('show.bs.collapse', function() {
                $(this).prev('.card-header').find('.chevron').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            });

            $('.collapse').on('hide.bs.collapse', function() {
                $(this).prev('.card-header').find('.chevron').removeClass('fa-chevron-up').addClass('fa-chevron-down');
            });
        });
    </script>
@endsection

<style>
    .card-header {
        cursor: pointer;
    }

    @media (max-width: 576px) {
        .card-body p {
            font-size: 14px;
        }
    }
</style>
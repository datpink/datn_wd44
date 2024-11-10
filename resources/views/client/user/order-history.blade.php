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

@foreach ($orders as $order)
    @php
        $statusClass = $statusClasses[$order->status] ?? 'bg-secondary';
        $statusLabel = $statusLabels[$order->status] ?? 'Không Xác Định';
    @endphp

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5>Mã Đơn Hàng: #{{ $order->id }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Ngày Đặt Hàng:</strong> {{ $order->created_at ? $order->created_at->format('d/m/Y') : 'N/A' }}</p>
            <p><strong>Trạng Thái:</strong> 
                <span class="badge {{ $statusClass }} text-white">{{ $statusLabel }}</span>
            </p>

            {{-- Hiển thị tổng tiền của đơn hàng theo order_id --}}
            <p><strong>Tổng Tiền:</strong> {{ number_format($order->items_sum_total, 0, ',', '.') }} VND</p>

            <a href="{{ route('order.detail', $order->id) }}" class="btn btn-secondary">
                Xem Chi Tiết
            </a>
        </div>
    </div>
@endforeach

    @endif
</div>

@endsection
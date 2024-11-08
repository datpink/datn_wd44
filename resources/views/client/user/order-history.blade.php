@extends('client.master')

@section('title', 'Lịch Sử Đơn Hàng')

@section('content')

<div class="container">
    <h1 class="text-center mb-5">Lịch Sử Đơn Hàng</h1>

    @if ($orders->isEmpty())
        <p class="text-center">Bạn chưa có đơn hàng nào.</p>
    @else
        @foreach ($orders as $order)
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5>Mã Đơn Hàng: #{{ $order->id }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>Ngày Đặt Hàng:</strong> {{ $order->created_at ? $order->created_at->format('d/m/Y') : 'N/A' }}</p>
                    <p><strong>Trạng Thái:</strong> <span class="badge bg-success text-muted">{{ $order->status }}</span></p>
                    <p><strong>Tổng Tiền:</strong> {{ number_format($order->items_sum_total, 0, ',', '.') }} VND</p>
                    <a href="{{ route('order.detail', $order->id) }}" class="btn btn-secondary">
                        Xem Chi Tiết
                    </a>
                </div>
            </div>
        @endforeach
    @endif
</div>

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection

<style>
    .custom-card-header {
        background-color: #007bff;
        color: #ffffff;
        padding: 15px;
        border-radius: 0.5rem;
    }

    .custom-btn {
        color: #ffffff;
        text-decoration: none;
        width: 100%;
        text-align: left;
    }

    .custom-btn:hover {
        color: #e0e0e0;
    }

    .custom-btn:focus {
        outline: none;
    }

    .custom-btn i {
        transition: transform 0.2s;
    }

    .collapse.show+.card-header .custom-btn i {
        transform: rotate(180deg);
    }
</style>

@endsection
@extends('client.master')

@section('title', 'Lịch Sử Đơn Hàng')

@section('content')

    <div class="container">
        <h1 class="text-center mb-5">Lịch Sử Đơn Hàng</h1>

        @if ($orders->isEmpty())
            <p class="text-center">Bạn chưa có đơn hàng nào.</p>
        @else
            <div class="accordion" id="orderAccordion">
                @foreach ($orders as $order)
                    <div class="card mb-3">
                        <div class="card-header custom-card-header" id="heading{{ $order->id }}">
                            <h5 class="mb-2">
                                <button class="btn btn-link custom-btn" type="button" data-toggle="collapse"
                                    data-target="#collapse{{ $order->id }}" aria-expanded="true"
                                    aria-controls="collapse{{ $order->id }}">
                                    Mã Đơn Hàng: #{{ $order->id }}
                                </button>
                            </h5>
                        </div>
                        <div id="collapse{{ $order->id }}" class="collapse" aria-labelledby="heading{{ $order->id }}"
                            data-parent="#orderAccordion">
                            <div class="card-body">
                                <p><strong>Ngày Đặt Hàng:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                                <p><strong>Trạng Thái:</strong>
                                    @if ($order->status === 'processing')
                                        <span class="badge rounded-pill bg-info">Đang xử lý</span>
                                    @elseif ($order->status === 'Delivering')
                                        <span class="badge rounded-pill bg-warning">Đang giao hàng</span>
                                    @elseif ($order->status === 'shipped')
                                        <span class="badge rounded-pill bg-primary">Đã giao hàng</span>
                                    @elseif ($order->status === 'canceled')
                                        <span class="badge rounded-pill bg-danger">Đã hủy</span>
                                    @elseif ($order->status === 'refunded')
                                        <span class="badge rounded-pill bg-secondary">Hoàn trả</span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary">Không rõ</span>
                                    @endif
                                </p>
                                <p><strong>Tổng Tiền:</strong> {{ number_format($order->items_sum_total, 0, ',', '.') }} VND
                                </p>
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

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        .custom-card-header {
            background-color: #007bff;
            /* Màu nền */
            color: #ffffff;
            /* Màu chữ */
            padding: 15px;
            /* Khoảng cách bên trong */
            border-radius: 0.5rem;
            /* Bo tròn các góc */
        }

        .custom-btn {
            color: #ffffff;
            /* Màu chữ của nút */
            text-decoration: none;
            /* Bỏ gạch chân */
            width: 100%;
            /* Chiếm toàn bộ chiều rộng */
            text-align: left;
            /* Căn trái nội dung */
        }

        .custom-btn:hover {
            color: #e0e0e0;
            /* Màu chữ khi hover */
        }

        .custom-btn:focus {
            outline: none;
            /* Bỏ viền khi nút được chọn */
        }

        .custom-btn i {
            transition: transform 0.2s;
            /* Hiệu ứng chuyển động cho biểu tượng */
        }

        .collapse.show+.card-header .custom-btn i {
            transform: rotate(180deg);
            /* Xoay biểu tượng khi mở */
        }
    </style>

@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection

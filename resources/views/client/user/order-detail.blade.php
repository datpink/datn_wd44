@extends('client.master')

@section('title', 'Lịch Sử Đơn Hàng')

@section('content')

    <div class="container my-5">
        <h1 class="text-center mb-5">Chi Tiết Đơn Hàng #{{ $order->id }}</h1>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Thông Tin Người Mua</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Tên:</strong> {{ $buyer->name }}</p>
                        <p><strong>Hình Ảnh:</strong>
                            @if ($buyer->image && \Storage::exists($buyer->image))
                                <img src="{{ \Storage::url($buyer->image) }}" alt="{{ $buyer->name }}"
                                    style="max-width: 50px; height: auto; border-radius: 50%">
                            @else
                                <p>Không có ảnh</p>
                            @endif
                        </p>
                        <p><strong>Email:</strong> {{ $buyer->email }}</p>
                        <p><strong>Địa Chỉ:</strong> {{ $buyer->address }}</p>
                        <p><strong>Số Điện Thoại:</strong> {{ $buyer->phone }}</p>
                    </div>
                </div>
                <div class=" mt-2">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Tổng Cộng</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Tổng Tiền Đơn Hàng:</strong>
                                {{ number_format($order->items->sum('total'), 0, ',', '.') }} VND</p>
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
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Thông Tin Sản Phẩm</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($items as $item)
                                <div class="col-md-6 mb-3">
                                    <div class=" p-3 rounded bg-light">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <p><strong>Sản Phẩm:</strong> {{ $item->productVariant->product->name }}</p>
                                                <p><strong>Biến Thể:</strong> {{ $item->productVariant->attribute }} -
                                                    {{ $item->productVariant->attribute_value }}</p>
                                                <p><strong>Giá:</strong>
                                                    {{ number_format($item->productVariant->price, 0, ',', '.') }} VND</p>
                                                <p><strong>Giảm Giá:</strong>
                                                    {{ number_format($order->discount_amount, 0, ',', '.') }} VND
                                                </p>
                                                <p><strong>Số Lượng:</strong> {{ $item->quantity }}</p>
                                                <p><strong>Tổng Tiền:</strong>
                                                    {{ number_format($item->total, 0, ',', '.') }} VND</p>
                                                <p><strong>Trạng Thái Thanh Toán:</strong>
                                                    @if ($order->payment_status === 'pending')
                                                        <span class="badge rounded-pill bg-warning">Chưa thanh toán</span>
                                                    @elseif ($order->payment_status === 'paid')
                                                        <span class="badge rounded-pill bg-success">Đã thanh toán</span>
                                                    @elseif ($order->payment_status === 'failed')
                                                        <span class="badge rounded-pill bg-danger">Thanh toán thất
                                                            bại</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-secondary">Không rõ</span>
                                                    @endif
                                                </p>
                                                <a href="#" class="btn btn-secondary">Mua lại sản phẩm này</a>
                                            </div>
                                            <div class="col-md-4">
                                                @if ($item->productVariant->product->image_url && \Storage::exists($item->productVariant->product->image_url))
                                                    <img src="{{ \Storage::url($item->productVariant->product->image_url) }}"
                                                        alt="{{ $item->productVariant->product->name }}"
                                                        style="max-width: 250px; height: auto;">
                                                @else
                                                    Không có ảnh
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

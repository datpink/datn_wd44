@extends('client.master')

@section('title', 'Lịch Sử Đơn Hàng')

@section('content')
<div class="container">
    <h1 class="text-center mb-5">Chi Tiết Đơn Hàng #{{ $order->id }}</h1>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Thông Tin Người Mua</h5>
        </div>
        <div class="card-body">
            <p><strong>Tên:</strong> {{ $buyer->name }}</p>
            <p><strong>Email:</strong> {{ $buyer->email }}</p>
            <p><strong>Địa Chỉ:</strong> {{ $buyer->address }}</p>
            <p><strong>Số Điện Thoại:</strong> {{ $buyer->phone }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Thông Tin Sản Phẩm</h5>
        </div>
        <div class="card-body">
            @foreach ($items as $item)
                <div class="mb-3">
                    <p><strong>Sản Phẩm:</strong> {{ $item->productVariant->product->name }}</p>
                    <p><strong>Biến Thể:</strong> {{ $item->productVariant->attribute }} - {{ $item->productVariant->attribute_value }}</p>
                    <p><strong>Giá:</strong> {{ number_format($item->productVariant->price, 0, ',', '.') }} VND</p>
                    <p><strong>Số Lượng:</strong> {{ $item->quantity }}</p>
                    <p><strong>Tổng Tiền:</strong> {{ number_format($item->total, 0, ',', '.') }} VND</p>
                    <a href="#" class="btn btn-secondary">{{-- đến trang chi tiết sản phẩm--}}
                        mua lại sản phẩm này
                    </a>
                </div>
                <hr>
            @endforeach
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Tổng Cộng</h5>
        </div>
        <div class="card-body">
            <p><strong>Tổng Tiền Đơn Hàng:</strong> {{ number_format($order->items->sum('total'), 0, ',', '.') }} VND</p>
            <p><strong>Trạng Thái:</strong> {{ $order->status }}</p>
        </div>
    </div>
</div>


@endsection
@extends('client.master')

@section('title', 'Chi Tiết Đơn Hàng')

@section('content')
    <div class="container my-5">
        <h1 class="text-center mb-4">Chi Tiết Đơn Hàng #{{ $order->id }}</h1>

        <!-- Thông Tin Người Mua -->
        <div class="card mb-4 shadow border-light">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Thông Tin Người Mua</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Tên:</strong> {{ $buyer->name }}</p>
                        <p><strong>Email:</strong> {{ $buyer->email }}</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <p><strong>Địa Chỉ:</strong> {{ $buyer->address ?? 'Chưa có thông tin' }}</p>
                        <p><strong>Số Điện Thoại:</strong> {{ $buyer->phone ?? 'Chưa có thông tin' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông Tin Sản Phẩm -->
        <div class="card mb-4 shadow border-light">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">Thông Tin Sản Phẩm</h5>
            </div>
            <div class="card-body">
                @if ($items->isEmpty())
                    <p class="text-danger">Không có sản phẩm nào trong đơn hàng này.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Hình Ảnh</th>
                                    <th>Giá</th>
                                    <th>Số Lượng</th>
                                    <th>Tổng Tiền</th>
                                    <th>Biến Thể</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $item->productVariant->variant_name }}</td>
                                        <td>
                                            @if (!empty($item->productVariant->img_url))
                                                <img src="{{ Storage::url($item->productVariant->img_url) }}" width="35" height="35" alt="Image">
                                            @else
                                                <p>Không có ảnh</p>
                                            @endif
                                        </td>
                                        <td>{{ number_format($item->productVariant->price, 0, ',', '.') }} VND</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->total, 0, ',', '.') }} VND</td>
                                        <td>
                                            @if ($groupedVariantAttributes->has($item->product_variant_id))
                                                <ul class="list-unstyled">
                                                    @foreach ($groupedVariantAttributes[$item->product_variant_id] as $variant)
                                                        <li><strong>{{ $variant->attribute_name }}:</strong>
                                                            {{ $variant->attribute_value }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                Không có biến thể nào.
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tổng Cộng -->
        <div class="card mb-4 shadow border-light">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Tổng Cộng</h5>
            </div>
            <div class="card-body">
                <p><strong>Tổng Tiền Đơn Hàng:</strong> {{ number_format($order->items->sum('total'), 0, ',', '.') }} VND
                </p>
                <p><strong>Trạng Thái:</strong> <span
                        class="badge {{ $order->status == 'Đã Giao' ? 'bg-success' : 'bg-danger' }}">{{ $order->status }}</span>
                </p>
            </div>
        </div>
    </div>

@endsection

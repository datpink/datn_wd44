@extends('admin.master')

@section('title', 'Chi Tiết Đơn Hàng')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Chi Tiết Đơn Hàng #{{ $order->id }}</h4>
                            <a href="{{ url()->previous() }}" class="btn rounded-pill btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Trở về
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h5 class="mb-3">Thông Tin Đơn Hàng</h5>
                                    <div class="card">
                                        <div class="card-body">
                                            <p><strong>Người dùng:</strong> {{ $order->user->name }}</p>
                                            <p><strong>Promotion:</strong>
                                                {{ $order->promotion ? $order->promotion->code : 'N/A' }}</p>
                                            <p><strong>Số điện thoại:</strong> {{ $order->phone_number }}</p>
                                            <p>
                                                <strong>Tổng tiền:</strong>
                                                {{ number_format($order->total_amount, 0, ',', '.') }} VND
                                            </p>
                                            <p>
                                                <strong>Giảm giá:</strong>
                                                {{ number_format($order->discount_amount, 0, ',', '.') }} VND
                                            </p>
                                            <p><strong>Trạng thái:</strong>
                                                @if ($order->status === 'pending_confirmation')
                                                    <span class="badge rounded-pill bg-info">Chờ xác nhận</span>
                                                @elseif ($order->status === 'pending_pickup')
                                                    <span class="badge rounded-pill bg-warning">Chờ lấy hàng</span>
                                                @elseif ($order->status === 'pending_delivery')
                                                    <span class="badge rounded-pill bg-primary">Chờ giao hàng</span>
                                                @elseif ($order->status === 'delivered')
                                                    <span class="badge rounded-pill bg-success">Đã giao hàng</span>
                                                @elseif ($order->status === 'returned')
                                                    <span class="badge rounded-pill bg-secondary">Trả hàng</span>
                                                @elseif ($order->status === 'canceled')
                                                    <span class="badge rounded-pill bg-danger">Đã hủy</span>
                                                @else
                                                    <span class="badge rounded-pill bg-secondary">Không rõ</span>
                                                @endif
                                            </p>
                                            <p><strong>Trạng thái thanh toán:</strong>
                                                @if ($order->payment_status === 'pending')
                                                    <span class="badge rounded-pill bg-warning">Chưa thanh toán</span>
                                                @elseif ($order->payment_status === 'paid')
                                                    <span class="badge rounded-pill bg-success">Đã thanh toán</span>
                                                @elseif ($order->payment_status === 'refunded')
                                                    <span class="badge rounded-pill bg-info">Hoàn trả</span>
                                                @elseif ($order->payment_status === 'failed')
                                                    <span class="badge rounded-pill bg-danger">Thanh toán thất bại</span>
                                                @else
                                                    <span class="badge rounded-pill bg-secondary">Không rõ</span>
                                                @endif
                                            </p>

                                            <p><strong>Địa chỉ giao hàng:</strong> {{ $order->shipping_address }}</p>
                                            <p><strong>Phương thức thanh toán:</strong>
                                                {{ $order->paymentMethod ? $order->paymentMethod->name : 'N/A' }}
                                            </p>

                                            <p><strong>Ngày Đặt Hàng:</strong>
                                                {{ $order->created_at ? $order->created_at : 'N/A' }}</p>
                                            <p><strong>Ngày Giao Hàng:</strong>
                                                {{ $order->delivered_at ? \Carbon\Carbon::parse($order->delivered_at) : 'N/A' }}
                                            </p>
                                            <p><strong>Ngày Hủy:</strong>
                                                {{ $order->canceled_at ? \Carbon\Carbon::parse($order->canceled_at) : 'N/A' }}
                                            </p>
                                            <p><strong>Ngày Hoàn Trả:</strong>
                                                {{ $order->refund_at ? \Carbon\Carbon::parse($order->refund_at) : 'N/A' }}
                                            </p>

                                            @if ($order->cancellation_reason)
                                                <p><strong>Lý do hủy đơn:</strong> {{ $order->cancellation_reason }}</p>
                                            @endif

                                            @if ($order->status === 'returned' && $order->refund_images)
                                                <p><strong>Lý Do Trả Hàng:</strong> {{ $order->refund_reason }}</p>
                                                <p><strong>Hình Ảnh Minh Họa:</strong></p>
                                                <div>
                                                    @foreach (json_decode($order->refund_images) as $image)
                                                        <img src="{{ Storage::url($image) }}" alt="Refund Image"
                                                            style="max-width: 100px; margin: 5px;">
                                                    @endforeach
                                                </div>
                                            @endif

                                            <!-- Hiển thị QR Code -->
                                            @if ($order->status === 'delivered' && $order->qr_code)
                                                <p><strong>QR Code:</strong></p>
                                                <img src="{{ Storage::url($order->qr_code) }}" alt="QR Code"
                                                    class="img-fluid" style="max-width: 150px;">
                                            @endif

                                            <!-- Hiển thị Số tài khoản -->
                                            @if ($order->status === 'delivered' && $order->account_number)
                                                <p><strong>Số tài khoản:</strong></p>
                                                <span>{{ $order->account_number }}</span>
                                            @endif


                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <h5>Danh Sách Sản Phẩm</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>Stt</th>
                                                    <th>Tên Sản Phẩm</th>
                                                    <th>Hình Ảnh</th> <!-- Cột cho hình ảnh -->
                                                    <th>Số lượng</th>
                                                    <th>Giá</th>
                                                    <th>Tổng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($order->orderItems as $index => $item)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            @if ($item->product_variant_id)
                                                                {{ $item->productVariant->product->name }}
                                                            @else
                                                                {{ $item->product->name }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (
                                                                $item->product_variant_id &&
                                                                    $item->productVariant->product->image_url &&
                                                                    \Storage::exists($item->productVariant->product->image_url))
                                                                <img src="{{ \Storage::url($item->productVariant->product->image_url) }}"
                                                                    alt="{{ $item->productVariant->product->name }}"
                                                                    style="max-width: 100px; height: auto;">
                                                            @elseif ($item->product && $item->product->image_url && \Storage::exists($item->product->image_url))
                                                                <img src="{{ \Storage::url($item->product->image_url) }}"
                                                                    alt="{{ $item->product->name }}"
                                                                    style="max-width: 100px; height: auto;">
                                                            @else
                                                                Không có ảnh
                                                            @endif
                                                        </td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>{{ number_format($item->price, 0, ',', '.') }} VND</td>
                                                        <td>{{ number_format($item->total, 0, ',', '.') }} VND</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">Không có sản phẩm nào trong
                                                            đơn
                                                            hàng.
                                                        </td>
                                                    </tr>
                                                @endforelse

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

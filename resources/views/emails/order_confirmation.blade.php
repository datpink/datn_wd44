<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
</head>

<body>
    <h1>Đặt hàng thành công!</h1>
    <p>Cảm ơn bạn đã đặt hàng tại <strong>ZAIA Enterprise</strong>.</p>
    <p><strong>Mã đơn hàng:</strong> {{ $order->id }}</p>
    <p><strong>Thông tin thanh toán:</strong>
        {{ $order->payment_status == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}</p>
    <p><strong>Địa chỉ giao hàng:</strong> {{ $order->shipping_address }}</p>

    <h3>Danh sách sản phẩm:</h3>
    <ul>
        @foreach ($order->orderItems as $item)
            <li>{{ $item->product->name }} - Số lượng: {{ $item->quantity }} - Giá:
                {{ number_format($item->price, 0, ',', '.') }} VND</li>
        @endforeach
    </ul>
    <p><strong>Tổng số tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }}
        VND</p>
</body>

</html>

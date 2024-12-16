<!DOCTYPE html>
<html>

<head>
    <title>Cập nhật trạng thái đơn hàng</title>
</head>

<body>
    <h1>Xin chào {{ $order->user->name }},</h1>
    <p>Đơn hàng của bạn (ID: {{ $order->id }}) đã được cập nhật trạng thái thành:
        <strong>{{ __("statuses.$status") }}</strong>.</p>
    <p>Chi tiết đơn hàng:</p>
    <ul>
        @foreach ($order->orderItems as $item)
            <li>
                {{ $item->product->name }} -
                Số lượng: {{ $item->quantity }} -
                Giá: {{ number_format($item->price, 0, ',', '.') }} VNĐ
            </li>
        @endforeach
    </ul>
    <p>Tổng cộng: <strong>{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</strong></p>
    <p>Cảm ơn bạn đã mua sắm cùng chúng tôi!</p>
</body>

</html>

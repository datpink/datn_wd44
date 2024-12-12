<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo hủy đơn hàng</title>
</head>
<body>
    <h1>Xin chào, {{ $order->user->name }}</h1>
    <p>Đơn hàng #{{ $order->id }} của bạn đã bị hủy.</p>
    <p>Lý do hủy: {{ $order->cancellation_reason }}</p>
    <p>Nếu bạn có bất kỳ thắc mắc nào, vui lòng liên hệ với chúng tôi.</p>
    <p>Trân trọng,<br>Đội ngũ hỗ trợ khách hàng</p>
</body>
</html>

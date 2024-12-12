<!DOCTYPE html>
<html>
<head>
    <title>Hoàn tiền đơn hàng</title>
</head>
<body>
    <h1>Đơn hàng #{{ $order->id }} đã được hoàn tiền</h1>
    <p>Chào {{ $order->user->name }},</p>
    <p>Chúng tôi xin thông báo rằng yêu cầu hoàn tiền cho đơn hàng của bạn đã được chấp thuận. Số tiền đã được hoàn lại thông qua phương thức thanh toán của bạn.</p>
    <p><strong>Lý do hoàn tiền:</strong> {{ $order->refund_reason }}</p>
    <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi.</p>
    <p>Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi.</p>
    <p>Trân trọng,</p>
    <p>Đội ngũ hỗ trợ khách hàng</p>
</body>
</html>

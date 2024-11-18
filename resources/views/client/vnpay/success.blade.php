<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giao dịch thành công</title>
</head>
<body>
    <h1>Giao dịch thành công!</h1>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.</p>
    <ul>
        <li>Số tiền: {{ number_format($data['vnp_Amount'] / 100) }} VND</li>
        <li>Mã giao dịch: {{ $data['vnp_TransactionNo'] }}</li>
        <li>Ngân hàng: {{ $data['vnp_BankCode'] }}</li>
    </ul>
    <a href="/">Quay về trang chủ</a>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giao dịch thất bại</title>
</head>
<body>
    <h1>Giao dịch thất bại</h1>
    <p>Rất tiếc, giao dịch của bạn đã không thành công. Vui lòng thử lại sau.</p>
    <ul>
        <li>Lý do: {{ $data['vnp_Message'] ?? 'Không xác định' }}</li>
    </ul>
    <a href="/">Quay về trang chủ</a>
</body>
</html>

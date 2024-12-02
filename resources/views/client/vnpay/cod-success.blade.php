<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giao dịch thành công</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #28a745;
        }

        p {
            font-size: 16px;
            margin: 20px 0;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        ul li {
            font-size: 14px;
            color: #6c757d;
            margin: 5px 0;
        }

        .order-check {
            margin-top: 20px;
        }

        .order-check p {
            font-size: 16px;
            color: #343a40;
            margin-bottom: 5px;
        }

        .order-check a {
            font-size: 16px;
            color: #007bff;
            text-decoration: none;
        }

        .order-check a:hover {
            color: #ff0000;
        }

        a.btn-home {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }

        a.btn-home:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Đặt hàng thành công!</h1>
        <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.</p>
        <ul>
            <li><strong>Số tiền:</strong> {{ $order['total_amount'] }} VND</li>
            <li><strong>Mã đơn hàng:</strong> {{ $order['id'] }}</li>
        </ul>
        <div class="order-check">
            <p>Kiểm tra đơn mua</p>
            <a href="{{ route('order.history', auth()->id()) }}">Đi ngay</a>
        </div>

        <a href="{{ route('client.index') }}" class="btn-home">Quay về trang chủ</a>
    </div>
</body>

</html>

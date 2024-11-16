<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hóa đơn #{{ $order->id }}</title>

    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 20px;
            padding: 0;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h1>Hóa đơn #{{ $order->id }}</h1>
    <p><strong>Tên người đã đặt hàng:</strong> {{ $order->user->name }}</p>
    <p><strong>Địa chỉ giao hàng:</strong> {{ $order->shipping_address }}</p>
    <p><strong>Số điện thoại:</strong> {{ $order->phone_number }}</p>
    <p><strong>Trạng thái:</strong> {{ $order->status }}</p>
    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    <p><strong>Phương thức thanh toán:</strong> {{ $order->paymentMethod ? $order->paymentMethod->name : 'N/A' }}</p>

    <table>
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng cộng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->productVariant->product->name }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->total, 0, ',', '.') }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Tổng số tiền</td>
                <td class="total">{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</td>
            </tr>
            @if ($order->discount_amount)
                <tr>
                    <td colspan="3" class="total">Giảm giá</td>
                    <td class="total">{{ number_format($order->discount_amount, 0, ',', '.') }} VNĐ</td>
                </tr>
            @endif
        </tfoot>
    </table>

    <footer style="margin-top: 50px">
        <span>© Presented by ZAIA.</span>
    </footer>

</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bill #{{ $order->id }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
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

    <h1>Bill #{{ $order->id }}</h1>
    <p><strong>Name of the person who placed the order:</strong> {{ $order->user->name }}</p>
    <p><strong>Shipping address:</strong> {{ $order->shipping_address }}</p>
    <p><strong>Phone number:</strong> {{ $order->phone_number }}</p>
    <p><strong>Status:</strong> {{ $order->status }}</p>
    <p><strong>Date booked:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>

    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->productVariant->product->name }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }} VND</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->total, 0, ',', '.') }} VND</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total Money</td>
                <td class="total">{{ number_format($order->total_amount, 0, ',', '.') }} VND</td>
            </tr>
            @if ($order->discount_amount)
                <tr>
                    <td colspan="3" class="total">Discount</td>
                    <td class="total">{{ number_format($order->discount_amount, 0, ',', '.') }} VND</td>
                </tr>
            @endif
        </tfoot>
    </table>

    <footer style="margin-top: 50px">
        <span>© Presented by ZAIA.</span>
    </footer>

</body>

</html>

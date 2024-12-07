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
    <p><strong>Ngày Đặt Hàng:</strong>
        {{ $order->created_at ? $order->created_at : 'N/A' }}</p>
    <p><strong>Ngày Giao Hàng:</strong>
        {{ $order->delivered_at ? \Carbon\Carbon::parse($order->delivered_at) : 'N/A' }}
    </p>

    <p><strong>Phương thức thanh toán:</strong> {{ $order->paymentMethod ? $order->paymentMethod->name : 'N/A' }}</p>

    <table>
        <thead>
            <tr>
                <th>Mã Sản Phẩm</th>
                <th>Tên sản phẩm</th>
                <th>
                    Thuộc tính
                </th>
                <th>Thương Hiệu</th>
                <th>Số lượng</th>
                <th>Giá</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>
                        @if ($item->product_variant_id)
                            (Mã SP: {{ $item->productVariant->id }})
                        @else
                            (Mã SP: {{ $item->product->id }})
                        @endif
                    </td>
                    <td>
                        @if ($item->product_variant_id)
                            {{ $item->productVariant->product->name }}
                        @else
                            {{ $item->product->name }}
                        @endif
                    </td>
                    <td>
                        @if ($item->product_variant_id && isset($order->groupedVariantAttributes[$item->product_variant_id]))
                            <div>
                                <strong>Thuộc Tính:</strong>
                                <ul>
                                    @foreach ($order->groupedVariantAttributes[$item->product_variant_id] as $attribute)
                                        <li>{{ $attribute->attribute_name }}:
                                            {{ $attribute->attribute_value }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <small>Không có thuộc tính nào.</small>
                        @endif
                    </td>
                    <td>
                        @if ($item->product_variant_id && $item->productVariant->product->brand)
                            {{ $item->productVariant->product->brand->name }}
                        @elseif ($item->product && $item->product->brand)
                            {{ $item->product->brand->name }}
                        @else
                            Không xác định
                        @endif
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
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

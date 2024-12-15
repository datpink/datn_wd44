@extends('admin.master')

@section('title', 'Danh Sách Mã Giảm Giá')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('content')
<style>
    tr.selected {
        background-color: #f0f8ff;
        /* Màu nền highlight */
    }

    input[type="checkbox"]:checked+td {
        background-color: rgb(88, 90, 91);
    }
</style>
@if(session('success'))
<script type="text/javascript">
    alert("{{ session('success') }}");
</script>
@endif
<form action="{{ route('discount.applyToProducts', ['discountId' => $discount->id]) }}" method="POST">
    @csrf
    <h3>Chọn sản phẩm để áp dụng giảm giá: {{ $discount->discount_value }} ({{ $discount->percentage }}%)</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Chọn</th>
                <th>Tên sản phẩm</th>
                <th>Giá gốc</th>
                <th>Giá hiện tại</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr onclick="toggleCheckbox(event, {{ $product->id }})" style="cursor: pointer;">
                <td>
                    <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" id="checkbox-{{ $product->id }}">
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ number_format($product->price, 0, ',', '.') }}₫</td>
                <td>
                    {{ $product->discount_price ? number_format($product->discount_price, 0, ',', '.') : '-' }}₫
                </td>
                <!-- <td>

                    <form action="{{ route('discounts.cancel', ['discountId' => $discount->id]) }}" method="POST">
                        <form action="{{ route('discounts.cancel', ['discountId' => $discount->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            @foreach($products as $product)
                            <div>
                                <input type="checkbox" name="product_ids[]" value="{{ $product->id }}">
                                {{ $product->name }}
                            </div>
                            @endforeach
                            <button type="submit" class="btn btn-danger">Hủy Giảm Giá</button>
                        </form>


                </td> -->
            </tr>

            @endforeach
        </tbody>
    </table>

    <button type="submit" class="btn btn-success">Áp dụng giảm giá</button>
</form>
<script>
    // Hàm toggle checkbox khi click vào hàng
    function toggleCheckbox(event, productId) {
        // Ngăn chặn hành động mặc định của thẻ <td> khi click vào
        if (event.target.tagName === 'INPUT') {
            return; // Nếu click trực tiếp vào checkbox thì không xử lý
        }

        // Lấy checkbox tương ứng với productId
        const checkbox = document.getElementById(`checkbox-${productId}`);

        // Đổi trạng thái của checkbox (checked <=> unchecked)
        checkbox.checked = !checkbox.checked;
    }
</script>
@endsection
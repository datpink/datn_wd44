@extends('client.master')

@section('title', 'Zaia Enterprise | Giỏ hàng của bạn')

@section('content')
    @include('components.breadcrumb-client2')
    <div class="container px-3 my-5 clearfix mt-5">
        <div class="card">
            <div class="card-header">
                <h2>Giỏ hàng của bạn</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered m-0" id="cart-table">
                        <thead>
                            <tr>
                                <th class="text-center align-middle py-3 px-0" style="width: 40px;">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th class="text-center py-3 px-4" style="min-width: 150px;">Hình ảnh</th>
                                <th class="text-center py-3 px-4" style="min-width: 400px;">Tên sản phẩm</th>
                                <th class="text-right py-3 px-4" style="width: 100px;">Giá</th>
                                <th class="text-center py-3 px-4" style="width: 120px;">Số lượng</th>
                                <th class="text-right py-3 px-4" style="width: 100px;">Tổng</th>
                                <th class="text-center align-middle py-3 px-0" style="width: 80px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $subtotal = 0; @endphp
                            @if (session("cart_{$id}") && count(session("cart_{$id}")) > 0)
                                @foreach (session("cart_{$id}") as $key => $item)
                                    <tr data-cart-id="{{ $key }}">
                                        <td class="text-center align-middle px-0">
                                            <input type="checkbox" class="product-checkbox" value="{{ $key }}">
                                        </td>
                                        <td class="text-center">
                                            <img src="{{ $item['options']['image'] }}" class="d-block ui-w-40 ui-bordered"
                                                alt="{{ $item['name'] }}" style="max-width: 150px; margin: 0 auto;">
                                        </td>
                                        <td class="p-4">
                                            <div class="media align-items-center">
                                                <div class="media-body">
                                                    <a href="#" class="d-block text-dark">{{ $item['name'] }}</a>
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach ($item['options']['variant'] as $variant)
                                                            <li>
                                                                <small>{{ $variant->name }}</small>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right font-weight-semibold align-middle p-4"
                                            data-price="{{ $item['price'] }}">
                                            {{ number_format($item['price'], 0, ',', '.') }}₫
                                        </td>
                                        <td class="align-middle p-4">
                                            <input type="number" class="form-control text-center quantity"
                                                value="{{ $item['quantity'] }}" min="1" onchange="updateTotal(this)">
                                        </td>
                                        <td class="text-right font-weight-semibold align-middle p-4 total">
                                            {{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }}₫
                                        </td>
                                        <td class="text-center align-middle px-0">
                                            <button type="button" class="btn btn-warning remove-from-cart"
                                                data-id="{{ $key }}">Xóa</button>
                                        </td>
                                    </tr>
                                    @php $subtotal += $item['quantity'] * $item['price']; @endphp
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">Giỏ hàng của bạn đang trống.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="d-flex flex-wrap justify-content-between align-items-center pb-4">
                    <div class="mt-4"></div>
                    <div class="d-flex">
                        <div class="text-right mt-4 mr-4"></div>
                        <div class="text-right mt-4">
                            <div class="text-right mt-4 mr-4"></div>
                            <label class="text-muted font-weight-normal m-0">Tổng giá</label>
                            <div class="text-large"><strong
                                    id="total-price">₫{{ number_format($subtotal, 0, ',', '.') }}</strong></div>
                        </div>
                    </div>
                </div>
                <div class="float-right">
                    <form id="checkoutForm" action="{{ route('showCheckout') }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" id="selected_products" name="selected_products">
                        <button type="button" class="btn btn-lg btn-primary mt-2" onclick="submitCheckout()">Tiến hành
                            thanh toán</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all');
        const productCheckboxes = document.querySelectorAll('.product-checkbox');
        const totalPriceElement = document.getElementById('total-price');
        const quantityInputs = document.querySelectorAll('.quantity');  // Lấy tất cả các input số lượng

        // Hàm cập nhật tổng giá sản phẩm
        function updateTotal(input) {
            const row = input.closest('tr');  // Lấy dòng sản phẩm
            const price = parseFloat(row.querySelector('.text-right').dataset.price);  // Lấy giá sản phẩm
            const quantity = parseInt(input.value);  // Lấy số lượng mới
            const totalCell = row.querySelector('.total');  // Lấy cột tổng giá
            const newTotal = price * quantity;  // Tính lại tổng giá

            totalCell.textContent = newTotal.toLocaleString('vi-VN') + '₫';  // Cập nhật lại cột tổng
            updateCartTotal();  // Cập nhật lại tổng toàn bộ giỏ hàng
        }

        // Hàm cập nhật tổng giá của toàn bộ giỏ hàng
        function updateCartTotal() {
            let total = 0;
            productCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const row = checkbox.closest('tr');
                    const totalCell = row.querySelector('.total').textContent.replace('₫', '').replace(/\./g, '');
                    total += parseFloat(totalCell);
                }
            });
            totalPriceElement.textContent = `₫${total.toLocaleString('vi-VN')}`;
        }

        // Gắn sự kiện change cho checkbox "select-all"
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            productCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
            updateCartTotal();
        });

        // Gắn sự kiện change cho từng checkbox sản phẩm
        productCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateCartTotal);
        });

        // Gắn sự kiện change cho các input số lượng
        quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (input.value < 1) {
                    input.value = 1;  // Đảm bảo không có số lượng âm hoặc bằng 0
                }
                updateTotal(input);  // Cập nhật lại tổng của sản phẩm này
            });
        });

        // Gọi hàm cập nhật tổng giá ban đầu
        updateCartTotal();
    });

    // Hàm xử lý thanh toán
    function submitCheckout() {
        const selectedProducts = [...document.querySelectorAll('.product-checkbox:checked')].map(checkbox => {
            const row = checkbox.closest('tr');
            return {
                cart_id: checkbox.value
            };
        });

        document.getElementById('selected_products').value = JSON.stringify(selectedProducts);
        document.getElementById('checkoutForm').submit();
    }
</script>

@extends('client.master')

@section('title', 'Zaia Enterprise | Giỏ hàng của bạn')

@section('content')
    @include('components.breadcrumb-client2')
    {{-- <div class="container px-3 my-5 clearfix mt-5">
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
                                                    @if (!empty($item['options']['variant']) && is_array($item['options']['variant']))
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach ($item['options']['variant'] as $variant)
                                                                <li>
                                                                    <small>{{ $variant->name }}</small>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right font-weight-semibold align-middle p-4"
                                            data-price="{{ $item['price'] }}">
                                            {{ number_format(floatval($item['price']), 0, ',', '.') }}₫

                                        </td>
                                        <td class="align-middle p-4">
                                            <input type="number" class="form-control text-center quantity"
                                                value="{{ $item['quantity'] }}" min="1" onchange="updateTotal(this)">
                                        </td>
                                        <td class="text-right font-weight-semibold align-middle p-4 total">
                                            {{ number_format(floatval($item['quantity']) * floatval($item['price']), 0, ',', '.') }}₫
                                        </td>
                                        <td class="text-center align-middle px-0">
                                            <button type="button" class="btn btn-warning remove-from-cart"
                                                data-id="{{ $key }}">Xóa</button>
                                        </td>
                                    </tr>
                                    @php
                                        $quantity = is_numeric($item['quantity']) ? floatval($item['quantity']) : 0;
                                        $price = is_numeric($item['price']) ? floatval($item['price']) : 0;
                                        $subtotal += $quantity * $price;
                                    @endphp
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
    </div> --}}

    <main class="site-main main-container no-sidebar">
        <div class="container">
            <div class="row">
                <div class="main-content col-md-12">
                    <div class="page-main-content">
                        <div class="kobolg">
                            <div class="kobolg-notices-wrapper"></div>
                            <form class="kobolg-cart-form">
                                <table class="shop_table shop_table_responsive cart kobolg-cart-form__contents"
                                    cellspacing="0" id="cart-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center align-middle py-3 px-0" style="width: 40px;">
                                                <input type="checkbox" id="select-all">
                                            </th>
                                            <th class="text-center py-3 px-4">Hình ảnh</th>
                                            <th class="text-center py-3 px-4">Tên sản phẩm</th>
                                            <th class="text-center py-3 px-4">Giá</th>
                                            <th class="text-center py-3 px-4">Số lượng</th>
                                            <th class="text-center py-3 px-4">Tổng</th>
                                            <th class="text-center align-middle py-3 px-0"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $subtotal = 0; @endphp
                                        @if (session("cart_{$id}") && count(session("cart_{$id}")) > 0)
                                            @foreach (session("cart_{$id}") as $key => $item)
                                                <tr data-cart-id="{{ $key }}">
                                                    <td class="text-center align-middle px-0">
                                                        <input type="checkbox" class="product-checkbox"
                                                            value="{{ $key }}">
                                                    </td>
                                                    <td class="text-center">
                                                        <img src="{{ $item['options']['image'] }}"
                                                            class="d-block ui-w-40 ui-bordered" alt="{{ $item['name'] }}"
                                                            style="max-width: 150px; margin: 0 auto;">
                                                    </td>
                                                    <td class="p-4">
                                                        <div class="media align-items-center">
                                                            <div class="media-body">
                                                                <a href="#"
                                                                    class="d-block text-dark">{{ $item['name'] }}</a>
                                                                @if (!empty($item['options']['variant']) && is_array($item['options']['variant']))
                                                                    <ul class="list-unstyled mb-0">
                                                                        @foreach ($item['options']['variant'] as $variant)
                                                                            <li>
                                                                                <small>{{ $variant->name }}</small>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif

                                                                @if (
                                                                    !empty($item['options']['variant']) &&
                                                                        is_countable($item['options']['variant']) &&
                                                                        $item['options']['variant']->count() > 0)
                                                                    <div class="product-attributes">
                                                                        @foreach ($item['options']['variant'] as $index => $attribute)
                                                                            <span
                                                                                class="attribute-item">{{ $attribute->name }}</span>
                                                                            @if ($index < count($item['options']['variant']) - 1)
                                                                                <span>-</span>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-right font-weight-semibold align-middle p-4"
                                                        data-price="{{ $item['price'] }}">
                                                        {{ number_format(floatval($item['price']), 0, ',', '.') }}₫

                                                    </td>
                                                    <td class="align-middle p-4">
                                                        <input type="number" class="form-control text-center quantity"
                                                            value="{{ $item['quantity'] }}" min="1"
                                                            onchange="updateTotal(this)">
                                                    </td>
                                                    <td class="text-right font-weight-semibold align-middle p-4 total">
                                                        {{ number_format(floatval($item['quantity']) * floatval($item['price']), 0, ',', '.') }}₫
                                                    </td>
                                                    <td class="text-center align-middle px-0">
                                                        <button type="button"
                                                            class="btn btn-danger remove remove-from-cart"
                                                            aria-label="Remove this item"
                                                            data-id="{{ $key }}">×</button>
                                                    </td>
                                                </tr>
                                                @php
                                                    $quantity = is_numeric($item['quantity'])
                                                        ? floatval($item['quantity'])
                                                        : 0;
                                                    $price = is_numeric($item['price']) ? floatval($item['price']) : 0;
                                                    $subtotal += $quantity * $price;
                                                @endphp
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center">Giỏ hàng của bạn đang trống.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </form>
                            <div class="cart-collaterals">
                                <div class="cart_totals ">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center pb-4">
                                        <div class="mt-4"></div>
                                        <div class="d-flex">
                                            <div class="text-right mt-4 mr-4"></div>
                                            <div class="text-right mt-4">
                                                <div class="text-right mt-4 mr-4"></div>
                                                <label class="text-muted font-weight-normal m-0">Tổng giá</label>
                                                <div class="text-large"><strong
                                                        id="total-price">₫{{ number_format($subtotal, 0, ',', '.') }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kobolg-proceed-to-checkout float-right">
                                        <form id="checkoutForm" action="{{ route('showCheckout') }}" method="GET"
                                            style="display: inline;">
                                            @csrf
                                            <input type="hidden" id="selected_products" name="selected_products">
                                            <button type="button" class="checkout-button button alt kobolg-forward"
                                                onclick="submitCheckout()">Tiến hành
                                                thanh toán</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all');
            const productCheckboxes = document.querySelectorAll('.product-checkbox');
            const totalPriceElement = document.getElementById('total-price');
            const quantityInputs = document.querySelectorAll('.quantity'); // Lấy tất cả các input số lượng
            // Hàm làm tròn giá thành số nguyên
            function roundPrice(price) {
                return Math.round(price);
            }
            // Hàm cập nhật tổng giá sản phẩm
            function updateTotal(input) {
                const row = input.closest('tr');
                const productId = row.getAttribute('data-cart-id'); // ID sản phẩm hoặc biến thể trong giỏ hàng
                const quantity = parseInt(input.value);

                fetch(`/cart/check-stock2`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: quantity,
                        }),
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            // Nếu đủ tồn kho, cập nhật tổng giá
                            const priceElement = row.querySelector('.text-right[data-price]');
                            const price = parseFloat(priceElement.dataset.price);
                            const totalCell = row.querySelector('.total');
                            const newTotal = price * quantity;

                            totalCell.textContent = newTotal.toLocaleString('vi-VN') + '₫';
                            updateCartTotal(); // Cập nhật tổng giá toàn bộ giỏ hàng
                        } else {
                            // Nếu không đủ tồn kho
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: data.message,
                                toast: true,
                                timer: 5000,
                                position: 'top-right',
                                showConfirmButton: false,
                            });
                            input.value = data.available_stock; // Cập nhật lại số lượng tối đa
                        }
                    });
            }

            // Hàm cập nhật tổng giá của toàn bộ giỏ hàng
            function updateCartTotal() {
                let total = 0;
                productCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const row = checkbox.closest('tr');
                        const totalCell = row.querySelector('.total').textContent.replace('₫', '').replace(
                            /\./g, '');
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
                        input.value = 1; // Đảm bảo không có số lượng âm hoặc bằng 0
                    }
                    updateTotal(input); // Cập nhật lại tổng của sản phẩm này
                });
            });
            updateCartTotal();
        });

        // Hàm xử lý thanh toán
        function submitCheckout() {
            const selectedProducts = [...document.querySelectorAll('.product-checkbox:checked')].map(checkbox => {
                const row = checkbox.closest('tr');
                const quantity = parseInt(row.querySelector('.quantity').value); // Lấy số lượng từ input
                return {
                    cart_id: checkbox.value,
                    quantity: quantity // Thêm số lượng vào dữ liệu gửi đi
                };
            });

            document.getElementById('selected_products').value = JSON.stringify(selectedProducts);
            document.getElementById('checkoutForm').submit();
        }
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.remove-from-cart').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const productId = this.getAttribute('data-id');
                    const row = this.closest('tr'); // Lấy dòng chứa sản phẩm
                    Swal.fire({
                        title: 'Xác nhận',
                        text: "Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?",
                        icon: 'warning',
                        toast: true,
                        timer: 5000,
                        position: 'top-right',
                        showCancelButton: true,
                        confirmButtonText: 'Có',
                        cancelButtonText: 'Không'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/cart/remove/${productId}`, { // Đường dẫn tới controller
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Thêm CSRF Token
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        id: productId
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Đã xóa!',
                                            text: data.message,
                                            toast: true,
                                            timer: 5000,
                                            position: 'top-right',
                                            showConfirmButton: false
                                        });
                                        row.remove(); // Xóa dòng sản phẩm
                                        updateCartTotal(); // Cập nhật lại tổng giá
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Lỗi!',
                                            text: data.message,
                                            toast: true,
                                            timer: 5000,
                                            position: 'top-right',
                                            showConfirmButton: false
                                        });
                                    }
                                })
                        }
                    });
                });
            });
        });
    </script>
@endsection

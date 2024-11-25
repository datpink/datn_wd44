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
                                <th class="text-center py-3 px-4" style="min-width: 400px;">Tên sản phẩm &amp; Chi tiết</th>
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
                                    <tr data-cart-id="{{ $key }}"
                                        data-storage-variant-id="{{ $item['options']['storage_variant_id'] }}"
                                        data-color-variant-id="{{ $item['options']['color_variant_id'] }}">

                                        <td class="text-center align-middle px-0">
                                            <input type="checkbox" name="product_checkbox" value="{{ $key }}">
                                        </td>
                                        <td class="text-center">
                                            <img src="{{ $item['options']['image'] }}" class="d-block ui-w-40 ui-bordered"
                                                alt="{{ $item['name'] }}" style="max-width: 150px; margin: 0 auto;">
                                        </td>
                                        <td class="p-4">
                                            <div class="media align-items-center">
                                                <div class="media-body">
                                                    <a href="#" class="d-block text-dark">{{ $item['name'] }}</a>
                                                    <small>
                                                        @if ($item['options']['color'] || $item['options']['storage'])
                                                            Màu: {{ $item['options']['color'] }} - Bộ nhớ:
                                                            {{ $item['options']['storage'] }}
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right font-weight-semibold align-middle p-4"
                                            data-price="{{ $item['price'] }}">
                                            {{ number_format($item['price'], 0, ',', '.') }}₫
                                        </td>
                                        <td class="align-middle p-4">
                                            <input type="number" class="form-control text-center quantity"
                                                value="{{ $item['quantity'] }}" min="1"
                                                onchange="updateTotal(this)">
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
                    <div class="mt-4">
                    </div>
                    <div class="d-flex">
                        <div class="text-right mt-4 mr-4">
                        </div>
                        <div class="text-right mt-4">
                            <label class="text-muted font-weight-normal m-0">Tổng giá</label>
                            <div class="text-large"><strong id="total-price">₫
                                    {{ number_format($subtotal, 0, ',', '.') }}</strong></div>
                        </div>
                    </div>
                </div>
                <div class="float-right">
                    <button type="button" class="btn btn-lg btn-default md-btn-flat mt-2 mr-3"
                        onclick="window.location.href='{{ route('products.index') }}'">Trở về mua sắm</button>

                    <!-- Form gửi dữ liệu sản phẩm đã chọn -->
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function formatCurrency(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function updateTotal(input) {
            const row = input.closest('tr');
            const price = parseFloat(row.querySelector('[data-price]').dataset.price);
            const quantity = parseInt(input.value);

            if (isNaN(quantity) || quantity < 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    toast: true,
                    timer: 3500,
                    position: 'top',
                    text: "Số lượng không hợp lệ!"
                });
                return;
            }

            const total = price * quantity;
            row.querySelector('.total').textContent = `₫${formatCurrency(total)}`;
            updateCartTotal();
        }

        function updateTotal(input) {
            const row = input.closest('tr');
            const price = parseFloat(row.querySelector('[data-price]').dataset.price);
            let quantity = parseInt(input.value);

            if (isNaN(quantity) || quantity < 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    toast: true,
                    timer: 3500,
                    position: 'top',
                    text: "Số lượng không hợp lệ!"
                });
                input.value = 1; // Đặt lại số lượng về 1 nếu không hợp lệ
                quantity = 1; // Cập nhật lại giá trị
            }

            const total = price * quantity;
            row.querySelector('.total').textContent = `₫${formatCurrency(total)}`;
            updateCartTotal();
        }


        function submitCheckout() {
            const selectedProducts = [...document.querySelectorAll('input[name="product_checkbox"]:checked')].map(
                checkbox => {
                    const row = checkbox.closest('tr');
                    return {
                        cart_id: checkbox.value,
                        storage_variant_id: row.dataset.storageVariantId ||
                        null, // Sử dụng dataset để lấy giá trị data-attributes
                        color_variant_id: row.dataset.colorVariantId ||
                            null // Sử dụng dataset để lấy giá trị data-attributes
                    };
                });

            document.getElementById('selected_products').value = JSON.stringify(selectedProducts);
            document.getElementById('checkoutForm').submit();
        }



        document.querySelectorAll('#cart-table tbody input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', updateCartTotal);
        });

        document.addEventListener('DOMContentLoaded', updateCartTotal);

        document.getElementById('select-all').addEventListener('change', function() {
            const checked = this.checked;
            document.querySelectorAll('#cart-table tbody input[type="checkbox"]').forEach(checkbox => {
                checkbox.checked = checked;
            });
            updateCartTotal();
        });
    </script>
@endsection

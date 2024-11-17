@extends('client.master')

@section('title', 'Zaia Enterprise | Giỏ hàng của bạn')

@section('content')
<div class="container px-3 my-5 clearfix">
    <div class="card">
        <div class="card-header">
            <h2>Giỏ hàng của bạn</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered m-0" id="cart-table">
                    <thead>
                        <tr>
                            <th class="text-center align-middle py-3 px-0" style="width: 40px;"></th>
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
                        @if (session('cart') && count(session('cart')) > 0)
                        @foreach (session('cart') as $key => $item)
                        <tr>
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
                <div class="col-6">
                    <label class="text-muted font-weight-normal">Mã Giảm Giá</label>
                    <select class="form-control" id="discount-code">
                        <option value="">Chọn mã giảm giá</option>
                        @foreach ($discountCodes as $promotion)
                        <option
                            value="{{ $promotion->discount_value }}"
                            data-type="{{ $promotion->type }}"
                            data-value="{{ $promotion->discount_value }}">
                            @if ($promotion->type == 'percentage')
                            {{ $promotion->code }} - Giảm giá {{ $promotion->discount_value }}%
                            @else
                            {{ $promotion->code }} - Giảm giá {{ number_format($promotion->discount_value, 0, ',', '.') }}₫
                            @endif
                        </option>
                        @endforeach
                    </select>

                    <button type="button" class="btn btn-primary mt-2" id="apply-discount-btn">Áp dụng</button>
                </div>
                >


                <div class="d-flex">
                    <div class="text-right mt-4 mr-5">
                        <label class="text-muted font-weight-normal m-0">Giảm Giá</label>
                        <div class="text-large"><strong id="discount-value">₫0.00</strong></div>
                    </div>
                    <div class="text-right mt-4">
                        <label class="text-muted font-weight-normal m-0">Tổng giá</label>
                        <div class="text-large"><strong id="total-price">₫{{ number_format($subtotal, 0, ',', '.') }}</strong></div>
                    </div>
                </div>
            </div>

            <div class="float-right">
                <button type="button" class="btn btn-lg btn-default md-btn-flat mt-2 mr-3"
                    onclick="window.location.href='{{ route('products.index') }}'">Trở về mua sắm</button>
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

    function updateCartTotal() {
        let subtotal = 0;
        document.querySelectorAll('#cart-table tbody tr').forEach(row => {
            const totalValue = parseFloat(row.querySelector('.total').textContent.replace('₫', '').replace(/\./g, ''));
            if (!isNaN(totalValue)) subtotal += totalValue;
        });

        const discountCode = document.getElementById('discount-code').value;
        let discountValue = 0;

        // Kiểm tra loại mã giảm giá và tính toán giá trị giảm
        if (discountCode) {
            const discountData = document.querySelector(`#discount-code option[value="${discountCode}"]`);
            const discountType = discountData ? discountData.dataset.type : '';
            const discountAmount = discountData ? parseFloat(discountData.dataset.value) : 0;

            if (discountType === 'percentage') {
                // Giảm giá theo phần trăm
                discountValue = (subtotal * discountAmount) / 100;
            } else if (discountType === 'fixed_amount') {
                // Giảm giá theo số tiền cố định
                discountValue = discountAmount;
            } else if (discountType === 'free_shipping') {
                // Nếu miễn phí vận chuyển, không thay đổi tổng
                discountValue = 0;
            }
        }

        // Cập nhật giá trị giảm giá và tổng
        document.getElementById('discount-value').textContent = `₫${formatCurrency(discountValue)}`;
        const total = Math.max(subtotal - discountValue, 0); // Đảm bảo không âm
        document.getElementById('total-price').textContent = `₫${formatCurrency(total)}`;
    }

    document.getElementById('apply-discount-btn').addEventListener('click', function() {
        updateCartTotal();
        Swal.fire({
            icon: 'success',
            title: 'Đã áp dụng mã giảm giá!',
            toast: true,
            timer: 2000,
            position: 'top',
            showConfirmButton: false
        });
    });

    function submitCheckout() {
        const selectedProducts = [];
        document.querySelectorAll('#cart-table tbody tr').forEach(row => {
            const checkbox = row.querySelector('input[type="checkbox"]');
            if (checkbox && checkbox.checked) {
                const productId = row.dataset.productId;
                selectedProducts.push(productId);
            }
        });
        document.getElementById('selected_products').value = JSON.stringify(selectedProducts);
        document.getElementById('checkoutForm').submit();
    }
</script>

@endsection
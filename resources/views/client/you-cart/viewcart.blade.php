@extends('client.master')

@section('title', 'Zaia Enterprise | Giỏ hàng của bạn')

@section('content')

    <style>
        .custom-alert {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            padding: 20px;
            text-align: center;
        }

        .custom-alert .alert-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .custom-alert .alert-message {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .custom-alert .btn {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            padding: 8px 16px;
            border-radius: 4px;
        }

        .custom-alert .btn:hover {
            background-color: #0056b3;
            border-color: #004d99;
        }

        .ui-w-40 {
            width: 70px !important;
            height: auto;
        }

        .card {
            box-shadow: 0 1px 15px 1px rgba(52, 40, 104, .08);
        }

        .ui-product-color {
            display: inline-block;
            overflow: hidden;
            margin: .144em;
            width: .875rem;
            height: .875rem;
            border-radius: 10rem;
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.15) inset;
            vertical-align: middle;
        }
    </style>

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
                                <th class="text-center py-3 px-4" style="min-width: 400px;">Tên sản phẩm &amp; Chi tiết</th>
                                <th class="text-right py-3 px-4" style="width: 100px;">Giá</th>
                                <th class="text-center py-3 px-4" style="width: 120px;">Số lượng</th>
                                <th class="text-right py-3 px-4" style="width: 100px;">Tổng</th>
                                <th class="text-center align-middle py-3 px-0" style="width: 40px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $subtotal = 0; @endphp
                            @if (session('cart') && count(session('cart')) > 0)
                                @foreach (session('cart') as $key => $item)
                                    <tr>
                                        <td class="text-center align-middle px-0">
                                            <input type="checkbox"></input>
                                        </td>
                                        <td class="p-4">
                                            <div class="media align-items-center">
                                                <img src="{{ $item['options']['image'] }}"
                                                    class="d-block ui-w-40 ui-bordered mr-4" alt="{{ $item['name'] }}">
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
                                            ${{ number_format($item['price'], 0, ',', '.') }}
                                        </td>
                                        <td class="align-middle p-4">
                                            <input type="number" class="form-control text-center quantity"
                                                value="{{ $item['quantity'] }}" min="1" onchange="updateTotal(this)">
                                        </td>
                                        <td class="text-right font-weight-semibold align-middle p-4 total">
                                            ${{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }}
                                        </td>
                                        <td class="text-center align-middle px-0">
                                            <button type="button" class="btn btn-light remove-from-cart"
                                                data-id="{{ $key }}">Xóa</button>
                                        </td>
                                    </tr>
                                    @php $subtotal += $item['quantity'] * $item['price']; @endphp
                                @endforeach
                                <tr>
                                    <td colspan="4" class="text-right font-weight-bold">Tổng cộng:</td>
                                    <td class="text-right font-weight-bold" id="total-price">
                                        ${{ number_format($subtotal, 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">Giỏ hàng của bạn đang trống.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center pb-4">
                    <div class="mt-4">
                        <label class="text-muted font-weight-normal">Mã Giảm Giá</label>
                        <input type="text" placeholder="ABC" class="form-control">
                    </div>
                    <div class="d-flex">
                        <div class="text-right mt-4 mr-5">
                            <label class="text-muted font-weight-normal m-0">Discount</label>
                            <div class="text-large"><strong>$0.00</strong></div>
                        </div>
                        <div class="text-right mt-4">
                            <label class="text-muted font-weight-normal m-0">Tổng giá</label>
                            <div class="text-large"><strong
                                    id="total-price">${{ number_format($subtotal, 0, ',', '.') }}</strong></div>
                        </div>
                    </div>
                </div>

                <div class="float-right">
                    <button type="button" class="btn btn-lg btn-default md-btn-flat mt-2 mr-3"
                        onclick="window.location.href='{{ route('products.index') }}'">Trở về mua sắm</button>
                    <button type="button" class="btn btn-lg btn-primary mt-2" onclick="checkout()">Thanh toán</button>
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
                    text: "Số lượng không hợp lệ!",
                });
                return;
            }

            const total = price * quantity;
            row.querySelector('.total').textContent = `$${formatCurrency(total)}`;
            updateCartTotal();
        }

        function updateCartTotal() {
            let subtotal = 0;
            document.querySelectorAll('.total').forEach(item => {
                const totalValue = parseFloat(item.textContent.replace('$', '').replace('.', '').replace(',', ''));
                if (!isNaN(totalValue)) {
                    subtotal += totalValue;
                }
            });
            document.getElementById('total-price').textContent = `$${formatCurrency(subtotal)}`;
        }

        function checkout() {
            window.location.href = "{{ route('cart.view') }}";
        }

        document.addEventListener('DOMContentLoaded', updateCartTotal);

        document.querySelectorAll('.remove-from-cart').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const productId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Xác nhận',
                    text: "Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?",
                    icon: 'warning',
                    timer: 3500,
                    showCancelButton: true,
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Không',
                    customClass: {
                        container: 'custom-alert',
                        title: 'alert-title',
                        content: 'alert-message',
                        confirmButton: 'btn custom-confirm-button',
                        cancelButton: 'btn custom-cancel-button'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`{{ url('cart/remove/') }}/${productId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                    this.closest('tr')
                                        .remove(); // Xóa hàng tương ứng trong bảng giỏ hàng
                                    updateCartTotal(); // Cập nhật tổng giỏ hàng
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Lỗi!',
                                        text: data.message,
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }
                });
            });
        });
    </script>

@endsection

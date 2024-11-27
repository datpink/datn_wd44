@if (session('success'))
    <script>
        Swal.fire({
            position: 'top',
            icon: 'success',
            title: 'Thành công!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 1500
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            position: 'top',
            icon: 'error',
            title: 'Lỗi!',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 1500
        });
    </script>
@endif

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

    .kobolg-mini-cart-item a {
        display: inline-block;
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        vertical-align: middle;
    }

    .kobolg-mini-cart__total {
        font-weight: bold;
    }
</style>

<div class="block-minicart block-dreaming kobolg-mini-cart kobolg-dropdown">
    <div class="shopcart-dropdown block-cart-link" data-kobolg="kobolg-dropdown">
        <a class="block-link link-dropdown" href="{{ route('cart.view') }}">
            <span class="flaticon-online-shopping-cart"></span>
            <span
                class="count">{{ session('cart_' . auth()->id()) ? count(session('cart_' . auth()->id())) : 0 }}</span>
        </a>
    </div>
    <div class="widget kobolg widget_shopping_cart">
        <div class="widget_shopping_cart_content">
            <h3 class="minicart-title">
                Giỏ hàng của bạn <span
                    class="minicart-number-items">{{ session('cart_' . auth()->id()) ? count(session('cart_' . auth()->id())) : 0 }}</span>
            </h3>
            <ul class="kobolg-mini-cart cart_list product_list_widget">
                @if (session('cart_' . auth()->id()))
                    @php $subtotal = 0; @endphp
                    @foreach (session('cart_' . auth()->id()) as $key => $item)
                        <li class="kobolg-mini-cart-item mini_cart_item">
                            <form class="remove-form" style="display: inline;">
                                @csrf
                                <button type="button" class="remove remove_from_cart_button" title="Remove this item"
                                    style="border: none; background: none; cursor: pointer;">×</button>
                                <input type="hidden" name="id" value="{{ $key }}">
                            </form>
                            <a href="#">
                                <img src="{{ $item['options']['image'] }}" alt="{{ $item['name'] }}" width="100px"
                                    height="100px">
                                {{ $item['name'] }}
                                @if ($item['options']['color'] || $item['options']['storage'])
                                    - {{ $item['options']['color'] }} - {{ $item['options']['storage'] }}
                                @endif
                            </a>
                            <span class="quantity">
                                {{ $item['quantity'] }} ×
                                <span class="kobolg-Price-amount amount">
                                    {{ number_format($item['price'], 0) }}<span
                                        class="kobolg-Price-currencySymbol">₫</span>
                                </span>
                            </span>
                        </li>
                        @php $subtotal += $item['quantity'] * $item['price']; @endphp
                    @endforeach
                @else
                    <li class="kobolg-mini-cart-item mini_cart_item">Giỏ hàng trống.</li>
                @endif
            </ul>
            <p class="kobolg-mini-cart__total total">
                <strong>Tổng:</strong>
                <span class="kobolg-Price-amount amount">
                    {{ number_format($subtotal ?? 0, 0) }}<span class="kobolg-Price-currencySymbol">₫</span>
                </span>
            </p>
            <p class="kobolg-mini-cart__buttons buttons">
                <a href="{{ route('cart.view') }}" class="button kobolg-forward">Xem Giỏ hàng</a>
                <a href="checkout.html" class="button checkout kobolg-forward">Thanh toán</a>
            </p>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function updateCartCount(count) {
        document.querySelector('.count').textContent = count;
        document.querySelector('.minicart-number-items').textContent = count;
    }

    document.querySelectorAll('.remove_from_cart_button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const form = this.closest('.remove-form');

            Swal.fire({
                title: 'Xác nhận',
                text: "Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?",
                icon: 'warning',
                position: 'top',
                toast: true,
                showCancelButton: true,
                timer: 3500,
                confirmButtonText: 'Có',
                cancelButtonText: 'Không',
                customClass: {
                    confirmButton: 'custom-confirm-button',
                    cancelButton: 'custom-cancel-button'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const productId = form.querySelector('input[name="id"]').value;

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
                                    position: 'top',
                                    toast: true,
                                    showConfirmButton: false
                                });
                                form.closest('.kobolg-mini-cart-item')
                                    .remove(); // Xóa sản phẩm khỏi danh sách
                                updateCartTotal(); // Cập nhật tổng giỏ hàng
                                updateCartCount(data
                                    .cartCount); // Cập nhật số lượng giỏ hàng
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi!',
                                    text: data.message,
                                    position: 'top',
                                    toast: true,
                                    showConfirmButton: false
                                });
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        });
    });

    function updateCartTotal() {
        let subtotal = 0;
        document.querySelectorAll('.kobolg-mini-cart-item').forEach(item => {
            const quantity = parseInt(item.querySelector('.quantity').textContent.split(' × ')[0]);
            const price = parseFloat(item.querySelector('.kobolg-Price-amount').textContent.replace('₫', '')
                .replace('.', '').trim());
            subtotal += quantity * price;
        });
        document.querySelector('.total').innerHTML =
            `<strong>Tổng:</strong> <span class="kobolg-Price-amount amount"><span class="kobolg-Price-currencySymbol">₫</span>${numberWithCommas(subtotal.toFixed(2))}</span>`;
    }

    function numberWithCommas(x) {
        return x.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>

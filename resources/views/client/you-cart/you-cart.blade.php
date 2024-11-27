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

<div class="block-minicart block-dreaming kobolg-mini-cart kobolg-dropdown">
    <div class="shopcart-dropdown block-cart-link" data-kobolg="kobolg-dropdown">
        <a class="block-link link-dropdown" href="{{ route('cart.view') }}">
            <span class="flaticon-online-shopping-cart"></span>
            <span class="count">{{ session('cart_' . auth()->id()) ? count(session('cart_' . auth()->id())) : 0 }}</span>
        </a>
    </div>
    <div class="widget kobolg widget_shopping_cart">
        <div class="widget_shopping_cart_content">
            <h3 class="minicart-title">
                Giỏ hàng của bạn <span class="minicart-number-items">{{ session('cart_' . auth()->id()) ? count(session('cart_' . auth()->id())) : 0 }}</span>
            </h3>
            <ul class="kobolg-mini-cart cart_list product_list_widget">
                @php
                    $cart = session('cart_' . auth()->id(), []);
                    $subtotal = 0;
                @endphp

                @foreach($cart as $item)
                    <li class="kobolg-mini-cart-item">
                        <a href="#" class="product-title">{{ $item['name'] }}</a>
                        <span class="quantity">{{ $item['quantity'] }} x
                            <span class="amount">{{ $item['price'] }}₫</span>
                        </span>

                        <!-- Hiển thị hình ảnh sản phẩm -->
                        <img src="{{ $item['options']['image'] }}" alt="{{ $item['name'] }}" class="mini-cart-product-image">

                        <!-- Hiển thị thuộc tính (variant) nếu có -->
                        @if($item['options']['variant']->count() > 0)
                            <div class="product-attributes">
                                @foreach($item['options']['variant'] as $attribute)
                                    <p><strong>{{ $attribute->name }}:</strong> {{ $attribute->value }}</p>
                                @endforeach
                            </div>
                        @endif

                        <a href="#" class="remove remove_from_cart" data-id="{{ $item['id'] }}">×</a>
                    </li>
                    @php
                        $subtotal += $item['price'] * $item['quantity']; // Tính tổng giá trị giỏ hàng
                    @endphp
                @endforeach
            </ul>
            <p class="kobolg-mini-cart__total total">
                <strong>Tổng:</strong>
                <span class="kobolg-Price-amount amount">
                    {{ number_format($subtotal, 0) }}₫
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

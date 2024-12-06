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
    <style>.product-attributes {
        display: flex;
        flex-wrap: wrap;
        /* Nếu có quá nhiều nội dung, nó sẽ tự xuống dòng */
        gap: 8px;
        /* Khoảng cách giữa các mục */
    }

    .product-attributes .attribute-item {
        font-size: 12px;
        /* Kích thước chữ nhỏ hơn */
        color: #666;
        /* Màu chữ xám nhạt (tuỳ chọn) */
        white-space: nowrap;
        /* Ngăn nội dung bị xuống dòng */
    }
</style>

</style>
<div class="block-minicart block-dreaming kobolg-mini-cart kobolg-dropdown" id="cart-content">
    <div class="shopcart-dropdown block-cart-link" data-kobolg="kobolg-dropdown">
        <a class="block-link link-dropdown" href="{{ route('cart.view') }}">
            <span class="flaticon-online-shopping-cart"></span>
            <span
                class="count cart">{{ session('cart_' . auth()->id()) ? count(session('cart_' . auth()->id())) : 0 }}</span>
        </a>
    </div>
    <div class="widget kobolg widget_shopping_cart">
        <div class="widget_shopping_cart_content">
            <h3 class="minicart-title">
                Giỏ hàng của bạn
                <span class="minicart-number-items">
                    {{ session('cart_' . auth()->id()) ? count(session('cart_' . auth()->id())) : 0 }}
                </span>
            </h3>
            <ul class="kobolg-mini-cart cart_list product_list_widget">
                @if (session('cart_' . auth()->id()))
                    @php $subtotal = 0; @endphp
                    @foreach (session('cart_' . auth()->id()) as $key => $item)
                        <li class="kobolg-mini-cart-item mini_cart_item">
                            <a href="#">
                                <img src="{{ $item['options']['image'] }}" alt="{{ $item['name'] }}"
                                    class="mini-cart-product-image"
                                    style="width: 80px; height: auto; margin-right: 10px;">
                                <span class="product-title">{{ $item['name'] }}</span>
                            </a>
                            @if (
                                !empty($item['options']['variant']) &&
                                    is_countable($item['options']['variant']) &&
                                    $item['options']['variant']->count() > 0)
                                <div class="product-attributes">
                                    @foreach ($item['options']['variant'] as $index => $attribute)
                                        <span class="attribute-item">{{ $attribute->name }}</span>
                                        @if ($index < count($item['options']['variant']) - 1)
                                            <span>-</span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                            <span class="quantity">
                                {{ $item['quantity'] }} × {{ number_format(floatval($item['price']), 0) }}₫
                            </span>


                            <button type="button" class="remove remove_from_cart_button" data-id="{{ $key }}"
                                style="background: none; border: none; color: red; font-size: 16px; cursor: pointer;">×</button>
                        </li>
                        @php
                            $price = is_numeric($item['price']) ? floatval($item['price']) : 0;
                            $subtotal += $item['quantity'] * $price;
                        @endphp
                    @endforeach
                @else
                    <li class="kobolg-mini-cart-item mini_cart_item">Giỏ hàng trống.</li>
                @endif
            </ul>
            <p class="kobolg-mini-cart__total total">
                <strong>Tổng:</strong>
                <span class="kobolg-Price-amount amount">
                    <span class="kobolg-Price-currencySymbol">₫</span>
                    {{ number_format($subtotal ?? 0, 0) }}
                </span>
            </p>
            <p class="kobolg-mini-cart__buttons buttons">
                <a href="{{ route('cart.view') }}" class="button kobolg-forward">Xem Giỏ hàng</a>
                <a href="{{ route('showCheckout') }}" class="button checkout kobolg-forward">Thanh toán</a>
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
            const cartItemId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Xác nhận',
                text: "Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?",
                icon: 'warning',
                toast: true,
                timer: 4000,
                position: 'top',
                showCancelButton: true,
                confirmButtonText: 'Có',
                cancelButtonText: 'Không'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ url('cart/remove/') }}/${cartItemId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Đã xóa!',
                                    text: data.message,
                                    toast: true,
                                    timer: 4000,
                                    position: 'top',
                                    showConfirmButton: false
                                });
                                document.querySelector(`.remove[data-id="${cartItemId}"]`)
                                    .closest('.kobolg-mini-cart-item')
                                    .remove(); // Xóa sản phẩm khỏi giao diện
                                updateCartCount(data
                                    .cartCount); // Cập nhật số lượng giỏ hàng
                            }
                        })
                        .catch(console.error);
                }
            });
        });
    });

    // Hàm tính lại tổng số lượng và giá trị giỏ hàng
    function updateTemporaryCart() {
        $.ajax({
            url: '{{ route('cart.temporary') }}', // Lấy lại giỏ hàng mới từ backend
            method: 'GET',
            success: function(data) {
                console.log('Dữ liệu giỏ hàng:', data);
                $('.widget_shopping_cart_content').html(data.cartHtml);

                const cartCount = data.cartCount;
                $('.header-control-inner .meta-dreaming .cart').text(cartCount);
                $('.minicart-number-items').text(cartCount); // Cập nhật số lượng trong giỏ hàng
            },
            error: function(xhr, status, error) {
                console.error("Lỗi khi cập nhật giỏ hàng:", status, error);
            },
        });
    }



    function numberWithCommas(x) {
        return x.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>

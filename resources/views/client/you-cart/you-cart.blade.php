<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        <a class="block-link link-dropdown" href="cart.html">
            <span class="flaticon-online-shopping-cart"></span>
            <span class="count">{{ session('cart') ? count(session('cart')) : 0 }}</span>
            <!-- Số lượng sản phẩm trong giỏ -->
        </a>
    </div>
    <div class="widget kobolg widget_shopping_cart">
        <div class="widget_shopping_cart_content">
            <h3 class="minicart-title">Your Cart<span
                    class="minicart-number-items">{{ session('cart') ? count(session('cart')) : 0 }}</span></h3>
            <ul class="kobolg-mini-cart cart_list product_list_widget">
                @if (session('cart'))
                    @php $subtotal = 0; @endphp
                    @foreach (session('cart') as $key => $item)
                        <li class="kobolg-mini-cart-item mini_cart_item">
                            <form action="{{ route('cart.remove', ['id' => $key]) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                <button type="submit" class="remove remove_from_cart_button" title="Remove this item"
                                    style="border: none; background: none; cursor: pointer;">×</button>
                            </form>
                            <a href="#">
                                <img src="{{ $item['options']['image'] }}" alt="{{ $item['name'] }}" width="100px"
                                    height="100px">{{ $item['name'] }}
                                @if ($item['options']['color'] || $item['options']['storage'])
                                    - {{ $item['options']['color'] }} - {{ $item['options']['storage'] }}
                                @endif
                            </a>
                            <span class="quantity">{{ $item['quantity'] }} × <span
                                    class="kobolg-Price-amount amount"><span
                                        class="kobolg-Price-currencySymbol">$</span>{{ number_format($item['price'], 2) }}</span></span>
                        </li>
                        @php $subtotal += $item['quantity'] * $item['price']; @endphp
                    @endforeach
                @else
                    <li class="kobolg-mini-cart-item mini_cart_item">Giỏ hàng trống.</li>
                @endif
            </ul>
            <p class="kobolg-mini-cart__total total"><strong>Subtotal:</strong>
                <span class="kobolg-Price-amount amount"><span
                        class="kobolg-Price-currencySymbol">$</span>{{ number_format($subtotal ?? 0, 2) }}</span>
            </p>
            <p class="kobolg-mini-cart__buttons buttons">
                <a href="cart.html" class="button kobolg-forward">View Cart</a>
                <a href="checkout.html" class="button checkout kobolg-forward">Checkout</a>
            </p>
        </div>
    </div>
</div>

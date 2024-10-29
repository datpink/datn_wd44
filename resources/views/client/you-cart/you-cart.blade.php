<<<<<<< HEAD
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

=======
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

{{-- <style>
    .kobolg-mini-cart-item a {
        display: inline-block;
        max-width: 300px;
        /* Điều chỉnh kích thước phù hợp với giao diện của bạn */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        vertical-align: middle;
    }
</style> --}}


>>>>>>> d48c587078eb2a3e569b4258a8a30a767b8842ee
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
<<<<<<< HEAD
            <h3 class="minicart-title">Your Cart<span class="minicart-number-items">{{ session('cart') ? count(session('cart')) : 0 }}</span></h3>
=======
            <h3 class="minicart-title">Your Cart<span
                    class="minicart-number-items">{{ session('cart') ? count(session('cart')) : 0 }}</span></h3>
>>>>>>> d48c587078eb2a3e569b4258a8a30a767b8842ee
            <ul class="kobolg-mini-cart cart_list product_list_widget">
                @if (session('cart'))
                    @php $subtotal = 0; @endphp
                    @foreach (session('cart') as $key => $item)
                        <li class="kobolg-mini-cart-item mini_cart_item">
<<<<<<< HEAD
                            <form action="{{ route('cart.remove', ['id' => $key]) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="remove remove_from_cart_button" title="Remove this item" style="border: none; background: none; cursor: pointer;">×</button>
                            </form>
                            <a href="#">
                                <img src="{{ $item['options']['image'] }}" alt="{{ $item['name'] }}" width="100px" height="100px">{{ $item['name'] }}
=======
                            <form action="{{ route('cart.remove', ['id' => $key]) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                <button type="submit" class="remove remove_from_cart_button" title="Remove this item"
                                    style="border: none; background: none; cursor: pointer;">×</button>
                            </form>
                            <a href="#">
                                <img src="{{ $item['options']['image'] }}" alt="{{ $item['name'] }}" width="100px"
                                    height="100px">{{ $item['name'] }}
>>>>>>> d48c587078eb2a3e569b4258a8a30a767b8842ee
                                @if ($item['options']['color'] || $item['options']['storage'])
                                    - {{ $item['options']['color'] }} - {{ $item['options']['storage'] }}
                                @endif
                            </a>
<<<<<<< HEAD
                            <span class="quantity">{{ $item['quantity'] }} × <span class="kobolg-Price-amount amount"><span class="kobolg-Price-currencySymbol">$</span>{{ number_format($item['price'], 2) }}</span></span>
=======
                            <span class="quantity">{{ $item['quantity'] }} × <span
                                    class="kobolg-Price-amount amount"><span
                                        class="kobolg-Price-currencySymbol">₫</span>{{ number_format($item['price'], 2) }}</span></span>
>>>>>>> d48c587078eb2a3e569b4258a8a30a767b8842ee
                        </li>
                        @php $subtotal += $item['quantity'] * $item['price']; @endphp
                    @endforeach
                @else
                    <li class="kobolg-mini-cart-item mini_cart_item">Giỏ hàng trống.</li>
                @endif
            </ul>
            <p class="kobolg-mini-cart__total total"><strong>Subtotal:</strong>
<<<<<<< HEAD
                <span class="kobolg-Price-amount amount"><span class="kobolg-Price-currencySymbol">$</span>{{ number_format($subtotal ?? 0, 2) }}</span>
            </p>
            <p class="kobolg-mini-cart__buttons buttons">
                <a href="cart.html" class="button kobolg-forward">View Cart</a>
=======
                <span class="kobolg-Price-amount amount"><span
                        class="kobolg-Price-currencySymbol">₫</span>{{ number_format($subtotal ?? 0, 2) }}</span>
            </p>
            <p class="kobolg-mini-cart__buttons buttons">
                <a href="{{ route('cart.view')}}" class="button kobolg-forward">View Cart</a>
>>>>>>> d48c587078eb2a3e569b4258a8a30a767b8842ee
                <a href="checkout.html" class="button checkout kobolg-forward">Checkout</a>
            </p>
        </div>
    </div>
</div>

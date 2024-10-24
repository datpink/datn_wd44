<div class="block-minicart block-dreaming kobolg-mini-cart kobolg-dropdown">
    <div class="shopcart-dropdown block-cart-link" data-kobolg="kobolg-dropdown">
        <a class="block-link link-dropdown" href="{{ url('/cart') }}">
            <span class="flaticon-online-shopping-cart"></span>
            <span class="count">{{ count(session('cart', [])) }}</span>
        </a>
    </div>
    <div class="widget kobolg widget_shopping_cart">
        <div class="widget_shopping_cart_content">
            <h3 class="minicart-title">Giỏ hàng của bạn<span class="minicart-number-items">{{ count(session('cart', [])) }}</span>
            </h3>
            <ul class="kobolg-mini-cart cart_list product_list_widget">
                @foreach(session('cart', []) as $item)
                <li class="kobolg-mini-cart-item mini_cart_item">
                    <a href="#" class="remove remove_from_cart_button" data-id="{{ $item['id'] }}">×</a>
                    <a href="#">
                        <img src="{{ $item['image_url'] }}"
                            class="attachment-kobolg_thumbnail size-kobolg_thumbnail" alt="img"
                            width="600" height="778">{{ $item['name'] }}&nbsp;
                    </a>
                    <span class="quantity">{{ $item['quantity'] }} × <span class="kobolg-Price-amount amount"><span
                                class="kobolg-Price-currencySymbol">$</span>{{ number_format($item['price'], 2) }}</span></span>
                </li>
                @endforeach
            </ul>
            <p class="kobolg-mini-cart__total total"><strong>Subtotal:</strong>
                <span class="kobolg-Price-amount amount"><span
                        class="kobolg-Price-currencySymbol">$</span>{{ number_format(session('cart_total', 0), 2) }}</span>
            </p>
            <p class="kobolg-mini-cart__buttons buttons">
                <a href="{{ url('/cart') }}" class="button kobolg-forward">Viewcart</a>
                <a href="{{ url('/checkout') }}" class="button checkout kobolg-forward">Checkout</a>
            </p>
        </div>
    </div>
</div>

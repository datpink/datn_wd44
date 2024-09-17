<div class="header-middle-inner">
    <div class="header-logo-menu">
        <div class="block-menu-bar">
            <a class="menu-bar menu-toggle" href="#">
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>
        <div class="header-logo">
            <a href="index.html"><img alt="Zaia" src="{{ asset('theme/client/assets/images/logozaia.png') }}" class="logo" width="160px"></a>
        </div>
    </div>
    <div class="header-search-mid">
        <div class="header-search">
            <div class="block-search">
                <form role="search" method="get" class="form-search block-search-form kobolg-live-search-form">
                    <div class="form-content search-box results-search">
                        <div class="inner">
                            <input autocomplete="off" class="searchfield txt-livesearch input" name="s"
                                value="" placeholder="Search here..." type="text">
                        </div>
                    </div>
                    <input name="post_type" value="product" type="hidden">
                    <input name="taxonomy" value="product_cat" type="hidden">
                    <div class="category">
                        <select title="product_cat" name="product_cat" id="1771262470" class="category-search-option"
                            tabindex="-1" style="display: none;">
                            <option value="0">All Categories</option>
                            <option class="level-0" value="light">Camera</option>
                            <option class="level-0" value="chair">Accessories</option>
                            <option class="level-0" value="table">Game & Consoles</option>
                            <option class="level-0" value="bed">Life style</option>
                            <option class="level-0" value="new-arrivals">New arrivals</option>
                            <option class="level-0" value="lamp">Summer Sale</option>
                            <option class="level-0" value="specials">Specials</option>
                            <option class="level-0" value="sofas">Featured</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-submit">
                        <span class="flaticon-search"></span>
                    </button>
                </form><!-- block search -->
            </div>
        </div>
    </div>
    <div class="header-control">
        <div class="header-control-inner">
            <div class="meta-dreaming">
                <div class="menu-item block-user block-dreaming kobolg-dropdown">
                    <a class="block-link" href="my-account.html">
                        <span class="flaticon-profile"></span>
                    </a>
                    <ul class="sub-menu">
                        @if (Auth::check())
                            <li class="menu-item kobolg-MyAccount-navigation-link kobolg-MyAccount-navigation-link--dashboard is-active">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="menu-item kobolg-MyAccount-navigation-link kobolg-MyAccount-navigation-link--orders">
                                <a href="#">Orders</a>
                            </li>
                            <li class="menu-item kobolg-MyAccount-navigation-link kobolg-MyAccount-navigation-link--downloads">
                                <a href="#">Downloads</a>
                            </li>
                            <li class="menu-item kobolg-MyAccount-navigation-link kobolg-MyAccount-navigation-link--edit-addresses">
                                <a href="#">Addresses</a>
                            </li>
                            <li class="menu-item kobolg-MyAccount-navigation-link kobolg-MyAccount-navigation-link--edit-account">
                                <a href="#">Account details</a>
                            </li>
                            <li class="menu-item kobolg-MyAccount-navigation-link kobolg-MyAccount-navigation-link--customer-logout">
                                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer;">Logout</button>
                                </form>
                            </li>
                        @else
                            <li class="menu-item kobolg-MyAccount-navigation-link kobolg-MyAccount-navigation-link--login">
                                <a href="{{ route('login') }}">Đăng Nhập</a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="block-minicart block-dreaming kobolg-mini-cart kobolg-dropdown">
                    <div class="shopcart-dropdown block-cart-link" data-kobolg="kobolg-dropdown">
                        <a class="block-link link-dropdown" href="cart.html">
                            <span class="flaticon-online-shopping-cart"></span>
                            <span class="count">3</span>
                        </a>
                    </div>
                    <div class="widget kobolg widget_shopping_cart">
                        <div class="widget_shopping_cart_content">
                            <h3 class="minicart-title">Your Cart<span class="minicart-number-items">3</span>
                            </h3>
                            <ul class="kobolg-mini-cart cart_list product_list_widget">
                                <li class="kobolg-mini-cart-item mini_cart_item">
                                    <a href="#" class="remove remove_from_cart_button">×</a>
                                    <a href="#">
                                        <img src="{{ asset('theme/client/assets/images/apro134-1-600x778.jpg') }}"
                                            class="attachment-kobolg_thumbnail size-kobolg_thumbnail" alt="img"
                                            width="600" height="778">T-shirt with skirt –
                                        Pink&nbsp;
                                    </a>
                                    <span class="quantity">1 × <span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>150.00</span></span>
                                </li>
                                <li class="kobolg-mini-cart-item mini_cart_item">
                                    <a href="#" class="remove remove_from_cart_button">×</a>
                                    <a href="#">
                                        <img src="{{ asset('theme/client/assets/images/apro1113-600x778.jpg') }}"
                                            class="attachment-kobolg_thumbnail size-kobolg_thumbnail" alt="img"
                                            width="600" height="778">Red Consoles&nbsp;
                                    </a>
                                    <span class="quantity">1 × <span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>129.00</span></span>
                                </li>
                                <li class="kobolg-mini-cart-item mini_cart_item">
                                    <a href="#" class="remove remove_from_cart_button">×</a>
                                    <a href="#">
                                        <img src="{{ asset('theme/client/assets/images/apro201-1-600x778.jpg') }}"
                                            class="attachment-kobolg_thumbnail size-kobolg_thumbnail" alt="img"
                                            width="600" height="778">Smart Monitor&nbsp;
                                    </a>
                                    <span class="quantity">1 × <span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>139.00</span></span>
                                </li>
                            </ul>
                            <p class="kobolg-mini-cart__total total"><strong>Subtotal:</strong>
                                <span class="kobolg-Price-amount amount"><span
                                        class="kobolg-Price-currencySymbol">$</span>418.00</span>
                            </p>
                            <p class="kobolg-mini-cart__buttons buttons">
                                <a href="cart.html" class="button kobolg-forward">Viewcart</a>
                                <a href="checkout.html" class="button checkout kobolg-forward">Checkout</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

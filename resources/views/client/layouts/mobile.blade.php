<div class="header-mobile-left">
    <div class="block-menu-bar">
        <a class="menu-bar menu-toggle" href="#">
            <span></span>
            <span></span>
            <span></span>
        </a>
    </div>
    <div class="header-search kobolg-dropdown">
        <div class="header-search-inner" data-kobolg="kobolg-dropdown">
            <a href="#" class="link-dropdown block-link">
                <span class="flaticon-search"></span>
            </a>
        </div>
        <div class="block-search">
            <form role="search" method="get" class="form-search block-search-form kobolg-live-search-form">
                <div class="form-content search-box results-search">
                    <div class="inner">
                        <input autocomplete="off" class="searchfield txt-livesearch input" name="s" value=""
                            placeholder="Search here..." type="text">
                    </div>
                </div>
                <input name="post_type" value="product" type="hidden">
                <input name="taxonomy" value="product_cat" type="hidden">
                <div class="category">
                    <select title="product_cat" name="product_cat" id="1770352541" class="category-search-option"
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
    <ul class="wpml-menu">
        <li class="menu-item kobolg-dropdown block-language">
            <a href="#" data-kobolg="kobolg-dropdown">
                <img src="{{ asset('theme/client/assets/images/en.png') }}" alt="en" width="18" height="12">
                English
            </a>
            <span class="toggle-submenu"></span>
            <ul class="sub-menu">
                <li class="menu-item">
                    <a href="#">
                        <img src="assets/images/it.png" alt="it" width="18" height="12">
                        Italiano
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <div class="wcml-dropdown product wcml_currency_switcher">
                <ul>
                    <li class="wcml-cs-active-currency">
                        <a class="wcml-cs-item-toggle">USD</a>
                        <ul class="wcml-cs-submenu">
                            <li>
                                <a>EUR</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>
<div class="header-mobile-mid">
    <div class="header-logo">
        <a href="index-2.html"><img alt="Kobolg" src="{{ asset('theme/client/assets/images/logozaia.png') }}" class="logo"></a>
    </div>
</div>
<div class="header-mobile-right">
    <div class="header-control-inner">
        <div class="meta-dreaming">

            {{-- login --}}
            @include('auth.login-client')

            {{-- you-card --}}
            @include('client.you-cart.you-cart')
        </div>
    </div>
</div>

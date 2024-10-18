<div class="header-position">
    <div class="header-nav">
        <div class="container">
            <div class="kobolg-menu-wapper"></div>
            <div class="header-nav-inner">
                <div data-items="8" class="vertical-wrapper block-nav-category has-vertical-menu show-button-all">
                    <div class="block-title">
                        <span class="before">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                        <span class="text-title">DANH MỤC SẢN PHẨM</span>
                    </div>
                    <div class="block-content verticalmenu-content">
                        <ul id="menu-vertical-menu" class="azeroth-nav vertical-menu default">
                            @foreach ($menuCatalogues as $catalogue)
                                @if ($catalogue->status == 'active')
                                    <li id="menu-item-886"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-886">
                                        <a class="azeroth-menu-item-title" title="menu"
                                            href="{{ route('client.productByCatalogues', $catalogue->slug) }}"><span
                                                class="icon flaticon-technology"></span>{{ $catalogue->name }}</a>
                                    </li>
                                @endif
                            @endforeach

                        </ul>
                        <div class="view-all-category">
                            <a href="#" data-closetext="Close" data-alltext="All Categories"
                                class="btn-view-all open-cate">All Categories</a>
                        </div>
                    </div>
                </div>
                <!-- block category -->
                <div class="box-header-nav menu-nocenter">
                    <ul id="menu-primary-menu" class="clone-main-menu kobolg-clone-mobile-menu kobolg-nav main-menu">
                        <li id="menu-item-230"
                            class="menu-item menu-item-type-post_type menu-item-object-megamenu menu-item-230 parent parent-megamenu item-megamenu menu-item-has-children">
                            <a class="kobolg-menu-item-title" title="Home" href="{{ route('client.index') }}">Trang Chủ</a>
                            <span class="toggle-submenu"></span>
                        </li>

                        <li id="menu-item-228"
                            class="menu-item menu-item-type-post_type menu-item-object-megamenu menu-item-228 parent parent-megamenu item-megamenu menu-item-has-children">
                            <a class="kobolg-menu-item-title" title="Shop"
                                href="{{ route('client.products.index') }}">Cửa Hàng</a>
                            <span class="toggle-submenu"></span>
                            <div class="submenu megamenu megamenu-shop">
                                <div class="row">
                                    @foreach ($menuCatalogues as $catalogues)
                                        @if ($catalogues->status === 'active')
                                            <!-- Kiểm tra trạng thái active -->
                                            <div class="col-md-4">
                                                <div class="kobolg-listitem style-01">
                                                    <div class="listitem-inner">
                                                        <h4 class="title"><a
                                                                href="{{ route('client.productByCatalogues', $catalogues->slug) }}">{{ $catalogues->name }}</a>
                                                        </h4>
                                                        <ul class="listitem-list mb-3">
                                                            @foreach ($catalogues->children as $child)
                                                                @if ($child->status === 'active')
                                                                    <!-- Kiểm tra trạng thái cho child -->
                                                                    <li>
                                                                        <a
                                                                            href="{{ route('client.productByCatalogues', [$catalogues->slug, $child->slug]) }}">{{ $child->name }}</a>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </li>


                        <li id="menu-item-996"
                            class="menu-item menu-item-type-post_type menu-item-object-megamenu menu-item-996 parent parent-megamenu item-megamenu menu-item-has-children">
                            <a class="kobolg-menu-item-title" title="Blog"
                                href="{{ route('client.posts.index') }}">Tin Tức</a>
                            <span class="toggle-submenu"></span>
                            <div class="submenu megamenu megamenu-blog">
                                <div class="row">
                                    @foreach ($menuCategories as $category)
                                        @if ($category->status === 'active')
                                            <div class="col-md-4">
                                                <div class="kobolg-listitem style-01">
                                                    <div class="listitem-inner">
                                                        <h4 class="title">{{ $category->name }}</h4>
                                                        <ul class="listitem-list mb-3">
                                                            @foreach ($category->children as $child)
                                                                @if ($child->status === 'active')
                                                                    <li>
                                                                        <a href="#">
                                                                            {{ $child->name }}
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </li>

                        {{-- <li id="menu-item-229"
                            class="menu-item menu-item-type-post_type menu-item-object-megamenu menu-item-229 parent parent-megamenu item-megamenu menu-item-has-children">

                            <a class="kobolg-menu-item-title" title="Elements" href="#">Liên hệ</a>
                            <span class="toggle-submenu"></span>
                            <div class="submenu megamenu megamenu-elements">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="kobolg-listitem style-01">
                                            <div class="listitem-inner">
                                                <h4 class="title">Element 1 </h4>
                                                <ul class="listitem-list">
                                                    <li>
                                                        <a href="banner.html" target="_self">
                                                            Banner
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="blog-element.html" target="_self">
                                                            Blog Element
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="categories-element.html" target="_self">
                                                            Categories Element
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="product-element.html" target="_self">
                                                            Product Element
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="kobolg-listitem style-01">
                                            <div class="listitem-inner">
                                                <h4 class="title">
                                                    Element 2 </h4>
                                                <ul class="listitem-list">
                                                    <li>
                                                        <a href="client.html" target="_self">
                                                            Client </a>
                                                    </li>
                                                    <li>
                                                        <a href="product-layout.html" target="_self">
                                                            Product Layout </a>
                                                    </li>
                                                    <li>
                                                        <a href="google-map.html" target="_self">
                                                            Google map </a>
                                                    </li>
                                                    <li>
                                                        <a href="iconbox.html" target="_self">
                                                            Icon Box </a>
                                                    </li>
                                                    <li>
                                                        <a href="team.html" target="_self">
                                                            Team </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="kobolg-listitem style-01">
                                            <div class="listitem-inner">
                                                <h4 class="title">
                                                    Element 3 </h4>
                                                <ul class="listitem-list">
                                                    <li>
                                                        <a href="instagram-feed.html" target="_self">
                                                            Instagram Feed </a>
                                                    </li>
                                                    <li>
                                                        <a href="newsletter.html" target="_self">
                                                            Newsletter </a>
                                                    </li>
                                                    <li>
                                                        <a href="testimonials.html" target="_self">
                                                            Testimonials </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li> --}}

                        <li id="menu-item-237"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-237 parent">
                            <a class="kobolg-menu-item-title" title="Pages" href="#">Hỏi & Đáp</a>
                            <span class="toggle-submenu"></span>
                            <ul role="menu" class="submenu">
                                <li id="menu-item-987"
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-987">
                                    <a class="kobolg-menu-item-title" title="About" href="about.html">About</a>
                                </li>
                                <li id="menu-item-988"
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-988">
                                    <a class="kobolg-menu-item-title" title="Contact"
                                        href="{{ route('client.contact.index') }}">Contact</a>
                                </li>
                                <li id="menu-item-990"
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-990">
                                    <a class="kobolg-menu-item-title" title="Page 404" href="404.html">Page
                                        404</a>
                                </li>
                            </ul>
                        </li>
                        <li id="menu-item-238"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-238">
                            <a class="kobolg-menu-item-title" title="Free Shipping on Orders $100"
                                href="#">Freeship với đơn từ 1.000.000đ
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

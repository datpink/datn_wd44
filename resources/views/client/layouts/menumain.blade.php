
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
                        <span class="text-title">SHOP BY CATEGORIES</span>
                    </div>
                    <div class="block-content verticalmenu-content">
                        <ul id="menu-vertical-menu" class="azeroth-nav vertical-menu default">
                            <li id="menu-item-886" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-886">
                                <a class="azeroth-menu-item-title" title="Camera" href="#"><span class="icon flaticon-technology"></span>Camera</a>
                            </li>
                            <li id="menu-item-895" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-895">
                                <a class="azeroth-menu-item-title" title="Game & Consoles" href="#"><span class="icon flaticon-console"></span>Game & Consoles</a>
                            </li>
                            <li id="menu-item-888" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-888">
                                <a class="azeroth-menu-item-title" title="Printers & Ink" href="#"><span class="icon flaticon-print-button"></span>Printers & Ink</a>
                            </li>
                            <li id="menu-item-889" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-889">
                                <a class="azeroth-menu-item-title" title="Speaker" href="#"><span class="icon flaticon-technology-1"></span>Speaker</a>
                            </li>
                            <li id="menu-item-890" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-890">
                                <a class="azeroth-menu-item-title" title="Smartphone" href="#"><span class="icon flaticon-smartphone"></span>Smartphone</a>
                            </li>
                            <li id="menu-item-891" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-891">
                                <a class="azeroth-menu-item-title" title="Accessories" href="#"><span class="icon flaticon-mouse"></span>Accessories</a>
                            </li>
                            <li id="menu-item-892" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-892">
                                <a class="azeroth-menu-item-title" title="Essentials" href="#"><span class="icon flaticon-layers"></span>Essentials</a>
                            </li>
                            <li id="menu-item-893" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-893">
                                <a class="azeroth-menu-item-title" title="Featured" href="#"><span class="icon flaticon-shapes"></span>Featured</a>
                            </li>
                            <li id="menu-item-894" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-894 link-other">
                                <a class="azeroth-menu-item-title" title="Best Seller" href="#"><span class="icon flaticon-shiny-diamond"></span> Seller</a>
                            </li>
                        </ul>
                        <div class="view-all-category">
                            <a href="#" data-closetext="Close" data-alltext="All Categories" class="btn-view-all open-cate">All Categories</a>
                        </div>
                    </div>
                </div><!-- block category -->
                <div class="box-header-nav menu-nocenter">
                    <ul id="menu-primary-menu" class="clone-main-menu kobolg-clone-mobile-menu kobolg-nav main-menu">
                        <li id="menu-item-230"
                            class="menu-item menu-item-type-post_type menu-item-object-megamenu menu-item-230 parent parent-megamenu item-megamenu menu-item-has-children">
                            <a class="kobolg-menu-item-title" title="Home" href="{{ route('client.index')}}">Home</a>
                            <span class="toggle-submenu"></span>
                        </li>
                        <li id="menu-item-228"
                            class="menu-item menu-item-type-post_type menu-item-object-megamenu menu-item-228 parent parent-megamenu item-megamenu menu-item-has-children">
                            <a class="kobolg-menu-item-title" title="Shop" href="{{ route('client.products.index') }}">Product</a>

                        <li id="menu-item-238" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-238">
                            <a class="kobolg-menu-item-title" title="Home" href="{{ route('client.index') }}">Home</a>
                        </li>

                        <li id="menu-item-228" class="menu-item menu-item-type-post_type menu-item-object-megamenu menu-item-228 parent parent-megamenu item-megamenu menu-item-has-children">
                            <a class="kobolg-menu-item-title" title="Shop" href="{{ route('client.products.index') }}">Shop</a>
                            <span class="toggle-submenu"></span>
                            <div class="submenu megamenu megamenu-shop">
                                <div class="row">
                                    @foreach ($menuCategories as $category)
                                        @if ($category->status === 'active')
                                            <!-- Kiểm tra trạng thái active -->
                                            <div class="col-md-4">
                                                <div class="kobolg-listitem style-01">
                                                    <div class="listitem-inner">
                                                        <h4 class="title">{{ $category->name }}</h4>
                                                        <ul class="listitem-list mb-3">
                                                            @foreach ($category->children as $child)
                                                                @if ($child->status === 'active')
                                                                    <!-- Kiểm tra trạng thái cho child -->
                                                                    <li>
                                                                        <a
                                                                            href="{{ route('client.products.index', ['category' => $child->id]) }}">{{ $child->name }}</a>
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
                        <li id="menu-item-229"
                            class="menu-item menu-item-type-post_type menu-item-object-megamenu menu-item-229 parent parent-megamenu item-megamenu menu-item-has-children">
                        <li id="menu-item-229" class="menu-item menu-item-type-post_type menu-item-object-megamenu menu-item-229 parent parent-megamenu item-megamenu menu-item-has-children">

                            <a class="kobolg-menu-item-title" title="Elements" href="#">Elements</a>
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
                        </li>


                        <li id="menu-item-996"
                            class="menu-item menu-item-type-post_type menu-item-object-megamenu menu-item-996 parent parent-megamenu item-megamenu menu-item-has-children">
                            <a class="kobolg-menu-item-title" title="Blog"
                                href="{{ route('client.posts.index') }}">Blog</a>
                            <span class="toggle-submenu"></span>
                            <div class="submenu megamenu megamenu-blog">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="kobolg-listitem style-01">
                                            <div class="listitem-inner">
                                                <h4 class="title">
                                                    Blog Layout </h4>
                                                <ul class="listitem-list">
                                                    <li>
                                                        <a href="blog.html" target="_self">No Sidebar </a>
                                                    </li>
                                                    <li>
                                                        <a href="blog-leftsidebar.html" target="_self">Left
                                                            Sidebar </a>
                                                    </li>
                                                    <li>
                                                        <a href="blog-rightsidebar.html" target="_self">Right
                                                            Sidebar </a>
                                                    </li>
                                                    <li>
                                                        <a href="blog.html" target="_self">Blog Standard
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="blog-grid.html" target="_self">Blog Grid
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
                                                    Post Layout </h4>
                                                <ul class="listitem-list">
                                                    <li>
                                                        <a href="single-post.html" target="_self">No
                                                            Sidebar </a>
                                                    </li>
                                                    <li>
                                                        <a href="single-post-leftsidebar.html" target="_self">Left
                                                            Sidebar </a>
                                                    </li>
                                                    <li>
                                                        <a href="single-post-rightsidebar.html" target="_self">Right
                                                            Sidebar </a>
                                                    </li>
                                                    <li>
                                                        <a href="single-post-instagram.html" target="_self">
                                                            <span class="image">
                                                                <img src="{{ asset('theme/client/assets/images/label-hot.jpg') }}"
                                                                    class="attachment-full size-full" alt="img">
                                                            </span>
                                                            Instagram In Post
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="single-post-product.html" target="_self">
                                                            <span class="image">
                                                                <img src="{{ asset('theme/client/assets/images/label-new.jpg') }}"
                                                                    class="attachment-full size-full" alt="img">
                                                            </span>
                                                            Product In Post
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="kobolg-listitem style-01">
                                            <div class="listitem-inner">
                                                <h4 class="title">
                                                    Post Format </h4>
                                                <ul class="listitem-list">
                                                    <li>
                                                        <a href="single-post.html" target="_self">Standard
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="single-post-gallery.html" target="_self">Gallery </a>
                                                    </li>
                                                    <li>
                                                        <a href="single-post-video.html" target="_self">
                                                            <span class="image">
                                                                <img src="{{ asset('theme/client/assets/images/label-hot.jpg') }}"
                                                                    class="attachment-full size-full" alt="img">
                                                            </span>
                                                            Video
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>


                        <li id="menu-item-237"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-237 parent">
                            <a class="kobolg-menu-item-title" title="Pages" href="#">Pages</a>
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
                                href="#">Free
                                Shipping on Orders $100</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@extends('client.master')

@section('title', 'Zaia Enterprise | Điện thoại, Laptop, Phụ kiện chính hãng giá tốt nhất')

@section('content')
    <style>
        .img{
            width: 200px;
            height: auto;
            margin: 0 auto;
            min-height: 230px;
        }
    </style>

    <div class="fullwidth-template">
        <div class="slide-home-01">
            <div class="container">

                <!-- banner -->
                @include('client.layouts.banner')

            </div>
        </div>
        {{-- content --}}
        <div class="section-003 section-002">

            <!-- GGI 1 -->
            <div class="container">

                <div class="row">
                    @php
                        $validAdvertisements = $advertisements->filter(function ($advertisement) {
                            return $advertisement->image &&
                                $advertisement->title &&
                                $advertisement->description &&
                                $advertisement->button_link &&
                                $advertisement->button_text &&
                                ($advertisement->position == 1 || $advertisement->position == 2);
                        });
                    @endphp

                    @if ($validAdvertisements->count() == 2)
                        <!-- Kiểm tra xem có đúng 2 quảng cáo hợp lệ -->
                        @foreach ($validAdvertisements as $advertisement)
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="kobolg-banner style-01">
                                    <div class="banner-inner">
                                        <figure class="banner-thumb">
                                            <img src="{{ asset('storage/' . $advertisement->image) }}"
                                                class="attachment-full size-full" alt="{{ $advertisement->title }}">
                                        </figure>
                                        <div class="banner-info">
                                            <div class="banner-content">
                                                <div class="title-wrap">
                                                    <div class="banner-label">
                                                        {{ $advertisement->title }}
                                                    </div>
                                                    <h6 class="title">
                                                        {!! $advertisement->description !!}
                                                    </h6>
                                                </div>
                                                <div class="button-wrap">
                                                    <a class="button" target="_self"
                                                        href="{{ $advertisement->button_link }}">
                                                        <span>{{ $advertisement->button_text }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center">Không có quảng cáo nào cho vị trí 1 và 2.</p>
                        <!-- Thông báo nếu không có quảng cáo -->
                    @endif
                </div>

            </div>

        </div>
        <div class="section-001">

            <!-- danh mục 1 -->
            <div class="container">
                <div class="kobolg-heading style-01">
                    <div class="heading-inner">
                        <h3 class="title">Nổi Bật</h3>
                        <div class="subtitle">Danh sách những sản phẩm được khách hàng quan tâm và mua nhiều </div>
                    </div>
                </div>

                <div class="kobolg-products style-02">
                    <div class="response-product product-list-owl owl-slick equal-container better-height"
                        data-slick='{"arrows":false,"slidesMargin":30,"dots":true,"infinite":false,"speed":300,"slidesToShow":4,"rows":2}'
                        data-responsive='[
                            {"breakpoint":480,"settings":{"slidesToShow":2,"slidesMargin":"10"}},
                            {"breakpoint":768,"settings":{"slidesToShow":2,"slidesMargin":"10"}},
                            {"breakpoint":992,"settings":{"slidesToShow":3,"slidesMargin":"20"}},
                            {"breakpoint":1200,"settings":{"slidesToShow":3,"slidesMargin":"20"}},
                            {"breakpoint":1500,"settings":{"slidesToShow":4,"slidesMargin":"30"}}
                        ]'>

                        @foreach ($featuredProducts as $product)
                            <div class="product-item featured_products style-02 rows-space-30 post-{{ $product->id }}">
                                <div class="product-inner tooltip-top">
                                    <div class="product-thumb">
                                        <div class="img"  style="width: 200px; height: auto;" >
                                            <a class="thumb-link"
                                            href="{{ route('client.products.product-detail', $product->slug) }}"
                                            tabindex="0">
                                            @if ($product->image_url && \Storage::exists($product->image_url))
                                                <img src="{{ \Storage::url($product->image_url) }}"
                                                    alt="{{ $product->name }}">
                                            @else
                                            
                                            @endif
                                        </a>
                                        </div>
                                        <div class="flash">
                                            @if ($product->condition === 'new')
                                                <span class="onsale"><span class="number">-18%</span></span>
                                                <span class="onnew"><span class="text">New</span></span>
                                            @endif
                                        </div>
                                        <a href="{{ route('client.products.product-detail', $product->slug) }}"
                                            class="button yith-wcqv-button">Quick View</a>
                                    </div>
                                    <div class="product-info">
                                        <div class="rating-wapper nostar">
                                            <div class="star-rating"><span style="width:0%">Rated <strong
                                                        class="rating">0</strong> out of 5</span></div>
                                            <span class="review">(0)</span>
                                        </div>
                                        <h3 class="product-name product_title">
                                            <a href="{{ route('client.products.product-detail', $product->slug) }}"
                                                tabindex="0">{{ $product->name }}</a>
                                        </h3>
                                        <span class="price">
                                            <span class="kobolg-Price-amount amount text-danger">
                                                <del>
                                                    {{ number_format($product->price, $product->price == floor($product->price) ? 0 : 2) }}<span
                                                        class="kobolg-Price-currencySymbol">₫</span>
                                                </del>
                                            </span>
                                            @if ($product->discount_price)
                                                <span class="kobolg-Price-amount amount old-price">
                                                    {{ number_format($product->discount_price, $product->discount_price == floor($product->discount_price) ? 0 : 2) }}<span
                                                        class="kobolg-Price-currencySymbol">₫</span>
                                                </span>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="group-button clearfix">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button show">
                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                            </div>
                                        </div>
                                        <div class="add-to-cart">
                                            <a href="#" class="button product_type_grouped">View products</a>
                                        </div>
                                        <div class="kobolg product compare-button">
                                            <a href="#" class="compare button">Compare</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
        <div>
            <div class="kobolg-banner style-02 left-center">

                <!-- GGI 2 -->
                @php
                    $validAdvertisements = $advertisements->filter(function ($advertisement) {
                        return $advertisement->image &&
                            $advertisement->title &&
                            $advertisement->description &&
                            $advertisement->button_link &&
                            $advertisement->button_text &&
                            $advertisement->position == 3;
                    });
                @endphp

                <div class="banner-inner">
                    @if ($validAdvertisements->count() == 1)
                        <!-- Kiểm tra xem có đúng 1 quảng cáo hợp lệ -->
                        @foreach ($validAdvertisements as $advertisement)
                            <figure class="banner-thumb">
                                <img src="{{ asset('storage/' . $advertisement->image) }}"
                                    class="attachment-full size-full" alt="{{ $advertisement->title }}">
                            </figure>
                            <div class="banner-info container">
                                <div class="banner-content">
                                    <div class="title-wrap">
                                        <h6 class="title">
                                            {{ $advertisement->title }}</h6>
                                    </div>
                                    <div class="button-wrap">
                                        <div class="subtitle">
                                            {!! $advertisement->description !!}
                                        </div>
                                        <a class="button" target="_self" href="{{ $advertisement->button_link }}">
                                            <span>{{ $advertisement->button_text }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center">Không có quảng cáo nào cho vị trí 3.</p>
                        <!-- Thông báo nếu không có quảng cáo -->
                    @endif
                </div>

            </div>
        </div>
        <div class="section-001">

            <!-- danh mục 2 -->
            <div class="container">
                <div class="kobolg-heading style-01">
                    <div class="heading-inner">
                        <h3 class="title">Sản phẩm mới</h3>
                        <div class="subtitle">
                            Các sản phẩm mới ra mắt và đang được mọi người săn đón.
                        </div>
                    </div>
                </div>
                <div class="kobolg-products style-01">
                    <div class="response-product product-list-owl owl-slick equal-container better-height"
                        data-slick="{&quot;arrows&quot;:true,&quot;slidesMargin&quot;:30,&quot;dots&quot;:true,&quot;infinite&quot;:false,&quot;speed&quot;:300,&quot;slidesToShow&quot;:4,&quot;rows&quot;:1}"
                        data-responsive="[{&quot;breakpoint&quot;:480,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:768,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:992,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1500,&quot;settings&quot;:{&quot;slidesToShow&quot;:4,&quot;slidesMargin&quot;:&quot;30&quot;}}]">
                        <div
                            class="product-item recent-product style-01 rows-space-0 post-93 product type-product status-publish has-post-thumbnail product_cat-light product_cat-table product_cat-new-arrivals product_tag-table product_tag-sock first instock shipping-taxable purchasable product-type-simple  ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="0">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro13-1-270x350.jpg') }}"
                                            alt="Meta Watches                                                "
                                            width="270" height="350">
                                    </a>
                                    <div class="flash">
                                        <span class="onnew"><span class="text">New</span></span>
                                    </div>
                                    <div class="group-button">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button show">
                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                            </div>
                                        </div>
                                        <div class="kobolg product compare-button">
                                            <a href="#" class="compare button">Compare</a>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button">Quick View</a>
                                        <div class="add-to-cart">
                                            <a href="#" class="button product_type_simple add_to_cart_button">Add to
                                                cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="0">Meta Watches </a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>109.00</span></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="product-item recent-product style-01 rows-space-0 post-49 product type-product status-publish has-post-thumbnail product_cat-light product_cat-bed product_cat-sofas product_tag-multi product_tag-lamp  instock shipping-taxable purchasable product-type-simple">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="0">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro302-270x350.jpg') }}"
                                            alt="Circle Watches" width="270" height="350">
                                    </a>
                                    <div class="flash">
                                        <span class="onnew"><span class="text">New</span></span>
                                    </div>
                                    <div class="group-button">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button show">
                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                            </div>
                                        </div>
                                        <div class="kobolg product compare-button">
                                            <a href="#" class="compare button">Compare</a>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button">Quick View</a>
                                        <div class="add-to-cart">
                                            <a href="#" class="button product_type_simple add_to_cart_button">Add to
                                                cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="0">Circle Watches</a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>79.00</span></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="product-item recent-product style-01 rows-space-0 post-37 product type-product status-publish has-post-thumbnail product_cat-chair product_cat-bed product_tag-light product_tag-hat product_tag-sock last instock shipping-taxable purchasable product-type-simple">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="0">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro31-1-270x350.jpg') }}"
                                            alt="Blue Smartphone" width="270" height="350">
                                    </a>
                                    <div class="flash">
                                        <span class="onnew"><span class="text">New</span></span>
                                    </div>
                                    <div class="group-button">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button show">
                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                            </div>
                                        </div>
                                        <div class="kobolg product compare-button">
                                            <a href="#" class="compare button">Compare</a>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button">Quick View</a>
                                        <div class="add-to-cart">
                                            <a href="#" class="button product_type_simple add_to_cart_button">Add to
                                                cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="0">Blue Smartphone</a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>120.00</span></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="product-item recent-product style-01 rows-space-0 post-35 product type-product status-publish has-post-thumbnail product_cat-chair product_cat-new-arrivals product_cat-lamp product_tag-light product_tag-hat product_tag-sock first instock shipping-taxable purchasable product-type-simple">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="0">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro41-1-270x350.jpg') }}"
                                            alt="White Watches" width="270" height="350">
                                    </a>
                                    <div class="flash">
                                        <span class="onnew"><span class="text">New</span></span>
                                    </div>
                                    <div class="group-button">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button show">
                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                            </div>
                                        </div>
                                        <div class="kobolg product compare-button">
                                            <a href="#" class="compare button">Compare</a>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button">Quick View</a>
                                        <div class="add-to-cart">
                                            <a href="#" class="button product_type_simple add_to_cart_button">Add to
                                                cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="0">White Watches</a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>134.00</span></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="product-item recent-product style-01 rows-space-0 post-36 product type-product status-publish has-post-thumbnail product_cat-table product_cat-bed product_tag-light product_tag-table product_tag-sock  instock sale shipping-taxable purchasable product-type-simple">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="-1">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro51012-1-270x350.jpg') }}"
                                            alt="Multi Cellphone" width="270" height="350">
                                    </a>
                                    <div class="flash">
                                        <span class="onsale"><span class="number">-21%</span></span>
                                        <span class="onnew"><span class="text">New</span></span>
                                    </div>
                                    <div class="group-button">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button show">
                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                            </div>
                                        </div>
                                        <div class="kobolg product compare-button">
                                            <a href="#" class="compare button">Compare</a>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button">Quick View</a>
                                        <div class="add-to-cart">
                                            <a href="#" class="button product_type_simple add_to_cart_button">Add to
                                                cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="-1">Multi Cellphone</a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><del><span class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>125.00</span></del>
                                        <ins><span class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>99.00</span></ins></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="product-item recent-product style-01 rows-space-0 post-34 product type-product status-publish has-post-thumbnail product_cat-light product_cat-new-arrivals product_tag-light product_tag-hat product_tag-sock last instock sale featured shipping-taxable product-type-grouped">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="-1">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro61-1-270x350.jpg') }}"
                                            alt="Black Watches" width="270" height="350">
                                    </a>
                                    <div class="flash">
                                        <span class="onnew"><span class="text">New</span></span>
                                    </div>
                                    <div class="group-button">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button show">
                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                            </div>
                                        </div>
                                        <div class="kobolg product compare-button">
                                            <a href="#" class="compare button">Compare</a>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button">Quick View</a>
                                        <div class="add-to-cart">
                                            <a href="#"
                                                class="button product_type_simple add_to_cart_button">Viewproducts</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="-1">Black Watches</a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>79.00</span> – <span
                                            class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>139.00</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="section-038">
            <div class="kobolg-banner style-07 left-center">

                <!-- GGI 3  -->
                @php
                    $validAdvertisements = $advertisements->filter(function ($advertisement) {
                        return $advertisement->image &&
                            $advertisement->title &&
                            $advertisement->description &&
                            $advertisement->button_link &&
                            $advertisement->button_text &&
                            $advertisement->position == 4;
                    });
                @endphp
                <div class="banner-inner">
                    @if ($validAdvertisements->count() == 1)
                        <!-- Kiểm tra xem có đúng 1 quảng cáo hợp lệ -->
                        @foreach ($validAdvertisements as $advertisement)
                            <figure class="banner-thumb">
                                <img src="{{ asset('storage/' . $advertisement->image) }}"
                                    class="attachment-full size-full" alt="img" {{ $advertisement->title }}>
                            </figure>
                            <div class="banner-info container">
                                <div class="banner-content">
                                    <div class="title-wrap">
                                        <h6 class="title">
                                            {{ $advertisement->title }} </h6>
                                    </div>
                                    <div class="button-wrap">
                                        <div class="subtitle">
                                            {!! $advertisement->description !!}
                                        </div>
                                        <a class="button" target="_self" href="{{ $advertisement->button_link }}">
                                            <span>{{ $advertisement->button_text }}</span></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center">Không có quảng cáo nào cho vị trí 4.</p>
                        <!-- Thông báo nếu không có quảng cáo -->
                    @endif
                </div>

            </div>
        </div>
        <div class="section-001">

            <!-- blog -->
            <div class="container">
                <div class="kobolg-heading style-01">
                    <div class="heading-inner">
                        <h3 class="title">Bài Viết Nổi Bật</h3>
                        <div class="subtitle">
                            Dẫn đầu xu hướng công nghệ - Trải nghiệm mua sắm máy tính và điện thoại chất lượng, giá tốt nhất
                            chỉ với một cú nhấp chuột
                        </div>
                    </div>
                </div>
                <div class="kobolg-blog style-01">
                    <div class="blog-list-owl owl-slick equal-container better-height"
                        data-slick='{"arrows":false,"slidesMargin":30,"dots":true,"infinite":false,"speed":300,"slidesToShow":3,"rows":1}'
                        data-responsive='[{"breakpoint":480,"settings":{"slidesToShow":1,"slidesMargin":"10"}},{"breakpoint":768,"settings":{"slidesToShow":2,"slidesMargin":"10"}},{"breakpoint":992,"settings":{"slidesToShow":2,"slidesMargin":"20"}},{"breakpoint":1200,"settings":{"slidesToShow":3,"slidesMargin":"20"}},{"breakpoint":1500,"settings":{"slidesToShow":3,"slidesMargin":"30"}}]'>

                        @foreach ($featuredPosts as $post)
                            <article class="post-item post-grid rows-space-0">
                                <div class="post-inner blog-grid">
                                    <div class="post-thumb">
                                        <a href="{{ route('post.show', $post->id) }}" tabindex="0">
                                            @if ($post->image && \Storage::exists($post->image))
                                                <img src="{{ \Storage::url($post->image) }}"class="img-responsive attachment-370x330 size-370x330"
                                                    alt="{{ $post->name }}" width="370px" height="330px">
                                            @else
                                                Không có ảnh
                                            @endif
                                        </a>
                                        <a class="datebox" href="{{ route('post.show', $post->id) }}" tabindex="0">
                                            <span>{{ $post->created_at->format('d') }}</span>
                                            <span>{{ $post->created_at->format('M') }}</span>
                                        </a>
                                    </div>
                                    <div class="post-content">
                                        <div class="post-meta">
                                            <div class="post-author">
                                                By: <a
                                                    href="{{ route('post.show', $post->id) }}">{{ $post->author_name ?? 'Unknown' }}</a>
                                            </div>
                                            <div class="post-comment-icon">
                                                <a href="#" tabindex="0">{{ $post->comments_count }}</a>
                                            </div>
                                        </div>
                                        <div class="post-info equal-elem">
                                            <h2 class="post-title">
                                                <a href="{{ route('post.show', $post->id) }}"
                                                    tabindex="0">{{ $post->title }}</a>
                                            </h2>
                                            <p>{{ $post->excerpt }}</p>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
        <div class="section-014">

            <!-- GGI 4 -->
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="kobolg-iconbox style-02">
                            <div class="iconbox-inner">
                                <div class="icon">
                                    <span class="flaticon-rocket-launch"></span>
                                </div>
                                <div class="content">
                                    <h4 class="title">Giao hàng toàn cầu</h4>
                                    <div class="desc">Với các trang web bằng 5 ngôn ngữ, chúng tôi gửi hàng đến hơn 200
                                        quốc gia &amp;
                                        các vùng.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="kobolg-iconbox style-02">
                            <div class="iconbox-inner">
                                <div class="icon">
                                    <span class="flaticon-truck"></span>
                                </div>
                                <div class="content">
                                    <h4 class="title">Vận chuyển an toàn</h4>
                                    <div class="desc">Thanh toán bằng các phương thức thanh toán an toàn và phổ biến nhất
                                        thế giới.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="kobolg-iconbox style-02">
                            <div class="iconbox-inner">
                                <div class="icon">
                                    <span class="flaticon-reload"></span>
                                </div>
                                <div class="content">
                                    <h4 class="title">Hoàn trả 365 ngày</h4>
                                    <div class="desc">Hỗ trợ suốt ngày đêm để có trải nghiệm mua sắm suôn sẻ.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="kobolg-iconbox style-02">
                            <div class="iconbox-inner">
                                <div class="icon">
                                    <span class="flaticon-telemarketer"></span>
                                </div>
                                <div class="content">
                                    <h4 class="title">Niềm tin mua sắm</h4>
                                    <div class="desc">Bảo vệ người mua của chúng tôi bao gồm việc mua hàng của bạn từ
                                        nhấp chuột đến giao hàng.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

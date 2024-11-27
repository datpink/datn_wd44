@extends('client.master')

@section('title', $product->name . ' - Zaia Enterprise')

@section('content')

    <style>
        /* Container chứa các lựa chọn biến thể */
        .variant-options-container {
            /* Border mặc định, không có scroll */
            border: none;
            padding: 10px;
            margin-top: 10px;
        }

        /* Chỉ cho phép cuộn và thêm border khi có đủ 10 biến thể */
        .variant-options-container.scrollable {
            max-height: 200px;
            /* Đặt chiều cao tối đa cho khung */
            overflow-y: auto;
            /* Cho phép cuộn dọc khi vượt quá chiều cao */
            border: 1px solid #ccc;
            /* Thêm border khi có cuộn */
        }

        /* Đảm bảo nút lựa chọn được căn chỉnh đẹp */
        .variant-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* Nếu bạn muốn có thanh cuộn mượt mà */
        .variant-options-container::-webkit-scrollbar {
            width: 8px;
        }

        .variant-options-container::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
        }

        .variant-options-container::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }


        .variant-btn {
            background-color: #fff;
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .variant-btn:hover {
            border-color: #007bff;
            background-color: #f1f1f1;
        }

        .variant-btn span {
            display: block;
            margin-top: 5px;
        }

        .variant-btn.active {
            border: 2px solid #007bff;
            /* Đổi màu viền của nút đã chọn */
            background-color: #f0f8ff;
            /* Thêm nền sáng cho nút đã chọn */
            color: #007bff;
            /* Đổi màu chữ của nút đã chọn */
        }

        .variant-btn {
            /* Các kiểu dáng mặc định của nút */
            padding: 10px;
            margin: 5px;
            border: 1px solid #ddd;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            color: #333;
            transition: all 0.3s ease;
        }

        .variant-btn img {
            margin-right: 5px;
        }
    </style>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> --}}

    @include('components.breadcrumb-client2')

    @include('client.muteki.css')

    <div class="single-thumb-vertical main-container shop-page no-sidebar">
        <div class="container">
            <div class="row">
                <div class="main-content col-md-12">
                    <div class="kobolg-notices-wrapper"></div>
                    <div id="product-27"
                        class="post-27 product type-product status-publish has-post-thumbnail product_cat-table product_cat-new-arrivals product_cat-lamp product_tag-table product_tag-sock first instock shipping-taxable purchasable product-type-variable has-default-attributes">
                        <div class="main-contain-summary">
                            <div class="contain-left has-gallery">
                                <div class="single-left">
                                    <div class="kobolg-product-gallery kobolg-product-gallery--with-images kobolg-product-gallery--columns-4 images">
                                        <a href="#" class="kobolg-product-gallery__trigger">
                                            <img draggable="false" class="emoji" alt="🔍" src="https://s.w.org/images/core/emoji/11/svg/1f50d.svg">
                                        </a>
                                        <div class="flex-viewport">
                                            <figure class="kobolg-product-gallery__wrapper">
                                                @if ($product->galleries->isNotEmpty())
                                                    @foreach ($product->galleries as $gallery)
                                                        <div class="kobolg-product-gallery__image">
                                                            <img src="{{ \Storage::url($gallery->image_url) }}" alt="{{ $product->name }}" id="main-image" style="max-width: 70%; margin: 0 auto; height: auto;">
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="kobolg-product-gallery__image">
                                                        <img src="{{ \Storage::url($product->image_url) }}" alt="{{ $product->name }}" id="main-image" style="max-width: 70%; margin: 0 auto; height: auto;">
                                                    </div>
                                                @endif
                                            </figure>
                                        </div>
                                        <ol class="flex-control-nav flex-control-thumbs">
                                            @if ($product->galleries->isNotEmpty())
                                                @foreach ($product->galleries as $gallery)
                                                    <li>
                                                        <img src="{{ \Storage::url($gallery->image_url) }}" alt="Thumbnail" style="width: 100px; height: auto;">
                                                    </li>
                                                @endforeach
                                            @else
                                                <li>
                                                    <img src="{{ \Storage::url($product->image_url) }}" alt="{{ $product->name }} Thumbnail" style="width: 100px; height: auto;">
                                                </li>
                                            @endif
                                        </ol>
                                    </div>
                                </div>
                                @php
                                if ($product->variants->isNotEmpty()) {
                                    $prices = $product->variants->pluck('price')->toArray();
                                    $minPrice = min($prices);
                                    $maxPrice = max($prices);
                                } else {
                                    $minPrice = $product->price;
                                    $maxPrice = $product->price;
                                }
                            @endphp

                                <div class="summary entry-summary">
                                    <h1 class="product_title entry-title">{{ $product->name }}</h1>
                                    <p class="price">
                                        <span class="kobolg-Price-currencySymbol">₫</span>
                                        <span id="product-price">
                                            @if ($product->variants->isNotEmpty())
                                                {{ number_format($minPrice, 0, ',', '.') }}₫ - {{ number_format($maxPrice, 0, ',', '.') }}₫
                                            @else
                                                {{ number_format($product->price, 0, ',', '.') }}₫
                                            @endif
                                        </span>
                                    </p>
                                    <br>

                                    <div class="product-variants">
                                        <div class="product-attributes">
                                            @php
                                                $variantGroups = [];
                                                foreach ($product->variants as $variant) {
                                                    $attributes = [];
                                                    foreach ($variant->attributeValues as $attributeValue) {
                                                        $attributes[$attributeValue->attribute->name] = $attributeValue->name;
                                                    }

                                                    $variantGroups[$attributes['Storage'] ?? 'Không có'][$attributes['Color'] ?? 'Không có'][] = $variant;
                                                }
                                            @endphp

                                            @if (count($variantGroups) > 0)
                                                <div class="attribute-group">
                                                    <h4>Chọn biến thể:</h4>
                                                    <div class="variant-options-container">
                                                        <div class="variant-options d-flex flex-wrap">
                                                            @foreach ($variantGroups as $storage => $colors)
                                                                @foreach ($colors as $color => $variants)
                                                                    <button class="variant-btn mx-2 mb-2"
                                                                            data-variant="{{ json_encode($variants[0]) }}"
                                                                            data-price="{{ number_format($variants[0]->price, 0, ',', '.') }}đ"
                                                                            data-img-url="{{ $variants[0]->image_url }}"
                                                                            data-dung-luong="{{ $storage }}"
                                                                            data-mau-sac="{{ $color }}">
                                                                        @if (!empty($variants[0]->image_url))
                                                                            <img src="{{ \Storage::url($variants[0]->image_url) }}" alt="Image" width="40px" height="40px" class="img-fluid">
                                                                        @else
                                                                            <img src="{{ \Storage::url($product->image_url) }}" alt="No Image" width="40px" height="40px" class="img-fluid">
                                                                        @endif
                                                                        <span>{{ $storage }}</span> - <span>{{ $color }}</span>
                                                                    </button>
                                                                @endforeach
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div id="error-message" style="color: red;"></div>

                                    <p class="stock in-stock">
                                        Thương hiệu: <span>{{ $product->brand ? $product->brand->name : 'Không có' }}</span>
                                    </p>

                                    <div class="kobolg-product-details__short-description">
                                        <p>{{ $product->tomtat }}</p>
                                    </div>

                                    <form class="variations_form cart" id="add-to-cart-form">
                                        <input type="hidden" name="variant_id" id="selected-variant-id">
                                        <div class="single_variation_wrap">
                                            <div class="kobolg-variation single_variation"></div>
                                            <div class="kobolg-variation-add-to-cart variations_button">
                                                <!-- Số lượng -->
                                                <div class="quantity">
                                                    <label class="qty-label" for="quantity">Số lượng:</label>
                                                    <div class="control">
                                                        <a class="btn-number qtyminus quantity-minus" href="#">-</a>
                                                        <input type="text" data-step="1" min="0" max="" name="quantity" value="1" title="Qty" class="input-qty input-text qty text" size="4" pattern="[0-9]*" inputmode="numeric" id="quantity">
                                                        <a class="btn-number qtyplus quantity-plus" href="#">+</a>
                                                    </div>
                                                </div>

                                                <!-- Nút Thêm vào giỏ hàng và Mua ngay -->
                                                <div class="action-buttons">
                                                    <button type="submit" id="add-to-cart" class="single_add_to_cart_button button alt">
                                                        Thêm vào giỏ hàng
                                                    </button>
                                                    <button type="submit" id="buy-now" class="single_add_to_cart_button button buy-now">
                                                        Mua ngay
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="yith-wcwl-add-to-wishlist">
                                        <div class="yith-wcwl-add-button show">
                                            <a href="#" rel="nofollow" data-product-id="27" data-product-type="variable" class="add_to_wishlist">
                                                Thêm vào danh sách yêu thích</a>
                                        </div>
                                    </div>

                                    <div class="clear"></div>
                                    <a href="#" class="compare button" data-product_id="27" rel="nofollow">So sánh</a>

                                    <div class="product_meta">
                                        <span class="sku_wrapper">SKU: <span class="sku">{{ $product->sku }}</span></span>
                                        <span class="posted_in">Danh mục:
                                            <a href="#" rel="tag">{{ $product->catalogue ? $product->catalogue->name : 'Không có' }}</a>
                                        </span>
                                    </div>

                                    <div class="kobolg-share-socials">
                                        <h5 class="social-heading">Chia sẻ:</h5>
                                        <a target="_blank" class="facebook" href="#"><i class="fa fa-facebook-f"></i></a>
                                        <a target="_blank" class="twitter" href="#"><i class="fa fa-twitter"></i></a>
                                        <a target="_blank" class="pinterest" href="#"> <i class="fa fa-pinterest"></i></a>
                                        <a target="_blank" class="googleplus" href="#"><i class="fa fa-google-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kobolg-tabs kobolg-tabs-wrapper">
                            <ul class="tabs dreaming-tabs" role="tablist">
                                <li class="description_tab active" id="tab-title-description" role="tab"
                                    aria-controls="tab-description">
                                    <a href="#tab-description">Mô tả</a>
                                </li>
                                <li class="additional_information_tab" id="tab-title-additional_information"
                                    role="tab" aria-controls="tab-additional_information">
                                    <a href="#tab-additional_information">Bình luận
                                        ({{ $product->comments->count() }})</a>
                                </li>
                                <li class="reviews_tab" id="tab-title-reviews" role="tab"
                                    aria-controls="tab-reviews">
                                    <a href="#tab-reviews">Đánh giá ({{ $product->reviews->count() }})</a>
                                </li>
                            </ul>

                            @include('client.muteki.description')

                            @include('client.muteki.comment')

                            @include('client.muteki.evaluate')

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
                                                    <a href="#"
                                                        class="button product_type_simple add_to_cart_button">Add to
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
                                                    <a href="#"
                                                        class="button product_type_simple add_to_cart_button">Add to
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
                                                    <a href="#"
                                                        class="button product_type_simple add_to_cart_button">Add to
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
                                                    <a href="#"
                                                        class="button product_type_simple add_to_cart_button">Add to
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
                                                    <a href="#"
                                                        class="button product_type_simple add_to_cart_button">Add to
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
            </div>

            @include('client.muteki.js')
        @endsection

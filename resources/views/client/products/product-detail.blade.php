@extends('client.master')
@section('title', $product->name . ' - Zaia Enterprise')

@section('content')

    @include('components.breadcrumb-client')

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
                                    <div
                                        class="kobolg-product-gallery kobolg-product-gallery--with-images kobolg-product-gallery--columns-4 images">
                                        <a href="#" class="kobolg-product-gallery__trigger">
                                            <img draggable="false" class="emoji" alt="🔍"
                                                src="https://s.w.org/images/core/emoji/11/svg/1f50d.svg"></a>
                                        <div class="flex-viewport">
                                            <figure class="kobolg-product-gallery__wrapper">
                                                <div class="kobolg-product-gallery__image">
                                                    @if ($product->image_url && \Storage::exists($product->image_url))
                                                        <img src="{{ \Storage::url($product->image_url) }}"
                                                            alt="{{ $product->name }}"
                                                            style="max-width: 70% ;margin:0 auto; height: 100% auto;">
                                                    @else
                                                        <p>Không có ảnh</p>
                                                    @endif

                                                </div>
                                                <div class="kobolg-product-gallery__image">
                                                    <img src="{{ asset('theme/client/assets/images/apro134-1.jpg') }}"
                                                        alt="img">
                                                </div>
                                                <div class="kobolg-product-gallery__image">
                                                    <img src="{{ asset('theme/client/assets/images/apro132-1.jpg') }}"
                                                        class="" alt="img">
                                                </div>
                                                <div class="kobolg-product-gallery__image">
                                                    <img src="{{ asset('theme/client/assets/images/apro133-1.jpg') }}"
                                                        class="" alt="img">
                                                </div>
                                            </figure>
                                        </div>
                                        <ol class="flex-control-nav flex-control-thumbs">
                                            <li><img src="{{ asset('theme/client/assets/images/apro131-2-100x100.jpg') }}"
                                                    alt="img">
                                            </li>
                                            <li><img src="{{ asset('theme/client/assets/images/apro134-1-100x100.jpg') }}"
                                                    alt="img">
                                            </li>
                                            <li><img src="{{ asset('theme/client/assets/images/apro132-1-100x100.jpg') }}"
                                                    alt="img">
                                            </li>
                                            <li><img src="{{ asset('theme/client/assets/images/apro133-1-100x100.jpg') }}"
                                                    alt="img">
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="summary entry-summary">
                                    <div class="flash">
                                        <span class="onnew"><span class="text">New</span></span>
                                    </div>
                                    <h1 class="product_title entry-title">{{ $product->name }}</h1>
                                    <p class="price">
                                        <span class="kobolg-Price-amount amount">
                                            <span class="kobolg-Price-currencySymbol"></span>
                                            <span id="product-price" class="kobolg-Price-amount amount">
                                                {{ number_format($product->price, 0, ',', '.') }}đ
                                            </span>
                                        </span>
                                    </p>
                                    <br>
                                    <div class="product-variants">
                                        @php
                                            // Khởi tạo các mảng để lưu trữ các biến thể theo thuộc tính
                                            $dungLuongVariants = [];
                                            $mauSacVariants = [];

                                            // Duyệt qua tất cả các biến thể và phân loại dựa trên tên của attribute
                                            foreach ($product->variants as $variant) {
                                                foreach ($variant->attributeValues as $attributeValue) {
                                                    if ($attributeValue->attribute->name === 'Storage') {
                                                        $dungLuongVariants[$attributeValue->name][] = $variant;
                                                    }

                                                    if ($attributeValue->attribute->name === 'Color') {
                                                        $mauSacVariants[$attributeValue->name][] = $variant;
                                                    }
                                                }
                                            }
                                        @endphp

                                        <div class="product-attributes">
                                            <!-- Dung lượng -->
                                            <div class="attribute-group">
                                                <h4>Dung lượng:</h4>
                                                @foreach ($dungLuongVariants as $dungLuong => $variants)
                                                    <button class="variant-btn" data-dung-luong="{{ $dungLuong }}">
                                                        {{ $dungLuong }}
                                                    </button>
                                                @endforeach
                                            </div>

                                            <!-- Màu sắc -->
                                            <div class="attribute-group">
                                                <h4>Màu sắc:</h4>
                                                @foreach ($mauSacVariants as $mauSac => $variants)
                                                    <button class="variant-btn" data-mau-sac="{{ $mauSac }}">
                                                        {{ $mauSac }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>

                                    <div id="error-message" style="color: red;"></div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const variantButtons = document.querySelectorAll('.variant-btn');
                                            const originalPrice = '{{ number_format($product->price, 0, ',', '.') }}đ';
                                            let selectedButton = null;

                                            // Xử lý sự kiện click trên từng nút biến thể
                                            variantButtons.forEach(button => {
                                                // Thiết lập màu nền ban đầu cho các button
                                                button.style.backgroundColor = '#f4cdd1';
                                                button.style.border = 'none';
                                                button.style.color = 'black';

                                                button.addEventListener('click', function() {
                                                    if (selectedButton === this) {
                                                        // Nếu click lại vào nút đã chọn, trở về trạng thái ban đầu
                                                        selectedButton.style.backgroundColor = '#f4cdd1';
                                                        selectedButton.style.border = 'none';
                                                        selectedButton.style.color = 'black';
                                                        selectedButton = null;

                                                        // Đặt lại giá gốc
                                                        $('#product-price').text(originalPrice);
                                                    } else {
                                                        // Nếu có nút khác đang được chọn, reset lại nút đó
                                                        if (selectedButton) {
                                                            selectedButton.style.backgroundColor = '#f4cdd1';
                                                            selectedButton.style.border = 'none';
                                                            selectedButton.style.color = 'black';
                                                        }

                                                        // Chọn nút hiện tại và thay đổi style
                                                        selectedButton = this;
                                                        selectedButton.style.backgroundColor = '#fff';
                                                        selectedButton.style.border = '2px solid #bc2f3e';
                                                        selectedButton.style.color = '#bc2f3e';

                                                        // Thay đổi giá theo biến thể
                                                        $('#product-price').text(this.dataset.price);
                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                    <p class="stock in-stock">
                                        Thương hiệu: <span>
                                            {{ $product->brand ? $product->brand->name : 'Không có' }}</span>
                                    </p>

                                    <div class="kobolg-product-details__short-description">
                                        <p>{{ $product->tomtat }}</p>

                                    </div>
                                    <form class="variations_form cart">
                                        <div class="single_variation_wrap">
                                            <div class="kobolg-variation single_variation"></div>
                                            <div class="kobolg-variation-add-to-cart variations_button">
                                                <div class="quantity">
                                                    <span class="qty-label">Quantiy:</span>
                                                    <div class="control">
                                                        <a class="btn-number qtyminus quantity-minus" href="#">-</a>
                                                        <input type="text" data-step="1" min="0" max=""
                                                            name="quantity[25]" value="0" title="Qty"
                                                            class="input-qty input-text qty text" size="4"
                                                            pattern="[0-9]*" inputmode="numeric">
                                                        <a class="btn-number qtyplus quantity-plus" href="#">+</a>
                                                    </div>
                                                </div>
                                                <button type="submit"
                                                    class="single_add_to_cart_button button alt kobolg-variation-selection-needed">
                                                    Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="yith-wcwl-add-to-wishlist">
                                        <div class="yith-wcwl-add-button show">
                                            <a href="#" rel="nofollow" data-product-id="27"
                                                data-product-type="variable" class="add_to_wishlist">
                                                Add to Wishlist</a>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <a href="#" class="compare button" data-product_id="27"
                                        rel="nofollow">Compare</a>
                                    <div class="product_meta">
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
                                        <span class="sku_wrapper">SKU: <span
                                                class="sku">{{ $product->sku }}</span></span>
                                        <span class="posted_in">Categories: <a href="#"
                                                rel="tag">{{ $product->catalogue ? $product->catalogue->name : 'Không có' }}</span>
                                        <span class="tagged_as">Tags: <a href="#" rel="tag">Game &
                                                Consoles</a>, <a href="#" rel="tag">Sock</a></span>
                                    </div>
                                    <div class="kobolg-share-socials">
                                        <h5 class="social-heading">Share: </h5>
                                        <a target="_blank" class="facebook" href="#">
                                            <i class="fa fa-facebook-f"></i>
                                        </a>
                                        <a target="_blank" class="twitter" href="#"><i class="fa fa-twitter"></i>
                                        </a>
                                        <a target="_blank" class="pinterest" href="#"> <i
                                                class="fa fa-pinterest"></i>
                                        </a>
                                        <a target="_blank" class="googleplus" href="#"><i
                                                class="fa fa-google-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kobolg-tabs kobolg-tabs-wrapper">
                            <ul class="tabs dreaming-tabs" role="tablist">
                                <li class="description_tab active" id="tab-title-description" role="tab"
                                    aria-controls="tab-description">
                                    <a href="#tab-description">Description</a>
                                </li>
                                <li class="additional_information_tab" id="tab-title-additional_information"
                                    role="tab" aria-controls="tab-additional_information">
                                    <a href="#tab-additional_information">Additional information</a>
                                </li>
                                <li class="reviews_tab" id="tab-title-reviews" role="tab"
                                    aria-controls="tab-reviews">
                                    <a href="#tab-reviews">Reviews (0)</a>
                                </li>
                            </ul>
                            <div class="kobolg-Tabs-panel kobolg-Tabs-panel--description panel entry-content kobolg-tab"
                                id="tab-description" role="tabpanel" aria-labelledby="tab-title-description">
                                <h2>Description</h2>
                                <div class="col-md-8 justify-content-center align-items-center text-center">
                                    {!! $product->description !!}
                                </div>
                                {{-- <div class="container-table">
                                    <div class="container-cell">
                                        <div class="az_single_image-wrapper az_box_border_grey">
                                            <img src="{{ asset('theme/client/assets/images/single-pro2.jpg') }}"
                                                class="az_single_image-img attachment-full" alt="img">
                                        </div>
                                    </div>
                                    <div class="container-cell">
                                        <h2 class="az_custom_heading">
                                            Potenti praesent molestie<br>
                                            at viverra</h2>
                                        <p>This generator uses a dictionary of Latin words to construct
                                            passages of Lorem Ipsum text that meet your desired length. The
                                            sentence and paragraph durations and punctuation dispersal are
                                            calculated using Gaussian distribution, based on statistical
                                            analysis of real world texts. This ensures that the generated
                                            Lorem Ipsum text is unique, free of repetition and also
                                            resembles readable text as much as possible.</p>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="kobolg-Tabs-panel kobolg-Tabs-panel--additional_information panel entry-content kobolg-tab"
                                id="tab-additional_information" role="tabpanel"
                                aria-labelledby="tab-title-additional_information">
                                <h2>Additional information</h2>
                                <table class="shop_attributes">
                                    <tbody>
                                        <tr>
                                            <th>Color</th>
                                            <td>
                                                <p>Blue, Pink, Red, Yellow</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="kobolg-Tabs-panel kobolg-Tabs-panel--reviews panel entry-content kobolg-tab"
                                id="tab-reviews" role="tabpanel" aria-labelledby="tab-title-reviews">
                                <div id="reviews" class="kobolg-Reviews">
                                    <div id="comments">
                                        <h2 class="kobolg-Reviews-title">Reviews</h2>
                                        <p class="kobolg-noreviews">There are no reviews yet.</p>
                                    </div>
                                    <div id="review_form_wrapper">
                                        <div id="review_form">
                                            <div id="respond" class="comment-respond">
                                                <span id="reply-title" class="comment-reply-title">Be the first to review
                                                    “T-shirt with skirt”</span>
                                                <form id="commentform" class="comment-form">
                                                    <p class="comment-notes"><span id="email-notes">Your email addresses
                                                            will not be published.</span>
                                                        Required fields are marked <span class="required">*</span></p>
                                                    <p class="comment-form-author">
                                                        <label for="author">Name&nbsp;<span
                                                                class="required">*</span></label>
                                                        <input id="author" name="author" value=""
                                                            size="30" required="" type="text">
                                                    </p>
                                                    <p class="comment-form-email"><label for="email">Email&nbsp;
                                                            <span class="required">*</span></label>
                                                        <input id="email" name="email" value=""
                                                            size="30" required="" type="email">
                                                    </p>
                                                    <div class="comment-form-rating"><label for="rating">Your
                                                            rating</label>
                                                        <p class="stars">
                                                            <span>
                                                                <a class="star-1" href="#">1</a>
                                                                <a class="star-2" href="#">2</a>
                                                                <a class="star-3" href="#">3</a>
                                                                <a class="star-4" href="#">4</a>
                                                                <a class="star-5" href="#">5</a>
                                                            </span>
                                                        </p>
                                                        <select title="product_cat" name="rating" id="rating"
                                                            required="" style="display: none;">
                                                            <option value="">Rate…</option>
                                                            <option value="5">Perfect</option>
                                                            <option value="4">Good</option>
                                                            <option value="3">Average</option>
                                                            <option value="2">Not that bad</option>
                                                            <option value="1">Very poor</option>
                                                        </select>
                                                    </div>
                                                    <p class="comment-form-comment"><label for="comment">Your
                                                            review&nbsp;<span class="required">*</span></label>
                                                        <textarea id="comment" name="comment" cols="45" rows="8" required=""></textarea>
                                                    </p><input name="wpml_language_code" value="en" type="hidden">
                                                    <p class="form-submit"><input name="submit" id="submit"
                                                            class="submit" value="Submit" type="submit"> <input
                                                            name="comment_post_ID" value="27" id="comment_post_ID"
                                                            type="hidden">
                                                        <input name="comment_parent" id="comment_parent" value="0"
                                                            type="hidden">
                                                    </p>
                                                </form>
                                            </div><!-- #respond -->
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 dreaming_related-product">
                    <div class="block-title">
                        <h2 class="product-grid-title">
                            <span>Related Products</span>
                        </h2>
                    </div>
                    <div class="owl-slick owl-products equal-container better-height"
                        data-slick="{&quot;arrows&quot;:false,&quot;slidesMargin&quot;:30,&quot;dots&quot;:true,&quot;infinite&quot;:false,&quot;slidesToShow&quot;:4}"
                        data-responsive="[{&quot;breakpoint&quot;:480,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:768,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:992,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1500,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;30&quot;}}]">
                        <div
                            class="product-item style-01 post-27 product type-product status-publish has-post-thumbnail product_cat-table product_cat-new-arrivals product_cat-lamp product_tag-table product_tag-sock  instock shipping-taxable purchasable product-type-variable has-default-attributes ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="0">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro101-1-600x778.jpg') }}"
                                            alt="Mac 27 Inch" width="600" height="778">
                                    </a>
                                    <div class="flash"><span class="onnew"><span class="text">New</span></span></div>
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
                                            <a href="#" class="button product_type_variable add_to_cart_button">Add
                                                to
                                                cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="0">Mac 27 Inch</a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>60.00</span></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="product-item style-01 post-30 product type-product status-publish has-post-thumbnail product_cat-light product_cat-bed product_cat-specials product_tag-light product_tag-table product_tag-sock last instock featured downloadable shipping-taxable purchasable product-type-simple  ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="0">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro41-1-600x778.jpg') }}"
                                            alt="White Watches" width="600" height="778">
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
                                            <a href="#" class="button product_type_variable add_to_cart_button">Add
                                                to
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
                            class="product-item style-01 post-35 product type-product status-publish has-post-thumbnail product_cat-chair product_cat-new-arrivals product_cat-lamp product_tag-light product_tag-hat product_tag-sock first instock shipping-taxable purchasable product-type-simple  ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="0">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro151-1-600x778.jpg') }}"
                                            alt="Cellphone Factory" width="600" height="778">
                                    </a>
                                    <div class="flash">
                                        <span class="onsale"><span class="number">-11%</span></span>
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
                                            <a href="#" class="button product_type_variable add_to_cart_button">Add
                                                to
                                                cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="0">Cellphone Factory</a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><del><span class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>89.00</span></del>
                                        <ins><span class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>79.00</span></ins></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="product-item style-01 post-25 product type-product status-publish has-post-thumbnail product_cat-light product_cat-chair product_cat-specials product_tag-light product_tag-sock  instock sale featured shipping-taxable purchasable product-type-simple ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="-1">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro13-1-600x778.jpg') }}"
                                            alt="Meta Watches                                                "
                                            width="600" height="778">
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
                                            <a href="#" class="button product_type_variable add_to_cart_button">Add
                                                to
                                                cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="-1">Meta Watches </a>
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
                            class="product-item style-01 post-93 product type-product status-publish has-post-thumbnail product_cat-light product_cat-table product_cat-new-arrivals product_tag-table product_tag-sock last instock shipping-taxable purchasable product-type-simple ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="-1">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro181-2-600x778.jpg') }}"
                                            alt="Red Mouse" width="600" height="778">
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
                                            <a href="#" class="button product_type_variable add_to_cart_button">Add
                                                to
                                                cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="-1">City
                                            life jumpers</a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>98.00</span></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="product-item style-01 post-22 product type-product status-publish has-post-thumbnail product_cat-table product_cat-bed product_cat-lamp product_tag-table product_tag-hat product_tag-sock first instock featured downloadable shipping-taxable purchasable product-type-simple ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="-1">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro171-1-600x778.jpg') }}"
                                            alt="Photo Camera" width="600" height="778">
                                    </a>
                                    <div class="flash">
                                        <span class="onnew"><span class="text">New</span></span>
                                    </div>
                                    <form class="variations_form cart">
                                        <table class="variations">
                                            <tbody>
                                                <tr>
                                                    <td class="value">
                                                        <select title="box_style" data-attributetype="box_style"
                                                            data-id="pa_color" class="attribute-select "
                                                            name="attribute_pa_color"
                                                            data-attribute_name="attribute_pa_color"
                                                            data-show_option_none="yes" tabindex="-1">
                                                            <option data-type="" data-pa_color="" value="">Choose
                                                                an
                                                                option
                                                            </option>
                                                            <option data-width="30" data-height="30" data-type="color"
                                                                data-pa_color="#ff63cb" value="pink"
                                                                class="attached enabled">Pink
                                                            </option>
                                                            <option data-width="30" data-height="30" data-type="color"
                                                                data-pa_color="#a825ea" value="purple"
                                                                class="attached enabled">Purple
                                                            </option>
                                                            <option data-width="30" data-height="30" data-type="color"
                                                                data-pa_color="#db2b00" value="red"
                                                                class="attached enabled">Red
                                                            </option>
                                                        </select>
                                                        <div class="data-val attribute-pa_color"
                                                            data-attributetype="box_style"><a class="change-value color"
                                                                href="#" style="background: #ff63cb;"
                                                                data-value="pink"></a><a class="change-value color"
                                                                href="#" style="background: #a825ea;"
                                                                data-value="purple"></a><a class="change-value color"
                                                                href="#" style="background: #db2b00;"
                                                                data-value="red"></a></div>
                                                        <a class="reset_variations" href="#" tabindex="-1"
                                                            style="visibility: hidden;">Clear</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
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
                                                class="button product_type_variable add_to_cart_button">Select
                                                options</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="-1">Photo Camera</a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>105.00</span> – <span
                                            class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>110.00</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 kobolg_dreaming_upsell-product">
                    <div class="block-title">
                        <h2 class="product-grid-title">
                            <span>Upsell Products</span>
                        </h2>
                    </div>
                    <div class="owl-slick owl-products equal-container better-height"
                        data-slick="{&quot;arrows&quot;:false,&quot;slidesMargin&quot;:30,&quot;dots&quot;:true,&quot;infinite&quot;:false,&quot;slidesToShow&quot;:4}"
                        data-responsive="[{&quot;breakpoint&quot;:480,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:768,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:992,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1500,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;30&quot;}}]">
                        <div
                            class="product-item style-01 post-27 product type-product status-publish has-post-thumbnail product_cat-table product_cat-new-arrivals product_cat-lamp product_tag-table product_tag-sock  instock shipping-taxable purchasable product-type-variable has-default-attributes ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="0">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro141-1-600x778.jpg') }}"
                                            alt="Smart Monitor" width="600" height="778">
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
                                            <a href="#" class="button product_type_external add_to_cart_button">Buy
                                                it on Amazon</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="0">Dining Accessories</a>
                                    </h3>
                                    <div class="rating-wapper ">
                                        <div class="star-rating"><span style="width:100%">Rated <strong
                                                    class="rating">5.00</strong> out of 5</span></div>
                                        <span class="review">(1)</span>
                                    </div>
                                    <span class="price"><span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>207.00</span></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="product-item style-01 post-26 product type-product status-publish has-post-thumbnail product_cat-light product_cat-chair product_cat-sofas product_tag-light product_tag-hat last instock featured shipping-taxable product-type-external  ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="0">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro31-1-600x778.jpg') }}"
                                            alt="Blue Smartphone" width="600" height="778">
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
                            class="product-item style-01 post-37 product type-product status-publish has-post-thumbnail product_cat-chair product_cat-bed product_tag-light product_tag-hat product_tag-sock first instock shipping-taxable purchasable product-type-simple  ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link kobolg-product-gallery__image" href="#" tabindex="0">
                                        <img class="img-responsive wp-post-image"
                                            src="{{ asset('theme/client/assets/images/apro83-1-600x778.jpg') }}"
                                            alt="Glasses – Red" width="600" height="778">
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
                                        <a href="#" tabindex="0">Glasses – Red</a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>56.00</span></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="product-item style-01 post-1194 product_variation type-product_variation status-publish has-post-thumbnail product  instock shipping-taxable purchasable product-type-variation ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="-1">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro302-600x778.jpg') }}"
                                            alt="Circle Watches" width="600" height="778">
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
                                        <a href="#" tabindex="-1">Circle Watches</a>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@extends('client.master')

@section('title', $product->name . ' - Zaia Enterprise')

@section('content')

    <style>
        /* Container chứa các lựa chọn biến thể */
        .variant-options-container {
            padding: 10px;
            margin-top: 10px;
            max-height: 200px;
            /* Giới hạn chiều cao */
            overflow-y: auto;
            /* Cuộn dọc khi cần */
            border: 1px solid transparent;
            /* Border mặc định */
            transition: border 0.3s ease;
        }

        /* Hiển thị border khi có đủ các biến thể */
        .variant-options-container.scrollable {
            border: 1px solid #ccc;
            /* Thêm border khi có cuộn */
        }

        /* Tùy chỉnh thanh cuộn */
        .variant-options-container::-webkit-scrollbar {
            width: 8px;
        }

        .variant-options-container::-webkit-scrollbar-thumb {
            background-color: #888;
            /* Màu thanh cuộn */
            border-radius: 10px;
            /* Bo góc thanh cuộn */
        }

        .variant-options-container::-webkit-scrollbar-thumb:hover {
            background-color: #555;
            /* Đổi màu khi hover thanh cuộn */
        }

        /* Kiểu dáng nút lựa chọn */
        .variant-btn {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            text-align: center;
            color: #333;
            margin: 5px;
            transition: all 0.3s ease;
        }

        /* Hover: Đổi màu viền và nền */
        .variant-btn:hover {
            border-color: #007bff;
            background-color: #f1f1f1;
        }

        /* Nút được chọn */
        .variant-btn.active {
            border-color: #dc3545;
            /* Màu đỏ khi được chọn */
            background-color: #ffe6e6;
            /* Nền nhạt màu đỏ */
            color: #dc3545;
            /* Đổi màu chữ */
        }

        /* Hình ảnh trong nút */
        .variant-btn img {
            margin-right: 5px;
            width: 40px;
            height: 40px;
            object-fit: cover;
        }

        /* Văn bản dưới hình ảnh */
        .variant-btn span {
            display: block;
            margin-top: 5px;
            font-size: 14px;
            font-weight: 500;
            text-align: center;
        }

        /* Ẩn tất cả ảnh gallery khi trang tải */
        .kobolg-product-gallery__image {
            display: none;
        }

        /* Chỉ hiển thị ảnh chính của sản phẩm khi trang tải */
        #main-image {
            display: block;
        }

        .kobolg-product-gallery__image {
            overflow: hidden;
            /* Ẩn phần ảnh phóng to ra ngoài */
            position: relative;
            /* Đảm bảo ảnh không bị tràn ra ngoài */
        }

        .kobolg-product-gallery__image img {
            transition: transform 0.3s ease;
            transform-origin: center center;
            /* Đảm bảo ảnh phóng to từ giữa */
        }

        .kobolg-product-gallery__image img:hover {
            transform: scale(1.5);
            /* Phóng to ảnh lên 1.5 lần */
            cursor: zoom-in;
            /* Hiển thị con trỏ zoom khi hover */
        }
    </style>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> --}}

    @include('components.breadcrumb-client2')

    @include('client.muteki.css')
    <script>
        var hasVariants = @json($product->variants->isNotEmpty()); // Kiểm tra sản phẩm có biến thể hay không

        // Thông tin về số lượng sản phẩm còn lại
        var stockQuantity = @json($product->stock); // Số lượng sản phẩm còn lại (không có biến thể)
        var variantStock = {}; // Đối tượng để lưu trữ số lượng tồn kho của các biến thể (nếu có)

        @foreach ($product->variants as $variant)
            variantStock['{{ $variant->id }}'] = {{ $variant->stock }};
        @endforeach

    </script>
    <div class="single-thumb-vertical main-container shop-page no-sidebar">
        <div class="container">
            <div class="row">
                <div class="main-content col-md-12">
                    <div class="kobolg-notices-wrapper"></div>
                    <div id="product-27"
                        class="post-27 product type-product status-publish has-post-thumbnail product_cat-table product_cat-new-arrivals product_cat-lamp product_tag-table product_tag-sock first instock shipping-taxable purchasable product-type-variable has-default-attributes">
                        <div class="main-contain-summary">
                            <div class="contain-left has-gallery">
                                <div class="single-left" style="width: 100%">
                                    <div id="product-360-view" class="product-360-view-wrapper mfp-hide">
                                        <div class="kobolg-threed-view">
                                            <div class="nav_bar"><a href="#" class="nav_bar_previous">previous</a><a
                                                    href="#" class="nav_bar_play">play</a><a href="#"
                                                    class="nav_bar_next">next</a>
                                            </div>
                                            <ul class="threed-view-images">
                                                <li><img src="assets/images/is_main11.jpg" class="previous-image"></li>
                                                <li><img src="assets/images/is_main12.jpg" class="previous-image"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div
                                        class="kobolg-product-gallery kobolg-product-gallery--with-images kobolg-product-gallery--columns-4 images">
                                        <a href="#" class="kobolg-product-gallery__trigger">
                                            <img draggable="false" class="emoji" alt="🔍"
                                                src="https://s.w.org/images/core/emoji/11/svg/1f50d.svg">
                                        </a>

                                        <div class="flex-viewport">
                                            <figure class="kobolg-product-gallery__wrapper">
                                                <div class="kobolg-product-gallery__image">
                                                    <img src="{{ \Storage::url($product->image_url) }}"
                                                        alt="{{ $product->name }}" id="main-image"
                                                        style="max-width: 70%; margin: 0 auto; height: auto;">
                                                </div>
                                                @if ($product->galleries->isNotEmpty())
                                                    @foreach ($product->galleries as $gallery)
                                                        <div class="kobolg-product-gallery__image">
                                                            <img src="{{ \Storage::url($gallery->image_url) }}"
                                                                alt="{{ $product->name }}" id="main-image"
                                                                style="max-width: 70%; margin: 0 auto; height: auto;">
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </figure>
                                        </div>

                                        <!-- Thanh ảnh thumbnails dưới ảnh chính -->
                                        <ol class="flex-control-nav flex-control-thumbs">
                                            <li>
                                                <img src="{{ \Storage::url($product->image_url) }}"
                                                    alt="{{ $product->name }} Thumbnail" style="width: 100px; height: auto;"
                                                    class="gallery-thumbnail">
                                            </li>
                                            @if ($product->galleries->isNotEmpty())
                                                @foreach ($product->galleries as $gallery)
                                                    <li>
                                                        <img src="{{ \Storage::url($gallery->image_url) }}" alt="Thumbnail"
                                                            style="width: 100px; height: auto;" class="gallery-thumbnail">
                                                    </li>
                                                @endforeach

                                            @endif
                                        </ol>

                                    </div>
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
                                    {{-- <span class="kobolg-Price-currencySymbol">₫</span> --}}
                                    <span id="product-price">
                                        @if ($product->variants->isNotEmpty())
                                            {{ number_format($minPrice, 0, ',', '.') }}₫ -
                                            {{ number_format($maxPrice, 0, ',', '.') }}₫
                                        @else
                                            {{ number_format($product->price, 0, ',', '.') }}₫
                                        @endif
                                    </span>
                                </p>
                                <br>
                                <span class="sku_wrapper">
                                    Sản phẩm còn lại:
                                    <span class="sku">
                                        @if ($product->variants()->exists())
                                            {{ $product->updateTotalStock2() }}
                                        @else
                                            {{ $product->stock }}
                                        @endif
                                    </span>
                                </span>

                                <div class="product-variants">
                                    <div class="product-attributes">
                                        @php
                                            $variantGroups = [];
                                            foreach ($product->variants as $variant) {
                                                $attributes = [];
                                                foreach ($variant->attributeValues as $attributeValue) {
                                                    $attributes[$attributeValue->attribute->name] =
                                                        $attributeValue->name;
                                                }

                                                $variantGroups[$attributes['Storage'] ?? 'Không có'][
                                                    $attributes['Color'] ?? 'Không có'
                                                ][] = $variant;
                                            }
                                        @endphp
                                        <div id="error-message" style="color: red;"></div>

                                        @if (count($variantGroups) > 0)
                                            <div class="attribute-group">
                                                <h4>Chọn biến thể:</h4>
                                                <div class="variant-options-container">
                                                    <div class="variant-options d-flex flex-wrap">
                                                        @foreach ($variantGroups as $storage => $colors)
                                                            @foreach ($colors as $color => $variants)
                                                                <button class="variant-btn mx-2 mb-2"
                                                                    data-variant="{{ json_encode($variants[0]) }}"
                                                                    data-price="{{ number_format($variants[0]->price, 0, ',', '.') }}₫"
                                                                    data-img-url="{{ \Storage::url($variants[0]->image_url ?? $product->image_url) }}"
                                                                    data-dung-luong="{{ $storage }}"
                                                                    data-mau-sac="{{ $color }}">
                                                                    <img src="{{ \Storage::url($variants[0]->image_url ?? $product->image_url) }}"
                                                                        alt="Product Image" width="40px" height="40px"
                                                                        class="img-fluid">
                                                                    <span>{{ $storage }}</span> -
                                                                    <span>{{ $color }}</span>
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
                                    Thương hiệu:
                                    <span>{{ $product->brand ? $product->brand->name : 'Không có' }}</span>
                                </p>

                                <div class="kobolg-product-details__short-description">
                                    <p>{{ $product->tomtat }}</p>
                                </div>

                                <form class="variations_form cart" id="add-to-cart-form" onsubmit="return false;">
                                    <input type="hidden" id="product-image"
                                        data-default-src="{{ \Storage::url($product->image_url) }}">
                                    <input type="hidden" name="variant_id" id="selected-variant-id">
                                    <div class="single_variation_wrap">
                                        <div class="kobolg-variation single_variation"></div>
                                        <div class="kobolg-variation-add-to-cart variations_button">
                                            <!-- Số lượng -->
                                            <div class="quantity">
                                                <label class="qty-label" for="quantity">Số lượng:</label>
                                                <div class="control">
                                                    <a class="btn-number qtyminus quantity-minus" href="#">-</a>
                                                    <input type="text" data-step="1" min="0" max=""
                                                        name="quantity" value="1" title="Qty"
                                                        class="input-qty input-text qty text" size="4"
                                                        pattern="[0-9]*" inputmode="numeric" id="quantity">
                                                    <a class="btn-number qtyplus quantity-plus" href="#">+</a>
                                                </div>
                                            </div>
                                            <input type="hidden" id="product-id" value="{{ $product->id }}">
                                            <div id="out-of-stock-message"
                                                style="display: none; color: red; font-weight: bold;">
                                                Sản phẩm này hiện đã hết hàng và ngừng kinh doanh.
                                            </div>
                                            <!-- Nút Thêm vào giỏ hàng và Mua ngay -->
                                            <div class="action-buttons">
                                                <button type="submit" id="add-to-cart"
                                                    class="single_add_to_cart_button button alt">
                                                    Thêm vào giỏ hàng
                                                </button>
                                                <button type="submit" id="buy-now"
                                                    class="single_add_to_cart_button button buy-now">
                                                    Mua ngay
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="yith-wcwl-add-to-wishlist">
                                    <div class="yith-wcwl-add-button show">
                                        <a href="#" rel="nofollow" data-product-id="27"
                                            data-product-type="variable" class="add_to_wishlist">
                                            Thêm vào danh sách yêu thích</a>
                                    </div>
                                </div>

                                <div class="clear"></div>
                                <a href="#" class="compare button" data-product_id="27" rel="nofollow">So
                                    sánh</a>

                                <div class="product_meta">
                                    <span class="sku_wrapper">SKU: <span class="sku">{{ $product->sku }}</span></span>
                                    <span class="posted_in">Danh mục:
                                        <a href="#"
                                            rel="tag">{{ $product->catalogue ? $product->catalogue->name : 'Không có' }}</a>
                                    </span>
                                </div>

                                <div class="kobolg-share-socials">
                                    <h5 class="social-heading">Chia sẻ:</h5>
                                    <a target="_blank" class="facebook" href="#"><i
                                            class="fa fa-facebook-f"></i></a>
                                    <a target="_blank" class="twitter" href="#"><i class="fa fa-twitter"></i></a>
                                    <a target="_blank" class="pinterest" href="#"> <i
                                            class="fa fa-pinterest"></i></a>
                                    <a target="_blank" class="googleplus" href="#"><i
                                            class="fa fa-google-plus"></i></a>
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

                </div>
            </div>

            @include('client.muteki.js')

            <script>

                
                $(document).ready(function() {
                    $('.kobolg-product-gallery__image').on('mousemove', function(e) {
                        var $img = $(this).find('img'); // Lấy ảnh trong phần tử này
                        var offset = $(this).offset(); // Vị trí của phần tử chứa ảnh
                        var width = $(this).width(); // Chiều rộng của phần tử chứa ảnh
                        var height = $(this).height(); // Chiều cao của phần tử chứa ảnh
                        var mouseX = e.pageX - offset.left; // Vị trí chuột theo trục X
                        var mouseY = e.pageY - offset.top; // Vị trí chuột theo trục Y

                        // Tính toán tỷ lệ di chuyển của ảnh theo vị trí chuột
                        var moveX = (mouseX / width) * 100;
                        var moveY = (mouseY / height) * 100;

                        // Di chuyển ảnh ngược lại theo hướng chuột di chuyển
                        $img.css({
                            transform: 'scale(1.5) translate(-' + moveX + '%, -' + moveY + '%)',
                            transition: 'none' // Tắt hiệu ứng chuyển động khi di chuyển
                        });
                    });

                    // Khi rời chuột ra ngoài ảnh, trả lại ảnh về vị trí ban đầu
                    $('.kobolg-product-gallery__image').on('mouseleave', function() {
                        $(this).find('img').css({
                            transform: 'scale(1)',
                            transition: 'transform 0.3s ease' // Hiệu ứng chuyển động mượt mà khi rời chuột
                        });
                    });
                });
            </script>
        @endsection

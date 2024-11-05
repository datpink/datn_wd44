@extends('client.master')

@section('title', 'Sản phẩm')



@section('content')

    @include('components.breadcrumb-client')

    @include('admin.layouts.load')

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Thêm jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Thêm jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <style>
        .ui-slider-horizontal .ui-slider-handle {
            top: 0px !important;
        }
    </style>


    <div class="main-container shop-page right-sidebar">
        <div class="container">
            <div class="row">
                <div class="main-content col-xl-9 col-lg-8 col-md-8 col-sm-12 has-sidebar">
                    @include('client.layouts.fillter2')

                    <div class="auto-clear equal-container better-height kobolg-products">
                        <ul class="row products columns-3" id="product-list">
                            @foreach ($products as $product)
                                <li class="product-item wow fadeInUp product-item list col-md-12 post-{{ $product->id }} product type-product status-publish has-post-thumbnail"
                                    id="item-product" data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                                    <div class="product-inner images">
                                        <div class="product-thumb">
                                            <a class="thumb-link" href="#">
                                                <img src="{{ $product->image_url }}" alt="">


                                            </a>
                                            <div class="flash">
                                                @if ($product->condition === 'new')
                                                    <span class="onsale"><span class="number">-18%</span></span>
                                                    <span class="onnew"><span class="text">New</span></span>
                                                @endif
                                            </div>
                                            <form class="variations_form cart" method="post" enctype="multipart/form-data">
                                                <table class="variations">
                                                    <tbody>
                                                        <tr>
                                                            <td class="value">
                                                                <select title="box_style" class="attribute-select"
                                                                    name="attribute_pa_color">
                                                                    <option value="">Choose an option</option>
                                                                    {{-- @foreach ($product->colors as $color)
                                                                        <option value="{{ $color }}">
                                                                            {{ ucfirst($color) }}</option>
                                                                    @endforeach --}}
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </form>
                                            <a href="{{ route('client.products.product-detail', $product->slug) }}"
                                                class="button yith-wcqv-button" data-product_id="{{ $product->id }}">Xem
                                                nhanh</a>
                                        </div>
                                        <div class="product-info">
                                            <div class="rating-wapper nostar">
                                                <div class="star-rating"><span
                                                        style="width:{{ $product->rating * 20 }}%">Rated <strong
                                                            class="rating">{{ $product->rating }}</strong> out of 5</span>
                                                </div>
                                                <span class="review">({{ $product->reviews_count }})</span>
                                            </div>
                                            <h3 class="product-name product_title">
                                                <a
                                                    href="{{ route('client.products.product-detail', $product->slug) }}">{{ $product->name }}</a>
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
                                            <div class="kobolg-product-details__short-description">
                                                <p>{{ $product->tomtat }}</p>
                                            </div>
                                        </div>
                                        <div class="group-button">
                                            <div class="group-button-inner">
                                                <div class="add-to-cart">
                                                    <a href="{{ route('client.products.product-detail', $product->slug) }}"
                                                        class="button product_type_variable add_to_cart_button">Thêm vào giỏ
                                                        hàng</a>
                                                </div>
                                                <div class="yith-wcwl-add-to-wishlist">
                                                    <div class="yith-wcwl-add-button show">
                                                        <a href="#" class="add_to_wishlist">Thêm vào yêu thích</a>
                                                    </div>
                                                </div>
                                                <div class="kobolg product compare-button">
                                                    <a href="#" class="compare button">So sánh</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @if ($products->count() > 0 && $products->lastPage() > 1)
                        <nav class="navigation pagination mt-3">
                            <div class="nav-links">
                                @if ($products->onFirstPage())
                                    <span class="disabled page-numbers">«</span>
                                @else
                                    <a class="page-numbers" href="{{ $products->previousPageUrl() }}">«</a>
                                @endif

                                @foreach (range(1, $products->lastPage()) as $page)
                                    @if ($page == $products->currentPage())
                                        <span class="current page-numbers">{{ $page }}</span>
                                    @else
                                        <a class="page-numbers" href="{{ $products->url($page) }}">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if ($products->hasMorePages())
                                    <a class="page-numbers" href="{{ $products->nextPageUrl() }}">»</a>
                                @else
                                    <span class="disabled page-numbers">»</span>
                                @endif
                            </div>
                        </nav>
                    @endif
                </div>

                @include('client.layouts.fillter')
            </div>
        </div>
    </div>
@endsection
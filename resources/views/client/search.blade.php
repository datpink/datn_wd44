@extends('client.master')

@section('title', 'Sản phẩm')

@section('content')

    {{-- @include('components.breadcrumb-client2') --}}

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

        .pagination-button {
            background-color: #fff;
            color: #000;
            border: 1px solid #ccc;

        }

        .pagination-button.active {
            background-color: #E52E06 !important;
            color: #fff;
        }

        .pagination-button:hover {
            background-color: #E52E06 !important;
            color: #fff;
        }

        .widget_price_filter .button {
            display: none;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="main-container shop-page right-sidebar">
        <div class="container">
            <h2>Sản phẩm liên quan</h2>
            <div class="row">

                <div class="main-content col-xl-9 col-lg-8 col-md-8 col-sm-12 has-sidebar">

                    {{-- @include('client.layouts.fillter2') --}}

                    <div class="auto-clear equal-container better-height kobolg-products">
                        <ul class="row products columns-3">
                            @if (!empty($listProducts) && $listProducts->count() > 0)

                                @foreach ($listProducts as $product)
                                    <li class="product-item wow fadeInUp product-item rows-space-30 col-bg-3 col-xl-3 col-lg-4 col-md-6 col-sm-6 col-ts-6 style-01 post-24 product type-product status-publish has-post-thumbnail product_cat-chair product_cat-table product_cat-new-arrivals product_tag-light product_tag-hat product_tag-sock first instock featured shipping-taxable purchasable product-type-variable has-default-attributes"
                                        data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">

                                        <div class="product-inner tooltip-left">
                                            <div class="product-thumb">
                                                {{-- <a class="thumb-link" href="#">
                                            <img class="img-responsive" src="assets/images/apro161-1-600x778.jpg"
                                                alt="Gaming Mouse" width="600" height="778">
                                        </a> --}}
                                                <div class="img" style="width: 200px; height: auto; margin-top: 10px">
                                                    <a class="thumb-link"
                                                        href="{{ route('client.products.product-detail', $product->slug) }}"
                                                        tabindex="0">
                                                        @if ($product->image_url && \Storage::exists($product->image_url))
                                                            <img src="{{ \Storage::url($product->image_url) }}"
                                                                alt="{{ $product->name }}">
                                                        @endif
                                                    </a>
                                                </div>

                                                <div class="flash">
                                                    @if ($product->condition === 'new')
                                                        <span class="onnew"><span class="text">New</span></span>
                                                    @endif
                                                </div>

                                                <a href="{{ route('client.products.product-detail', $product->slug) }}"
                                                    class="button yith-wcqv-button">Quick View</a>

                                            </div>

                                            <div class="product-info equal-elem" style="height: 117px;">

                                                <h3 class="product-name product_title">
                                                    <a href="{{ route('client.products.product-detail', $product->slug) }}"
                                                        tabindex="0">{{ $product->name }}</a>
                                                </h3>

                                                <div class="rating-wapper nostar">
                                                    <div class="star-rating"><span style="width:0%">Rated <strong
                                                                class="rating">0</strong> out of 5</span></div>
                                                    <span class="review">(0)</span>
                                                </div>

                                                @php
                                                    $hasVariants =
                                                        $product->variants->where('status', 'active')->count() > 0; // Kiểm tra biến thể active
                                                    $variantPrices = []; // Danh sách giá các biến thể active
                                                    if ($hasVariants) {
                                                        // Lấy giá của các biến thể có trạng thái active
                                                        foreach (
                                                            $product->variants->where('status', 'active')
                                                            as $variant
                                                        ) {
                                                            $variantPrices[] = $variant->price;
                                                        }

                                                        // dd($variantPrices);

                                                        // Tính giá min và max từ các biến thể active
                                                        $minVariantPrice = min($variantPrices);
                                                        $maxVariantPrice = max($variantPrices);
                                                    } else {
                                                        // Nếu không có biến thể active, giá min và max là giá gốc sản phẩm
                                                        $minVariantPrice = $product->price;
                                                        $maxVariantPrice = $product->price;
                                                    }

                                                    // Tính chênh lệch giữa giá sản phẩm gốc và giá giảm giá
                                                    $priceDifference =
                                                        $product->price - ($product->discount_price ?? $product->price);

                                                    // dd($priceDifference);

                                                @endphp

                                                <span class="price">
                                                    @if ($product->discount_price && $product->discount_price > 0 && $product->discount_price < $product->price)
                                                        @if ($hasVariants && count($variantPrices) > 1)
                                                            <!-- Nhiều biến thể active -->
                                                            <span
                                                                class="kobolg-Price-amount amount text-danger font-weight-bold">
                                                                <!-- Giá giảm: Áp dụng công thức giảm giá cho từng biến thể -->
                                                                {{ number_format($minVariantPrice - $priceDifference, 0, ',', '.') }}₫
                                                                -
                                                                {{ number_format($maxVariantPrice - $priceDifference, 0, ',', '.') }}₫
                                                            </span>
                                                            <del>
                                                                <!-- Gạch ngang: Giá biến thể thấp nhất - Giá biến thể cao nhất -->
                                                                <span class="kobolg-Price-amount amount">
                                                                    {{ number_format($minVariantPrice, 0, ',', '.') }}₫ -
                                                                    {{ number_format($maxVariantPrice, 0, ',', '.') }}₫
                                                                </span>
                                                            </del>
                                                        @elseif ($hasVariants && count($variantPrices) === 1)
                                                            <!-- Chỉ có một biến thể active -->
                                                            <span
                                                                class="kobolg-Price-amount amount text-danger font-weight-bold"
                                                                style="font-size: 1.3vw">
                                                                {{ number_format($minVariantPrice - $priceDifference, 0, ',', '.') }}₫
                                                            </span>
                                                            <del>
                                                                <span class="kobolg-Price-amount amount">
                                                                    {{ number_format($minVariantPrice, 0, ',', '.') }}₫
                                                                </span>
                                                            </del>
                                                        @else
                                                            <!-- Không có biến thể active -->
                                                            <span
                                                                class="kobolg-Price-amount amount text-danger font-weight-bold"
                                                                style="font-size: 1.3vw">
                                                                {{ number_format($product->discount_price, 0, ',', '.') }}₫
                                                            </span>
                                                            <del>
                                                                <span class="kobolg-Price-amount amount">
                                                                    {{ number_format($product->price, 0, ',', '.') }}₫
                                                                </span>
                                                            </del>
                                                        @endif
                                                    @else
                                                        @if ($hasVariants && count($variantPrices) > 1)
                                                            <!-- Không có giảm giá, hiển thị min-max -->
                                                            <span class="kobolg-Price-amount amount"
                                                                style="font-size: 1.3vw">
                                                                {{ number_format($minVariantPrice, 0, ',', '.') }}₫ -
                                                                {{ number_format($maxVariantPrice, 0, ',', '.') }}₫
                                                            </span>
                                                        @else
                                                            <!-- Chỉ có một biến thể hoặc không có biến thể -->
                                                            <span class="kobolg-Price-amount amount"
                                                                style="font-size: 1.3vw">
                                                                {{ number_format($minVariantPrice, 0, ',', '.') }}₫
                                                            </span>
                                                        @endif
                                                    @endif
                                                </span>

                                            </div>
                                        </div>

                                    </li>
                                @endforeach
                            @else
                                <h3>Ko có dữ liệu</h3>
                            @endif
                        </ul>
                    </div>

                    @if ($listProducts->count() > 0 && $listProducts->lastPage() > 1)
                        <nav class="navigation pagination mt-3">
                            <div class="nav-links">
                                @if ($listProducts->onFirstPage())
                                    <span class="disabled page-numbers">«</span>
                                @else
                                    <a class="page-numbers" href="{{ $listProducts->previousPageUrl() }}">«</a>
                                @endif

                                @foreach (range(1, $listProducts->lastPage()) as $page)
                                    @if ($page == $listProducts->currentPage())
                                        <span class="current page-numbers">{{ $page }}</span>
                                    @else
                                        <a class="page-numbers"
                                            href="{{ $listProducts->url($page) }}">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if ($listProducts->hasMorePages())
                                    <a class="page-numbers" href="{{ $listProducts->nextPageUrl() }}">»</a>
                                @else
                                    <span class="disabled page-numbers">»</span>
                                @endif
                            </div>
                        </nav>
                    @endif
                </div>

                <div class="sidebar col-xl-3 col-lg-4 col-md-4 col-sm-12">
                    <div id="widget-area" class="widget-area shop-sidebar">

                        <div id="widget_kobolg_post-2" class="widget widget-kobolg-post">
                            <h2 class="widgettitle">Bài viết liên quan<span class="arrow"></span></h2>
                            <div class="kobolg-posts">
                                @if (!empty($listPosts) && $listPosts->count() > 0)

                                    @foreach ($listPosts as $post)
                                        <article
                                            class="post-{{ $post->id }} post type-post status-publish format-standard has-post-thumbnail hentry">
                                            <div class="post-item-inner">
                                                <div class="post-thumb">
                                                    <a href="{{ route('post.show', $post->id) }}">
                                                        @if ($post->image && \Storage::exists($post->image))
                                                            <img src="{{ \Storage::url($post->image) }}"
                                                                class="img-responsive attachment-83x83 size-83x83"
                                                                alt="{{ $post->title }}" width="83" height="83">
                                                        @else
                                                            Không có ảnh
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="post-info">
                                                    <div class="block-title">
                                                        <h2 class="post-title">
                                                            <a
                                                                href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a>
                                                        </h2>
                                                    </div>
                                                    <div class="date">{{ $post->created_at->format('d-m-Y') }}</div>
                                                </div>
                                            </div>
                                        </article>
                                    @endforeach
                                @else
                                    <h3>Ko có dữ liệu</h3>

                                @endif

                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection

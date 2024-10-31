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
                    <div class="shop-control shop-before-control">
                        <div class="grid-view-mode">
                            <form>
                                <a href="shop.html" data-toggle="tooltip" data-placement="top"
                                    class="modes-mode mode-grid display-mode " value="grid">
                                    <span class="button-inner">
                                        Shop Grid
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </span>
                                </a>
                                <a href="shop-list.html" data-toggle="tooltip" data-placement="top"
                                    class="modes-mode mode-list display-mode active" value="list">
                                    <span class="button-inner">
                                        Shop List
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </span>
                                </a>
                            </form>
                        </div>
                        <form class="kobolg-ordering" method="get" id="orderingForm" action="">
                            <select title="product_cat" name="orderby" class="orderby">
                                <option value="price-latest">Sản phẩm mới nhất</option>
                                <option value="price-asc">Sắp xếp theo giá: từ thấp đến cao</option>
                                <option value="price-desc">Sắp xếp theo giá: từ cao đến thấp</option>
                            </select>
                        </form>

                        <script>
                            $(document).ready(function() {
                                $(".orderby").change(function() {
                                    const orderby = $(this).val(); // Lấy giá trị đã chọn
                                    console.log(orderby);

                                    // Gửi yêu cầu AJAX với Axios
                                    axios.get('/api/shop/products', {
                                            params: { // Sử dụng params để gửi các tham số
                                                orderby: orderby
                                            }
                                        })
                                        .then((res) => {
                                            console.log(res); // Kiểm tra dữ liệu nhận được
                                            $('#item-product').html(''); // Xóa danh sách cũ

                                            // Lấy dữ liệu sản phẩm từ phản hồi
                                            const products = res.data.data.data; // Dữ liệu sản phẩm
                                            // console.log(products.data);

                                            // Kiểm tra nếu products là mảng
                                            if (Array.isArray(products)) {
                                                // Tạo HTML cho từng sản phẩm
                                                let productHtml = ''; // Khởi tạo biến chứa HTML sản phẩm
                                                products.forEach(product => {
                                                    productHtml += `
                                                        <li class="product-item wow fadeInUp product-item list col-md-12 post-${product.id} product type-product status-publish has-post-thumbnail"
                                                            data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                                                            <div class="product-inner images">
                                                                <div class="product-thumb">
                                                                    <a class="thumb-link" href="#">
                                                                        ${product.image_url ? `<img class="img-responsive" src="http://127.0.0.1:8000/storage/${product.image_url}" alt="${product.name}" width="600" height="778">` : 'Không có ảnh'}
                                                                    </a>
                                                                    <div class="flash">
                                                                        ${product.condition === 'new' ? '<span class="onsale"><span class="number">-18%</span></span>' : '<span class="onnew"><span class="text">New</span></span>'}
                                                                    </div>
                                                                    <a href="#" class="button yith-wcqv-button" data-product_id="${product.id}">Quick View</a>
                                                                </div>
                                                                <div class="product-info">
                                                                    <div class="rating-wapper nostar">
                                                                        <div class="star-rating">
                                                                            <span style="width:${(product.ratings_avg * 20)}%">Rated <strong class="rating">${product.ratings_avg}</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review">(${product.ratings_count})</span>
                                                                    </div>
                                                                    <h3 class="product-name product_title">
                                                                        <a href="/products/${product.id}">${product.name}</a>
                                                                    </h3>
                                                                    <span class="price">
                                                                        <span class="kobolg-Price-amount amount text-danger">
                                                                            <del><span class="kobolg-Price-currencySymbol">$</span>${Number(product.price).toFixed(2)}</del>
                                                                        </span>
                                                                        ${product.discount_price ? `<span class="kobolg-Price-amount amount old-price"><span class="kobolg-Price-currencySymbol">$</span>${Number(product.discount_price).toFixed(2)}</span>` : ''}
                                                                    </span>
                                                                    <div class="kobolg-product-details__short-description">
                                                                        <p>${product.tomtat}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="group-button">
                                                                    <div class="group-button-inner">
                                                                        <div class="add-to-cart">
                                                                            <a href="#" class="button product_type_variable add_to_cart_button">Select options</a>
                                                                        </div>
                                                                        <div class="yith-wcwl-add-to-wishlist">
                                                                            <div class="yith-wcwl-add-button show">
                                                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="kobolg product compare-button">
                                                                            <a href="#" class="compare button">Compare</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    `;
                                                });

                                                // Cập nhật nội dung HTML của #item-product
                                                document.getElementById('item-product').innerHTML =
                                                    productHtml; // Sử dụng innerHTML
                                                console.log(document.getElementById('item-product'));
                                            } else {
                                                // Nếu products không phải là mảng, log ra đối tượng chứa dữ liệu
                                                console.error('Dữ liệu không phải là mảng:', products);
                                            }
                                        })
                                        .catch((error) => {
                                            console.error('Có lỗi xảy ra:', error);
                                        });
                                });
                            });
                        </script>

                        {{-- <form class="per-page-form">
                            <label>
                                <select class="option-perpage">
                                    <option value="12" selected="">
                                        Show 12
                                    </option>
                                    <option value="5">
                                        Show 05
                                    </option>
                                    <option value="10">
                                        Show 10
                                    </option>
                                    <option value="12">
                                        Show 12
                                    </option>
                                    <option value="15">
                                        Show 15
                                    </option>
                                    <option value="20">
                                        Show All
                                    </option>
                                </select>
                            </label>
                        </form> --}}
                    </div>

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
                                                        <span class="kobolg-Price-currencySymbol">$</span>{{ number_format($product->price, ($product->price == floor($product->price) ? 0 : 2)) }}
                                                    </del>
                                                </span>
                                                @if ($product->discount_price)
                                                    <span class="kobolg-Price-amount amount old-price">
                                                        <span class="kobolg-Price-currencySymbol">$</span>{{ number_format($product->discount_price, ($product->discount_price == floor($product->discount_price) ? 0 : 2)) }}
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
                                                    <a href="#"
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
                </div>
                <div class="sidebar col-xl-3 col-lg-4 col-md-4 col-sm-12">
                    <div id="widget-area" class="widget-area shop-sidebar">
                        <div id="kobolg_product_search-2" class="widget kobolg widget_product_search">
                            <form role="search" method="get" class="kobolg-product-search"
                                action="{{ route('product.search') }}">

                                <input id="kobolg-product-search-field-0" class="search-field"
                                    placeholder="Search products…" value="{{ request()->get('s') }}" name="s"
                                    type="search">
                                <button type="submit" value="Search">Search</button>
                            </form>
                        </div>
                        <div id="kobolg_price_filter-2" class="widget kobolg widget_price_filter">
                            <h2 class="widgettitle">Lọc theo giá<span class="arrow"></span></h2>
                            <form method="get" action="" id="priceFilterForm">
                                @php
                                    // dd($maxDiscountPrice);
                                @endphp
                                <div class="price_slider_wrapper">
                                    <div data-label-reasult="Range:" data-min="0" data-max="{{ $maxDiscountPrice }}"
                                        data-unit="₫" class="price_slider" data-value-min="0"
                                        data-value-max="{{ $maxDiscountPrice }} ">
                                    </div>


                                    <div class="price_slider_amount">
                                        <button type="submit" class="button">Filter</button>
                                        <div class="price_label">
                                            Price: <span class="from" id="priceFrom"> </span>—
                                            <span class="to" id="priceTo"></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- <a href="#" class="link-item" id="myLink">Click me</a>
                        <script>
                            document.getElementById('myLink').addEventListener('click', function(event) {
                                event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết

                                // Thực hiện hành động nào đó khi nhấp vào liên kết
                                console.log('Link clicked!');

                                // Thay đổi màu sắc của liên kết bằng cách thêm class mới
                                this.classList.add('clicked');
                            });
                        </script> --}}
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {

                                const priceFilterForm = document.getElementById('priceFilterForm');
                                const priceFrom = document.getElementById('priceFrom');
                                const priceTo = document.getElementById('priceTo');
                                let productLists = document.querySelector('.kobolg-products .products');

                                // Khởi tạo slider
                                const minPrice = parseFloat(priceFilterForm.querySelector('.price_slider').getAttribute(
                                    'data-value-min'));
                                const maxPrice = parseFloat(priceFilterForm.querySelector('.price_slider').getAttribute(
                                    'data-value-max'));
                                const maxDiscountPrice = parseFloat(priceFilterForm.querySelector('.price_slider').getAttribute(
                                    'data-max'));

                                $('.price_slider').slider({
                                    range: true,
                                    min: 0,
                                    max: maxDiscountPrice,
                                    values: [minPrice, maxPrice],
                                    slide: function(event, ui) {
                                        priceFrom.textContent = `₫${ui.values[0]}`;
                                        priceTo.textContent = `₫${ui.values[1]}`;
                                    },
                                    change: function(event, ui) {
                                        // Cập nhật giá trị trong thuộc tính data
                                        priceFilterForm.querySelector('.price_slider').setAttribute('data-value-min', ui
                                            .values[0]);
                                        priceFilterForm.querySelector('.price_slider').setAttribute('data-value-max', ui
                                            .values[1]);
                                    }
                                });

                                // Cập nhật giá trị hiển thị ban đầu
                                priceFrom.textContent = `₫${minPrice}`;
                                priceTo.textContent = `₫${maxPrice}`;

                                // Bắt sự kiện submit form
                                priceFilterForm.addEventListener('submit', function(e) {
                                    e.preventDefault();

                                    const minPrice = priceFilterForm.querySelector('.price_slider').getAttribute(
                                        'data-value-min');
                                    const maxPrice = priceFilterForm.querySelector('.price_slider').getAttribute(
                                        'data-value-max');

                                    let params = {
                                        'min_price': minPrice,
                                        'max_price': maxPrice,
                                    };

                                    // Gọi API lọc sản phẩm theo khoảng giá
                                    axios.get('/api/shop/products/filter-by-price', {
                                            params
                                        })

                                        .then((res) => {

                                            // console.log(res);
                                            // console.log(productLists);
                                            productLists.innerHTML = '';
                                            // console.log(res.data); // Kiểm tra toàn bộ cấu trúc phản hồi
                                            // console.log(res.data.data);
                                            // Xử lý danh sách sản phẩm
                                            // Kiểm tra nếu products là một mảng
                                            if (Array.isArray(res.data.products)) {

                                                productLists.innerHTML = ''; // Xóa danh sách sản phẩm cũ

                                                // Duyệt qua từng sản phẩm và thêm vào danh sách
                                                res.data.products.forEach(product => {
                                                    const productHTML = `
                                                        <li class="product-item wow fadeInUp product-item list col-md-12 post-${product.id} product type-product status-publish has-post-thumbnail"
                                                            data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                                                            <div class="product-inner images">
                                                                <div class="product-thumb">
                                                                    <a class="thumb-link" href="#">
                                                                        ${product.image_url ? `<img class="img-responsive" src="http://127.0.0.1:8000/storage/${product.image_url}" alt="${product.name}" width="600" height="778">` : 'Không có ảnh'}
                                                                    </a>
                                                                    <div class="flash">
                                                                        ${product.condition === 'new' ? '<span class="onsale"><span class="number">-18%</span></span>' : '<span class="onnew"><span class="text">New</span></span>'}
                                                                    </div>
                                                                    <a href="#" class="button yith-wcqv-button" data-product_id="${product.id}">Quick View</a>
                                                                </div>
                                                                <div class="product-info">
                                                                    <div class="rating-wapper nostar">
                                                                        <div class="star-rating">
                                                                            <span style="width:${product.rating * 20}%">Rated <strong class="rating">${product.rating}</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review">(${product.reviews_count})</span>
                                                                    </div>
                                                                    <h3 class="product-name product_title">
                                                                        <a href="/products/${product.id}">${product.name}</a>
                                                                    </h3>
                                                                    <span class="price">
                                                                        <span class="kobolg-Price-amount amount text-danger">
                                                                            <del><span class="kobolg-Price-currencySymbol">$</span>${Number(product.price).toFixed(2)}</del>
                                                                        </span>
                                                                        ${product.discount_price ? `<span class="kobolg-Price-amount amount old-price"><span class="kobolg-Price-currencySymbol">$</span>${Number(product.discount_price).toFixed(2)}</span>` : ''}
                                                                    </span>
                                                                    <div class="kobolg-product-details__short-description">
                                                                        <p>${product.tomtat}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="group-button">
                                                                    <div class="group-button-inner">
                                                                        <div class="add-to-cart">
                                                                            <a href="#" class="button product_type_variable add_to_cart_button">Select options</a>
                                                                        </div>
                                                                        <div class="yith-wcwl-add-to-wishlist">
                                                                            <div class="yith-wcwl-add-button show">
                                                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="kobolg product compare-button">
                                                                            <a href="#" class="compare button">Compare</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    `;
                                                    productLists.innerHTML +=
                                                    productHTML; // Thêm sản phẩm vào danh sách
                                                });
                                            } else {
                                                console.error('Dữ liệu không phải là một mảng:', res.data.products);
                                                productLists.innerHTML =
                                                    '<p>Không có sản phẩm nào phù hợp với tiêu chí lọc.</p>';
                                            }

                                        })
                                        .catch((error) => {
                                            console.log(error);

                                        })

                                })


                            })
                        </script>


                        <div id="kobolg_kobolg_layered_nav-4" class="widget kobolg_widget_layered_nav widget_layered_nav">
                            <h2 class="widgettitle">Lọc theo màu<span class="arrow"></span></h2>
                            <div class="color-group">
                                @foreach ($variant_values as $item)
                                    <a class="term-color " href="" id="variant_values" name="variant_values"
                                        data-attribute_id="{{ $item->id }}">
                                        <i style="color: {{ $item->name }}"></i>
                                        <span class="term-name-color">{{ $item->name }}</span>
                                        <span class="count">(*)</span> </a>
                                @endforeach

                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function(e) {
                                const colorGroup = document.querySelectorAll('.term-color');

                                // console.log(colorGroup);

                                colorGroup.forEach(function(color) {

                                    color.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        const attributeId = this.getAttribute('data-attribute_id');
                                        // console.log(attributeId);

                                        axios.get('/api/shop/products/filter-by-color', {
                                                params: {
                                                    attribute_value_id: attributeId
                                                }
                                            })
                                            .then((res) => {
                                                // console.log(res);
                                                // Xóa danh sách cũ
                                                const productList = document.getElementById('product-list');
                                                productList.innerHTML = ''; // Xóa danh sách cũ
                                                console.log(productList);


                                                // Kiểm tra nếu có sản phẩm trong phản hồi
                                                if (res.data.data.length > 0) {
                                                    // Tạo một biến để chứa HTML của tất cả các sản phẩm
                                                    let productsHTML = '';

                                                    res.data.data.forEach(product => {
                                                        // Tạo nội dung HTML cho sản phẩm mới
                                                        productsHTML += `
                                                            <li class="product-item wow fadeInUp product-item list col-md-12 post-${product.id} product type-product status-publish has-post-thumbnail"
                                                            data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                                                            <div class="product-inner images">
                                                                <div class="product-thumb">
                                                                    <a class="thumb-link" href="#">
                                                                        ${product.image_url ? `<img class="img-responsive" src="http://127.0.0.1:8000/storage/${product.image_url}" alt="${product.name}" width="600" height="778">` : 'Không có ảnh'}
                                                                    </a>
                                                                    <div class="flash">
                                                                        ${product.condition === 'new' ? '<span class="onsale"><span class="number">-18%</span></span>' : '<span class="onnew"><span class="text">New</span></span>'}
                                                                    </div>
                                                                    <a href="#" class="button yith-wcqv-button" data-product_id="${product.id}">Quick View</a>
                                                                </div>
                                                                <div class="product-info">
                                                                    <div class="rating-wapper nostar">
                                                                        <div class="star-rating">
                                                                            <span style="width:${(product.ratings_avg * 20)}%">Rated <strong class="rating">${product.ratings_avg}</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review">(${product.ratings_count})</span>
                                                                    </div>
                                                                    <h3 class="product-name product_title">
                                                                        <a href="/products/${product.id}">${product.name}</a>
                                                                    </h3>
                                                                    <span class="price">
                                                                        <span class="kobolg-Price-amount amount text-danger">
                                                                            <del><span class="kobolg-Price-currencySymbol">$</span>${Number(product.price).toFixed(2)}</del>
                                                                        </span>
                                                                        ${product.discount_price ? `<span class="kobolg-Price-amount amount old-price"><span class="kobolg-Price-currencySymbol">$</span>${Number(product.discount_price).toFixed(2)}</span>` : ''}
                                                                    </span>
                                                                    <div class="kobolg-product-details__short-description">
                                                                        <p>${product.tomtat}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="group-button">
                                                                    <div class="group-button-inner">
                                                                        <div class="add-to-cart">
                                                                            <a href="#" class="button product_type_variable add_to_cart_button">Select options</a>
                                                                        </div>
                                                                        <div class="yith-wcwl-add-to-wishlist">
                                                                            <div class="yith-wcwl-add-button show">
                                                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="kobolg product compare-button">
                                                                            <a href="#" class="compare button">Compare</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        `;
                                                    });

                                                    // Cập nhật danh sách sản phẩm mới vào DOM
                                                    productList.innerHTML = productsHTML;

                                                } else {
                                                    productList.innerHTML = '<p>Không có sản phẩm nào phù hợp.</p>';
                                                }

                                            }).catch((err) => {
                                                console.log(err);

                                            })
                                    })

                                })

                            })
                        </script>


                        <div id="kobolg_layered_nav-6" class="widget kobolg widget_layered_nav kobolg-widget-layered-nav">
                            <h2 class="widgettitle">Lọc theo dung lượng<span class="arrow"></span></h2>
                            <ul class="kobolg-widget-layered-nav-list">
                                @foreach ($variant_storage_values as $storage_value)
                                    <li class="kobolg-widget-layered-nav-list__item kobolg-layered-nav-term ">
                                        <a rel="nofollow" href="" class="term-storage"
                                            data-attribute_storage_id="{{ $storage_value->id }}">{{ $storage_value->name }}</a>
                                        <span class="count">(*)</span>

                                    </li>
                                @endforeach

                            </ul>
                        </div>


                        <script>
                            document.addEventListener('DOMContentLoaded', function(e) {
                                const storageGroup = document.querySelectorAll('.term-storage');

                                // console.log(storageGroup);

                                storageGroup.forEach(function(storage) {

                                    storage.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        const attributeStorageId = this.getAttribute('data-attribute_storage_id');
                                        // console.log(attributeStorageId);

                                        axios.get('/api/shop/products/filter-by-storage', {
                                                params: {
                                                    attribute_storage_value_id: attributeStorageId
                                                }
                                            })
                                            .then((res) => {
                                                // console.log(res);
                                                // Xóa danh sách cũ
                                                const productList = document.getElementById('product-list');
                                                productList.innerHTML = ''; // Xóa danh sách cũ
                                                console.log(productList);


                                                // Kiểm tra nếu có sản phẩm trong phản hồi
                                                if (res.data.data.length > 0) {
                                                    // Tạo một biến để chứa HTML của tất cả các sản phẩm
                                                    let productsHTML = '';

                                                    res.data.data.forEach(product => {
                                                        // Tạo nội dung HTML cho sản phẩm mới
                                                        productsHTML += `
                                                            <li class="product-item wow fadeInUp product-item list col-md-12 post-${product.id} product type-product status-publish has-post-thumbnail"
                                                            data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                                                            <div class="product-inner images">
                                                                <div class="product-thumb">
                                                                    <a class="thumb-link" href="#">
                                                                        ${product.image_url ? `<img class="img-responsive" src="http://127.0.0.1:8000/storage/${product.image_url}" alt="${product.name}" width="600" height="778">` : 'Không có ảnh'}
                                                                    </a>
                                                                    <div class="flash">
                                                                        ${product.condition === 'new' ? '<span class="onsale"><span class="number">-18%</span></span>' : '<span class="onnew"><span class="text">New</span></span>'}
                                                                    </div>
                                                                    <a href="#" class="button yith-wcqv-button" data-product_id="${product.id}">Quick View</a>
                                                                </div>
                                                                <div class="product-info">
                                                                    <div class="rating-wapper nostar">
                                                                        <div class="star-rating">
                                                                            <span style="width:${(product.ratings_avg * 20)}%">Rated <strong class="rating">${product.ratings_avg}</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review">(${product.ratings_count})</span>
                                                                    </div>
                                                                    <h3 class="product-name product_title">
                                                                        <a href="/products/${product.id}">${product.name}</a>
                                                                    </h3>
                                                                    <span class="price">
                                                                        <span class="kobolg-Price-amount amount text-danger">
                                                                            <del><span class="kobolg-Price-currencySymbol">$</span>${Number(product.price).toFixed(2)}</del>
                                                                        </span>
                                                                        ${product.discount_price ? `<span class="kobolg-Price-amount amount old-price"><span class="kobolg-Price-currencySymbol">$</span>${Number(product.discount_price).toFixed(2)}</span>` : ''}
                                                                    </span>
                                                                    <div class="kobolg-product-details__short-description">
                                                                        <p>${product.tomtat}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="group-button">
                                                                    <div class="group-button-inner">
                                                                        <div class="add-to-cart">
                                                                            <a href="#" class="button product_type_variable add_to_cart_button">Select options</a>
                                                                        </div>
                                                                        <div class="yith-wcwl-add-to-wishlist">
                                                                            <div class="yith-wcwl-add-button show">
                                                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="kobolg product compare-button">
                                                                            <a href="#" class="compare button">Compare</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        `;
                                                    });

                                                    // Cập nhật danh sách sản phẩm mới vào DOM
                                                    productList.innerHTML = productsHTML;

                                                } else {
                                                    productList.innerHTML = '<p>Không có sản phẩm nào phù hợp.</p>';
                                                }

                                            }).catch((err) => {
                                                console.log(err);

                                            })
                                    })

                                })

                            })
                        </script>





                        <div id="kobolg_product_categories-3" class="widget kobolg widget_product_categories">
                            <h2 class="widgettitle">Danh mục sản phẩm<span class="arrow"></span></h2>
                            <ul class="product-categories">
                                <li class="cat-item cat-item-22"><a href="#">Camera</a>
                                    <span class="count">(11)</span>
                                </li>
                                <li class="cat-item cat-item-16"><a href="#">Accessories</a>
                                    <span class="count">(9)</span>
                                </li>
                                <li class="cat-item cat-item-24"><a href="#">Game & Consoles</a>
                                    <span class="count">(6)</span>
                                </li>
                                <li class="cat-item cat-item-27"><a href="#">Life style</a> <span
                                        class="count">(6)</span></li>
                                <li class="cat-item cat-item-19"><a href="#">New arrivals</a>
                                    <span class="count">(7)</span>
                                </li>
                                <li class="cat-item cat-item-17"><a href="#">Summer Sale</a>
                                    <span class="count">(6)</span>
                                </li>
                                <li class="cat-item cat-item-26"><a href="#">Specials</a> <span
                                        class="count">(4)</span></li>
                                <li class="cat-item cat-item-18"><a href="#">Featured</a> <span
                                        class="count">(6)</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

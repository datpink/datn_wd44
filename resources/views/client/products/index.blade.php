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

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="main-container shop-page right-sidebar">
        <div class="container">
            <div class="row">
                <div class="main-content col-xl-9 col-lg-8 col-md-8 col-sm-12 has-sidebar">

                    {{-- @include('client.layouts.fillter2') --}}

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
                                                        <a href="javascript:void(0)" data-product-id={{ $product->id }}
                                                            class="add_to_wishlist">Thêm vào yêu
                                                            thích</a>
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

                {{-- @include('client.layouts.fillter') --}}

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
                                        {{-- <button type="submit" class="button">Filter</button> --}}
                                        <div class="price_label">
                                            Price: <span class="from" id="priceFrom"> </span>—
                                            <span class="to" id="priceTo"></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div id="kobolg_kobolg_layered_nav-4" class="widget kobolg_widget_layered_nav widget_layered_nav">
                            <h2 class="widgettitle">Lọc theo màu<span class="arrow"></span></h2>
                            <div class="color-group">
                                @foreach ($variant_values as $item)
                                    <a class="term-color" href="" id="variant_values" name="variant_values"
                                        data-attribute_id="{{ $item->id }}">
                                        <i style="color: {{ $item->name }}"></i>
                                        <span class="term-name-color">{{ $item->name }}</span>
                                        <span class="count">(*)</span> </a>
                                @endforeach

                            </div>
                        </div>


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

                        {{-- <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const addToWishlist = document.querySelectorAll('.add_to_wishlist');

                                console.log(addToWishlist);

                                addToWishlist.forEach(function(item) {
                                    item.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        console.log(item);
                                        console.log(123);

                                    })
                                })

                            });
                        </script> --}}



                        <style>
                            .kobolg-widget-layered-nav-list__item .term-storage:hover {
                                position: relative;
                                color: #28a745;
                                /* Màu chữ khi hover */
                            }

                            /* Thêm dấu tích khi hover */
                            .kobolg-widget-layered-nav-list__item .term-storage:hover::after {
                                content: '✔';
                                position: absolute;
                                right: -20px;
                                color: #28a745;
                            }

                            /* Thêm dấu tích khi chọn (class .selected) */
                            .term-storage.selected {
                                position: relative;
                                color: #28a745;
                                /* Màu chữ khi đã chọn */
                            }

                            .term-storage.selected::after {
                                content: '✔';
                                position: absolute;
                                right: -20px;
                                color: #28a745;
                            }
                        </style>

                        <script>
                            document.addEventListener('DOMContentLoaded', function(e) {
                                const orderBySelect = document.querySelector('.orderby');
                                const colorGroup = document.querySelectorAll('.term-color');
                                const storageGroup = document.querySelectorAll('.term-storage');
                                // const priceRange = document.getElementById('price-range');
                                // const parent_id = document.getElementById('catalogues-id');
                                // const child_id = document.getElementById('child-catalogues-id');
                                const priceFilterForm = document.getElementById('priceFilterForm');
                                const priceFrom = document.getElementById('priceFrom');
                                const priceTo = document.getElementById('priceTo');



                                let activeFilters = {
                                    color: null,
                                    storage: null,
                                    price_min: null,
                                    price_max: null,
                                    orderby: 'price-latest'
                                };

                                orderBySelect.addEventListener('change', function(e) {

                                    activeFilters.orderby = this.value; // Lấy giá trị tùy chọn sắp xếp
                                    fetchFilteredProducts();
                                })

                                // Cập nhật bộ lọc giá với slider
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
                                        priceFrom.textContent = `$${ui.values[0]}`;
                                        priceTo.textContent = `$${ui.values[1]}`;
                                    }
                                });

                                // Gắn sự kiện "change" sau khi slider đã khởi tạo
                                $('.price_slider').on('slidestop', function(event, ui) {
                                    activeFilters.price_min = ui.values[0];
                                    activeFilters.price_max = ui.values[1];
                                    fetchFilteredProducts();
                                });


                                priceFrom.textContent = `$${minPrice}`;
                                priceTo.textContent = `$${maxPrice}`;

                                // // Xử lý sự kiện cho .term-color
                                colorGroup.forEach(function(color) {
                                    color.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        const colorId = this.getAttribute('data-attribute_id');

                                        // Kiểm tra nếu đã chọn màu này, thì bỏ chọn (đặt thành null)
                                        if (activeFilters.color === colorId) {
                                            activeFilters.color = null;
                                            this.classList.remove('selected'); // Bỏ dấu tích
                                        } else {
                                            // Xóa dấu tích từ các màu khác và chỉ thêm vào màu được chọn
                                            colorGroup.forEach(c => c.classList.remove('selected'));
                                            activeFilters.color = colorId;
                                            this.classList.add('selected'); // Thêm dấu tích
                                        }

                                        fetchFilteredProducts();
                                    });
                                });

                                // Xử lý sự kiện cho .term-storage
                                storageGroup.forEach(function(storage) {
                                    storage.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        const storageId = this.getAttribute('data-attribute_storage_id');

                                        // Kiểm tra nếu đã chọn bộ nhớ này, thì bỏ chọn (đặt thành null)
                                        if (activeFilters.storage === storageId) {
                                            activeFilters.storage = null;
                                            this.classList.remove('selected'); // Bỏ dấu tích
                                        } else {
                                            // Xóa dấu tích từ các bộ nhớ khác và chỉ thêm vào bộ nhớ được chọn
                                            storageGroup.forEach(s => s.classList.remove('selected'));
                                            activeFilters.storage = storageId;
                                            this.classList.add('selected'); // Thêm dấu tích
                                        }

                                        fetchFilteredProducts();
                                    });
                                });


                                function fetchFilteredProducts() {
                                    axios.post('/api/shop/products', {
                                            // parent_id: parent_id ? parent_id.value : null,
                                            // child_id: child_id ? child_id.value : null,
                                            attribute_id: activeFilters.color,
                                            attribute_storage_value_id: activeFilters.storage,
                                            price_min: activeFilters.price_min, // Gửi giá min
                                            price_max: activeFilters.price_max, // Gửi giá max
                                            orderby: activeFilters.orderby
                                        })
                                        .then((res) => {
                                            const productList = document.getElementById('product-list');
                                            // console.log(productList);


                                            productList.innerHTML = ''; // Xóa danh sách cũ

                                            if (res.data.data.data.length > 0) {
                                                let productsHTML = '';
                                                res.data.data.data.forEach(product => {
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
                                                                            <a href="{{ route('client.products.product-detail', $product->slug) }}">${product.name}</a>
                                                                        </h3>
                                                                        <span class="price">
                                                                            <span class="kobolg-Price-amount amount text-danger">
                                                                                <del>
                                                                                    ${new Intl.NumberFormat('de-DE').format(product.price)}<span class="kobolg-Price-currencySymbol">₫</span>
                                                                                </del>
                                                                            </span>
                                                                            ${product.discount_price ? `<span class="kobolg-Price-amount amount old-price">${new Intl.NumberFormat('de-DE').format(product.discount_price)}</span>` : ''}<span class="kobolg-Price-currencySymbol">₫</span>
                                                                        </span>
                                                                        <div class="kobolg-product-details__short-description">
                                                                            <p>${product.tomtat}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="group-button">
                                                                        <div class="group-button-inner">
                                                                            <div class="add-to-cart">
                                                                                <a href="{{ route('client.products.product-detail', $product->slug) }}" class="button product_type_variable add_to_cart_button">Select options</a>
                                                                            </div>
                                                                            <div class="yith-wcwl-add-to-wishlist">
                                                                                <div class="yith-wcwl-add-button show">
                                                                                    <a href="javascript:void(0)" data-product-id=${product.id} class="add_to_wishlist">Thêm vào yêu thích</a>
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
                                                productList.innerHTML = productsHTML;
                                            } else {
                                                productList.innerHTML = '<p>Không có sản phẩm nào phù hợp.</p>';
                                            }
                                        })
                                        .catch((err) => {
                                            console.log(err);
                                        });
                                }


                                document.body.addEventListener('click', function(e) {
                                    if (e.target.classList.contains('add_to_wishlist')) {
                                        const productId = e.target.dataset.productId;
                                        console.log(productId);

                                        axios.post('http://127.0.0.1:8000/shop/add-product-favorite', {
                                                product_id: productId,
                                            }, {
                                                headers: {
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                                        .getAttribute('content'),
                                                }
                                            })
                                            .then((res) => {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Thành công!',
                                                    text: res.data.success, // Lấy thông báo từ response
                                                    position: 'top',
                                                    toast: true,
                                                    showConfirmButton: false,
                                                    timer: 3000
                                                });

                                            })
                                            .catch((err) => {
                                                if (err.response) {
                                                    // Kiểm tra mã lỗi HTTP từ server
                                                    if (err.response.status === 401) {
                                                        // Nếu người dùng chưa đăng nhập
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Cần đăng nhập!',
                                                            text: err.response.data
                                                                .error, // Lấy thông báo lỗi từ response
                                                            position: 'top',
                                                            toast: true,
                                                            showConfirmButton: false,
                                                            timer: 3000
                                                        });
                                                    } else if (err.response.status === 400) {
                                                        // Nếu sản phẩm đã có trong danh sách yêu thích
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Có lỗi xảy ra!',
                                                            text: err.response.data
                                                                .error, // Lấy thông báo lỗi từ response
                                                            position: 'top',
                                                            toast: true,
                                                            showConfirmButton: false,
                                                            timer: 3000
                                                        });
                                                    } else {
                                                        // Các lỗi khác
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Có lỗi xảy ra!',
                                                            text: 'Không thể thêm sản phẩm vào yêu thích.',
                                                            position: 'top',
                                                            toast: true,
                                                            showConfirmButton: false,
                                                            timer: 3000
                                                        });
                                                    }
                                                } else {
                                                    // Nếu không có response (ví dụ lỗi mạng)
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Có lỗi xảy ra!',
                                                        text: 'Không thể kết nối với server.',
                                                        position: 'top',
                                                        toast: true,
                                                        showConfirmButton: false,
                                                        timer: 3000
                                                    });
                                                }
                                            })

                                    }
                                });

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

@extends('client.master')

@section('title', 'Sản phẩm ')

@section('content')

    @include('components.breadcrumb-client2')



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


    <div class="main-container shop-page right-sidebar">
        <div class="container">
            <div class="row">
                <div class="main-content col-xl-9 col-lg-8 col-md-8 col-sm-12 has-sidebar">
                    <div class="shop-control shop-before-control">
                        <form class="kobolg-ordering" method="get" id="orderingForm" action="">
                            <select title="" name="orderby" class="orderby">
                                <option value="price-latest">Sản phẩm mới nhất</option>
                                <option value="price-asc">Sắp xếp theo giá: từ thấp đến cao</option>
                                <option value="price-desc">Sắp xếp theo giá: từ cao đến thấp</option>
                            </select>
                        </form>


                    </div>

                    <div class="auto-clear equal-container better-height kobolg-products">
                        <ul class="row products columns-3" id="product-list">
                            {{-- hiển thị danh sách sản phẩm --}}

                        </ul>
                    </div>
                    {{-- @if ($productByCatalogues->count() > 0 && $productByCatalogues->lastPage() > 1)
                        <nav class="navigation pagination mt-3">
                            <div class="nav-links">
                                @if ($productByCatalogues->onFirstPage())
                                    <span class="disabled page-numbers">«</span>
                                @else
                                    <a class="page-numbers" href="{{ $productByCatalogues->previousPageUrl() }}">«</a>
                                @endif

                                @foreach (range(1, $productByCatalogues->lastPage()) as $page)
                                    @if ($page == $productByCatalogues->currentPage())
                                        <span class="current page-numbers">{{ $page }}</span>
                                    @else
                                        <a class="page-numbers"
                                            href="{{ $productByCatalogues->url($page) }}">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if ($productByCatalogues->hasMorePages())
                                    <a class="page-numbers" href="{{ $productByCatalogues->nextPageUrl() }}">»</a>
                                @else
                                    <span class="disabled page-numbers">»</span>
                                @endif
                            </div>
                        </nav>
                    @endif --}}

                    <div id="paginationContainer" class="pagination  mt-3">
                        <!-- Phân trang sẽ được thêm tại đây -->
                    </div>

                </div>
                <div class="sidebar col-xl-3 col-lg-4 col-md-4 col-sm-12">
                    <div id="widget-area" class="widget-area shop-sidebar">
                        <div id="kobolg_product_search-2" class="widget kobolg widget_product_search">
                            <form class="kobolg-product-search">
                                <input id="kobolg-product-search-field-0" class="search-field" placeholder="Tìm kiếm…"
                                    value="" name="" type="search">
                                <button type="submit" value="Search" id="search-button">Tìm kiếm</button>
                            </form>
                        </div>
                        <div id="kobolg_price_filter-2" class="widget kobolg widget_price_filter">
                            <h2 class="widgettitle">Lọc theo giá<span class="arrow"></span></h2>
                            {{-- <form method="get" action="#">
                                <div class="price_slider_wrapper">
                                    <div data-label-reasult="Range:" data-min="0" data-max="1000" data-unit="$"
                                        class="price_slider" data-value-min="100" data-value-max="800">
                                    </div>
                                    <div class="price_slider_amount">
                                        <button type="submit" class="button">Filter</button>
                                        <div class="price_label">
                                            Price: <span class="from">$100</span> — <span class="to">$800</span>
                                        </div>
                                    </div>
                                </div>

                            </form> --}}
                            <form method="get" action="" id="priceFilterForm">
                                <input type="hidden" name="parentCataloguesID" id="parentCataloguesID"
                                    value="{{ $parentCataloguesID }}">
                                <div class="price_slider_wrapper">
                                    <div data-label-reasult="Range:" data-min="0" data-max="{{ $maxDiscountPrice }}"
                                        data-unit="$" class="price_slider" data-value-min="0"
                                        data-value-max="{{ $maxDiscountPrice }}">
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

                        <input id="catalogues-id" type="hidden" value="{{ $catalogues->id }}">
                        <input id="child-catalogues-id" type="hidden" value="{{ $childCatalogues }}">
                        <div id="kobolg_kobolg_layered_nav-4" class="widget kobolg_widget_layered_nav widget_layered_nav">
                            <h2 class="widgettitle">Lọc theo màu<span class="arrow"></span></h2>
                            <div class="color-group">
                                @foreach ($variant_values as $item)
                                    <a class="term-color " href="" id="variant_values" name="variant_values"
                                        data-attribute_id="{{ $item->id }}">
                                        <i style="color: {{ $item->name }}"></i>
                                        <span class="term-name-color">{{ $item->name }}</span>
                                        {{-- <span class="count">{{ $item->productVariants->count() }}(*)</span> --}}
                                    </a>
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


                    </div>
                </div>
            </div>
        </div>
    </div>

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
            const searchProduct = document.querySelector('.search-field');
            const colorGroup = document.querySelectorAll('.term-color');
            const storageGroup = document.querySelectorAll('.term-storage');
            // const priceRange = document.getElementById('price-range');
            const parent_id = document.getElementById('catalogues-id');
            const child_id = document.getElementById('child-catalogues-id');
            const priceFilterForm = document.getElementById('priceFilterForm');
            const priceFrom = document.getElementById('priceFrom');
            const priceTo = document.getElementById('priceTo');


            let activeFilters = {
                color: null,
                storage: null,
                price_min: null,
                price_max: null,
                orderby: 'price-latest',
                searchProduct: null,
            };

            orderBySelect.addEventListener('change', function(e) {
                activeFilters.orderby = this.value; // Lấy giá trị tùy chọn sắp xếp
                fetchFilteredProducts();
            })

            document.getElementById('search-button').addEventListener('click', function(e) {
                e.preventDefault();
                activeFilters.searchProduct = searchProduct.value.trim();
                fetchFilteredProducts();
            });


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
                },
                change: function(event, ui) {
                    activeFilters.price_min = ui.values[0];
                    activeFilters.price_max = ui.values[1];
                    fetchFilteredProducts();
                }
            });

            priceFrom.textContent = `$${minPrice}`;
            priceTo.textContent = `$${maxPrice}`;

            // Xử lý sự kiện cho .term-color
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

            // Xử lý sự kiện cho giá

            fetchFilteredProducts = function(page = 1) {
                axios.post('/api/shop/products/filter-catalogies-api', {
                        parent_id: parent_id ? parent_id.value : null,
                        child_id: child_id ? child_id.value : null,
                        attribute_id: activeFilters.color,
                        attribute_storage_value_id: activeFilters.storage,
                        price_min: activeFilters.price_min, // Gửi giá min
                        price_max: activeFilters.price_max, // Gửi giá max
                        orderby: activeFilters.orderby,
                        search: activeFilters.searchProduct,
                        page: page
                    })
                    .then((res) => {
                        const productList = document.getElementById('product-list');
                        productList.innerHTML = ''; // Xóa danh sách cũ

                        const paginationContainer = document.getElementById(
                            'paginationContainer'); // Container chứa các nút phân trang
                        // console.log(products););
                        // return;

                        if (res.data.data.length > 0) {
                            let productsHTML = '';
                            res.data.data.forEach(product => {
                                console.log(product.favorited_by);

                                const isFavorited = product.favorited_by.length > 0;

                                const favoriteIcon = isFavorited ?
                                    `<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EA3323"><path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Z"/></svg>` :
                                    `<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343"><path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/></svg>`;


                                let routeDetail =
                                    `{{ route('client.products.product-detail', ':slug') }}`
                                    .replace(
                                        ':slug', product.slug);

                                productsHTML += `
                        <li class="product-item wow fadeInUp product-item list col-md-12 post-${product.id} product type-product status-publish has-post-thumbnail"
                            data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                            <div class="product-inner images">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#">
                                        ${product.image_url ? `<img class="img-responsive" src="${product.image_url}" alt="${product.name}" width="600" height="778">` : 'Không có ảnh'}
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
                                        <a href="${routeDetail}">${product.name}</a>
                                    </h3>
                                    <span class="price">
                                        <span class="kobolg-Price-amount amount text-danger">
                                            ${
                                                product.discount_price && product.discount_price !== product.price
                                                    ? `
                                                        <del>
                                                            <span class="kobolg-Price-currencySymbol">₫</span>
                                                                ${Number(product.price).toLocaleString(undefined, { minimumFractionDigits: 0, maximumFractionDigits: 2 })}
                                                        </del>
                                                        <span class="kobolg-Price-amount amount old-price">
                                                            <span class="kobolg-Price-currencySymbol">₫</span>
                                                                ${Number(product.discount_price).toLocaleString(undefined, { minimumFractionDigits: 0, maximumFractionDigits: 2 })}
                                                        </span>

                                                    `
                                                    : `
                                                        <span>
                                                            <span class="kobolg-Price-currencySymbol">₫</span>
                                                                ${Number(product.price).toLocaleString(undefined, { minimumFractionDigits: 0, maximumFractionDigits: 2 })}
                                                        </span>
                                                    `
                                            }
                                        </span>
                                    </span>


                                    <div class="kobolg-product-details__short-description">
                                        <p>${product.tomtat}</p>
                                    </div>
                                </div>
                                <div class="group-button">
                                    <div class="group-button-inner">
                                        <div class="add-to-cart">
                                            <a href="#" class="button product_type_variable add_to_cart_button">Thêm vào giỏ hàng </a>
                                        </div>
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button show">
                                                <a href="javascript:void(0)" data-product-id=${product.id} class="add_to_wishlist_customer" style="color:${isFavorited ? 'red' : 'inherit'}">
                                                    ${favoriteIcon} ${isFavorited ? 'Đã yêu thích' : 'Thêm vào yêu thích'}
                                                </a>
                                            </div>
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

                        // Xử lý phân trang
                        const pagination = res.data.pagination;
                        paginationContainer.innerHTML = ''; // Xóa phân trang cũ

                        if (pagination) {
                            // Nút trang trước
                            if (pagination.prev_page_url) {
                                paginationContainer.innerHTML += `
                                    <button onclick="fetchFilteredProducts(${pagination.current_page - 1})"
                                            class="pagination-button">«</button>`;
                            }

                            // Các số trang
                            for (let page = 1; page <= pagination.last_page; page++) {
                                paginationContainer.innerHTML += `
                                    <button onclick="fetchFilteredProducts(${page})"
                                            class="pagination-button ${page === pagination.current_page ? 'active' : ''}">
                                        ${page}
                                    </button>`;
                            }

                            // Nút trang sau
                            if (pagination.next_page_url) {
                                paginationContainer.innerHTML += `
                                    <button onclick="fetchFilteredProducts(${pagination.current_page + 1})"
                                            class="pagination-button">»</button>`;
                            }
                        }

                    })
                    .catch((err) => {
                        console.log(err);
                    });
            }


            document.body.addEventListener('click', function(e) {
                if (e.target.classList.contains('add_to_wishlist_customer')) {
                    const productId = e.target.dataset.productId;
                    console.log(productId);

                    axios.post('/shop/add-product-favorite', {
                            product_id: productId,
                        }, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                            }
                        })
                        .then((res) => {
                            // console.log('123',res);

                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: res.data.success, // Lấy thông báo từ response
                                position: 'top',
                                toast: true,
                                showConfirmButton: false,
                                timer: 3000
                            });

                            // Thay đổi màu nút "Thêm vào yêu thích"
                            if (e.target.style.color === 'red') {
                                e.target.style.color =
                                    'inherit'; // Nếu đã yêu thích, chuyển lại màu mặc định

                                e.target.innerHTML = `  <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343">
                                                    <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/>
                                                </svg> Thêm vào yêu thích`;

                            } else {
                                e.target.style.color = 'red'; // Nếu chưa yêu thích, đổi sang màu đỏ
                                e.target.innerHTML =
                                    `<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EA3323"><path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Z"/></svg>Đã yêu thích`;

                            }

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


        });
    </script>

@endsection

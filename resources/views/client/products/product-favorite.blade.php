@extends('client.master')

@section('title', 'Sản phẩm Yêu Thích')

@section('content')

    @include('components.breadcrumb-client2')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <div class="container mt-3">
        {{-- <h1 class="m-5">Danh sách sản phẩm yêu thích</h1> --}}
        <div class="auto-clear equal-container better-height kobolg-products">
            <ul class="row products columns-3">
                @foreach ($products as $product)
                    {{-- @dd($product->variants) --}}

                    <li class="product-item wow fadeInUp product-item rows-space-30 col-bg-3 col-xl-3 col-lg-4 col-md-6 col-sm-6 col-ts-6 style-01 post-24 product type-product status-publish has-post-thumbnail product_cat-chair product_cat-table product_cat-new-arrivals product_tag-light product_tag-hat product_tag-sock first instock featured shipping-taxable purchasable product-type-variable has-default-attributes"
                        data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                        <div class="product-inner tooltip-left">
                            <div class="product-thumb">
                                <a class="thumb-link" href="#">
                                    <img class="img-responsive"
                                        src="https://static0.xdaimages.com/wordpress/wp-content/uploads/2024/08/acer-predator-helios-14-2024-commerce.png"
                                        alt="Gaming Mouse" width="600" height="778">
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
                                                        name="attribute_pa_color" data-attribute_name="attribute_pa_color"
                                                        data-show_option_none="yes">
                                                        <option data-type="" data-pa_color="" value="">Choose an
                                                            option
                                                        </option>
                                                        <option data-width="30" data-height="30" data-type="color"
                                                            data-pa_color="#3155e2" value="blue" class="attached enabled">
                                                            Blue
                                                        </option>
                                                        <option data-width="30" data-height="30" data-type="color"
                                                            data-pa_color="#49aa51" value="green" class="attached enabled">
                                                            Green
                                                        </option>
                                                        <option data-width="30" data-height="30" data-type="color"
                                                            data-pa_color="#ff63cb" value="pink" class="attached enabled">
                                                            Pink
                                                        </option>
                                                    </select>
                                                    {{-- <div class="data-val attribute-pa_color" data-attributetype="box_style">
                                                        <a class="change-value color" href="#"
                                                            style="background: #3155e2;" data-value="blue"></a><a
                                                            class="change-value color" href="#"
                                                            style="background: #49aa51;" data-value="green"></a><a
                                                            class="change-value color" href="#"
                                                            style="background: #ff63cb;" data-value="pink"></a></div> --}}
                                                    <a class="reset_variations" href="#"
                                                        style="visibility: hidden;">Clear</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                                <div class="group-button">
                                    <div class="yith-wcwl-add-to-wishlist">
                                        <div class="yith-wcwl-add-button show">
                                            <a href="javascript:voi(0)" data-product-id={{ $product->id }}
                                                class="add_to_wishlist remove_to_wishlist">Remove to Wishlist</a>
                                        </div>
                                    </div>
                                    <div class="kobolg product compare-button">
                                        <a href="#" class="compare button">Compare</a>
                                    </div>
                                    <a href="#" class="button yith-wcqv-button">Quick View</a>
                                    <div class="add-to-cart">
                                        <a href="#" class="button product_type_variable add_to_cart_button">Select
                                            options</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-info equal-elem" style="height: 118px;">
                                <h3 class="product-name product_title">
                                    <a href="{{ url('shop/products/chi-tiet', $product->slug) }}">{{ $product->name }}</a>
                                </h3>
                                <div class="rating-wapper nostar">
                                    <div class="star-rating">
                                        <span style="width:{{ $product->ratings_avg * 20 }}%">Rated <strong
                                                class="rating">{{ $product->ratings_avg }}</strong>
                                            out
                                            of
                                            5</span>
                                    </div>
                                    <span class="review">(0)</span>
                                </div>
                                <span class="price"><span class="kobolg-Price-amount amount"><span
                                            class="kobolg-Price-currencySymbol">$</span>{{ $product->discount_price }}</span>
                                    {{-- – <span
                                        class="kobolg-Price-amount amount"><span
                                            class="kobolg-Price-currencySymbol">$</span>{}</span></span> --}}
                            </div>
                        </div>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>

    <script>
        document.body.addEventListener('click', function(e) {
            if (e.target.classList.contains('add_to_wishlist')) {
                const productId = e.target.dataset.productId;
                console.log(productId);

                axios.post('/shop/remove-product-favorite', {
                        product_id: productId,
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                        }
                    })
                    .then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: res.data.success, // Lấy thông báo thành công từ response
                            position: 'top',
                            toast: true,
                            showConfirmButton: false,
                            timer: 3000
                        });

                        // Nếu xóa thành công, có thể thực hiện thêm các thao tác như cập nhật UI (xóa sản phẩm khỏi danh sách)
                        // Ví dụ: loại bỏ sản phẩm khỏi danh sách yêu thích trong UI
                        e.target.closest('.product')
                            .remove(); // Xóa sản phẩm khỏi danh sách (giả sử là sản phẩm có lớp 'product')
                    })
                    .catch((err) => {
                        if (err.response) {
                            // Kiểm tra lỗi từ response của API
                            Swal.fire({
                                icon: 'error',
                                title: 'Có lỗi xảy ra!',
                                text: err.response.data.error, // Lấy thông báo lỗi từ response
                                position: 'top',
                                toast: true,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Có lỗi xảy ra!',
                                text: 'Không thể xóa sản phẩm khỏi yêu thích.',
                                position: 'top',
                                toast: true,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    });
            }
        });
    </script>
@endsection

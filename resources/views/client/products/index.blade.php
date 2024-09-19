@extends('client.master')

@section('title', 'Sản phẩm')

@section('content')

    @include('components.breadcrumb-client')

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
                        <form class="kobolg-ordering" method="get">
                            <select title="product_cat" name="orderby" class="orderby">
                                <option value="menu_order" selected="selected">Default sorting</option>
                                <option value="popularity">Sort by popularity</option>
                                <option value="rating">Sort by average rating</option>
                                <option value="date">Sort by latest</option>
                                <option value="price">Sort by price: low to high</option>
                                <option value="price-desc">Sort by price: high to low</option>
                            </select>
                        </form>
                        <form class="per-page-form">
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
                        </form>
                    </div>
                    <div class=" auto-clear equal-container better-height kobolg-products">
                        <ul class="row products columns-3">
                            <li class="product-item wow fadeInUp product-item list col-md-12 post-24 product type-product status-publish has-post-thumbnail product_cat-chair product_cat-table product_cat-new-arrivals product_tag-light product_tag-hat product_tag-sock first instock featured shipping-taxable purchasable product-type-variable has-default-attributes"
                                data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                                <div class="product-inner images">
                                    <div class="product-thumb">
                                        <a class="thumb-link" href="#">
                                            <img class="img-responsive" src="{{ asset('theme/client/assets/images/apro161-1-600x778.jpg') }}"
                                                alt="Gaming Mouse" width="600" height="778">
                                        </a>
                                        <div class="flash">
                                            <span class="onnew"><span class="text">New</span></span>
                                        </div>
                                        <form class="variations_form cart" method="post" enctype="multipart/form-data">
                                            <table class="variations">
                                                <tbody>
                                                    <tr>
                                                        <td class="value">
                                                            <select title="box_style" data-attributetype="box_style"
                                                                data-id="pa_color" class="attribute-select "
                                                                name="attribute_pa_color"
                                                                data-attribute_name="attribute_pa_color"
                                                                data-show_option_none="yes">
                                                                <option data-type="" data-pa_color="" value="">
                                                                    Choose an
                                                                    option
                                                                </option>
                                                                <option data-width="30" data-height="30" data-type="color"
                                                                    data-pa_color="#3155e2" value="blue"
                                                                    class="attached enabled">Blue
                                                                </option>
                                                                <option data-width="30" data-height="30" data-type="color"
                                                                    data-pa_color="#49aa51" value="green"
                                                                    class="attached enabled">Green
                                                                </option>
                                                                <option data-width="30" data-height="30" data-type="color"
                                                                    data-pa_color="#ff63cb" value="pink"
                                                                    class="attached enabled">Pink
                                                                </option>
                                                            </select>
                                                            <div class="data-val attribute-pa_color"
                                                                data-attributetype="box_style"><a class="change-value color"
                                                                    href="#" style="background: #3155e2;"
                                                                    data-value="blue"></a><a class="change-value color"
                                                                    href="#" style="background: #49aa51;"
                                                                    data-value="green"></a><a class="change-value color"
                                                                    href="#" style="background: #ff63cb;"
                                                                    data-value="pink"></a></div>
                                                            <a class="reset_variations" href="#"
                                                                style="visibility: hidden;">Clear</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </form>
                                        <a href="#" class="button yith-wcqv-button" data-product_id="24">Quick
                                            View</a>
                                    </div>
                                    <div class="product-info">
                                        <div class="rating-wapper nostar">
                                            <div class="star-rating"><span style="width:0%">Rated <strong
                                                        class="rating">0</strong> out of 5</span></div>
                                            <span class="review">(0)</span>
                                        </div>
                                        <h3 class="product-name product_title">
                                            <a href="#">Gaming Mouse</a>
                                        </h3>
                                        <span class="price"><span class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>45.00</span> – <span
                                                class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>54.00</span></span>
                                        <div class="kobolg-product-details__short-description">
                                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac
                                                turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget,
                                                tempor sit amet, ante.</p>
                                            <ul>
                                                <li>Water-resistant fabric with soft lycra detailing inside</li>
                                                <li>CLean zip-front, and three piece hood</li>
                                                <li>Subtle branding and diagonal panel detail</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="group-button">
                                        <div class="group-button-inner">
                                            <div class="add-to-cart">
                                                <a href="#"
                                                    class="button product_type_variable add_to_cart_button">Select
                                                    options</a>
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
                            <li class="product-item wow fadeInUp product-item list col-md-12 post-28 product type-product status-publish has-post-thumbnail product_cat-light product_cat-chair product_cat-sofas product_tag-light product_tag-sock  instock sale featured shipping-taxable purchasable product-type-simple"
                                data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                                <div class="product-inner images">
                                    <div class="product-thumb">
                                        <a class="thumb-link" href="#">
                                            <img class="img-responsive" src="{{ asset('theme/client/assets/images/apro1211-2-600x778.jpg') }}"
                                                alt="Modern Watches" width="600" height="778">
                                        </a>
                                        <div class="flash">
                                            <span class="onsale"><span class="number">-14%</span></span>
                                            <span class="onnew"><span class="text">New</span></span>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button" data-product_id="28">Quick
                                            View</a>
                                    </div>
                                    <div class="product-info">
                                        <div class="rating-wapper ">
                                            <div class="star-rating"><span style="width:100%">Rated <strong
                                                        class="rating">5.00</strong> out of 5</span>
                                            </div>
                                            <span class="review">(1)</span>
                                        </div>
                                        <h3 class="product-name product_title">
                                            <a href="#">Modern Watches</a>
                                        </h3>
                                        <span class="price"><del><span class="kobolg-Price-amount amount"><span
                                                        class="kobolg-Price-currencySymbol">$</span>138.00</span></del>
                                            <ins><span class="kobolg-Price-amount amount"><span
                                                        class="kobolg-Price-currencySymbol">$</span>119.00</span></ins></span>
                                        <div class="kobolg-product-details__short-description">
                                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac
                                                turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget,
                                                tempor sit amet, ante.</p>
                                            <ul>
                                                <li>Water-resistant fabric with soft lycra detailing inside</li>
                                                <li>CLean zip-front, and three piece hood</li>
                                                <li>Subtle branding and diagonal panel detail</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="group-button">
                                        <div class="group-button-inner">
                                            <div class="add-to-cart">
                                                <a href="#"
                                                    class="button product_type_simple add_to_cart_button ajax_add_to_cart">Add
                                                    to cart</a>
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
                            <li class="product-item wow fadeInUp product-item list col-md-12 post-30 product type-product status-publish has-post-thumbnail product_cat-light product_cat-bed product_cat-specials product_tag-light product_tag-table product_tag-sock last instock featured downloadable shipping-taxable purchasable product-type-simple"
                                data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                                <div class="product-inner images">
                                    <div class="product-thumb">
                                        <a class="thumb-link" href="#">
                                            <img class="img-responsive" src="{{ asset('theme/client/assets/images/apro101-1-600x778.jpg') }}"
                                                alt="Mac 27 Inch" width="600" height="778">
                                        </a>
                                        <div class="flash">
                                            <span class="onnew"><span class="text">New</span></span>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button" data-product_id="30">Quick
                                            View</a>
                                    </div>
                                    <div class="product-info">
                                        <div class="rating-wapper nostar">
                                            <div class="star-rating"><span style="width:0%">Rated <strong
                                                        class="rating">0</strong> out of 5</span></div>
                                            <span class="review">(0)</span>
                                        </div>
                                        <h3 class="product-name product_title">
                                            <a href="#">Mac 27 Inch</a>
                                        </h3>
                                        <span class="price"><span class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>60.00</span></span>
                                        <div class="kobolg-product-details__short-description">
                                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac
                                                turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget,
                                                tempor sit amet, ante.</p>
                                            <ul>
                                                <li>Water-resistant fabric with soft lycra detailing inside</li>
                                                <li>CLean zip-front, and three piece hood</li>
                                                <li>Subtle branding and diagonal panel detail</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="group-button">
                                        <div class="group-button-inner">
                                            <div class="add-to-cart">
                                                <a href="#"
                                                    class="button product_type_simple add_to_cart_button ajax_add_to_cart">Add
                                                    to cart</a>
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
                            <li class="product-item wow fadeInUp product-item list col-md-12 post-23 product type-product status-publish has-post-thumbnail product_cat-chair product_cat-lamp product_cat-sofas product_tag-hat first instock shipping-taxable purchasable product-type-variable has-default-attributes"
                                data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                                <div class="product-inner images">
                                    <div class="product-thumb">
                                        <a class="thumb-link" href="#">
                                            <img class="img-responsive" src="{{ asset('theme/client/assets/images/apro171-1-600x778.jpg') }}"
                                                alt="Photo Camera" width="600" height="778">
                                        </a>
                                        <div class="flash">
                                            <span class="onnew"><span class="text">New</span></span>
                                        </div>
                                        <form class="variations_form cart" method="post" enctype="multipart/form-data">
                                            <table class="variations">
                                                <tbody>
                                                    <tr>
                                                        <td class="value">
                                                            <select title="box_style" data-attributetype="box_style"
                                                                data-id="pa_color" class="attribute-select "
                                                                name="attribute_pa_color"
                                                                data-attribute_name="attribute_pa_color"
                                                                data-show_option_none="yes">
                                                                <option data-type="" data-pa_color="" value="">
                                                                    Choose an
                                                                    option
                                                                </option>
                                                                <option data-width="30" data-height="30"
                                                                    data-type="color" data-pa_color="#ff63cb"
                                                                    value="pink" class="attached enabled">Pink
                                                                </option>
                                                                <option data-width="30" data-height="30"
                                                                    data-type="color" data-pa_color="#a825ea"
                                                                    value="purple" class="attached enabled">Purple
                                                                </option>
                                                                <option data-width="30" data-height="30"
                                                                    data-type="color" data-pa_color="#db2b00"
                                                                    value="red" class="attached enabled">Red
                                                                </option>
                                                            </select>
                                                            <div class="data-val attribute-pa_color"
                                                                data-attributetype="box_style"><a
                                                                    class="change-value color" href="#"
                                                                    style="background: #ff63cb;" data-value="pink"></a><a
                                                                    class="change-value color" href="#"
                                                                    style="background: #a825ea;"
                                                                    data-value="purple"></a><a class="change-value color"
                                                                    href="#" style="background: #db2b00;"
                                                                    data-value="red"></a></div>
                                                            <a class="reset_variations" href="#"
                                                                style="visibility: hidden;">Clear</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </form>
                                        <a href="#" class="button yith-wcqv-button" data-product_id="23">Quick
                                            View</a>
                                    </div>
                                    <div class="product-info">
                                        <div class="rating-wapper nostar">
                                            <div class="star-rating"><span style="width:0%">Rated <strong
                                                        class="rating">0</strong> out of 5</span></div>
                                            <span class="review">(0)</span>
                                        </div>
                                        <h3 class="product-name product_title">
                                            <a href="#">Photo Camera</a>
                                        </h3>
                                        <span class="price"><span class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>105.00</span> – <span
                                                class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>110.00</span></span>
                                        <div class="kobolg-product-details__short-description">
                                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac
                                                turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget,
                                                tempor sit amet, ante.</p>
                                            <ul>
                                                <li>Water-resistant fabric with soft lycra detailing inside</li>
                                                <li>CLean zip-front, and three piece hood</li>
                                                <li>Subtle branding and diagonal panel detail</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="group-button">
                                        <div class="group-button-inner">
                                            <div class="add-to-cart">
                                                <a href="#"
                                                    class="button product_type_variable add_to_cart_button ajax_add_to_cart">Select
                                                    options</a>
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
                            <li class="product-item wow fadeInUp product-item list col-md-12 post-35 product type-product status-publish has-post-thumbnail product_cat-chair product_cat-new-arrivals product_cat-lamp product_tag-light product_tag-hat product_tag-sock  instock shipping-taxable purchasable product-type-simple"
                                data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                                <div class="product-inner images">
                                    <div class="product-thumb">
                                        <a class="thumb-link" href="#">
                                            <img class="img-responsive" src="{{ asset('theme/client/assets/images/apro41-1-600x778.jpg') }}"
                                                alt="White Watches" width="600" height="778">
                                        </a>
                                        <div class="flash">
                                            <span class="onnew"><span class="text">New</span></span>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button" data-product_id="35">Quick
                                            View</a>
                                    </div>
                                    <div class="product-info">
                                        <div class="rating-wapper nostar">
                                            <div class="star-rating"><span style="width:0%">Rated <strong
                                                        class="rating">0</strong> out of 5</span></div>
                                            <span class="review">(0)</span>
                                        </div>
                                        <h3 class="product-name product_title">
                                            <a href="#">White Watches</a>
                                        </h3>
                                        <span class="price"><span class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>134.00</span></span>
                                        <div class="kobolg-product-details__short-description">
                                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac
                                                turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget,
                                                tempor sit amet, ante.</p>
                                            <ul>
                                                <li>Water-resistant fabric with soft lycra detailing inside</li>
                                                <li>CLean zip-front, and three piece hood</li>
                                                <li>Subtle branding and diagonal panel detail</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="group-button">
                                        <div class="group-button-inner">
                                            <div class="add-to-cart">
                                                <a href="#"
                                                    class="button product_type_simple add_to_cart_button ajax_add_to_cart">Add
                                                    to cart</a>
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
                            <li class="product-item wow fadeInUp product-item list col-md-12 post-22 product type-product status-publish has-post-thumbnail product_cat-table product_cat-bed product_cat-lamp product_tag-table product_tag-hat product_tag-sock last instock featured downloadable shipping-taxable purchasable product-type-simple"
                                data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                                <div class="product-inner images">
                                    <div class="product-thumb">
                                        <a class="thumb-link" href="#">
                                            <img class="img-responsive" src="{{ asset('theme/client/assets/images/apro181-2-600x778.jpg') }}"
                                                alt="Red Mouse" width="600" height="778">
                                        </a>
                                        <div class="flash">
                                            <span class="onnew"><span class="text">New</span></span>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button" data-product_id="22">Quick
                                            View</a>
                                    </div>
                                    <div class="product-info">
                                        <div class="rating-wapper nostar">
                                            <div class="star-rating"><span style="width:0%">Rated <strong
                                                        class="rating">0</strong> out of 5</span></div>
                                            <span class="review">(0)</span>
                                        </div>
                                        <h3 class="product-name product_title">
                                            <a href="#">Red Mouse</a>
                                        </h3>
                                        <span class="price"><span class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>98.00</span></span>
                                        <div class="kobolg-product-details__short-description">
                                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac
                                                turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget,
                                                tempor sit amet, ante.</p>
                                            <ul>
                                                <li>Water-resistant fabric with soft lycra detailing inside</li>
                                                <li>CLean zip-front, and three piece hood</li>
                                                <li>Subtle branding and diagonal panel detail</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="group-button">
                                        <div class="group-button-inner">
                                            <div class="add-to-cart">
                                                <a href="#"
                                                    class="button product_type_simple add_to_cart_button ajax_add_to_cart">Add
                                                    to cart</a>
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
                            <li class="product-item wow fadeInUp product-item list col-md-12 post-33 product type-product status-publish has-post-thumbnail product_cat-chair product_cat-table product_cat-lamp product_tag-light product_tag-table product_tag-hat first instock shipping-taxable purchasable product-type-variable has-default-attributes"
                                data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                                <div class="product-inner images">
                                    <div class="product-thumb">
                                        <a class="thumb-link" href="#">
                                            <img class="img-responsive" src="{{ asset('theme/client/assets/images/apro83-1-600x778.jpg') }}"
                                                alt="Glasses" width="600" height="778">
                                        </a>
                                        <div class="flash">
                                            <span class="onnew"><span class="text">New</span></span>
                                        </div>
                                        <form class="variations_form cart" method="post" enctype="multipart/form-data">
                                            <table class="variations">
                                                <tbody>
                                                    <tr>
                                                        <td class="value">
                                                            <select title="box_style" data-attributetype="box_style"
                                                                data-id="pa_color" class="attribute-select "
                                                                name="attribute_pa_color"
                                                                data-attribute_name="attribute_pa_color"
                                                                data-show_option_none="yes">
                                                                <option data-type="" data-pa_color="" value="">
                                                                    Choose an
                                                                    option
                                                                </option>
                                                                <option data-width="30" data-height="30"
                                                                    data-type="color" data-pa_color="#000000"
                                                                    value="black" class="attached enabled">Black
                                                                </option>
                                                                <option data-width="30" data-height="30"
                                                                    data-type="color" data-pa_color="#db2b00"
                                                                    value="red" class="attached enabled">Red
                                                                </option>
                                                            </select>
                                                            <div class="data-val attribute-pa_color"
                                                                data-attributetype="box_style"><a
                                                                    class="change-value color" href="#"
                                                                    style="background: #000000;" data-value="black"></a><a
                                                                    class="change-value color" href="#"
                                                                    style="background: #db2b00;" data-value="red"></a>
                                                            </div>
                                                            <a class="reset_variations" href="#"
                                                                style="visibility: hidden;">Clear</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </form>
                                        <a href="#" class="button yith-wcqv-button" data-product_id="33">Quick
                                            View</a>
                                    </div>
                                    <div class="product-info">
                                        <div class="rating-wapper nostar">
                                            <div class="star-rating"><span style="width:0%">Rated <strong
                                                        class="rating">0</strong> out of 5</span></div>
                                            <span class="review">(0)</span>
                                        </div>
                                        <h3 class="product-name product_title">
                                            <a href="#">Modern Headphone</a>
                                        </h3>
                                        <span class="price"><span class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>56.00</span> – <span
                                                class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>60.00</span></span>
                                        <div class="kobolg-product-details__short-description">
                                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac
                                                turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget,
                                                tempor sit amet, ante.</p>
                                            <ul>
                                                <li>Water-resistant fabric with soft lycra detailing inside</li>
                                                <li>CLean zip-front, and three piece hood</li>
                                                <li>Subtle branding and diagonal panel detail</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="group-button">
                                        <div class="group-button-inner">
                                            <div class="add-to-cart">
                                                <a href="#"
                                                    class="button product_type_simple add_to_cart_button ajax_add_to_cart">Select
                                                    options</a>
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
                            <li class="product-item wow fadeInUp product-item list col-md-12 post-26 product type-product status-publish has-post-thumbnail product_cat-light product_cat-chair product_cat-sofas product_tag-light product_tag-hat  instock featured shipping-taxable product-type-external"
                                data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                                <div class="product-inner images">
                                    <div class="product-thumb">
                                        <a class="thumb-link" href="#">
                                            <img class="img-responsive" src="{{ asset('theme/client/assets/images/apro141-1-600x778.jpg') }}"
                                                alt="Smart Monitor" width="600" height="778">
                                        </a>
                                        <div class="flash">
                                            <span class="onnew"><span class="text">New</span></span>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button" data-product_id="26">Quick
                                            View</a>
                                    </div>
                                    <div class="product-info">
                                        <div class="rating-wapper ">
                                            <div class="star-rating"><span style="width:100%">Rated <strong
                                                        class="rating">5.00</strong> out of 5</span>
                                            </div>
                                            <span class="review">(1)</span>
                                        </div>
                                        <h3 class="product-name product_title">
                                            <a href="#">Smart Monitor</a>
                                        </h3>
                                        <span class="price"><span class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>207.00</span></span>
                                        <div class="kobolg-product-details__short-description">
                                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac
                                                turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget,
                                                tempor sit amet, ante.</p>
                                            <ul>
                                                <li>Water-resistant fabric with soft lycra detailing inside</li>
                                                <li>CLean zip-front, and three piece hood</li>
                                                <li>Subtle branding and diagonal panel detail</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="group-button">
                                        <div class="group-button-inner">
                                            <div class="add-to-cart">
                                                <a href="#"
                                                    class="button product_type_external add_to_cart_button ajax_add_to_cart">Buy
                                                    it on Amazon</a>
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
                            <li class="product-item wow fadeInUp product-item list col-md-12 post-34 product type-product status-publish has-post-thumbnail product_cat-light product_cat-new-arrivals product_tag-light product_tag-hat product_tag-sock last instock sale featured shipping-taxable product-type-grouped"
                                data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                                <div class="product-inner images">
                                    <div class="product-thumb">
                                        <a class="thumb-link" href="#">
                                            <img class="img-responsive" src="{{ asset('theme/client/assets/images/apro61-1-600x778.jpg') }}"
                                                alt="Black Watches" width="600" height="778">
                                        </a>
                                        <div class="flash">
                                            <span class="onnew"><span class="text">New</span></span>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button" data-product_id="34">Quick
                                            View</a>
                                    </div>
                                    <div class="product-info">
                                        <div class="rating-wapper nostar">
                                            <div class="star-rating"><span style="width:0%">Rated <strong
                                                        class="rating">0</strong> out of 5</span></div>
                                            <span class="review">(0)</span>
                                        </div>
                                        <h3 class="product-name product_title">
                                            <a href="#">Black Watches</a>
                                        </h3>
                                        <span class="price"><span class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>79.00</span> – <span
                                                class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>139.00</span></span>
                                        <div class="kobolg-product-details__short-description">
                                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac
                                                turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget,
                                                tempor sit amet, ante.</p>
                                            <ul>
                                                <li>Water-resistant fabric with soft lycra detailing inside</li>
                                                <li>CLean zip-front, and three piece hood</li>
                                                <li>Subtle branding and diagonal panel detail</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="group-button">
                                        <div class="group-button-inner">
                                            <div class="add-to-cart">
                                                <a href="#"
                                                    class="button product_type_grouped add_to_cart_button ajax_add_to_cart">View
                                                    products</a>
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
                            <li class="product-item wow fadeInUp product-item list col-md-12 post-32 product type-product status-publish has-post-thumbnail product_cat-light product_cat-chair product_cat-sofas product_tag-hat product_tag-sock first instock sale featured shipping-taxable purchasable product-type-simple"
                                data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                                <div class="product-inner images">
                                    <div class="product-thumb">
                                        <a class="thumb-link" href="#">
                                            <img class="img-responsive" src="{{ asset('theme/client/assets/images/apro71-1-600x778.jpg') }}"
                                                alt="Gaming Mouse" width="600" height="778">
                                        </a>
                                        <div class="flash">
                                            <span class="onsale"><span class="number">-18%</span></span>
                                            <span class="onnew"><span class="text">New</span></span>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button" data-product_id="32">Quick
                                            View</a>
                                    </div>
                                    <div class="product-info">
                                        <div class="rating-wapper nostar">
                                            <div class="star-rating"><span style="width:0%">Rated <strong
                                                        class="rating">0</strong> out of 5</span></div>
                                            <span class="review">(0)</span>
                                        </div>
                                        <h3 class="product-name product_title">
                                            <a href="#">Gaming Mouse</a>
                                        </h3>
                                        <span class="price"><del><span class="kobolg-Price-amount amount"><span
                                                        class="kobolg-Price-currencySymbol">$</span>109.00</span></del>
                                            <ins><span class="kobolg-Price-amount amount"><span
                                                        class="kobolg-Price-currencySymbol">$</span>89.00</span></ins></span>
                                        <div class="kobolg-product-details__short-description">
                                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac
                                                turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget,
                                                tempor sit amet, ante.</p>
                                            <ul>
                                                <li>Water-resistant fabric with soft lycra detailing inside</li>
                                                <li>CLean zip-front, and three piece hood</li>
                                                <li>Subtle branding and diagonal panel detail</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="group-button">
                                        <div class="group-button-inner">
                                            <div class="add-to-cart">
                                                <a href="#"
                                                    class="button product_type_simple add_to_cart_button ajax_add_to_cart">Add
                                                    to cart</a>
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
                            <li class="product-item wow fadeInUp product-item list col-md-12 post-21 product type-product status-publish has-post-thumbnail product_cat-light product_cat-bed product_cat-lamp product_tag-light product_tag-sock  outofstock featured shipping-taxable purchasable product-type-simple"
                                data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                                <div class="product-inner images">
                                    <div class="product-thumb">
                                        <a class="thumb-link" href="#">
                                            <img class="img-responsive" src="{{ asset('theme/client/assets/images/apro191-1-600x778.jpg') }}"
                                                alt="Pink Headphone                                                  "
                                                width="600" height="778">
                                        </a>
                                        <div class="flash">
                                            <span class="sold-out"><span>Sold out</span></span>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button" data-product_id="21">Quick
                                            View</a>
                                    </div>
                                    <div class="product-info">
                                        <div class="rating-wapper nostar">
                                            <div class="star-rating"><span style="width:0%">Rated <strong
                                                        class="rating">0</strong> out of 5</span></div>
                                            <span class="review">(0)</span>
                                        </div>
                                        <h3 class="product-name product_title">
                                            <a href="#">Pink Headphone </a>
                                        </h3>
                                        <span class="price"><span class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>35.00</span></span>
                                        <div class="kobolg-product-details__short-description">
                                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac
                                                turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget,
                                                tempor sit amet, ante.</p>
                                            <ul>
                                                <li>Water-resistant fabric with soft lycra detailing inside</li>
                                                <li>CLean zip-front, and three piece hood</li>
                                                <li>Subtle branding and diagonal panel detail</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="group-button">
                                        <div class="group-button-inner">
                                            <div class="add-to-cart">
                                                <a href="#"
                                                    class="button product_type_simple add_to_cart_button ajax_add_to_cart">Read
                                                    more</a>
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
                            <li class="product-item wow fadeInUp product-item list col-md-12 post-93 product type-product status-publish has-post-thumbnail product_cat-light product_cat-table product_cat-new-arrivals product_tag-table product_tag-sock last instock shipping-taxable purchasable product-type-simple"
                                data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                                <div class="product-inner images">
                                    <div class="product-thumb">
                                        <a class="thumb-link" href="#">
                                            <img class="img-responsive" src="{{ asset('theme/client/assets/images/apro13-1-600x778.jpg') }}"
                                                alt="Meta Watches                                                "
                                                width="600" height="778">
                                        </a>
                                        <div class="flash">
                                            <span class="onnew"><span class="text">New</span></span>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button" data-product_id="93">Quick
                                            View</a>
                                    </div>
                                    <div class="product-info">
                                        <div class="rating-wapper nostar">
                                            <div class="star-rating"><span style="width:0%">Rated <strong
                                                        class="rating">0</strong> out of 5</span></div>
                                            <span class="review">(0)</span>
                                        </div>
                                        <h3 class="product-name product_title">
                                            <a href="#">Meta Watches </a>
                                        </h3>
                                        <span class="price"><span class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>109.00</span></span>
                                        <div class="kobolg-product-details__short-description">
                                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac
                                                turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget,
                                                tempor sit amet, ante.</p>
                                            <ul>
                                                <li>Water-resistant fabric with soft lycra detailing inside</li>
                                                <li>CLean zip-front, and three piece hood</li>
                                                <li>Subtle branding and diagonal panel detail</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="group-button">
                                        <div class="group-button-inner">
                                            <div class="add-to-cart">
                                                <a href="#"
                                                    class="button product_type_simple add_to_cart_button ajax_add_to_cart">Add
                                                    to cart</a>
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
                        </ul>
                    </div>
                    <div class="shop-control shop-after-control">
                        <nav class="kobolg-pagination">
                            <span class="page-numbers current">1</span>
                            <a class="page-numbers" href="#">2</a>
                            <a class="next page-numbers" href="#">Next</a>
                        </nav>
                        <p class="kobolg-result-count">Showing 1–12 of 20 results</p>
                    </div>
                </div>
                <div class="sidebar col-xl-3 col-lg-4 col-md-4 col-sm-12">
                    <div id="widget-area" class="widget-area shop-sidebar">
                        <div id="kobolg_product_search-2" class="widget kobolg widget_product_search">
                            <form class="kobolg-product-search">
                                <input id="kobolg-product-search-field-0" class="search-field"
                                    placeholder="Search products…" value="" name="s" type="search">
                                <button type="submit" value="Search">Search</button>
                            </form>
                        </div>
                        <div id="kobolg_price_filter-2" class="widget kobolg widget_price_filter">
                            <h2 class="widgettitle">Filter By Price<span class="arrow"></span></h2>
                            <form method="get" action="#">
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
                            </form>
                        </div>
                        <div id="kobolg_kobolg_layered_nav-4" class="widget kobolg_widget_layered_nav widget_layered_nav">
                            <h2 class="widgettitle">Filter By Color<span class="arrow"></span></h2>
                            <div class="color-group">
                                <a class="term-color " href="#">
                                    <i style="color: #000000"></i>
                                    <span class="term-name">Black</span>
                                    <span class="count">(4)</span> </a>
                                <a class="term-color " href="#">
                                    <i style="color: #3155e2"></i>
                                    <span class="term-name">Blue</span>
                                    <span class="count">(3)</span> </a>
                                <a class="term-color " href="#">
                                    <i style="color: #49aa51"></i>
                                    <span class="term-name">Green</span>
                                    <span class="count">(1)</span> </a>
                                <a class="term-color " href="#">
                                    <i style="color: #ff63cb"></i>
                                    <span class="term-name">Pink</span>
                                    <span class="count">(3)</span> </a>
                                <a class="term-color " href="#">
                                    <i style="color: #a825ea"></i>
                                    <span class="term-name">Purple</span>
                                    <span class="count">(1)</span> </a>
                                <a class="term-color " href="#">
                                    <i style="color: #db2b00"></i>
                                    <span class="term-name">Red</span>
                                    <span class="count">(5)</span> </a>
                                <a class="term-color " href="#">
                                    <i style="color: #FFFFFF"></i>
                                    <span class="term-name">White</span>
                                    <span class="count">(2)</span> </a>
                                <a class="term-color " href="#s">
                                    <i style="color: #e8e120"></i>
                                    <span class="term-name">Yellow</span>
                                    <span class="count">(2)</span> </a>
                            </div>
                        </div>
                        <div id="kobolg_layered_nav-6" class="widget kobolg widget_layered_nav kobolg-widget-layered-nav">
                            <h2 class="widgettitle">Filter By Size<span class="arrow"></span></h2>
                            <ul class="kobolg-widget-layered-nav-list">
                                <li class="kobolg-widget-layered-nav-list__item kobolg-layered-nav-term ">
                                    <a rel="nofollow" href="#">XS</a>
                                    <span class="count">(1)</span>
                                </li>
                                <li class="kobolg-widget-layered-nav-list__item kobolg-layered-nav-term ">
                                    <a rel="nofollow" href="#">S</a>
                                    <span class="count">(4)</span>
                                </li>
                                <li class="kobolg-widget-layered-nav-list__item kobolg-layered-nav-term ">
                                    <a rel="nofollow" href="#">M</a>
                                    <span class="count">(2)</span>
                                </li>
                                <li class="kobolg-widget-layered-nav-list__item kobolg-layered-nav-term ">
                                    <a rel="nofollow" href="#">L</a>
                                    <span class="count">(3)</span>
                                </li>
                                <li class="kobolg-widget-layered-nav-list__item kobolg-layered-nav-term ">
                                    <a rel="nofollow" href="#">XL</a>
                                    <span class="count">(1)</span>
                                </li>
                                <li class="kobolg-widget-layered-nav-list__item kobolg-layered-nav-term ">
                                    <a rel="nofollow" href="#">XXL</a>
                                    <span class="count">(4)</span>
                                </li>
                                <li class="kobolg-widget-layered-nav-list__item kobolg-layered-nav-term ">
                                    <a rel="nofollow" href="#">3XL</a>
                                    <span class="count">(4)</span>
                                </li>
                                <li class="kobolg-widget-layered-nav-list__item kobolg-layered-nav-term ">
                                    <a rel="nofollow" href="#">4XL</a>
                                    <span class="count">(3)</span>
                                </li>
                            </ul>
                        </div>
                        <div id="kobolg_product_categories-3" class="widget kobolg widget_product_categories">
                            <h2 class="widgettitle">Product categories<span class="arrow"></span></h2>
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

@extends('client.master')

@section('title', 'Liên Hệ')

@section('content')
<main class="site-main main-container no-sidebar">
    <div class="container">
        <div class="row">
            <div class="main-content col-md-12">
                <div class="page-main-content">
                    <div class="kobolg">
                        <div class="kobolg-notices-wrapper"></div>
                        <div class="checkout-before-top">
                            <div class="kobolg-checkout-login">
                                <div class="kobolg-form-login-toggle">
                                    <div class="kobolg-info">
                                        Khách hàng quay lại? <a href="#" class="showlogin">Nhấp vào đây để đăng nhập</a>
                                    </div>
                                </div>
                                <form class="kobolg-form kobolg-form-login login" method="post" style="display:none;">
                                    <p>Nếu bạn đã mua sắm với chúng tôi trước đây, vui lòng nhập thông tin của bạn dưới đây. Nếu bạn là khách hàng mới, hãy tiếp tục đến phần Thanh toán & Giao hàng.</p>
                                    <p class="form-row form-row-first">
                                        <label for="username">Tên người dùng hoặc email&nbsp;<span class="required">*</span></label>
                                        <input type="text" class="input-text" name="username" id="username" autocomplete="username">
                                    </p>
                                    <p class="form-row form-row-last">
                                        <label for="password">Mật khẩu&nbsp;<span class="required">*</span></label>
                                        <input class="input-text" type="password" name="password" id="password" autocomplete="current-password">
                                    </p>
                                    <div class="clear"></div>
                                    <p class="form-row">
                                        <input type="hidden" id="kobolg-login-nonce" name="kobolg-login-nonce" value="832993cb93">
                                        <input type="hidden" name="_wp_http_referer" value="/kobolg/checkout/">
                                        <button type="submit" class="button" name="login" value="Login">Đăng nhập</button>
                                        <label class="kobolg-form__label kobolg-form__label-for-checkbox inline">
                                            <input class="kobolg-form__input kobolg-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever">
                                            <span>Nhớ tôi</span>
                                        </label>
                                    </p>
                                    <p class="lost_password">
                                        <a href="#">Quên mật khẩu?</a>
                                    </p>
                                    <div class="clear"></div>
                                </form>
                            </div>
                            <div class="kobolg-checkout-coupon">
                                <div class="kobolg-notices-wrapper"></div>
                                <div class="kobolg-form-coupon-toggle">
                                    <div class="kobolg-info">
                                        Bạn có mã giảm giá? <a href="#" class="showcoupon">Nhấp vào đây để nhập mã của bạn</a>
                                    </div>
                                </div>
                                <form class="checkout_coupon kobolg-form-coupon" method="post" style="display:none">
                                    <p>Nếu bạn có mã giảm giá, vui lòng áp dụng nó bên dưới.</p>
                                    <p class="form-row form-row-first">
                                        <input type="text" name="coupon_code" class="input-text" placeholder="Mã giảm giá" id="coupon_code" value="">
                                    </p>
                                    <p class="form-row form-row-last">
                                        <button type="submit" class="button" name="apply_coupon" value="Apply coupon">Áp dụng mã giảm giá</button>
                                    </p>
                                    <div class="clear"></div>
                                </form>
                            </div>
                        </div>
                        <form name="checkout" method="post" class="checkout kobolg-checkout" action="#" enctype="multipart/form-data" novalidate="novalidate">
                            <div class="col2-set" id="customer_details">
                                <div class="col-1">
                                    <div class="kobolg-billing-fields">
                                        <h3>Thông tin thanh toán</h3>
                                        <div class="kobolg-billing-fields__field-wrapper">
                                            <p class="form-row form-row-first validate-required" id="billing_first_name_field" data-priority="10">
                                                <label for="billing_first_name" class="">Họ và tên&nbsp;<abbr class="required" title="required">*</abbr></label>
                                                <span class="kobolg-input-wrapper"><input type="text" class="input-text " autocomplete="given-name"></span>
                                            </p>
                                            <p class="form-row form-row-wide addresses-field validate-required" id="billing_addresses_1_field" data-priority="50">
                                                <label for="billing_addresses_1" class="">Địa chỉ&nbsp;<abbr class="required" title="required">*</abbr></label>
                                                <span class="kobolg-input-wrapper"><input type="text" class="input-text " name="billing_addresses_1" id="billing_addresses_1" placeholder="Số nhà và tên đường" data-placeholder="Số nhà và tên đường"></span>
                                            </p>
                                            <p class="form-row form-row-wide validate-required validate-phone" id="billing_phone_field" data-priority="100">
                                                <label for="billing_phone" class="">Số điện thoại&nbsp;<abbr class="required" title="required">*</abbr></label>
                                                <span class="kobolg-input-wrapper"><input type="tel" class="input-text " name="billing_phone" id="billing_phone" placeholder="" value="" autocomplete="tel"></span>
                                            </p>
                                            <p class="form-row form-row-wide validate-required validate-email" id="billing_email_field" data-priority="110">
                                                <label for="billing_email" class="">Email&nbsp;<abbr class="required" title="required">*</abbr></label>
                                                <span class="kobolg-input-wrapper"><input type="email" class="input-text " name="billing_email" id="billing_email" placeholder="" value="" autocomplete="email username"></span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="kobolg-account-fields">
                                        <p class="form-row form-row-wide create-account kobolg-validated">
                                            <label class="kobolg-form__label kobolg-form__label-for-checkbox checkbox">
                                                <input class="kobolg-form__input kobolg-form__input-checkbox input-checkbox" id="createaccount" type="checkbox" name="createaccount" value="1"> <span>Tạo tài khoản?</span>
                                            </label>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="kobolg-additional-fields">
                                        <h3>Thông tin bổ sung</h3>
                                        <div class="kobolg-additional-fields__field-wrapper">
                                            <p class="form-row notes" id="order_comments_field" data-priority="">
                                                <label for="order_comments" class="">Ghi chú đơn hàng&nbsp;<span class="optional">(tùy chọn)</span></label>
                                                <span class="kobolg-input-wrapper">
                                                    <textarea name="order_comments" class="input-text " id="order_comments" placeholder="Ghi chú về đơn hàng của bạn, ví dụ: ghi chú đặc biệt cho giao hàng." rows="2" cols="5"></textarea>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h3 id="order_review_heading">Đơn hàng của bạn</h3>
                            <div id="order_review" class="kobolg-checkout-review-order">
                                <table class="shop_table kobolg-checkout-review-order-table">
                                    <thead>
                                        <tr>
                                            <th class="product-name">Sản phẩm</th>
                                            <th class="product-total">Tổng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $product): ?>
                                            <tr class="cart_item">
                                                <td class="product-name">
                                                    <?= htmlspecialchars($product['name']) ?>
                                                    <strong class="product-quantity">× <?= $product['quantity'] ?></strong>
                                                </td>
                                                <td class="product-total">
                                                    <span class="kobolg-Price-amount amount">
                                                        <span class="kobolg-Price-currencySymbol">$</span>
                                                        <?= number_format($product['price'] * $product['quantity'], 2) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>

                                    <tfoot>
                                        <tr class="cart-subtotal">
                                            <th>Tổng phụ</th>
                                            <td><span class="kobolg-Price-amount amount"><span class="kobolg-Price-currencySymbol">$</span>418.00</span></td>
                                        </tr>
                                        <tr class="order-total">
                                            <th>Tổng cộng</th>
                                            <td><strong><span class="kobolg-Price-amount amount"><span class="kobolg-Price-currencySymbol">$</span>418.00</span></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <input type="hidden" name="lang" value="en">
                                <div id="payment" class="kobolg-checkout-payment">
                                    <ul class="wc_payment_methods payment_methods methods">
                                        <li class="wc_payment_method payment_method_bacs">
                                            <input id="payment_method_bacs" type="radio" class="input-radio" name="payment_method" value="bacs" checked="checked" data-order_button_text="">
                                            <label for="payment_method_bacs">Chuyển khoản ngân hàng trực tiếp</label>
                                        </li>
                                        <li class="wc_payment_method payment_method_cheque">
                                            <input id="payment_method_cheque" type="radio" class="input-radio" name="payment_method" value="cheque" data-order_button_text="">
                                            <label for="payment_method_cheque">Thanh toán bằng séc</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <p class="form-row place-order">
                                <input type="hidden" id="kobolg-checkout-nonce" name="kobolg-checkout-nonce" value="e896ef098e">
                                <button type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="Đặt hàng" data-value="Đặt hàng">Đặt hàng</button>
                                <span class="kobolg-loader"></span>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection


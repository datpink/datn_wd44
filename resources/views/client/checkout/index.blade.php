@extends('client.master')

@section('title', 'Liên Hệ')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .create-account-link {
            font-size: 16px;
            color: #333;
            /* Màu mặc định */
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease, transform 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .create-account-link:hover {
            color: #d9534f;
            /* Màu đỏ khi hover */
            transform: translateX(5px);
            /* Hiệu ứng di chuyển sang phải khi hover */
        }

        .create-account-link i {
            transition: transform 0.3s ease;
        }

        .create-account-link:hover i {
            transform: translateX(3px);
        }
    </style>
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
                                            Khách hàng quay lại?
                                            <a href=" {{ route('login') }}" class="showlogin">Nhấp
                                                vào đây để đăng nhập</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="kobolg-checkout-coupon">
                                    <div class="kobolg-notices-wrapper"></div>
                                    <div class="kobolg-form-coupon-toggle">
                                        <div class="kobolg-info">
                                            Bạn có mã giảm giá? <a href="#" class="showcoupon">Nhấp vào đây để nhập mã
                                                của bạn</a>
                                        </div>
                                    </div>
                                    <form class="checkout_coupon kobolg-form-coupon" method="post" style="display:none">
                                        <p>Nếu bạn có mã giảm giá, vui lòng áp dụng nó bên dưới.</p>
                                        <p class="form-row form-row-first">
                                            <input type="text" name="coupon_code" class="input-text"
                                                placeholder="Mã giảm giá" id="coupon_code" value="">
                                        </p>
                                        <p class="form-row form-row-last">
                                            <button type="submit" class="button" name="apply_coupon"
                                                value="Apply coupon">Áp dụng mã giảm giá</button>
                                        </p>
                                        <div class="clear"></div>
                                    </form>
                                </div>
                            </div>
                            <form name="checkout" method="post" class="checkout kobolg-checkout" action="#"
                                enctype="multipart/form-data">
                                <div class="col2-set" id="customer_details">
                                    <div class="col-1">
                                        @if ($user)
                                            <div class="kobolg-billing-fields">
                                                <h3>Thông tin thanh toán</h3>
                                                <div class="kobolg-billing-fields__field-wrapper">
                                                    <p class="form-row form-row-wide validate-required" data-priority="10">
                                                        <label>Họ và tên&nbsp;<abbr class="required"
                                                                title="required">*</abbr></label>
                                                        <span class="kobolg-input-wrapper">
                                                            <input type="text" class="input-text"
                                                                name="billing_first_name" value="{{ $user->name }}"
                                                                autocomplete="given-name" required>
                                                        </span>
                                                    </p>
                                                    <p class="form-row form-row-wide addresses-field validate-required"
                                                        data-priority="50">
                                                        <label>Địa chỉ&nbsp;<abbr class="required"
                                                                title="required">*</abbr></label>
                                                        <span class="kobolg-input-wrapper">
                                                            <input type="text" class="input-text"
                                                                name="billing_addresses_1"
                                                                value="{{ $user->address ?? '' }}"
                                                                placeholder="Số nhà và tên đường"
                                                                data-placeholder="Số nhà và tên đường" required>
                                                        </span>
                                                    </p>
                                                    <p class="form-row form-row-wide validate-required validate-phone"
                                                        data-priority="100">
                                                        <label>Số điện thoại&nbsp;<abbr class="required"
                                                                title="required">*</abbr></label>
                                                        <span class="kobolg-input-wrapper">
                                                            <input type="tel" class="input-text" name="billing_phone"
                                                                value="{{ $user->phone ?? '' }}" placeholder=""
                                                                autocomplete="tel" required>
                                                        </span>
                                                    </p>
                                                    <p class="form-row form-row-wide validate-required validate-email"
                                                        data-priority="110">
                                                        <label>Email&nbsp;<abbr class="required"
                                                                title="required">*</abbr></label>
                                                        <span class="kobolg-input-wrapper">
                                                            <input type="email" class="input-text" name="billing_email"
                                                                value="{{ $user->email }}" placeholder=""
                                                                autocomplete="email username" required>
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="kobolg-account-fields">
                                                <p class="hover-red" style="margin-top: 50px; padding-top: 40px">
                                                    <a href="{{ route('login') }}">Tạo tài khoản</a> <i
                                                        class="fas fa-arrow-right ml-2"></i>
                                                </p>
                                            </div>
                                        @endif




                                    </div>
                                    <div class="col-2">
                                        <div class="kobolg-additional-fields">
                                            <h3>Thông tin bổ sung</h3>
                                            <div class="kobolg-additional-fields__field-wrapper">
                                                <p class="form-row notes" id="order_comments_field" data-priority="">
                                                    <label for="order_comments" class="">Ghi chú đơn hàng&nbsp;<span
                                                            class="optional">(tùy chọn)</span></label>
                                                    <span class="kobolg-input-wrapper">
                                                        <textarea name="order_comments" class="input-text " id="order_comments"
                                                            placeholder="Ghi chú về đơn hàng của bạn, ví dụ: ghi chú đặc biệt cho giao hàng." rows="2" cols="5"></textarea>
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
                                                <th class="product-name" colspan="2">Sản phẩm</th>
                                                <th class="product-total">Tổng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $totalAmount = 0; @endphp
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td class="text-center">
                                                        <img src="{{ $product['options']['image'] }}"
                                                            class="d-block ui-w-40 ui-bordered"
                                                            alt="{{ $product['name'] }}"
                                                            style="max-width: 90px; margin: 0 auto;">
                                                    </td>
                                                    <td class="p-4">
                                                        <div class="media align-items-center">
                                                            <div class="media-body">
                                                                <a href="#"
                                                                    class="d-block text-dark">{{ $product['name'] }}</a>
                                                                <small>
                                                                    @if ($product['options']['color'] || $product['options']['storage'])
                                                                        Màu: {{ $product['options']['color'] }} - Bộ nhớ:
                                                                        {{ $product['options']['storage'] }}
                                                                    @endif
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="price-col">
                                                        @php
                                                            $lineTotal = $product['price'] * $product['quantity'];
                                                            $totalAmount += $lineTotal;
                                                        @endphp
                                                        <span>
                                                            {{ $lineTotal == floor($lineTotal) ? number_format($lineTotal, 0, ',', '.') : number_format($lineTotal, 2, ',', '.') }}₫
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>


                                        <tfoot>
                                            <tr class="cart-subtotal">
                                                <th>Tổng phụ</th>
                                                <td>
                                                    <span class="kobolg-Price-amount amount">
                                                        <span class="kobolg-Price-currencySymbol">₫</span>
                                                        {{ $totalAmount == floor($totalAmount) ? number_format($totalAmount, 0, ',', '.') : number_format($totalAmount, 2, ',', '.') }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <!-- Dòng giảm giá -->
                                            <tr class="cart-discount" style="display: none;">
                                                <th>Giảm giá</th>
                                                <td>
                                                    <span class="kobolg-Price-amount amount">
                                                        <span class="kobolg-Price-currencySymbol">₫</span>
                                                        -{{ number_format($discount, 2, ',', '.') }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr class="order-total">
                                            <tr class="order-total">
                                                <th>Tổng cộng</th>
                                                <td>
                                                    <strong>
                                                        <span class="kobolg-Price-amount amount">
                                                            <span class="kobolg-Price-currencySymbol">₫</span>
                                                            {{ $totalAmount == floor($totalAmount) ? number_format($totalAmount, 0, ',', '.') : number_format($totalAmount, 2, ',', '.') }}
                                                        </span>
                                                    </strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <input type="hidden" name="lang" value="en">
                                    <div id="payment" class="kobolg-checkout-payment">
                                        <div class="payment-methods">
                                            <h3>Phương thức thanh toán</h3>
                                            <ul class="wc_payment_methods payment_methods methods">
                                                @if ($paymentMethods->isNotEmpty())
                                                    @foreach ($paymentMethods as $method)
                                                        @if ($method->status === 'active')
                                                            <!-- Kiểm tra trạng thái -->
                                                            <li
                                                                class="wc_payment_method payment_method_{{ $method->id }}">
                                                                <input id="payment_method_{{ $method->id }}"
                                                                    type="radio" class="input-radio"
                                                                    name="payment_method" value="{{ $method->id }}"
                                                                    @if ($loop->first) checked="checked" @endif>
                                                                <label
                                                                    for="payment_method_{{ $method->id }}">{{ $method->name }}</label>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <li class="wc_payment_method">Không có phương thức thanh toán nào khả
                                                        dụng.</li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <p class="form-row place-order">
                                    <input type="hidden" id="kobolg-checkout-nonce" name="kobolg-checkout-nonce"
                                        value="e896ef098e">
                                    <button type="submit" class="button alt" name="woocommerce_checkout_place_order"
                                        id="place_order" value="Đặt hàng" data-value="Đặt hàng">Đặt hàng</button>
                                    <span class="kobolg-loader"></span>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Lấy các nút và form

            const showCouponButton = document.querySelector('.showcoupon');
            const couponForm = document.querySelector('.checkout_coupon');

            // Thêm sự kiện nhấp vào nút hiển thị form mã giảm giá
            if (showCouponButton && couponForm) {
                showCouponButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    couponForm.style.display = couponForm.style.display === 'none' ? 'block' : 'none';
                });
            }
        });
    </script>
@endsection

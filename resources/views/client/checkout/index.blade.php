@extends('client.master')

@section('title', 'Checkout')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                                        <input type="hidden" name="totalAmount" value="{{ $totalAmount }}">
                                        <div class="clear"></div>
                                    </form>
                                </div>
                            </div>
                            <form method="post" class="checkout kobolg-checkout" action="{{ route('vnpay') }}"
                                enctype="multipart/form-data">
                                @csrf
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
                                                    <div class="form-group">
                                                        <!-- Dropdown chọn tỉnh và huyện -->
                                                        <p class="form-row form-row-wide validate-required"
                                                            data-priority="20">
                                                            <label>Chọn Tỉnh&nbsp;<abbr class="required"
                                                                    title="required">*</abbr></label>
                                                            <span class="kobolg-input-wrapper">
                                                                <select name="province" id="province" class="form-control"
                                                                    required>
                                                                    <option value="">Chọn tỉnh</option>
                                                                    @foreach ($provinces as $province)
                                                                        <option value="{{ $province->id }}">
                                                                            {{ $province->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </span>
                                                        </p>
                                                        <p class="form-row form-row-wide validate-required"
                                                            data-priority="30">
                                                            <label>Chọn Huyện&nbsp;<abbr class="required"
                                                                    title="required">*</abbr></label>
                                                            <span class="kobolg-input-wrapper">
                                                                <select name="district" id="district" class="form-control"
                                                                    required>
                                                                    <option value="">Chọn huyện</option>
                                                                    <!-- Các option huyện sẽ được thêm qua AJAX -->
                                                                </select>
                                                            </span>
                                                        </p>
                                                        <p class="form-row form-row-wide validate-required"
                                                            data-priority="40">
                                                            <label>Chọn Xã/Phường&nbsp;<abbr class="required"
                                                                    title="required">*</abbr></label>
                                                            <span class="kobolg-input-wrapper">
                                                                <select name="ward" id="ward" class="form-control"
                                                                    required>
                                                                    <option value="">Chọn xã/phường</option>
                                                                    <!-- Các option xã/phường sẽ được thêm qua AJAX -->
                                                                </select>
                                                            </span>
                                                        </p>

                                                    </div>
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
                                                        <span>
                                                            {{ $product['price'] * $product['quantity'] == floor($product['price'] * $product['quantity']) ? number_format($product['price'] * $product['quantity'], 0, ',', '.') : number_format($product['price'] * $product['quantity'], 2, ',', '.') }}₫
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                        <tfoot>
                                            <tr class="cart-shipping">
                                                <th>Phí vận chuyển</th>
                                                <td>
                                                    <strong>
                                                        <span class="kobolg-Price-amount amount" style="color: red;">
                                                            <span class="kobolg-Price-currencySymbol">₫</span>
                                                            <span id="shipping-fee">0</span>
                                                            <!-- Giá sẽ được cập nhật qua JS -->
                                                        </span>
                                                    </strong>
                                                </td>
                                            </tr>



                                            <!-- Dòng giảm giá -->
                                            <tr class="cart-discount" style="display: none;">
                                                <th>Giảm giá</th>
                                                <td>
                                                    <span class="kobolg-Price-amount amount">
                                                        <span class="kobolg-Price-currencySymbol">₫</span>
                                                        0
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr class="order-total">
                                                <th>Tổng cộng</th>
                                                <td>
                                                    <strong>
                                                        <span class="kobolg-Price-amount amount">
                                                            <span class="kobolg-Price-currencySymbol">₫</span>
                                                            {{ number_format($totalAmount, 0, ',', '.') }}
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
                                    <input type="hidden" name="redirect" value="1">
                                    <input type="hidden" name="totalAmount" id="input-total"
                                        value="{{ $totalAmount }}">
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
            // Hiển thị/Ẩn form mã giảm giá
            const showCouponButton = document.querySelector(".showcoupon");
            const couponForm = document.querySelector(".checkout_coupon");
            if (showCouponButton && couponForm) {
                showCouponButton.addEventListener("click", function(e) {
                    e.preventDefault();
                    couponForm.style.display =
                        couponForm.style.display === "none" ? "block" : "none";
                });
            }

            // Xử lý form mã giảm giá
            const couponFormSubmit = document.querySelector(".checkout_coupon.kobolg-form-coupon");
            if (couponFormSubmit) {
                couponFormSubmit.addEventListener("submit", function(e) {
                    e.preventDefault();

                    const couponCode = document.querySelector("#coupon_code").value;
                    const totalAmount = parseFloat(
                        document.querySelector('[name="totalAmount"]').value
                    );
                    const shippingFee = parseFloat(document.querySelector("#shipping-fee").textContent
                        .replace(/[^\d]/g, "") || 0);

                    if (isNaN(totalAmount) || totalAmount <= 0) {
                        alert("Tổng tiền không hợp lệ.");
                        return;
                    }

                    fetch("{{ route('applyCoupon') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                            body: JSON.stringify({
                                coupon_code: couponCode,
                                totalAmount: totalAmount,
                            }),
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.status === "success") {
                                alert("Áp dụng mã giảm giá thành công!");

                                const discountElement = document.querySelector(
                                ".cart-discount .amount");
                                if (discountElement) {
                                    document.querySelector(".cart-discount").style.display =
                                    "table-row";
                                    discountElement.textContent = `-${new Intl.NumberFormat("vi-VN", {
                                style: "currency",
                                currency: "VND",
                            }).format(data.discount)}`;
                                }

                                // Cập nhật lại tổng giá sau khi áp dụng mã giảm giá và phí vận chuyển
                                const totalElement = document.querySelector(".order-total .amount");
                                const finalAmount = data.final_amount + shippingFee;

                                if (totalElement) {
                                    totalElement.textContent = new Intl.NumberFormat("vi-VN", {
                                        style: "currency",
                                        currency: "VND",
                                    }).format(finalAmount);
                                }

                                syncTotalToInput(finalAmount); // Đồng bộ lại tổng giá vào input
                            } else {
                                alert("Mã giảm giá không hợp lệ.");
                            }
                        })
                        .catch((error) => console.error("Error:", error));
                });
            }

            // Cập nhật danh sách huyện khi chọn tỉnh
            $("#province").change(function() {
                const provinceId = $(this).val();

                if (provinceId) {
                    $.ajax({
                        url: `{{ route('getDistricts', ':provinceId') }}`.replace(":provinceId",
                            provinceId),
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            if (response.status === "success") {
                                const $district = $("#district");
                                $district.empty().append(
                                '<option value="">Chọn huyện</option>');

                                response.districts.forEach((district) => {
                                    $district.append(
                                        `<option value="${district.id}">${district.name}</option>`
                                    );
                                });
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function() {
                            alert("Đã xảy ra lỗi khi tải danh sách huyện.");
                        },
                    });
                } else {
                    $("#district").empty().append('<option value="">Chọn huyện</option>');
                }
            });

            // Cập nhật danh sách xã/phường khi chọn huyện
            $("#district").change(function() {
                const districtId = $(this).val();

                if (districtId) {
                    $.ajax({
                        url: `{{ route('getWards', ':districtId') }}`.replace(":districtId",
                            districtId),
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            if (response.status === "success") {
                                const $ward = $("#ward");
                                $ward.empty().append(
                                '<option value="">Chọn xã/phường</option>');

                                response.wards.forEach((ward) => {
                                    $ward.append(
                                        `<option value="${ward.id}">${ward.name}</option>`
                                        );
                                });
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function() {
                            alert("Đã xảy ra lỗi khi tải danh sách xã/phường.");
                        },
                    });
                } else {
                    $("#ward").empty().append('<option value="">Chọn xã/phường</option>');
                }
            });

            // Tính phí vận chuyển
            $("#province, #district, #ward").change(function() {
                const provinceId = $("#province").val();
                const districtId = $("#district").val();
                const wardId = $("#ward").val();

                if (provinceId && districtId) {
                    $.ajax({
                        url: "{{ route('getShippingFee') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            province_id: provinceId,
                            district_id: districtId,
                            ward_id: wardId,
                        },
                        success: function(response) {
                            if (response.status === "success") {
                                const shippingFee = response.shipping_fee || 0;
                                $("#shipping-fee").text(shippingFee.toLocaleString("vi-VN"));
                                $("#shipping-row").show();

                                // Tính lại tổng tiền
                                const totalAmount = parseFloat({{ $totalAmount }}) +
                                    shippingFee;
                                $(".order-total .amount").text(
                                    new Intl.NumberFormat("vi-VN", {
                                        style: "currency",
                                        currency: "VND",
                                    }).format(totalAmount)
                                );

                                syncTotalToInput(totalAmount); // Đồng bộ lại tổng giá vào input
                            } else {
                                alert(response.message);
                                $("#shipping-row").hide();
                            }
                        },
                        error: function() {
                            alert("Có lỗi xảy ra. Vui lòng thử lại.");
                            $("#shipping-row").hide();
                        },
                    });
                } else {
                    $("#shipping-row").hide();
                }
            });
        });

        // Hàm đồng bộ giá trị tổng cộng vào input ẩn
        function syncTotalToInput(totalAmount) {
            document.querySelector("#input-total").value = totalAmount;
        }
        
    </script>

@endsection

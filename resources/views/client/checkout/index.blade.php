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

    @include('components.breadcrumb-client2')

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
                                                                            {{ $province->name }}
                                                                        </option>
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
                                                            <input type="tel" class="input-text" name="phone_number"
                                                                value="{{ $user->phone }}" placeholder=""
                                                                autocomplete="tel" required>
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
                                                        <textarea name="description" class="input-text " id="order_comments"
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
                                            @if ($products)
                                                @foreach ($products as $product)
                                                    <tr>
                                                        <td class="text-center">
                                                            <img src="{{ $product['options']['image'] }}"
                                                                alt="{{ $product['name'] }}"
                                                                class="mini-cart-product-image"
                                                                style="width: 80px; height: auto; margin-right: 10px;">
                                                        </td>
                                                        <td class="p-5" style="width: 350px">
                                                            <div class="media align-items-center">
                                                                <div class="media-body">
                                                                    <a href="#"
                                                                        class="d-block text-dark">{{ $product['name'] }}</a>
                                                                    @if (isset($product['options']['color']) || isset($product['options']['storage']))
                                                                        <small>
                                                                            Màu:
                                                                            {{ $product['options']['color'] ?? 'N/A' }} -
                                                                            Bộ nhớ:
                                                                            {{ $product['options']['storage'] ?? 'N/A' }}
                                                                        </small>
                                                                    @endif
                                                                    @if (!empty($product['options']['variant']) && count($product['options']['variant']) > 0)
                                                                        <div class="product-attributes">
                                                                            @foreach ($product['options']['variant'] as $index => $attribute)
                                                                                <span
                                                                                    class="attribute-item">{{ $attribute['name'] }}</span>
                                                                                @if ($index < count($product['options']['variant']) - 1)
                                                                                    <span>-</span>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    @endif
                                                                    <span
                                                                        style="font-size: 0.8vw">{{ $product['quantity'] }}
                                                                        ×
                                                                        {{ number_format($product['price'], 0) }}₫</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="total-col" style="text-align: right;">
                                                            <span>{{ number_format($product['quantity'] * $product['price'], 0, ',', '.') }}₫</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                @foreach (session('cart_' . auth()->id()) as $key => $item)
                                                    <tr>
                                                        <td class="text-center">
                                                            <img src="{{ $item['options']['image'] }}"
                                                                alt="{{ $item['name'] }}" class="mini-cart-product-image"
                                                                style="width: 80px; height: auto; margin-right: 10px;">
                                                        </td>
                                                        <td class="p-5" style="width: 350px">
                                                            <div class="media align-items-center">
                                                                <div class="media-body">
                                                                    <a href="#"
                                                                        class="d-block text-dark">{{ $item['name'] }}</a>
                                                                    @if (isset($item['options']['color']) || isset($item['options']['storage']))
                                                                        <small>
                                                                            Màu: {{ $item['options']['color'] ?? 'N/A' }} -
                                                                            Bộ
                                                                            nhớ: {{ $item['options']['storage'] ?? 'N/A' }}
                                                                        </small>
                                                                    @endif
                                                                    @if (!empty($item['options']['variant']) && count($item['options']['variant']) > 0)
                                                                        <div class="product-attributes">
                                                                            @foreach ($item['options']['variant'] as $index => $attribute)
                                                                                <span
                                                                                    class="attribute-item">{{ $attribute->name }}</span>
                                                                                @if ($index < count($item['options']['variant']) - 1)
                                                                                    <span>-</span>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    @endif
                                                                    <span style="font-size: 0.8vw">{{ $item['quantity'] }}
                                                                        ×
                                                                        {{ number_format($item['price'], 0) }}₫</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="total-col" style="text-align: right;">
                                                            <span>{{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }}₫</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif

                                        </tbody>

                                        <tfoot>
                                            <tr class="cart-shipping">
                                                <td colspan="2" class="text-left">Phí vận chuyển</td>
                                                <td class="shipping-fee" style="text-align: right;">
                                                    <strong>
                                                        <span class="kobolg-Price-amount amount" style="color: red;">
                                                            <span class="kobolg-Price-currencySymbol">₫</span>
                                                            <span id="shipping-fee">0</span>
                                                        </span>
                                                    </strong>
                                                </td>
                                            </tr>

                                            <tr class="cart-discount" style="display: none;">
                                                <td colspan="2" class="text-left">Giảm giá</td>
                                                <td style="text-align: right;">
                                                    <span class="kobolg-Price-amount amount">
                                                        <span class="kobolg-Price-currencySymbol"
                                                            style="color: red"></span>
                                                        0
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr class="order-total">
                                                <td colspan="2" class="text-left">Tổng cộng</td>
                                                <td style="text-align: right;">
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
                                                                    for="payment_method_{{ $method->id }}">{{ $method->description }}</label>
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
                                    {{-- input --}}
                                    <input type="hidden" name="redirect" value="1">
                                    <input type="hidden" name="totalAmount" id="input-total"
                                        value="{{ $totalAmount }}">

                                    <input type="hidden" name="promotion_id"
                                        value="{{ old('promotion_id', $promotion_id ?? '') }}">
                                    <input type="hidden" id="discount_display" name="discount_display">

                                    <!-- Trường input ẩn để chứa dữ liệu gộp -->
                                    <input type="hidden" id="full_address" name="full_address" value="">


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
                couponFormSubmit.addEventListener("submit", async function(e) {
                    e.preventDefault();

                    const couponCode = document.querySelector("#coupon_code").value;
                    const totalAmountInput = document.querySelector('[name="totalAmount"]');
                    const shippingFee = parseFloat(
                        document.querySelector("#shipping-fee").textContent.replace(/[^\d]/g, "") ||
                        0
                    );

                    const totalAmount = parseFloat(totalAmountInput?.value || 0);
                    if (isNaN(totalAmount) || totalAmount <= 0) {
                        alert("Tổng tiền không hợp lệ.");
                        return;
                    }

                    try {
                        const response = await fetch("{{ route('applyCoupon') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                            body: JSON.stringify({
                                coupon_code: couponCode,
                                totalAmount: totalAmount,
                            }),
                        });
                        const data = await response.json();

                        if (data.status === "success") {
                            alert("Áp dụng mã giảm giá thành công!");

                            updatePromotionInput(data.promotion_id);
                            updateDiscountInput(data.discount);
                            updateTotalAmount(totalAmount, data.discount, shippingFee);
                            updateDiscountDisplay(data.discount);
                        } else {
                            alert("Mã giảm giá không hợp lệ.");
                        }
                    } catch (error) {
                        console.error("Lỗi:", error);
                    }
                });
            }

            // Hàm cập nhật `promotion_id`
            function updatePromotionInput(promotionId) {
                let promotionInput = document.querySelector('[name="promotion_id"]');
                if (!promotionInput) {
                    promotionInput = document.createElement("input");
                    promotionInput.type = "hidden";
                    promotionInput.name = "promotion_id";
                    document.querySelector("form").appendChild(promotionInput);
                }
                promotionInput.value = promotionId;
            }

            function updateDiscountInput(discount) {
                // Kiểm tra giá trị của discount
                console.log('Discount: ', discount); // Debug

                // Tìm input ẩn 'discount_total'
                let discountInput = document.querySelector('[name="discount_total"]');

                // Nếu input không tồn tại, tạo mới
                if (!discountInput) {
                    discountInput = document.createElement("input");
                    discountInput.type = "hidden";
                    discountInput.name = "discount_total";
                    document.querySelector("form").appendChild(discountInput);
                }

                // Cập nhật giá trị giảm giá vào input ẩn
                discountInput.value = discount;

                // Debug giá trị đã được gán vào input ẩn
                console.log('Input Hidden Value: ', discountInput.value); // Kiểm tra giá trị

                // Cập nhật ô input ẩn `discount_display` (nếu tồn tại)
                const discountDisplayInput = document.querySelector("#discount_display");
                if (discountDisplayInput) {
                    discountDisplayInput.value = discount; // Gán giá trị số thẳng vào
                }
            }






            // Hàm cập nhật tổng tiền sau khi áp dụng mã giảm giá
            function updateTotalAmount(totalAmount, discount, shippingFee) {
                const finalAmount = totalAmount - discount + shippingFee;
                const totalAmountInput = document.querySelector('[name="totalAmount"]');
                if (totalAmountInput) totalAmountInput.value = finalAmount;

                const totalElement = document.querySelector(".order-total .amount");
                if (totalElement) {
                    totalElement.textContent = new Intl.NumberFormat("vi-VN", {
                        style: "currency",
                        currency: "VND",
                    }).format(finalAmount);
                }
            }

            // Hàm cập nhật giao diện hiển thị giảm giá
            function updateDiscountDisplay(discount) {
                const discountElement = document.querySelector(".cart-discount .amount");
                if (discountElement) {
                    document.querySelector(".cart-discount").style.display = "table-row";
                    discountElement.textContent = `-${new Intl.NumberFormat("vi-VN", {
                style: "currency",
                currency: "VND",
            }).format(discount)}`;
                }
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

        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.querySelector('#province');
            const districtSelect = document.querySelector('#district');
            const wardSelect = document.querySelector('#ward');
            const fullAddressInput = document.querySelector('#full_address');

            // Lắng nghe sự thay đổi của các dropdown
            provinceSelect.addEventListener('change', updateFullAddress);
            districtSelect.addEventListener('change', updateFullAddress);
            wardSelect.addEventListener('change', updateFullAddress);

            function updateFullAddress() {
                const provinceId = provinceSelect.value;
                const districtId = districtSelect.value;
                const wardId = wardSelect.value;

                let fullAddress = '';

                // Kiểm tra xem các giá trị có hợp lệ không và tạo chuỗi gộp
                if (provinceId) {
                    fullAddress += provinceSelect.options[provinceSelect.selectedIndex].text;
                }
                if (districtId) {
                    fullAddress += ' - ' + districtSelect.options[districtSelect.selectedIndex].text;
                }
                if (wardId) {
                    fullAddress += ' - ' + wardSelect.options[wardSelect.selectedIndex].text;
                }

                // Cập nhật giá trị cho input ẩn
                fullAddressInput.value = fullAddress;
            }
        });
    </script>

@endsection

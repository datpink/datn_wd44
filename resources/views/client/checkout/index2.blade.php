@extends('client.master')

@section('title', 'Checkout')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 12px;
            font-size: 14px;
            background-color: #ffffff;
        }

        .card .discount-info {
            flex: 1;
            line-height: 1.4;
        }

        .card .discount-info img {
            width: 50px;
            /* Điều chỉnh kích thước ảnh */
            height: auto;
            margin-right: 12px;
            /* Khoảng cách giữa ảnh và văn bản */
            border-radius: 4px;
            /* Bo góc ảnh nếu cần */
            object-fit: contain;
            /* Giữ tỷ lệ ảnh */
        }

        .card .discount-info p {
            margin-bottom: 6px;
            font-size: 13px;
            color: #333;
        }

        .card .discount-info p.font-weight-bold {
            font-size: 14px;
            font-weight: bold;
            color: #d9534f;
            /* Màu đỏ nhấn mạnh */
        }

        .card .discount-info p.text-muted {
            color: #6c757d;
            font-size: 12px;
        }

        .card .btn {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 6px;
        }

        .card .btn.apply-discount {
            background-color: #28a745;
            color: #ffffff;
            border: none;
            transition: background-color 0.3s ease;
        }

        .card .btn.apply-discount:hover {
            background-color: #218838;
        }

        .card .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
        }

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
                                <div class="kobolg-checkout-coupon mb-4">
                                    <div class="kobolg-notices-wrapper"></div>
                                    <div class="kobolg-form-coupon-toggle">
                                        <div class="kobolg-info mb-3">
                                            <span>Bạn có mã giảm giá? </span>
                                            <a href="#" class="showcoupon">Nhấp vào đây để nhập mã của bạn</a>
                                        </div>
                                    </div>
                                    <div class="checkout_coupon_wrapper" style="display: none;">
                                        <form class="checkout_coupon kobolg-form-coupon p-3 border rounded" method="post">
                                            <p class="text-muted">Nếu bạn có mã giảm giá, vui lòng áp dụng nó bên dưới.</p>
                                            <div class="form-row d-flex">
                                                <div class="form-group col-md-8">
                                                    <input type="text" name="coupon_code" class="form-control"
                                                        placeholder="Mã giảm giá" id="coupon_code" value="">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <button type="submit" class="btn btn-dark w-100" name="apply_coupon"
                                                        value="Apply coupon">Áp dụng mã giảm giá</button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="totalAmount" value="{{ $totalAmount }}">
                                        </form>
                                        <!-- Khu vực hiển thị cart promotion -->
                                        <div class="cart-promotion mt-3"
                                            style="max-height: 250px; overflow-y: auto; border: 1px solid #ddd; border-radius: 8px; padding: 10px;">
                                            @if (Auth::check())
                                                @foreach ($userPromotions as $userPromotion)
                                                    @php
                                                        $isExpired = \Carbon\Carbon::parse(
                                                            $userPromotion->promotion->end_date,
                                                        )->isPast();
                                                        $notEligible =
                                                            $totalAmount < $userPromotion->promotion->min_order_value;
                                                        $buttonClass =
                                                            $userPromotion->promotion->type == 'free_shipping'
                                                                ? 'btn-success'
                                                                : 'btn-danger';
                                                        if ($isExpired || $notEligible) {
                                                            $buttonClass = 'btn-outline-secondary';
                                                        }
                                                    @endphp
                                                    <div class="card mb-3 shadow-sm border-0 d-flex flex-row align-items-center"
                                                        style="border-radius: 8px; padding: 12px; font-size: 14px;">
                                                        <div class="discount-image">
                                                            <img src="{{ asset('images/coupon.png') }}" style="width: 100px"
                                                                height="80px">
                                                        </div>
                                                        <div class="discount-info"
                                                            style="flex: 1; margin-left: 12px; line-height: 1.4;">
                                                            <p class="font-weight-bold mb-1">
                                                                @if ($userPromotion->promotion->type == 'percentage')
                                                                    Giảm
                                                                    {{ number_format($userPromotion->promotion->discount_value, 0) }}%
                                                                @elseif($userPromotion->promotion->type == 'fixed_amount')
                                                                    Giảm
                                                                    {{ number_format($userPromotion->promotion->discount_value, 0) }}
                                                                    VND
                                                                @elseif($userPromotion->promotion->type == 'free_shipping')
                                                                    Miễn phí vận chuyển
                                                                @else
                                                                    Loại giảm giá không xác định
                                                                @endif
                                                            </p>
                                                            @if ($userPromotion->promotion->type != 'free_shipping')
                                                                <p class="mb-0">Tối đa:
                                                                    <strong>{{ number_format($userPromotion->promotion->max_value, 0) }}
                                                                        VND</strong>
                                                                </p>
                                                            @endif
                                                            <p class="mb-0">Đơn tối thiểu:
                                                                <strong>{{ number_format($userPromotion->promotion->min_order_value, 0) }}
                                                                    VND</strong>
                                                            </p>
                                                            <p class="text-muted mb-0">Hạn sử dụng:
                                                                <strong>{{ \Carbon\Carbon::parse($userPromotion->promotion->end_date)->format('d/m/Y') }}</strong>
                                                            </p>
                                                        </div>
                                                        <div class="discount-action">
                                                            @if ($isExpired)
                                                                <button class="btn btn-outline-secondary btn-sm" disabled>Đã
                                                                    hết hạn</button>
                                                            @elseif ($notEligible)
                                                                <button class="btn btn-outline-secondary btn-sm"
                                                                    disabled>Không đủ điều kiện</button>
                                                            @else
                                                                <button
                                                                    class="btn {{ $buttonClass }} btn-sm apply-coupon-from-list"
                                                                    data-promotion-id="{{ $userPromotion->promotion->id }}"
                                                                    data-discount="{{ $userPromotion->promotion->discount_value }}"
                                                                    data-max-discount="{{ $userPromotion->promotion->max_value }}"
                                                                    data-type="{{ $userPromotion->promotion->type }}"
                                                                    data-total-amount="{{ $totalAmount }}">Áp
                                                                    dụng</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-center text-muted">Bạn cần đăng nhập để áp dụng mã giảm giá.
                                                </p>
                                            @endif
                                        </div>
                                    </div>
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
                                                        <!-- Address -->
                                                        <!-- Dropdown chọn tỉnh -->
                                                        <p class="form-row form-row-wide validate-required"
                                                            data-priority="20">
                                                            <label>Tỉnh&nbsp;<abbr class="required"
                                                                    title="required">*</abbr></label>
                                                            <span class="kobolg-input-wrapper">
                                                                <select name="province" id="province" class="form-control"
                                                                    required>
                                                                    <option value="">Chọn tỉnh</option>
                                                                    @foreach ($provinces as $provinceOption)
                                                                        <option value="{{ $provinceOption->id }}"
                                                                            @if ($province && old('province', $province->id ?? null) == $provinceOption->id) selected @endif>
                                                                            {{ $provinceOption->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </span>
                                                        </p>

                                                        <!-- Dropdown chọn huyện -->
                                                        <p class="form-row form-row-wide validate-required"
                                                            data-priority="30">
                                                            <label>Huyện&nbsp;<abbr class="required"
                                                                    title="required">*</abbr></label>
                                                            <span class="kobolg-input-wrapper">
                                                                <select name="district" id="district"
                                                                    class="form-control" required>
                                                                    <option value="">Chọn huyện</option>
                                                                    @if ($district)
                                                                        <option value="{{ $district->id }}" selected>
                                                                            {{ $district->name }}
                                                                        </option>
                                                                    @endif
                                                                </select>
                                                            </span>
                                                        </p>

                                                        <!-- Dropdown chọn xã/phường -->
                                                        <p class="form-row form-row-wide validate-required"
                                                            data-priority="40">
                                                            <label>Xã/Phường&nbsp;<abbr class="required"
                                                                    title="required">*</abbr></label>
                                                            <span class="kobolg-input-wrapper">
                                                                <select name="ward" id="ward"
                                                                    class="form-control" required>
                                                                    <option value="">Chọn xã/phường</option>
                                                                    @if ($ward)
                                                                        <option value="{{ $ward->id }}" selected>
                                                                            {{ $ward->name }}
                                                                        </option>
                                                                    @endif
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
                                            <tr>
                                                <td class="text-center">
                                                    <img src="{{ $productData['options']['image'] }}"
                                                         alt="{{ $productData['name'] }}" class="mini-cart-product-image"
                                                         style="max-width: 120px; max-height: 150px; width: auto; height: auto; margin-right: 5px; padding: 5px;">
                                                </td>
                                                <td class="" style="padding: 10px; width: 350px;">
                                                    <div class="media align-items-center">
                                                        <div class="media-body">
                                                            <a href="#" class="d-block text-dark">{{ \Str::limit($productData['name'], 30) }}</a>
                                                            @if (!empty($productData['options']['variant']) && count($productData['options']['variant']) > 0)
                                                                <div class="product-attributes">
                                                                    @foreach ($productData['options']['variant'] as $attrIndex => $attribute)
                                                                        <span class="attribute-item">{{ $attribute['name'] }}: {{ $attribute['value'] }}</span>
                                                                        @if ($attrIndex < count($productData['options']['variant']) - 1)
                                                                            <span>-</span>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                            <span style="font-size: 0.8vw">{{ $productData['quantity'] }} × {{ number_format($productData['price'], 0) }}₫</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="total-col" style="text-align: right;">
                                                    <strong><span>{{ number_format($productData['quantity'] * $productData['price'], 0, ',', '.') }}</span>
                                                        <span class="kobolg-Price-currencySymbol">₫</span></strong>
                                                </td>
                                            </tr>

                                            <!-- Hidden inputs to include product data in form submission -->
                                            <input type="hidden" name="product[id]" value="{{ $productData['id'] }}">
                                            <input type="hidden" name="product[variant_id]" value="{{ $productData['options']['variant_id'] }}">
                                            <input type="hidden" name="product[quantity]" value="{{ $productData['quantity'] }}">
                                            <input type="hidden" name="product[price]" value="{{ $productData['price'] }}">


                                        </tbody>

                                        <tfoot>
                                            <!-- Phí vận chuyển -->
                                            <tr class="cart-shipping">
                                                <td colspan="2" class="text-left">Phí vận chuyển</td>
                                                <td class="text-right shipping-fee">
                                                    <strong>
                                                        <span class="kobolg-Price-amount amount" style="color: red;">
                                                            -<span id="shipping-fee">0</span>
                                                            <span class="kobolg-Price-currencySymbol">₫</span>
                                                        </span>
                                                    </strong>
                                                </td>
                                            </tr>

                                            <!-- Giảm giá -->
                                            <tr class="cart-discount" style="display: none;">
                                                <td colspan="2" class="text-left">Giảm giá</td>
                                                <td class="text-right">
                                                    <span class="kobolg-Price-amount amount" style="color: red;">0</span>
                                                </td>
                                            </tr>


                                            <!-- Áp dụng Xu -->
                                            <tr class="apply-points-row">
                                                <td colspan="2" class="text-left">
                                                    <div class="d-flex align-items-center" style="margin-left: 20px">
                                                        <!-- Checkbox -->
                                                        <input type="checkbox" class="form-check-input me-2"
                                                            id="apply-points-checkbox" onchange="togglePoints()">
                                                        <!-- Nội dung chữ -->
                                                        <div>
                                                            <div class="fw-bold">Áp dụng Xu</div>
                                                            <div id="points-info" data-points="200">
                                                                Dùng 200 Xu
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <!-- Số Xu trừ -->
                                                <td class="text-right">
                                                    <strong id="points-discount" style="color: red;">
                                                        -<span id="points-amount">200</span>
                                                        <span class="kobolg-Price-currencySymbol">₫</span>
                                                    </strong>
                                                </td>
                                            </tr>

                                            <!-- Tổng cộng -->
                                            <tr class="order-total">
                                                <td colspan="2" class="text-left">Tổng cộng</td>
                                                <td class="text-right">
                                                    <strong>
                                                        <span class="kobolg-Price-amount amount" style="color: red;">
                                                            <span class="kobolg-Price-currencySymbol">₫</span>
                                                            <span
                                                                id="total-amount">{{ number_format($totalAmount, 0, ',', '.') }}</span>
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
                                                                    name="payment_method"
                                                                    value="{{ json_encode(['id' => $method->id, 'name' => $method->name]) }}"
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


                                    <button type="submit" class="button alt mt-3"
                                        name="woocommerce_checkout_place_order" id="place_order" value="Đặt hàng"
                                        data-value="Đặt hàng">Đặt hàng</button>
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
            // Hiển thị/Ẩn form mã giảm giá và cart promotion
            const showCouponButton = document.querySelector(".showcoupon");
            const couponWrapper = document.querySelector(".checkout_coupon_wrapper");

            if (showCouponButton && couponWrapper) {
                showCouponButton.addEventListener("click", function(e) {
                    e.preventDefault();
                    // Toggle hiển thị
                    couponWrapper.style.display =
                        couponWrapper.style.display === "none" ? "block" : "none";
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


                //////////////////////////////////////////
            }
            /////////////////////////////////////////////////
            const discountCards = document.querySelectorAll(
                ".apply-coupon-from-list"); // Lấy tất cả thẻ giảm giá

            discountCards.forEach(function(discountCard) {
                discountCard.addEventListener("click", async function() {
                    // Lấy giá trị từ các thuộc tính data-* của button
                    const promotionId = discountCard.getAttribute("data-promotion-id");
                    const discount = parseFloat(discountCard.getAttribute("data-discount"));
                    const maxDiscount = parseFloat(discountCard.getAttribute(
                        "data-max-discount"));
                    const type = discountCard.getAttribute("data-type");
                    const totalAmount = parseFloat(discountCard.getAttribute(
                        "data-total-amount"));
                    const shippingFee = parseFloat(document.querySelector("#shipping-fee")
                        .textContent.replace(/[^\d]/g, "") || 0);

                    try {
                        const response = await fetch("{{ route('applyCoupon2') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                            body: JSON.stringify({
                                promotion_id: promotionId,
                                discount: discount,
                                max_discount: maxDiscount,
                                type: type,
                                total_amount: totalAmount,
                                shipping_fee: shippingFee
                            }),
                        });

                        const data = await response
                            .json(); // Nếu là lỗi, sẽ không thực hiện được
                        console.log(data);


                        if (data.status === "success") {
                            alert("Áp dụng giảm giá thành công!");
                            updatePromotionInput(data.promotion_id);
                            updateDiscountInput(data.discount);
                            updateTotalAmount(totalAmount, data.discount, shippingFee);
                            updateDiscountDisplay(data.discount);
                        } else {
                            alert("Không thể áp dụng giảm giá.");
                        }
                    } catch (error) {
                        console.error("Lỗi:", error);
                    }
                });
            });

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

            // Hàm cập nhật giá trị giảm giá
            function updateDiscountInput(discount) {
                let discountInput = document.querySelector('[name="discount_total"]');
                if (!discountInput) {
                    discountInput = document.createElement("input");
                    discountInput.type = "hidden";
                    discountInput.name = "discount_total";
                    document.querySelector("form").appendChild(discountInput);
                }

                discountInput.value = discount;

                // Cập nhật ô input ẩn `discount_display` (nếu tồn tại)
                const discountDisplayInput = document.querySelector("#discount_display");
                if (discountDisplayInput) {
                    discountDisplayInput.value = discount;
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

            $(document).ready(function() {
                // Gọi tính phí vận chuyển khi trang tải xong nếu đã có giá trị
                const provinceId = $("#province").val();
                const districtId = $("#district").val();
                const wardId = $("#ward").val();

                if (provinceId && districtId) {
                    calculateShippingFee(provinceId, districtId, wardId);
                }

                // Lắng nghe sự kiện thay đổi dropdown
                $("#province, #district, #ward").change(function() {
                    const provinceId = $("#province").val();
                    const districtId = $("#district").val();
                    const wardId = $("#ward").val();

                    if (provinceId && districtId) {
                        calculateShippingFee(provinceId, districtId, wardId);
                    } else {
                        $("#shipping-row").hide();
                    }
                });
            });

            // Hàm tính phí vận chuyển
            function calculateShippingFee(provinceId, districtId, wardId) {
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
                            const totalAmount = parseFloat({{ $totalAmount }}) + shippingFee;
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
            }
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

            // Cập nhật giá trị full address khi trang được load lần đầu
            updateFullAddress();

            function updateFullAddress() {
                const provinceId = provinceSelect.value;
                const districtId = districtSelect.value;
                const wardId = wardSelect.value;

                let fullAddress = '';

                // Kiểm tra xem các giá trị có hợp lệ không và tạo chuỗi gộp
                if (provinceId && provinceSelect.selectedIndex !== 0) { // Đảm bảo tỉnh đã được chọn
                    fullAddress += provinceSelect.options[provinceSelect.selectedIndex].text;
                }
                if (districtId && districtSelect.selectedIndex !== 0) { // Đảm bảo huyện đã được chọn
                    fullAddress += ' - ' + districtSelect.options[districtSelect.selectedIndex].text;
                }
                if (wardId && wardSelect.selectedIndex !== 0) { // Đảm bảo xã/phường đã được chọn
                    fullAddress += ' - ' + wardSelect.options[wardSelect.selectedIndex].text;
                }

                // Cập nhật giá trị cho input ẩn
                fullAddressInput.value = fullAddress;
            }
        });

        // Khởi tạo trang khi load
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('apply-points-checkbox');
            const pointsDiscount = document.getElementById('points-discount');
            const ml = document.getElementById('points-info');

            // Mặc định khi load trang, điểm xu làm mờ và màu đen
            if (!checkbox.checked) {
                pointsDiscount.style.color = 'black';
                pointsDiscount.style.opacity = '0.3';
                ml.style.color = 'black';
                ml.style.opacity = '0.3';


            }
        });

        function togglePoints() {
            const checkbox = document.getElementById('apply-points-checkbox');
            const pointsDiscount = document.getElementById('points-discount');
            const ml = document.getElementById('points-info');
            const pointsAmountElement = document.getElementById('points-amount');
            const totalAmountElement = document.querySelector('.order-total .amount');
            const inputTotal = document.getElementById('input-total'); // Lấy phần tử input totalAmount

            // Lấy số xu từ data attribute (hoặc từ giá trị tính toán)
            let pointsValue = parseInt(document.getElementById('points-info').dataset.points) || 0;
            console.log(pointsValue);

            if (!totalAmountElement) {
                console.error("Phần tử tổng tiền không tồn tại.");
                return;
            }

            // Lưu giá trị tổng tiền ban đầu nếu chưa lưu
            if (typeof checkbox.initialTotal === 'undefined') {
                checkbox.initialTotal = parseInt(totalAmountElement.textContent.replace(/[^\d]/g, ''));
            }

            let currentTotal = checkbox.initialTotal; // Gán lại tổng tiền ban đầu khi bỏ check

            if (checkbox.checked) {
                // Nếu số xu lớn hơn tổng tiền, chỉ trừ đúng bằng tổng tiền
                if (pointsValue > currentTotal) {
                    pointsValue = currentTotal; // Giới hạn số xu trừ
                }

                currentTotal -= pointsValue; // Giảm số xu
                pointsDiscount.style.color = 'red';
                pointsDiscount.style.opacity = '1';

                ml.style.color = 'black';
                ml.style.opacity = '1';
            } else {
                // Bỏ chọn, quay lại tổng tiền ban đầu
                pointsDiscount.style.color = 'black';
                pointsDiscount.style.opacity = '0.3';

                ml.style.color = 'black';
                ml.style.opacity = '0.3';
            }

            // Cập nhật lại tổng tiền hiển thị
            totalAmountElement.textContent = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(currentTotal);

            // Cập nhật giá trị của ô input hidden
            inputTotal.value = currentTotal;
        }
    </script>

@endsection

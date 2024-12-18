<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<input type="hidden" name="" id="discount_price" value="{{ $product->discount_price }}">

<script>
    $(document).ready(function() {
        let selectedVariantId = null;
        let selectedVariantPrice = null; // Khởi tạo giá trị null
        var originalPrice = $('#add-to-cart').data('original-price'); // Giá sản phẩm gốc
        var discountPrice = $('#add-to-cart').data('discount-price'); // Giá giảm

        // Hàm định dạng giá để loại bỏ phần thập phân nếu có
        function formatPrice(price) {
            var priceFormatted = parseInt(price)
                .toLocaleString(); // Loại bỏ phần thập phân nếu giá là số nguyên
            return priceFormatted + '₫'; // Trả về giá đã được định dạng
        }

        console.log("Giá sản phẩm gốc: " + formatPrice(originalPrice));
        console.log("Giá giảm (nếu có): " + formatPrice(discountPrice));

        // Sự kiện khi chọn biến thể
        $(document).on('click', '.variant-btn', function() {
            $('.variant-btn').removeClass('active');
            $(this).addClass('active');

            var variantData = $(this).data('variant'); // Lấy dữ liệu từ data-variant
            selectedVariantId = variantData.id;

            // Hiển thị ảnh sản phẩm chính từ data-default-src
            var productImage = $('#product-image').data('default-src');
            $('#product-image').attr('src', productImage);

            $('#selected-variant-id').val(selectedVariantId);

            var stock = variantData.stock; // Lấy số lượng tồn kho của biến thể
            if (stock <= 0) {
                $('.action-buttons').hide();
                $('#out-of-stock-message').show();
            } else {
                $('.action-buttons').show();
                $('#out-of-stock-message').hide();
            }

            $('.sku').text(variantData.stock);

            $('#error-message').text('');

            var discountedPrice = variantData.price; // Mặc định là giá gốc của biến thể
            console.log("Giá biến thể: " + formatPrice(discountedPrice));

            var discount = parseInt(discountPrice?.replace('₫', '').replace(/,/g, '') || 0);
            var originalPrice2 = parseInt(originalPrice.replace('₫', '').replace(/,/g, ''));

            if (discount > 0) {
                discountedPrice = variantData.price - (originalPrice2 - discount);
            }

            console.log("Giá sau giảm: " + formatPrice(discountedPrice));
            if (discount && discountedPrice < variantData.price) {
    $('#product-price').html('<span class="new-price">' + formatPrice(discountedPrice) + '</span> <strike>' + formatPrice(variantData.price) + '</strike>');
    $('#discount-message').text('Giảm giá ' + variantData.discount_percentage + '%');
} else {
    $('#product-price').text(formatPrice(variantData.price));
    $('#discount-message').text('');
}



            selectedVariantPrice = discountedPrice; // Gán giá của biến thể sau khi tính toán
            console.log(selectedVariantPrice);
        });

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $(document).on('click', '#buy-now', function(e) {
            e.preventDefault(); // Ngăn chặn reload trang khi submit form

            var productId = $('#product-id').val();
            var quantity = $('#quantity').val() || 1;
            var variantId = $('#selected-variant-id').val();
            var stock = $('#product-stock').val(); // Lấy thông tin tồn kho

            if (quantity > stock) {
                $('#out-of-stock-message').show();
                return;
            }

            var price;
            if (selectedVariantPrice) {
                price = selectedVariantPrice;
            } else {
                if (discountPrice) {
                    price = parseInt(discountPrice.replace('₫', '').replace(/,/g, ''));
                } else {
                    price = parseInt(originalPrice.replace('₫', '').replace(/,/g, ''));
                }
            }

            // Gửi yêu cầu mua ngay
            $.ajax({
                url: '{{ route('buyNowCheckout') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    variant_id: variantId,
                    quantity: quantity,
                    price: price
                },
                success: function(response) {
                    // Nếu có redirectUrl, chuyển hướng đến trang thanh toán
                    if (response.success) {
                        window.location.href = response
                            .redirectUrl; // Chuyển hướng nếu thành công
                    } else {
                        // Nếu có lỗi hoặc thông báo, hiển thị mà không reload trang
                        alert(response.message); // Hiển thị thông báo lỗi hoặc thành công
                    }
                },
                error: function(xhr) {
                    // Hiển thị thông báo lỗi nếu có sự cố trong quá trình gửi AJAX
                    console.error('Lỗi khi gửi yêu cầu:', xhr.responseText);
                }
            });
        });





        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Khi người dùng nhấn nút "Thêm vào giỏ hàng"
        $(document).on('click', '#add-to-cart', function(e) {
            e.preventDefault();
            var productId = $('#product-id').val();
            var imageUrl = $('#product-image').data('default-src') || null;
            var stock;
            var quantity = $('#quantity').val();

            if ($('.variant-btn').length > 0) {
                if (!selectedVariantId || selectedVariantId === "") {
                    $('#error-message').text('Vui lòng chọn một biến thể sản phẩm!');
                    return;
                }
                stock = $('.variant-btn.active').data('variant').stock;
            } else {
                stock = parseInt($('#product-stock').val());
            }

            if (quantity > stock) {
                $('#error-message').text('Số lượng bạn chọn vượt quá tồn kho! Vui lòng giảm số lượng.');
                return;
            }
            // if (quantity > 5) {
            //     $('#error-message').text('Bạn chỉ được mua tối đa 5 sản phẩm.');
            //     return;
            // }
            if (quantity <= 0) {
                $('#error-message').text('Số lượng bạn chọn không hợp lệ.');
                return;
            }

            var price;
            if (selectedVariantPrice) {
                price = selectedVariantPrice;
            } else {
                if (discountPrice) {
                    price = parseInt(discountPrice.replace('₫', '').replace(/,/g, ''));
                } else {
                    price = parseInt(originalPrice.replace('₫', '').replace(/,/g, ''));
                }
            }

            $.ajax({
                url: '{{ route('cart.check_stock') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    variant_id: selectedVariantId,
                },
                success: function(response) {
                    if (response.remainingStock < quantity) {
                        $('#error-message').text(
                            'Không thể thêm vào giỏ hàng vì tồn kho không đủ!'
                        );
                        return;
                    }

                    $.ajax({
                        url: '{{ route('cart.add') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            product_id: productId,
                            variant_id: selectedVariantId,
                            quantity: quantity,
                            price: price,
                            image_url: imageUrl,
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: response.message,
                                toast: true,
                                position: 'top-end',
                                timer: 3000,
                                showConfirmButton: false,
                            });

                            updateCartCount(response.cartCount);
                            updateCartContents();
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: 'Không thể thêm vào giỏ hàng. Vui lòng thử lại!',
                                toast: true,
                                position: 'top-end',
                                timer: 3000,
                                showConfirmButton: false,
                            });
                            console.error(xhr.responseText);
                        },
                    });
                },
                error: function(xhr) {
                    console.error('Kiểm tra tồn kho thất bại:', xhr.responseText);
                },
            });
        });


        // Hàm cập nhật giỏ hàng tạm
        function updateCartCount(count) {
            // Cập nhật số lượng giỏ hàng
            $('.count').text(count);
            $('.minicart-number-items').text(count);
        }

        // Hàm cập nhật nội dung giỏ hàng
        function updateCartContents() {
            $.ajax({
                url: '{{ route('cart.temporary') }}',
                method: 'GET',
                success: function(html) {
                    $('#cart-content').html(html); // Cập nhật nội dung giỏ hàng
                },
                error: function(xhr) {
                    console.error('Không thể tải nội dung giỏ hàng:', xhr.responseText);
                },
            });
        }

        // Cập nhật ảnh sản phẩm ban đầu khi trang tải
        $(document).ready(function() {
            var defaultImage = $('#product-image').data('default-src');
            $('#product-image').attr('src',
                defaultImage); // Gán ảnh mặc định cho sản phẩm nếu chưa chọn biến thể
        });

        // Các hàm thông báo thành công và thất bại
        function showSuccessMessage(message) {
            Swal.fire({
                position: 'top',
                icon: 'success',
                title: 'Thành công!',
                toast: true,
                text: message,
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3500
            });
        }

        function showErrorMessage() {
            Swal.fire({
                position: 'top',
                icon: 'error',
                title: 'Oops...',
                toast: true,
                text: 'Có lỗi xảy ra, vui lòng thử lại!',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3500
            });
        }
    });



    function confirmDeleteReply(replyId) {
        Swal.fire({
            position: 'top',
            title: 'Bạn có chắc chắn muốn xóa phản hồi này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            toast: true,
            confirmButtonText: 'Ok',
            cancelButtonText: 'Hủy',
            timer: 3500
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-reply-form-' + replyId).submit();
            }
        });
    }

    function confirmDeleteComment(commentId) {
        Swal.fire({
            position: 'top',
            title: 'Bạn có chắc chắn muốn xóa bình luận này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
            toast: true,
            cancelButtonText: 'Hủy',
            timer: 3500
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-comment-form-' + commentId).submit();
            }
        });
    }

    $(document).ready(function() {
        // Lưu ảnh gốc
        var defaultImage = $('#main-image').attr('src');

        // Khi hover vào biến thể
        $('.variant-btn').on('mouseenter', function() {
            var imgUrl = $(this).data('img-url');
            if (imgUrl) {
                $('#main-image').attr('src', "{{ \Storage::url('') }}" +
                    imgUrl); // Thay đổi ảnh chính thành ảnh của biến thể
            }
        });

        // Khi rời hover, đưa ảnh về mặc định
        $('.variant-btn').on('mouseleave', function() {
            $('#main-image').attr('src', defaultImage); // Trả lại ảnh gốc
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        var content = document.getElementById("description-content");
        var toggleLink = document.getElementById("toggle-link");
        var icon = toggleLink.querySelector(".toggle-icon");

        // Kiểm tra nếu nội dung vượt quá giới hạn chiều cao
        if (content.scrollHeight > content.clientHeight) {
            toggleLink.style.display = "inline-flex"; // Hiển thị link "Xem thêm"
        }

        // Thêm sự kiện click cho link "Xem thêm"
        toggleLink.addEventListener("click", function() {
            if (content.classList.contains("content-collapsed")) {
                content.classList.remove("content-collapsed");
                content.classList.add("content-expanded");
                this.innerHTML = '<i class="fa fa-chevron-up toggle-icon"></i> Thu gọn nội dung';
            } else {
                content.classList.remove("content-expanded");
                content.classList.add("content-collapsed");
                this.innerHTML = '<i class="fa fa-chevron-down toggle-icon"></i> Xem thêm nội dung';
            }
        });
    });
</script>

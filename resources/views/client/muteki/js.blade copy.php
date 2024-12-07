<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            // Xóa trạng thái active của các nút khác và thêm trạng thái active vào nút hiện tại
            $('.variant-btn').removeClass('active');
            $(this).addClass('active');

            // Lấy thông tin biến thể từ thuộc tính data-variant của nút
            var variantData = $(this).data('variant'); // Lấy dữ liệu từ data-variant
            console.log("vrdata: ", variantData); // In ra dữ liệu để kiểm tra

            selectedVariantId = variantData.id;

            // Hiển thị ảnh sản phẩm chính từ data-default-src
            var productImage = $('#product-image').data('default-src');
            $('#product-image').attr('src', productImage);

            // Gắn giá trị ID của biến thể vào input ẩn để gửi đi
            $('#selected-variant-id').val(selectedVariantId);

            // Kiểm tra số lượng sản phẩm hoặc biến thể
            var stock = variantData.stock; // Lấy số lượng tồn kho của biến thể
            if (stock <= 0) {
                // Nếu số lượng tồn kho = 0, ẩn nút và hiển thị thông báo ngừng kinh doanh
                $('.action-buttons').hide();
                $('#out-of-stock-message').show();
            } else {
                // Nếu có hàng, hiển thị nút thêm vào giỏ hàng và mua ngay
                $('.action-buttons').show();
                $('#out-of-stock-message').hide();
            }

            // Xóa thông báo lỗi (nếu có)
            $('#error-message').text('');

            var discountedPrice = variantData.price; // Mặc định là giá gốc của biến thể
            console.log("Giá biến thể: " + formatPrice(discountedPrice));

            // Giả sử bạn đã có discountPrice ở đâu đó, nếu không có thì để mặc định là 0
            var discount = parseInt(discountPrice.replace('₫', '').replace(/,/g, '') ??
            0); // Loại bỏ '₫' và dấu ',' rồi chuyển thành số
            console.log("Giảm giá: " + discount);

            var originalPrice2 = parseInt(originalPrice.replace('₫', '').replace(/,/g,
            '')); // Loại bỏ '₫' và dấu phẩy, sau đó chuyển thành số

            // Chỉ tính giá sau giảm nếu có giảm giá
            if (discount > 0) {
                discountedPrice = variantData.price - (originalPrice2 -
                discount); // Trừ đi giá trị giảm giá
            }

            console.log("Giá sau giảm: " + formatPrice(discountedPrice));

            // Hiển thị giá sản phẩm
            if (discount && discountedPrice < variantData.price) {
                $('#product-price').html('<strike>' + formatPrice(variantData.price) + '</strike> ' +
                    formatPrice(discountedPrice));
                $('#discount-message').text('Giảm giá ' + variantData.discount_percentage + '%');
            } else {
                $('#product-price').text(formatPrice(variantData.price));
                $('#discount-message').text('');
            }

            selectedVariantPrice = discountedPrice; // Gán giá của biến thể sau khi tính toán
            console.log(selectedVariantPrice);

            // Cập nhật tồn kho cho biến thể
            $('.sku').text(variantData.stock);
            var stock = variantData.stock;
            if (stock <= 0) {
                $('.action-buttons').hide();
                $('#out-of-stock-message').show();
            } else {
                $('.action-buttons').show();
                $('#out-of-stock-message').hide();
            }

            $('#error-message').text('');
        });

        // Khi người dùng nhấn nút "Thêm vào giỏ hàng"
        $(document).on('click', '#add-to-cart', function(e) {
            e.preventDefault();
            var productId = $('#product-id').val();
            var quantity = $('#quantity').val();

            var imageUrl = $('#product-image').data('default-src') || null;

            // Kiểm tra nếu sản phẩm có biến thể
            if ($('.variant-btn').length > 0 && (!selectedVariantId || selectedVariantId === "")) {
                $('#error-message').text('Vui lòng chọn một biến thể sản phẩm!');
                return;
            }
            var price;

            if (selectedVariantPrice) {
                // Nếu có giá biến thể
                price = selectedVariantPrice;
            } else {
                // Nếu không có giá biến thể, kiểm tra giảm giá
                if (discountPrice) {
                    // Nếu có giảm giá, hiển thị giá giảm trước
                    price = discountPrice;
                } else {
                    // Nếu không có giảm giá, hiển thị giá gốc
                    price = parseInt(originalPrice.replace('₫', '').replace(/,/g, ''));
                }
            }

            // Hiển thị giá khi thêm vào giỏ hàng
            console.log(formatPrice(price)); // Kiểm tra kết quả format

            // Tiến hành xử lý thêm vào giỏ hàng như trước
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
</script> -->

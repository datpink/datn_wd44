<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> --}}
<input type="hidden" name="" id="discount_price" value="{{ $product->discount_price }}">

<script>
    $(document).ready(function() {

        // Sự kiện khi chọn biến thể
        $(document).on('click', '.variant-btn', function() {
            // Xóa trạng thái active của các nút khác và thêm trạng thái active vào nút hiện tại
            $('.variant-btn').removeClass('active');
            $(this).addClass('active');

            // Lấy thông tin biến thể từ thuộc tính data-variant của nút
            var variantData = $(this).data('variant');

            // Gán ID biến thể vào biến selectedVariantId
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
        });
    });

    document.addEventListener("DOMContentLoaded", function() {

        // Phần mô tả sản phẩm
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
                icon.classList.add("icon-up"); // Xoay mũi tên hướng lên
                this.innerHTML = '<i class="fa fa-chevron-up toggle-icon"></i> Thu gọn nội dung';
            } else {
                content.classList.remove("content-expanded");
                content.classList.add("content-collapsed");
                icon.classList.remove("icon-up"); // Mũi tên trở lại hướng xuống
                this.innerHTML = '<i class="fa fa-chevron-down toggle-icon"></i> Xem thêm nội dung';
            }
        });


        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Khi người dùng nhấn vào một nút chọn biến thể
        $(document).ready(function() {
            let selectedVariantId = null;
            let selectedVariantPrice = 0; // Biến lưu trữ giá của biến thể đã chọn

            // Kiểm tra nếu sản phẩm không có biến thể
            if ($('.variant-btn').length === 0) {
                var stock = {{ $product->stock }};
                if (stock <= 0) {
                    $('.action-buttons').hide();
                    $('#out-of-stock-message').show();
                } else {
                    $('.action-buttons').show();
                    $('#out-of-stock-message').hide();
                }
            }

            // Sự kiện khi chọn biến thể
            $(document).on('click', '.variant-btn', function() {
                let discountPrice = document.getElementById('discount_price').value;
                $('.variant-btn').removeClass('active');
                $(this).addClass('active');

                var variantData = $(this).data('variant');
                selectedVariantId = variantData.id;
                // console.log(123);

                var discountedPrice = variantData.price;
                var discount = discountPrice; // Lấy giá giảm từ sản phẩm chính
                console.log(discount);


                // Tính giá sau giảm cho biến thể
                if (discount) {
                    discountedPrice = variantData.price - ({{ $product->price }} - discount);
                }

                // Hiển thị giá sản phẩm theo biến thể
                if (discountedPrice < variantData.price) {
                    $('#product-price').html('<strike>' + variantData.price.toLocaleString() +
                        '₫</strike> ' + discountedPrice.toLocaleString() + '₫');
                    $('#discount-message').text('Giảm giá ' + variantData.discount_percentage +
                        '%');
                } else {
                    $('#product-price').text(variantData.price.toLocaleString() + '₫');
                    $('#discount-message').text('');
                }

                // Lưu giá đã giảm vào biến
                selectedVariantPrice = discountedPrice;

                // Cập nhật ảnh và ID biến thể
                var productImage = $('#product-image').data('default-src');
                $('#product-image').attr('src', productImage);
                $('#selected-variant-id').val(selectedVariantId);

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

                var selectedVariantId = $('#selected-variant-id').val();
                var productId = $('#product-id').val();
                var quantity = $('#quantity').val();
                var price = selectedVariantPrice; // Sử dụng giá đã giảm của biến thể đã chọn
                var imageUrl = $('#product-image').data('default-src') || null;

                // Kiểm tra nếu sản phẩm có biến thể
                if ($('.variant-btn').length > 0 && (!selectedVariantId || selectedVariantId ===
                        "")) {
                    $('#error-message').text('Vui lòng chọn một biến thể sản phẩm!');
                    return;
                }

                // Lấy dữ liệu tồn kho cho biến thể đã chọn từ variantData
                var variantStock = parseInt($('#selected-variant-id').data('stock'));

                // Kiểm tra tồn kho trước khi thêm vào giỏ hàng
                if (quantity > variantStock) {
                    $('#error-message').text(
                        'Số lượng sản phẩm vượt quá tồn kho của biến thể này!');
                    return;
                }

                // Gửi dữ liệu qua AJAX để thêm vào giỏ hàng
                $.ajax({
                    url: '{{ route('cart.add') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        variant_id: selectedVariantId,
                        quantity: quantity,
                        price: price, // Gửi giá đã giảm cho biến thể
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
</script>

<script>
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
</script>

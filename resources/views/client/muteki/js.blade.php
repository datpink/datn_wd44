<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> --}}


<script>
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
        let selectedVariantId = null; // Khai báo và gán mặc định

        // Khi người dùng chọn một biến thể
        $('.variant-btn').on('click', function() {
            // Xóa trạng thái active của các nút khác và thêm trạng thái active vào nút hiện tại
            $('.variant-btn').removeClass('active');
            $(this).addClass('active');

            // Lấy thông tin biến thể từ thuộc tính data-variant của nút
            var variantData = $(this).data('variant');

            // Gán ID biến thể vào biến selectedVariantId
            selectedVariantId = variantData.id;

            // Hiển thị giá sản phẩm theo biến thể
            $('#product-price').text(variantData.price);

            var productImage = $('#product-image').data(
                'default-src'); // Lấy ảnh sản phẩm chính từ data-default-src

            $('#product-image').attr('src', productImage);

            // Gắn giá trị ID của biến thể vào input ẩn để gửi đi
            $('#selected-variant-id').val(selectedVariantId);

            // Xóa thông báo lỗi (nếu có)
            $('#error-message').text('');
        });

        // Xử lý khi người dùng nhấn nút "Thêm vào giỏ hàng"
        // Khi người dùng nhấn nút "Thêm vào giỏ hàng"
        $('#add-to-cart').on('click', function(e) {
            e.preventDefault(); // Ngăn form submit mặc định

            // Kiểm tra xem đã chọn biến thể hay chưa
            if (!selectedVariantId) {
                selectedVariantId = null;
            }

            // Lấy các giá trị cần thiết
            var productId = $('#product-id').val(); // ID sản phẩm
            var quantity = $('#quantity').val(); // Số lượng sản phẩm
            var price = $('#product-price').text().replace(/[^0-9.-]+/g, ''); // Loại bỏ ký hiệu tiền tệ

            // Gửi dữ liệu qua AJAX
            $.ajax({
                url: '{{ route('cart.add') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    variant_id: selectedVariantId || null, // Null nếu không có biến thể
                    quantity: quantity,
                    price: price, // Giá đã loại bỏ ký hiệu tiền tệ
                    image_url: $('#product-image').data('default-src') ||
                        null, // Gửi ảnh biến thể hoặc ảnh sản phẩm chính
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

                    // Gọi hàm cập nhật giỏ hàng tạm sau khi thêm sản phẩm thành công
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
            document.querySelector('.count').textContent = count;
            document.querySelector('.minicart-number-items').textContent = count;
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
        // Hàm cập nhật hiển thị số lượng giỏ hàng
        function updateCartCount(count) {
            // Chỉ thay đổi số lượng mà không thay đổi các thành phần khác
            $('.minicart-number-items, .cart').text(count);
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

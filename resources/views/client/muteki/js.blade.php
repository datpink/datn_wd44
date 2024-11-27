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
        $(document).ready(function() {
            // Lấy giá min và max từ server (có thể lưu bằng HTML data-attributes)
            var minPrice = {{ $minPrice }};
            var maxPrice = {{ $maxPrice }};
            var originalPrice = "{{ number_format($product->price, 0, ',', '.') }}₫";
            var isVariantProduct = {{ $product->variants->isNotEmpty() ? 'true' : 'false' }};

            // Hiển thị giá min-max ban đầu nếu sản phẩm có biến thể
            if (isVariantProduct) {
                $('#product-price').text(formatPrice(minPrice) + '₫ - ' + formatPrice(maxPrice) + '₫');
            }

            // Khi chọn biến thể
            $('.variant-btn').on('click', function() {
                var selectedPrice = $(this).data('price');
                $('#product-price').text(selectedPrice); // Hiển thị giá biến thể đã chọn
            });

            // Khi bỏ chọn hoặc không chọn biến thể nào
            $('.variant-options').on('mouseleave', function() {
                if (isVariantProduct) {
                    $('#product-price').text(formatPrice(minPrice) + '₫ - ' + formatPrice(
                        maxPrice) + '₫');
                } else {
                    $('#product-price').text(originalPrice);
                }
            });

            // Hàm định dạng giá
            function formatPrice(price) {
                return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        });

        document.querySelectorAll('.variant-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Lấy thông tin biến thể từ data-variant
                const variant = JSON.parse(this.getAttribute('data-variant'));
                const price = variant.price;
                const imgUrl = this.getAttribute('data-img-url');
                const storage = this.getAttribute('data-dung-luong');
                const color = this.getAttribute('data-mau-sac');

                // Cập nhật giá
                const priceElement = document.getElementById('product-price');
                if (priceElement) {
                    priceElement.innerText = numberWithCommas(price) + '₫';
                }

                // Cập nhật hình ảnh sản phẩm
                const imgElement = document.getElementById('product-img');
                if (imgElement) {
                    imgElement.src = imgUrl ? imgUrl : '/path/to/default-image.jpg';
                }

                // Hiển thị dung lượng và màu sắc đã chọn
                const storageElement = document.getElementById('selected-storage');
                const colorElement = document.getElementById('selected-color');
                if (storageElement) {
                    storageElement.innerText = `Dung lượng: ${storage}`;
                }
                if (colorElement) {
                    colorElement.innerText = `Màu sắc: ${color}`;
                }

                // Cập nhật trạng thái của các nút
                document.querySelectorAll('.variant-btn').forEach(btn => {
                    btn.classList.remove(
                        'active'); // Xóa lớp active khỏi tất cả các nút
                });

                // Thêm lớp active vào nút đang được chọn
                this.classList.add('active');
            });
        });

        // Hàm giúp định dạng giá theo định dạng Việt Nam (ví dụ: 1.000.000₫)
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }


        // Khi nhấn "Thêm vào giỏ hàng"
        // document.getElementById('add-to-cart').addEventListener('click', function(e) {
        //     e.preventDefault();

        //     const productId = '{{ $product->id }}';
        //     const quantity = document.getElementById('quantity').value;
        //     const productImage = '{{ \Storage::url($product->image_url) }}';
        //     const variantIds = getVariantIds(); // Lấy tất cả variantIds từ hàm getVariantIds

        //     console.log('Variant IDs:', variantIds); // Kiểm tra mảng variantIds

        //     if (variantIds.length > 0) {
        //         if (selectedStorage && selectedColor) {
        //             variantId = variantIds; // Truyền cả dung lượng và màu sắc dưới dạng mảng
        //         } else {
        //             Swal.fire({
        //                 position: 'top',
        //                 icon: 'warning',
        //                 title: 'Chưa chọn đầy đủ',
        //                 toast: true,
        //                 text: 'Vui lòng chọn cả dung lượng và màu sắc!',
        //                 showConfirmButton: false,
        //                 timerProgressBar: true,
        //                 timer: 3500
        //             });
        //             return; // Ngừng hàm lại nếu chưa chọn đủ thông tin
        //         }
        //     } else {
        //         // Nếu sản phẩm không có biến thể, sử dụng giá trị mặc định
        //         variantId = null; // Không có biến thể
        //     }
        //     alert(variantIds)
        //     $.ajax({
        //         url: '{{ route('cart.add') }}',
        //         method: 'POST',
        //         data: {
        //             _token: '{{ csrf_token() }}',
        //             product_id: productId,
        //             variant_ids: variantIds, // Truyền cả mảng variantIds
        //             price: currentPrice, // Đảm bảo currentPrice được định nghĩa ở đâu đó
        //             quantity: quantity,
        //             selected_storage: selectedStorage, // Truyền storage nếu có
        //             selected_color: selectedColor, // Truyền color nếu có
        //             product_image: productImage,
        //         },
        //         success: function(response) {
        //             showSuccessMessage(response.message);
        //             updateTemporaryCart();
        //         },
        //         error: function(xhr) {
        //             showErrorMessage();
        //             console.log(xhr.responseText); // In ra lỗi từ server
        //         }
        //     });
        // });


        function updateTemporaryCart() {
            $.ajax({
                url: '{{ route('cart.temporary') }}', // Đường dẫn route lấy giỏ hàng tạm
                method: 'GET',
                success: function(data) {
                    $('.header-control-inner .meta-dreaming').html(
                        data); // Cập nhật HTML giỏ hàng tạm
                },
                error: function(xhr, status, error) {
                    console.error("Lỗi khi cập nhật giỏ hàng tạm:", status, error);
                }
            });
        }

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


        function updateTemporaryCart() {
            $.ajax({
                url: '{{ route('cart.temporary') }}', // Đường dẫn route lấy giỏ hàng tạm
                method: 'GET',
                success: function(data) {
                    $('.header-control-inner .meta-dreaming').html(
                        data); // Cập nhật HTML giỏ hàng tạm
                },
                error: function(xhr, status, error) {
                    console.error("Lỗi khi cập nhật giỏ hàng tạm:", status, error);
                }
            });
        }

        // Hàm hiển thị thông báo thành công
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

        // Hàm hiển thị thông báo lỗi
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
</script>>

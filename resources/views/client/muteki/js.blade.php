<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


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

        // Phần giỏ hàng
        let selectedStorage = null;
        let selectedColor = null;
        let selectedSize = null;
        let selectedStorageButton = null;
        let selectedColorButton = null;
        let selectedSizeButton = null;

        // Giá gốc của sản phẩm (giá cơ bản)
        const originalPrice = parseFloat("{{ $product->price }}");
        const priceElement = document.getElementById('product-price');
        let currentPrice = originalPrice; // Biến để lưu giá hiện tại sau khi chọn biến thể


        // Lấy danh sách biến thể từ PHP (dung lượng, màu sắc, kích thước và giá tương ứng)
        const variants = {!! json_encode(
            $product->variants->map(function ($variant) {
                    return [
                        'price' => $variant->price,
                        'attributes' => $variant->attributeValues->map(function ($attributeValue) {
                            return [
                                'name' => $attributeValue->attribute->name,
                                'value' => $attributeValue->name,
                            ];
                        }),
                    ];
                })->toArray(),
        ) !!};

        // Hiển thị giá
        function updatePrice() {
            let totalPrice = originalPrice;
            let minPrice = originalPrice;
            let maxPrice = originalPrice;
            let isVariantSelected = false;

            if (variants.length === 0) {
                priceElement.innerHTML = new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(originalPrice);
                currentPrice = originalPrice; // Cập nhật currentPrice khi không có biến thể
                return;
            }

            variants.forEach(variant => {
                const variantPrice = variant.price;
                if (variantPrice < minPrice) minPrice = variantPrice;
                if (variantPrice > maxPrice) maxPrice = variantPrice;
            });

            if (selectedStorage) {
                const foundStorageVariant = variants.find(variant =>
                    variant.attributes.some(attr => attr.name === 'Storage' && attr.value ===
                        selectedStorage)
                );
                if (foundStorageVariant) {
                    totalPrice += foundStorageVariant.price - originalPrice;
                    isVariantSelected = true;
                }
            }

            if (selectedColor) {
                const foundColorVariant = variants.find(variant =>
                    variant.attributes.some(attr => attr.name === 'Color' && attr.value === selectedColor)
                );
                if (foundColorVariant) {
                    totalPrice += foundColorVariant.price - originalPrice;
                    isVariantSelected = true;
                }
            }

            if (selectedSize) {
                const foundSizeVariant = variants.find(variant =>
                    variant.attributes.some(attr => attr.name === 'Size' && attr.value === selectedSize)
                );
                if (foundSizeVariant) {
                    totalPrice += foundSizeVariant.price - originalPrice;
                    isVariantSelected = true;
                }
            }

            currentPrice = totalPrice; // Cập nhật currentPrice sau khi chọn biến thể

            if (!isVariantSelected && minPrice === maxPrice) {
                priceElement.innerHTML = new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(originalPrice);
            } else if (!isVariantSelected) {
                priceElement.innerHTML = `${new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }).format(minPrice)} - ${new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }).format(maxPrice)}`;
            } else {
                priceElement.innerHTML = new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(totalPrice);
            }
        }


        // Sử dụng event delegation để lắng nghe sự kiện click
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('variant-btn')) {
                const storage = event.target.getAttribute('data-dung-luong');
                const color = event.target.getAttribute('data-mau-sac');
                const size = event.target.getAttribute('data-size');

                // Kiểm tra nếu là nút dung lượng
                if (storage) {
                    if (selectedStorage === storage) {
                        resetButton(selectedStorageButton);
                        selectedStorage = null;
                        selectedStorageButton = null;
                    } else {
                        if (selectedStorageButton) resetButton(selectedStorageButton);
                        selectedStorage = storage;
                        selectedStorageButton = event.target;
                        selectButton(selectedStorageButton);
                    }
                }

                // Kiểm tra nếu là nút màu sắc
                if (color) {
                    if (selectedColor === color) {
                        resetButton(selectedColorButton);
                        selectedColor = null;
                        selectedColorButton = null;
                    } else {
                        if (selectedColorButton) resetButton(selectedColorButton);
                        selectedColor = color;
                        selectedColorButton = event.target;
                        selectButton(selectedColorButton);
                    }
                }

                // Kiểm tra nếu là nút kích thước
                if (size) {
                    if (selectedSize === size) {
                        resetButton(selectedSizeButton);
                        selectedSize = null;
                        selectedSizeButton = null;
                    } else {
                        if (selectedSizeButton) resetButton(selectedSizeButton);
                        selectedSize = size;
                        selectedSizeButton = event.target;
                        selectButton(selectedSizeButton);
                    }
                }

                // Cập nhật giá dựa trên các lựa chọn hiện tại
                updatePrice();
            }
        });

        // Hàm để đặt lại trạng thái của nút về mặc định
        function resetButton(button) {
            if (button) {
                button.style.backgroundColor = 'white'; // Màu nền trắng
                button.style.border = '1px solid black'; // Viền đen
            }
        }

        // Hàm để cập nhật trạng thái của nút khi được chọn
        function selectButton(button) {
            if (button) {
                button.style.backgroundColor = 'white'; // Màu nền trắng
                button.style.border = '2px solid red'; // Viền đỏ
            }
        }

        // Khi nhấn "Thêm vào giỏ hàng"
        document.getElementById('add-to-cart').addEventListener('click', function(e) {
            e.preventDefault();

            const productId = '{{ $product->id }}';
            const quantity = document.getElementById('quantity').value;
            const productImage = '{{ \Storage::url($product->image_url) }}';

            if (variants.length > 0) {
                if (selectedStorage && selectedColor) {
                    const variantId = document.getElementById('selected-variant-id').value;

                    $.ajax({
                        url: '{{ route('cart.add') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            product_id: productId,
                            variant_id: variantId,
                            price: currentPrice,
                            quantity: quantity,
                            selected_storage: selectedStorage,
                            selected_color: selectedColor,
                            product_image: productImage,
                        },
                        success: function(response) {
                            Swal.fire({
                                position: 'top',
                                icon: 'success',
                                title: 'Thành công!',
                                text: response.message,
                                showConfirmButton: false,
                                timerProgressBar: true,
                                timer: 1500
                            });

                            // Gọi AJAX để cập nhật giỏ hàng tạm
                            updateTemporaryCart();
                        },
                        error: function(xhr) {
                            Swal.fire({
                                position: 'top',
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Có lỗi xảy ra, vui lòng thử lại!',
                                showConfirmButton: false,
                                timerProgressBar: true,
                                timer: 1500
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        position: 'top',
                        icon: 'warning',
                        title: 'Chưa chọn đầy đủ',
                        text: 'Vui lòng chọn cả dung lượng và màu sắc!',
                        showConfirmButton: false,
                        timerProgressBar: true,
                        timer: 1500
                    });
                }
            } else {
                // Trường hợp sản phẩm không có biến thể
                $.ajax({
                    url: '{{ route('cart.add') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        price: currentPrice,
                        quantity: quantity,
                        product_image: productImage,
                    },
                    success: function(response) {
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: 'Thành công!',
                            text: response.message,
                            showConfirmButton: false,
                            timerProgressBar: true,
                            timer: 1500
                        });
                        // Gọi AJAX để cập nhật giỏ hàng tạm
                        updateTemporaryCart();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Có lỗi xảy ra, vui lòng thử lại!',
                            showConfirmButton: false,
                            timerProgressBar: true,
                            timer: 1500
                        });
                    }
                });
            }
        });

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
    });
</script>

<script>
    function confirmDeleteReply(replyId) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa phản hồi này?',
            text: "Hành động này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-reply-form-' + replyId).submit();
            }
        });
    }

    function confirmDeleteComment(commentId) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa bình luận này?',
            text: "Hành động này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-comment-form-' + commentId).submit();
            }
        });
    }
</script>>

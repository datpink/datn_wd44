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

        // Phần giỏ hàng
        // Khai báo các biến để lưu trữ các lựa chọn
        let selectedStorage = null;
        let selectedColor = null;
        let selectedSize = null;
        let selectedStorageButton = null;
        let selectedColorButton = null;
        let selectedSizeButton = null;
        let selectedVariantId = null; // Biến để lưu variantId

        // Lấy danh sách biến thể từ PHP (dung lượng, màu sắc, kích thước và giá tương ứng)
        const variants = {!! json_encode(
            $product->variants->map(function ($variant) {
                    return [
                        'variant_id' => $variant->id, // Lưu variant_id vào đây
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

        const originalPrice = parseFloat("{{ $product->price }}");
        const priceElement = document.getElementById('product-price');
        let currentPrice = originalPrice; // Biến để lưu giá hiện tại sau khi chọn biến thể

        // Hàm cập nhật giá
        function updatePrice() {
            let minPrice = originalPrice; // Khởi tạo minPrice bằng giá gốc
            let maxPrice = originalPrice; // Khởi tạo maxPrice bằng giá gốc
            let isVariantSelected = false; // Kiểm tra xem có biến thể nào được chọn

            // Nếu sản phẩm có biến thể
            if (variants.length > 0) {
                variants.forEach(variant => {
                    const variantPrice = variant.price;
                    if (variantPrice < minPrice) minPrice = variantPrice;
                    if (variantPrice > maxPrice) maxPrice = variantPrice;
                });

                // Hiển thị giá min-max cho sản phẩm có biến thể
                priceElement.innerHTML = `${new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
            }).format(minPrice)} - ${new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(maxPrice)}`;

                // Cập nhật giá khi có lựa chọn biến thể
                let totalPrice = originalPrice; // Giá ban đầu sẽ được sử dụng làm cơ sở

                // Kiểm tra biến thể Storage
                if (selectedStorage) {
                    const foundStorageVariant = variants.find(variant =>
                        variant.attributes.some(attr => attr.name === 'Storage' && attr.value ===
                            selectedStorage)
                    );
                    if (foundStorageVariant) {
                        totalPrice = foundStorageVariant.price;
                        isVariantSelected = true;
                    }
                }

                // Kiểm tra biến thể Color
                if (selectedColor) {
                    const foundColorVariant = variants.find(variant =>
                        variant.attributes.some(attr => attr.name === 'Color' && attr.value ===
                            selectedColor)
                    );
                    if (foundColorVariant) {
                        totalPrice = foundColorVariant.price;
                        isVariantSelected = true;
                    }
                }

                // Kiểm tra biến thể Size
                if (selectedSize) {
                    const foundSizeVariant = variants.find(variant =>
                        variant.attributes.some(attr => attr.name === 'Size' && attr.value === selectedSize)
                    );
                    if (foundSizeVariant) {
                        totalPrice = foundSizeVariant.price;
                        isVariantSelected = true;
                    }
                }

                // Cập nhật giá cuối cùng sau khi chọn biến thể
                currentPrice = totalPrice;

                // Nếu đã chọn biến thể, hiển thị giá mới
                if (isVariantSelected) {
                    priceElement.innerHTML = new Intl.NumberFormat('vi-VN', {
                        style: 'currency',
                        currency: 'VND'
                    }).format(totalPrice);
                }
            } else {
                // Nếu không có biến thể, chỉ hiển thị giá đơn
                priceElement.innerHTML = new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(originalPrice);
            }
        }


        // Gọi hàm để cập nhật giá khi trang tải
        updatePrice();



        // Sử dụng event delegation để lắng nghe sự kiện click
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('variant-btn')) {
                const storage = event.target.getAttribute('data-dung-luong');
                const color = event.target.getAttribute('data-mau-sac');

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

                // Cập nhật giá dựa trên các lựa chọn hiện tại
                updatePrice();
            }
        });
        // Hàm để lấy variantId dựa trên các lựa chọn (Storage và Color)
        function getVariantIds() {
            let variantIds = [];

            // Kiểm tra nếu đã chọn cả Storage và Color
            if (selectedStorage && selectedColor) {
                const selectedStorageVariantBtn = document.querySelector(
                    `button[data-dung-luong="${selectedStorage}"]`);
                const selectedColorVariantBtn = document.querySelector(
                    `button[data-mau-sac="${selectedColor}"]`);

                if (selectedStorageVariantBtn && selectedColorVariantBtn) {
                    variantIds.push(selectedStorageVariantBtn.getAttribute('data-variant-id'));
                    variantIds.push(selectedColorVariantBtn.getAttribute('data-variant-id'));
                }
            }
            // Kiểm tra nếu chỉ chọn Storage
            else if (selectedStorage) {
                const selectedVariantBtn = document.querySelector(
                    `button[data-dung-luong="${selectedStorage}"]`);
                if (selectedVariantBtn) {
                    variantIds.push(selectedVariantBtn.getAttribute('data-variant-id'));
                }
            }
            // Kiểm tra nếu chỉ chọn Color
            else if (selectedColor) {
                const selectedVariantBtn = document.querySelector(
                    `button[data-mau-sac="${selectedColor}"]`);
                if (selectedVariantBtn) {
                    variantIds.push(selectedVariantBtn.getAttribute('data-variant-id'));
                }
            }

            return variantIds; // Trả về mảng chứa các variantIds
        }

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
            const variantIds = getVariantIds(); // Lấy tất cả variantIds từ hàm getVariantIds

            console.log('Variant IDs:', variantIds); // Kiểm tra mảng variantIds

            if (variantIds.length > 0) {
                if (selectedStorage && selectedColor) {
                    variantId = variantIds; // Truyền cả dung lượng và màu sắc dưới dạng mảng
                } else {
                    Swal.fire({
                        position: 'top',
                        icon: 'warning',
                        title: 'Chưa chọn đầy đủ',
                        toast: true,
                        text: 'Vui lòng chọn cả dung lượng và màu sắc!',
                        showConfirmButton: false,
                        timerProgressBar: true,
                        timer: 3500
                    });
                    return; // Ngừng hàm lại nếu chưa chọn đủ thông tin
                }
            } else {
                // Nếu sản phẩm không có biến thể, sử dụng giá trị mặc định
                variantId = null; // Không có biến thể
            }
            alert(variantIds)
            $.ajax({
                url: '{{ route('cart.add') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    variant_ids: variantIds, // Truyền cả mảng variantIds
                    price: currentPrice, // Đảm bảo currentPrice được định nghĩa ở đâu đó
                    quantity: quantity,
                    selected_storage: selectedStorage, // Truyền storage nếu có
                    selected_color: selectedColor, // Truyền color nếu có
                    product_image: productImage,
                },
                success: function(response) {
                    showSuccessMessage(response.message);
                    updateTemporaryCart();
                },
                error: function(xhr) {
                    showErrorMessage();
                    console.log(xhr.responseText); // In ra lỗi từ server
                }
            });
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
</script>>

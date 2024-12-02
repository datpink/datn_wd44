document.addEventListener('DOMContentLoaded', function() {
    let selectedStorage = null;
    let selectedColor = null;
    let selectedSize = null;
    let selectedStorageButton = null;
    let selectedColorButton = null;
    let selectedSizeButton = null;

    // Giá gốc của sản phẩm (giá cơ bản) và giá đã giảm (discount_price)
    const originalPrice = parseFloat("{{ $product->price }}");
    const discountPrice = parseFloat("{{ $product->discount_price }}"); // discount_price luôn tồn tại
    const priceElement = document.getElementById('product-price');

    // Giá hiển thị sẽ là discount_price nếu lớn hơn 0, nếu không dùng giá gốc
    const effectivePrice = discountPrice > 0 ? discountPrice : originalPrice;

    // Lấy danh sách biến thể từ PHP (dung lượng, màu sắc, kích thước và giá tương ứng)
    const variants = {!! json_encode(
        $product->variants->map(function ($variant) {
            return [
                'price' => $variant->discount_price > 0 ? $variant->discount_price : $variant->price, // Nếu có discount_price > 0 thì dùng giá đã giảm
                'attributes' => $variant->attributeValues->map(function ($attributeValue) {
                    return [
                        'name' => $attributeValue->attribute->name,
                        'value' => $attributeValue->name,
                    ];
                }),
            ];
        }),
    ) !!};

    // Hiển thị giá
    function updatePrice() {
        let totalPrice = effectivePrice;
        let minPrice = effectivePrice; // Giá tối thiểu khởi tạo là giá đã giảm hoặc giá gốc
        let maxPrice = effectivePrice; // Giá tối đa khởi tạo là giá đã giảm hoặc giá gốc
        let isVariantSelected = false;

        // Nếu không có biến thể nào
        if (variants.length === 0) {
            priceElement.innerHTML = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(effectivePrice);
            return;
        }

        // Tính toán giá tối thiểu và tối đa từ danh sách biến thể
        variants.forEach(variant => {
            const variantPrice = variant.price;
            if (variantPrice < minPrice) {
                minPrice = variantPrice; // Cập nhật giá tối thiểu
            }
            if (variantPrice > maxPrice) {
                maxPrice = variantPrice; // Cập nhật giá tối đa
            }
        });

        // Tìm biến thể lưu trữ được chọn và cộng giá nếu có
        if (selectedStorage) {
            const foundStorageVariant = variants.find(variant =>
                variant.attributes.some(attr => attr.name === 'Storage' && attr.value === selectedStorage)
            );
            if (foundStorageVariant) {
                totalPrice += foundStorageVariant.price - effectivePrice; // Cộng thêm giá biến thể lưu trữ
                isVariantSelected = true;
            }
        }

        // Tìm biến thể màu sắc được chọn và cộng giá nếu có
        if (selectedColor) {
            const foundColorVariant = variants.find(variant =>
                variant.attributes.some(attr => attr.name === 'Color' && attr.value === selectedColor)
            );
            if (foundColorVariant) {
                totalPrice += foundColorVariant.price - effectivePrice; // Cộng thêm giá biến thể màu sắc
                isVariantSelected = true;
            }
        }

        // Tìm biến thể kích thước được chọn và cộng giá nếu có
        if (selectedSize) {
            const foundSizeVariant = variants.find(variant =>
                variant.attributes.some(attr => attr.name === 'Size' && attr.value === selectedSize)
            );
            if (foundSizeVariant) {
                totalPrice += foundSizeVariant.price - effectivePrice; // Cộng thêm giá biến thể kích thước
                isVariantSelected = true;
            }
        }

        // Hiển thị giá
        if (!isVariantSelected && minPrice === maxPrice) {
            // Nếu không có biến thể được chọn và giá min = max, hiển thị giá đơn lẻ
            priceElement.innerHTML = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(effectivePrice);
        } else if (!isVariantSelected) {
            // Nếu không có biến thể được chọn, hiển thị giá min và max
            priceElement.innerHTML = `${new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(minPrice)} - ${new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(maxPrice)}`;
        } else {
            // Nếu có biến thể được chọn, hiển thị giá tổng
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

    // Hiển thị giá gốc khi trang được tải
    updatePrice();
});

// Giỏ hàng
$(document).ready(function() {
    let selectedVariantId = null;
    let isSingleProduct = {{ $product->variants->isEmpty() ? 'true' : 'false' }}; 
    let productId = "{{ $product->id }}";

    // Khi người dùng chọn dung lượng hoặc màu sắc (có biến thể)
    $('.attribute-group .variant-btn').on('click', function() {
        selectedVariantId = $(this).data('variant-id');
        $('.variant-btn').removeClass('selected');
        $(this).addClass('selected');
    });

    // Xử lý sự kiện thêm vào giỏ hàng
    $('#add-to-cart').on('click', function() {
        let data = {
            _token: '{{ csrf_token() }}',
            quantity: 1 // Số lượng mặc định là 1
        };

        if (isSingleProduct) {
            // Nếu sản phẩm không có biến thể
            data.product_id = productId;
        } else {
            // Nếu sản phẩm có biến thể, kiểm tra xem có chọn biến thể hay chưa
            if (!selectedVariantId) {
                alert('Vui lòng chọn dung lượng hoặc màu sắc.');
                return;
            }
            data.variant_id = selectedVariantId;
        }

        $.ajax({
            url: '/cart/add', // Route xử lý trong Laravel
            method: 'POST',
            data: data,
            success: function(response) {
                alert('Sản phẩm đã được thêm vào giỏ hàng.');
                updateCartCount(response.cart_count);
            },
            error: function(xhr) {
                alert('Có lỗi xảy ra khi thêm vào giỏ hàng. Vui lòng thử lại.');
            }
        });
    });

    // Hàm cập nhật số lượng giỏ hàng (nếu có)
    function updateCartCount(count) {
        $('#cart-count').text(count);
    }
});

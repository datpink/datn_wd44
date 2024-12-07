@extends('admin.master')

@section('title', 'Thêm Biến Thể')

@section('content')
    <h4>Thêm Biến Thể cho Sản Phẩm: {{ $product->name }}</h4>

    <form action="{{ route('variants.store', $product->id) }}" class="was-validated" method="POST"
        enctype="multipart/form-data" id="variantForm">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="variant_name">Tên Biến Thể</label>
                    <input type="text" name="variant_name" class="form-control" id="variant_name" required>
                </div>
                <div class="form-group">
                    <label for="price">Giá</label>
                    <input type="number" name="price" class="form-control" id="price" required>
                </div>
                <div class="form-group">
                    <label for="sku">SKU</label>
                    <input type="text" name="sku" class="form-control" id="sku" readonly required>
                </div>
                <div class="form-group">
                    <label for="stock">Số lượng tồn kho</label>
                    <input type="number" name="stock" class="form-control" id="stock" required>
                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">
                    <label for="colors">Màu Sắc</label>
                    <select name="attributes[color]" class="form-control" id="colors" required>
                        <option value="" selected>Chọn màu sắc</option>
                        @forelse ($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                        @empty
                            <option value="" disabled>Không có màu sắc</option>
                        @endforelse
                    </select>
                </div>
                <div class="form-group">
                    <label for="storages">Dung Lượng</label>
                    <select name="attributes[storage]" class="form-control" id="storages" required>
                        <option value="" selected>Chọn dung lượng</option>
                        @forelse ($storages as $storage)
                            <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                        @empty
                            <option value="" disabled>Không có dung lượng</option>
                        @endforelse
                    </select>
                </div>

                <div class="form-group">
                    <label for="image_url">Hình Ảnh</label>
                    <input type="file" name="image_url" class="form-control" accept="image/*"
                        onchange="previewImage(event)" required>
                    <img id="image-preview" src="" alt="Hình ảnh xem trước"
                        style="max-width: 150px; height: auto; display: none;" class="mt-2">
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <button type="submit" class="btn btn-success rounded-pill" id="submitButton" disabled>Thêm Biến Thể</button>
            <div>
                <button type="button" class="btn btn-secondary rounded-pill me-2" id="generateSkuBtn">Tạo SKU</button>
                <a href="{{ route('products.variants.index', $product->id) }}" class="btn btn-secondary rounded-pill">Quay
                    lại</a>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        // Enable/Disable submit button based on form validation
        function validateForm() {
            const variantName = document.getElementById('variant_name').value.trim();
            const price = document.querySelector('input[name="price"]').value.trim();
            const stock = document.querySelector('input[name="stock"]').value.trim();
            const submitButton = document.getElementById('submitButton');

            // Enable button if all required fields have values
            if (variantName && price && stock) {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        }

        // Add event listeners for form fields
        document.getElementById('variant_name').addEventListener('input', validateForm);
        document.querySelector('input[name="price"]').addEventListener('input', validateForm);
        document.querySelector('input[name="stock"]').addEventListener('input', validateForm);

        // Generate SKU when the button is clicked
        document.getElementById('generateSkuBtn').addEventListener('click', function() {
            const randomSku = 'SKU-' + Math.random().toString(36).substr(2, 9).toUpperCase();
            document.getElementById('sku').value = randomSku;
        });

        // Image preview functionality
        function previewImage(event) {
            const imagePreview = document.getElementById('image-preview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '';
                imagePreview.style.display = 'none';
            }
        }

        // Input validation for weight, price, and stock
        document.addEventListener('DOMContentLoaded', function() {
            const weightInput = document.getElementById('weight');
            const priceInput = document.getElementById('price');
            const stockInput = document.getElementById('stock');

            // Function to validate and reset negative or invalid values
            function validateInput(input, minValue = 0, maxValue = 100000000) {
                input.addEventListener('input', function() {
                    const value = parseFloat(input.value);

                    // Reset if value is less than minimum value (e.g., 0) or invalid
                    if (value < minValue || isNaN(value)) {
                        input.value = ''; // Clear the value
                        input.classList.add('is-invalid');
                    }
                    // If value exceeds the maximum value
                    else if (value > maxValue) {
                        input.value = maxValue; // Set to max value
                        input.classList.add('is-invalid');
                    }
                    // If value is valid
                    else {
                        input.classList.remove('is-invalid');
                    }
                });
            }

            // Apply validation for weight, price, and stock
            validateInput(weightInput, 0);
            validateInput(priceInput, 1); // Price should be at least 1
            validateInput(stockInput, 0);
        });
    </script>
@endsection

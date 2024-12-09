@extends('admin.master')

@section('title', 'Thêm Biến Thể')

@section('content')
    <h4>Thêm Biến Thể cho Sản Phẩm: {{ $product->name }}</h4>

    <form action="{{ route('variants.store', $product->id) }}" class="was-validated" method="POST" enctype="multipart/form-data" id="variantForm">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="variant_name">Tên Biến Thể</label>
                    <input type="text" name="variant_name" class="form-control" id="variant_name" value="{{ old('variant_name') }}" required>
                    @error('variant_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="price">Giá</label>
                    <input type="number" name="price" class="form-control" id="price" value="{{ old('price') }}" required>
                    @error('price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="sku">SKU</label>
                    <input type="text" name="sku" class="form-control" id="sku" readonly value="{{ old('sku', 'SKU-' . strtoupper(Str::random(9))) }}" required>
                    @error('sku')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="stock">Số lượng tồn kho</label>
                    <input type="number" name="stock" class="form-control" id="stock" value="{{ old('stock') }}" required>
                    @error('stock')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="colors">Màu Sắc</label>
                    <select name="attributes[color]" class="form-control" id="colors">
                        <option value="" selected>Chọn màu sắc</option>
                        @forelse ($colors as $color)
                            <option value="{{ $color->id }}" {{ old('attributes.color') == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                        @empty
                            <option value="" disabled>Không có màu sắc</option>
                        @endforelse
                    </select>
                    @error('attributes.color')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="storages">Dung Lượng</label>
                    <select name="attributes[storage]" class="form-control" id="storages">
                        <option value="" selected>Chọn dung lượng</option>
                        @forelse ($storages as $storage)
                            <option value="{{ $storage->id }}" {{ old('attributes.storage') == $storage->id ? 'selected' : '' }}>{{ $storage->name }}</option>
                        @empty
                            <option value="" disabled>Không có dung lượng</option>
                        @endforelse
                    </select>
                    @error('attributes.storage')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image_url">Hình Ảnh</label>
                    <input type="file" name="image_url" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <img id="image-preview" src="{{ old('image_url') }}" alt="Hình ảnh xem trước" style="max-width: 150px; height: auto; display: none;" class="mt-2">
                    @error('image_url')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Hiển thị lỗi duplicate nếu có -->
                @error('duplicate')
                    <div class="alert alert-danger mt-3">
                        {{ $message }}
                    </div>
                @enderror
                @error('attributes')
                    <div class="alert alert-danger mt-3">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <button type="submit" class="btn btn-success rounded-pill" id="submitButton">Thêm Biến Thể</button>
            <div>
                <a href="{{ route('products.variants.index', $product->id) }}" class="btn btn-secondary rounded-pill">Quay lại</a>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
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
    </script>
@endsection

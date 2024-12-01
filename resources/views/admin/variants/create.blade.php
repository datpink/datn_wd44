@extends('admin.master')

@section('title', 'Thêm Biến Thể')

@section('content')
    <h4>Thêm Biến Thể cho Sản Phẩm: {{ $product->name }}</h4>

    <form action="{{ route('variants.store', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="variant_name">Tên Biến Thể</label>
            <input type="text" name="variant_name" class="form-control" id="variant_name" required>
        </div>
        <div class="form-group">
            <label for="price">Giá</label>
            <input type="number" name="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="sku">SKU</label>
            <input type="text" name="sku" class="form-control" id="sku" readonly required>
        </div>
        <div class="form-group">
            <label for="stock">Số lượng tồn kho</label>
            <input type="number" name="stock" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="weight">Cân nặng (kg)</label>
            <input type="number" name="weight" class="form-control" step="0.01">
        </div>
        <div class="form-group">
            <label for="dimension">Kích thước (DxRxC)</label>
            <input type="text" name="dimension" class="form-control">
        </div>
        <div class="form-group">
            <label for="image_url">Hình Ảnh</label>
            <input type="file" name="image_url" class="form-control" accept="image/*" onchange="previewImage(event)">
            <img id="image-preview" src="" alt="Hình ảnh xem trước"
                style="max-width: 150px; height: auto; display: none;" class="mt-2">
        </div>
        <div class="form-group">
            <label for="colors">Màu Sắc</label>
            <select name="attributes[color]" class="form-control" id="colors">
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
            <select name="attributes[storage]" class="form-control" id="storages">
                <option value="" selected>Chọn dung lượng</option>
                @forelse ($storages as $storage)
                    <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                @empty
                    <option value="" disabled>Không có dung lượng</option>
                @endforelse
            </select>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <button type="submit" class="btn btn-success rounded-pill">Thêm Biến Thể</button>
            <div>
                <button type="button" class="btn btn-secondary rounded-pill me-2" id="generateSkuBtn">Tạo SKU</button>
                <a href="{{ route('products.variants.index', $product->id) }}" class="btn btn-secondary rounded-pill">Quay lại</a>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        document.getElementById('generateSkuBtn').addEventListener('click', function() {
            const randomSku = 'SKU-' + Math.random().toString(36).substr(2, 9).toUpperCase(); // Tạo SKU ngẫu nhiên
            document.getElementById('sku').value = randomSku;
        });

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

@extends('admin.master')

@section('title', 'Thêm biến thể')

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
            <label for="stock">Kho</label>
            <input type="number" name="stock" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="attributes">Chọn Thuộc Tính</label>
            <select name="attributes[]" class="form-control" multiple>
                @foreach ($attributeValues as $value)
                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <button type="submit" class="btn btn-success rounded-pill">Thêm Biến Thể</button>
            <div>
                <button type="button" class="btn btn-secondary rounded-pill me-2" id="generateSkuBtn">Tạo SKU</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary rounded-pill">Quay lại</a>
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

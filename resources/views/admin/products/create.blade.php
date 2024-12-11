@extends('admin.master')

@section('title', 'Thêm mới sản phẩm')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Thêm Mới Sản Phẩm</div>
                            <a href="{{ route('products.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Trở về
                            </a>
                        </div>
                        <div class="card-body">
                            <form id="productForm" action="{{ route('products.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="productName" class="form-label">Tên Sản Phẩm</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="productName" name="name" value="{{ old('name') }}"
                                                oninput="ChangeToSlug()">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="sku" class="form-label">SKU</label>
                                            <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                                id="sku" name="sku"
                                                value="{{ old('sku', $sku ?? 'SKU-' . strtoupper(Str::random(9))) }}"
                                                @if (!old('sku')) readonly @endif>
                                            @error('sku')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="mb-3">
                                            <label for="slug" class="form-label">Slug</label>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                value="{{ old('slug') }}" readonly>
                                            @error('slug')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="catalogue_id" class="form-label">Danh Mục</label>
                                            <select class="form-control @error('catalogue_id') is-invalid @enderror"
                                                id="catalogue_id" name="catalogue_id">
                                                <option value="">Chọn danh mục</option>
                                                <!-- Thêm tùy chọn mặc định -->
                                                @foreach ($catalogues as $catalogue)
                                                    <option value="{{ $catalogue->id }}"
                                                        {{ old('catalogue_id') == $catalogue->id ? 'selected' : '' }}>
                                                        {{ $catalogue->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('catalogue_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="brand_id" class="form-label">Thương Hiệu</label>
                                            <select class="form-control" id="brand_id" name="brand_id">
                                                <option value="">Không có</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('brand_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="price" class="form-label">Giá</label>
                                            <input type="number" step="0.01"
                                                class="form-control @error('price') is-invalid @enderror" id="price"
                                                name="price" value="{{ old('price') }}">
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="discount_price" class="form-label">Giảm Giá</label>
                                            <input type="number" step="0.01"
                                                class="form-control @error('discount_price') is-invalid @enderror"
                                                id="discount_price" name="discount_price"
                                                value="{{ old('discount_price') }}">
                                            @error('discount_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="stock" class="form-label">Số Lượng</label>
                                            <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                                id="stock" name="stock" value="{{ old('stock') }}">
                                            @error('stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="is_active" class="form-label">Trạng Thái</label>
                                            <select class="form-control" id="is_active" name="is_active">
                                                <option value="1" selected>Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="image_url" class="form-label">Ảnh Sản Phẩm</label>
                                            <input type="file"
                                                class="form-control @error('image_url') is-invalid @enderror"
                                                id="image_url" name="image_url" onchange="previewImageUrl(event)">
                                            <img id="imageUrlPreview" src="" alt="Hình ảnh xem trước"
                                                class="mt-2" style="display: none; width: 100px;">
                                            @error('image_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="condition" class="form-label">Tình trạng</label>
                                            <select class="form-select" id="condition" name="condition">
                                                {{-- <option value="">Chọn tình trạng</option> --}}
                                                <option value="new">Mới</option>
                                                <option value="used">Đã qua sử dụng</option>
                                                <option value="refurbished">Tái chế</option>
                                            </select>
                                            @error('condition')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div id="image-inputs">
                                            <div class="form-group d-flex align-items-center">
                                                <label for="image1" class="me-2">Gallery 1</label>
                                                <input type="file" name="images[]" id="image1"
                                                    class="form-control me-2" accept="image/*"
                                                    onchange="previewGalleryImage(event, this)">
                                                <button type="button" class="btn btn-secondary add-image">Thêm</button>
                                            </div>
                                        </div>
                                        <div id="gallery" class="mt-3 d-flex flex-wrap"></div>

                                        {{-- <button type="button" id="generateSkuBtn"
                                            class="btn btn-rounded btn-secondary">Tạo
                                            SKU</button> --}}
                                        <button type="submit" class="btn btn-rounded btn-primary">Thêm Mới</button>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="editor" class="form-label">Mô Tả</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="editor" name="description">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="editors" class="form-label">Thông số kĩ thuật</label>
                                            <textarea class="form-control @error('specifications') is-invalid @enderror" id="editors" name="specifications">{{ old('specifications') }}</textarea>
                                            @error('specifications')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="editorss" class="form-label">Tóm tắt</label>
                                            <textarea class="form-control @error('stomtat') is-invalid @enderror" id="editorss" name="tomtat">{{ old('tomtat') }}</textarea>
                                            @error('tomtat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="is_featured" class="form-label">Nổi bật</label>
                                            <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                                {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>
    <script>
        CKEDITOR.replace('editors');
    </script>
    <script>
        CKEDITOR.replace('editorss');
    </script>

    <script>
        function previewImageUrl(event) {
            const imageUrlPreview = document.getElementById('imageUrlPreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imageUrlPreview.src = e.target.result;
                    imageUrlPreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imageUrlPreview.src = '';
                imageUrlPreview.style.display = 'none';
            }
        }
    </script>

    <script>
        document.querySelector('.add-image').addEventListener('click', function() {
            const container = document.getElementById('image-inputs');
            const newIndex = container.children.length + 1; // Tính số lượng trường hiện tại

            const newInput = document.createElement('div');
            newInput.classList.add('form-group', 'd-flex', 'align-items-center', 'mb-3');
            newInput.innerHTML = `
            <label for="image${newIndex}" class="me-2 col-md-1">Gallery ${newIndex}</label>
            <input type="file" name="images[]" id="image${newIndex}" class="form-control me-2" accept="image/*" onchange="previewGalleryImage(event, this)">
            <button type="button" class="btn btn-danger ms-2 remove-image">Xóa</button>
        `;

            container.appendChild(newInput);

            // Xử lý sự kiện cho nút "Xóa" mới
            newInput.querySelector('.remove-image').addEventListener('click', function() {
                container.removeChild(newInput);
                updateGallery(); // Cập nhật lại gallery khi xóa
            });
        });

        function previewGalleryImage(event, input) {
            const gallery = document.getElementById('gallery');
            const file = event.target.files[0];

            // Xóa hình ảnh xem trước cũ nếu có
            const existingImages = gallery.querySelectorAll(`img[data-input-id="${input.id}"]`);
            existingImages.forEach(img => img.remove());

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'gallery-image me-2 mb-2';
                    img.style.width = '100px';
                    img.style.height = 'auto';
                    img.setAttribute('data-input-id', input.id); // Gán ID trường nhập vào hình ảnh
                    gallery.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        }

        function updateGallery() {
            const gallery = document.getElementById('gallery');
            gallery.innerHTML = ''; // Xóa tất cả hình ảnh hiện có

            const images = document.querySelectorAll('input[type="file"]');
            images.forEach(input => {
                const file = input.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'gallery-image me-2 mb-2';
                        img.style.width = '100px';
                        img.style.height = 'auto';
                        img.setAttribute('data-input-id', input.id); // Gán ID trường nhập vào hình ảnh
                        gallery.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    </script>
@endsection

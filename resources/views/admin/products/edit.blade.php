@extends('admin.master')

@section('title', 'Sửa sản phẩm')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Sửa sản phẩm</div>
                            <a href="{{ route('products.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Trở về
                            </a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('products.update', $product) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                <!-- Tên sản phẩm -->
                                <div class="form-group">
                                    <label for="name">Tên sản phẩm</label>
                                    <input type="text" name="name" id="productName" class="form-control"
                                        value="{{ $product->name }}" oninput="ChangeToSlug()">
                                </div>

                                <!-- Slug -->
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control"
                                        value="{{ $product->slug }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="stock" class="form-label">Số Lượng</label>
                                    <input type="number" class="form-control" id="stock" name="stock"
                                        value="{{ $product->stock }}" min="0" required>
                                </div>


                                <!-- Thương hiệu -->
                                <div class="form-group">
                                    <label for="brand_id">Thương hiệu</label>
                                    <select name="brand_id" id="brand_id" class="form-control">
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Danh mục -->
                                <div class="form-group">
                                    <label for="catalogue_id">Danh mục</label>
                                    <select name="catalogue_id" id="catalogue_id" class="form-control">
                                        @foreach ($catalogues as $catalogue)
                                            <option value="{{ $catalogue->id }}"
                                                {{ $product->catalogue_id == $catalogue->id ? 'selected' : '' }}>
                                                {{ $catalogue->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Hình ảnh sản phẩm -->
                                <div class="form-group">
                                    <label for="image_url">Hình ảnh</label>
                                    <input type="file" name="image_url" id="image_url" class="form-control"
                                        onchange="previewImageUrl(event)"><br>

                                    @if ($product->image_url && \Storage::exists($product->image_url))
                                        <img id="imageUrlPreview" src="{{ \Storage::url($product->image_url) }}"
                                            alt="{{ $product->name }}" style="max-width: 100px; height: auto;"
                                            class="mt-2">
                                    @else
                                        <p>Không có ảnh</p>
                                    @endif
                                </div>
                                <!-- Trạng thái hoạt động (is_active) -->
                                <div class="form-group">
                                    <label for="is_active">Trạng thái hoạt động</label>
                                    <select name="is_active" id="is_active" class="form-control">
                                        <option value="1" {{ $product->is_active ? 'selected' : '' }}>Hoạt động
                                        </option>
                                        <option value="0" {{ !$product->is_active ? 'selected' : '' }}>Không hoạt động
                                        </option>
                                    </select>
                                </div>

                                <!-- Giá sản phẩm -->
                                <div class="form-group">
                                    <label for="price">Giá sản phẩm</label>
                                    <input type="number" name="price" id="price" class="form-control"
                                        value="{{ $product->price }}" required>
                                </div>

                                <input type="hidden" name="discount_price" id="discount_price" class="form-control"
                                    value="{{ $product->discount_price }}">


                                <!-- SKU -->
                                <div class="form-group">
                                    <label for="sku">SKU (Mã sản phẩm)</label>
                                    <input type="text" name="sku" id="sku" class="form-control"
                                        value="{{ $product->sku }}">
                                </div>

                                <!-- Cân nặng (Weight) -->
                                <div class="form-group">
                                    <label for="weight">Cân nặng (kg)</label>
                                    <input type="text" name="weight" id="weight" class="form-control"
                                        value="{{ $product->weight }}">
                                </div>

                                <!-- Kích thước (Dimensions) -->
                                <div class="form-group">
                                    <label for="dimensions">Kích thước (DxRxC)</label>
                                    <input type="text" name="dimensions" id="dimensions" class="form-control"
                                        value="{{ $product->dimensions }}">
                                </div>

                                <!-- Tóm tắt sản phẩm -->
                                <div class="form-group">
                                    <label for="tomtat">Tóm tắt</label>
                                    <textarea name="tomtat" id="tomtat" class="form-control" rows="2">{{ $product->tomtat }}</textarea>
                                </div>

                                <!-- Mô tả sản phẩm -->
                                <div class="form-group">
                                    <label for="editor">Mô tả sản phẩm</label>
                                    <textarea name="description" id="editor" class="form-control" rows="4">{{ $product->description }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="is_featured" class="form-label">Nổi bật</label>
                                    <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                        {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                                </div>

                                <div class="mb-3">
                                    <label for="condition" class="form-label">Tình trạng</label>
                                    <select class="form-select" id="condition" name="condition" required>
                                        <option value="">Chọn tình trạng</option>
                                        <option value="new"
                                            {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>Mới
                                        </option>
                                        <option value="used"
                                            {{ old('condition', $product->condition) == 'used' ? 'selected' : '' }}>Đã qua
                                            sử dụng</option>
                                        <option value="refurbished"
                                            {{ old('condition', $product->condition) == 'refurbished' ? 'selected' : '' }}>
                                            Tái chế</option>
                                    </select>
                                </div>

                                <div id="image-inputs">
                                    @foreach ($product->galleries as $index => $gallery)
                                        <div class="form-group d-flex align-items-center">
                                            <label for="image{{ $index + 1 }}" class="me-2">Hình ảnh
                                                {{ $index + 1 }}</label>
                                            <input type="file" name="images[]" id="image{{ $index + 1 }}"
                                                class="form-control me-2" accept="image/*"
                                                onchange="previewGalleryImage(event, this)">
                                            <button type="button" class="btn btn-danger ms-2 remove-image">Xóa</button>
                                            <input type="hidden" name="existing_images[]"
                                                value="{{ $gallery->image_url }}">
                                            <img src="{{ Storage::url($gallery->image_url) }}" alt="Hình ảnh"
                                                style="width: 100px; height: auto; margin-left: 10px;"
                                                data-input-id="image{{ $index + 1 }}" class="gallery-image">
                                        </div>
                                    @endforeach
                                </div>
                                {{-- <button type="button" class="btn btn-secondary add-image">Thêm</button> --}}
                                <div id="gallery" class="mt-3 d-flex flex-wrap"></div>

                                <div class="form-group d-flex align-items-center">
                                    <button type="button" class="btn btn-rounded btn-secondary add-image"
                                        style="margin-right: 15px;">Thêm Hình
                                        Ảnh</button>
                                    <button type="submit" class="btn btn-rounded btn-primary">Cập nhật</button>
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
        function previewImageUrl(event) {
            const imageUrlPreview = document.getElementById('imageUrlPreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imageUrlPreview.src = e.target.result;
                    imageUrlPreview.style.display = 'block'; // Hiện hình ảnh xem trước
                };
                reader.readAsDataURL(file);
            } else {
                // Nếu không có tệp nào được chọn, sẽ giữ nguyên hình ảnh cũ
                imageUrlPreview.src = '';
                imageUrlPreview.style.display = 'none'; // Ẩn hình ảnh xem trước
            }
        }

        function ChangeToSlug() {
            var productName, slug;

            // Lấy text từ thẻ input title
            productName = document.getElementById("productName").value;

            // Đổi chữ hoa thành chữ thường
            slug = productName.toLowerCase();

            // Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');

            // Xóa các ký tự đặc biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');

            // Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, "-");

            // Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');

            // Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');

            // In slug ra textbox có id “slug”
            document.getElementById('slug').value = slug;
        }
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addImageButton = document.querySelector('.add-image');

            // Sự kiện cho nút Thêm
            if (addImageButton) {
                addImageButton.addEventListener('click', function() {
                    const container = document.getElementById('image-inputs');
                    const newIndex = container.children.length + 1; // Tính số lượng trường hiện tại

                    const newInput = document.createElement('div');
                    newInput.classList.add('form-group', 'd-flex', 'align-items-center');
                    newInput.innerHTML = `
                    <label for="image${newIndex}" class="me-2">Hình ảnh ${newIndex}</label>
                    <input type="file" name="images[]" id="image${newIndex}" class="form-control me-2" accept="image/*" onchange="previewGalleryImage(event, this)">
                    <button type="button" class="btn btn-danger ms-2 remove-image">Xóa</button>
                `;

                    container.appendChild(newInput);

                    // Xử lý sự kiện cho nút "Xóa"
                    newInput.querySelector('.remove-image').addEventListener('click', function() {
                        container.removeChild(newInput);
                        updateGallery(); // Cập nhật lại gallery khi xóa
                    });
                });
            }
        });

        function previewGalleryImage(event, input) {
            const file = event.target.files[0];

            // Tìm hình ảnh tương ứng với trường nhập này
            const img = document.querySelector(`img[data-input-id="${input.id}"]`);

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (img) {
                        img.src = e.target.result; // Cập nhật src của hình ảnh với hình mới
                    }
                };
                reader.readAsDataURL(file);
            } else {
                // Nếu không có file, giữ nguyên hình ảnh cũ
                if (img) {
                    const hiddenInput = input.closest('.form-group').querySelector('input[type="hidden"]');
                    img.src = hiddenInput.value; // Đặt lại src về hình ảnh cũ nếu không có file mới
                }
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
                } else {
                    // Kiểm tra hình ảnh hiện có từ input ẩn
                    const existingImage = input.closest('.form-group').querySelector('input[type="hidden"]').value;
                    if (existingImage) {
                        const img = document.createElement('img');
                        img.src = existingImage; // Sử dụng đường dẫn hình ảnh hiện có
                        img.className = 'gallery-image me-2 mb-2';
                        img.style.width = '100px';
                        img.style.height = 'auto';
                        gallery.appendChild(img);
                    }
                }
            });
        }
    </script>
@endsection

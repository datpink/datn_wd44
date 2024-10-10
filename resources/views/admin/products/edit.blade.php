@extends('admin.master')

@section('title', 'Sửa sản phẩm')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('errors'))
                <div class="alert alert-errors">{{ session('errors') }}</div>
            @endif

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
                                @method('PUT')

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
                                    <input type="file" name="image_url" id="image_url" class="form-control"><br>
                                    @if ($product->image_url && \Storage::exists($product->image_url))
                                        <img src="{{ \Storage::url($product->image_url) }}" alt="{{ $product->name }}"
                                            style="max-width: 100px; height: auto;">
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

                                <button type="submit" class="btn btn-rounded btn-primary">Cập nhật</button>
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

@endsection

@extends('admin.master')

@section('title', 'Thêm Danh Mục')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Thêm Mới Danh Mục</div>
                    <a href="{{ route('catalogues.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">
                    <form action="{{ route('catalogues.store') }}" method="POST" enctype="multipart/form-data"
                        id="catalogueForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-body">
                                    <div class="was-validated">
                                        <label for="name" class="form-label">Tên danh mục:</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ old('name') }}" required
                                            placeholder="Tên danh mục">
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="was-validated">
                                        <label for="parent_id" class="form-label">Danh mục cha:</label>
                                        <select name="parent_id" id="parent_id" class="form-select">
                                            <option value="">Chọn danh mục cha</option>
                                            @foreach ($parentCatalogues as $parentCatalogue)
                                                <option value="{{ $parentCatalogue->id }}">{{ $parentCatalogue->name }}
                                                </option>
                                                @if ($parentCatalogue->children->isNotEmpty())
                                                    @include('admin.catalogues.partials.category_options', [
                                                        'categories' => $parentCatalogue->children,
                                                        'prefix' => '--- ',
                                                    ])
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="was-validated">
                                        <label for="image" class="form-label">Hình ảnh:</label>
                                        <input type="file" name="image" id="image" class="form-control"
                                            onchange="previewImage(event)" required>
                                        <img id="imagePreview"
                                            src="{{ old('image') ? asset('storage/' . old('image')) : '' }}"
                                            alt="Hình ảnh xem trước" class="mt-2"
                                            style="display: {{ old('image') ? 'block' : 'none' }}; width: 100px;">
                                    </div>
                                </div>

                                <button type="submit" id="submitButton" class="btn rounded-pill btn-primary mt-3" disabled>
                                    Thêm danh mục
                                </button>
                            </div>

                            <div class="col-md-6">
                                <div class="card-body">
                                    <div class="was-validated">
                                        <label for="description" class="form-label">Mô tả:</label>
                                        <textarea name="description" id="description" class="form-control"
                                        placeholder="Mô tả"
                                        required>{{ old('description') }}</textarea>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="was-validated">
                                        <label for="status" class="form-label">Trạng thái:</label>
                                        <select name="status" id="status" class="form-select" required>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Kích
                                                hoạt
                                            </option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                                Không
                                                kích hoạt</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const imagePreview = document.getElementById('imagePreview');
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

        function validateForm() {
            const name = document.getElementById('name').value.trim();
            const image = document.getElementById('image').value;
            const description = document.getElementById('description').value.trim();
            const status = document.getElementById('status').value;

            const submitButton = document.getElementById('submitButton');

            // Kiểm tra xem có trường nào trống không (trừ danh mục cha)
            if (name && image && description && status) {
                submitButton.disabled = false; // Kích hoạt nút nếu tất cả các trường cần thiết có giá trị
            } else {
                submitButton.disabled = true; // Khóa nút nếu có trường trống
            }
        }

        // Thêm sự kiện input cho các trường
        document.getElementById('name').addEventListener('input', validateForm);
        document.getElementById('image').addEventListener('change', validateForm);
        document.getElementById('description').addEventListener('input', validateForm);
        document.getElementById('status').addEventListener('change', validateForm);
    </script>
@endsection

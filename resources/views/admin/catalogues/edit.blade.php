@extends('admin.master')

@section('title', 'Cập Nhật Danh Mục')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Cập Nhật Danh Mục</div>
                    <a href="{{ route('catalogues.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('catalogues.update', $catalogue) }}" method="POST" enctype="multipart/form-data"
                        id="catalogueForm">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="was-validated">
                                <label for="name" class="form-label">Tên danh mục:</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $catalogue->name) }}" required>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="was-validated">
                                <label for="slug" class="form-label">Slug:</label>
                                <input type="text" name="slug" id="slug" class="form-control"
                                    value="{{ old('slug', $catalogue->slug) }}" required>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="was-validated">
                                <label for="status" class="form-label">Trạng thái:</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="active" {{ $catalogue->status === 'active' ? 'selected' : '' }}>Kích hoạt
                                    </option>
                                    <option value="inactive" {{ $catalogue->status === 'inactive' ? 'selected' : '' }}>Không
                                        kích hoạt</option>
                                </select>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="was-validated">
                                <label for="image" class="form-label">Hình ảnh:</label>
                                <input type="file" name="image" id="image" class="form-control"
                                    onchange="previewImage(event)">

                                @if ($catalogue->image)
                                    <img id="imagePreview" src="{{ asset('storage/' . $catalogue->image) }}"
                                        alt="{{ $catalogue->name }}" style="width: 100px; margin-top: 10px;">
                                @else
                                    <p class="text-danger mt-2">Hình ảnh không tồn tại</p>
                                @endif
                            </div>
                        </div>

                        <button type="submit" id="submitButton" class="btn rounded-pill btn-primary mt-3" disabled>Cập
                            nhật</button>
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
                imagePreview.src = '{{ asset('storage/' . $catalogue->image) }}';
            }
        }

        function validateForm() {
            const name = document.getElementById('name').value.trim();
            const slug = document.getElementById('slug').value.trim();
            const status = document.getElementById('status').value;

            const submitButton = document.getElementById('submitButton');

            // Kiểm tra xem có trường nào trống không
            if (name && slug && status) {
                submitButton.disabled = false; // Kích hoạt nút nếu tất cả các trường có giá trị
            } else {
                submitButton.disabled = true; // Khóa nút nếu có trường trống
            }
        }

        // Thêm sự kiện input cho các trường
        document.getElementById('name').addEventListener('input', validateForm);
        document.getElementById('slug').addEventListener('input', validateForm);
        document.getElementById('status').addEventListener('change', validateForm);
    </script>

    @if (session()->has('success'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 1500
            });
        </script>
    @endif
@endsection

@extends('admin.master')

@section('title', 'Thêm Mới Banner')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Thêm mới banner</div>
                    <a href="{{ route('banners.index') }}" class="btn rounded-pill btn-sm btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">

                    <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="image">Hình ảnh:</label>
                                    <input type="file" class="form-control" id="image" name="image"
                                        accept="image/*" onchange="previewImage(event)">
                                    <img id="imagePreview" src="" alt="Hình ảnh xem trước"
                                        style="max-width: 150px; height: auto; display: none;" class="mt-2">
                                    @error('image')
                                        <ul>
                                            <li class="text-danger mb-1">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="button_text">Văn bản nút:</label>
                                    <input type="text" class="form-control" id="button_text" name="button_text"
                                        value="{{ old('button_text') }}" placeholder="Nhập văn bản nút">
                                    @error('button_text')
                                        <ul>
                                            <li class="text-danger mb-1">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="button_link">Liên kết nút:</label>
                                    <input type="url" class="form-control" id="button_link" name="button_link"
                                        value="{{ old('button_link') }}" placeholder="Nhập liên kết nút">
                                    @error('button_link')
                                        <ul>
                                            <li class="text-danger mb-1">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="title">Tiêu đề:</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="{{ old('title') }}" placeholder="Nhập tiêu đề">
                                    @error('title')
                                        <ul>
                                            <li class="text-danger mb-1">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="status">Trạng thái:</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Kích hoạt
                                        </option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Vô
                                            hiệu hóa</option>
                                    </select>
                                    @error('status')
                                        <ul>
                                            <li class="text-danger mb-1">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-rounded btn-success">Thêm Mới</button>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="description">Mô tả:</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                        rows="3" placeholder="Nhập mô tả">{{ old('description') }}</textarea>
                                    @error('description')
                                        <ul>
                                            <li class="text-danger mb-1">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script> <!-- CKEditor script -->
    <script>
        // Replace the textarea with CKEditor
        CKEDITOR.replace('description');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.all.min.js"></script>
    @if (session('create'))
        <script>
            Swal.fire({
                position: "top-center",
                icon: "success",
                title: "Thêm banner thành công",
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    <script>
        function previewImage(event) {
            const imagePreview = document.getElementById('imagePreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block'; // Hiện hình ảnh xem trước
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = ''; // Xóa ảnh xem trước
                imagePreview.style.display = 'none'; // Ẩn hình ảnh xem trước
            }
        }
    </script>
@endsection

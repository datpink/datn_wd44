@extends('admin.master')

@section('title', 'Cập Nhật Banner')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Cập nhật banner</div>
                    <a href="{{ route('banners.index') }}" class="btn rounded-pill btn-sm btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">

                    <form action="{{ route('banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="image">Hình ảnh:</label>
                                    <input type="file" class="mb-3 form-control @error('image') is-invalid @enderror"
                                        name="image" id="image" accept="image/*" onchange="previewPostImage(event)">

                                    @if ($banner->image)
                                        <img id="currentImage" src="{{ asset('storage/' . $banner->image) }}" alt=""
                                            style="width: 150px; height: auto;" class="mt-2">
                                    @else
                                        <p id="noImageText">Không có ảnh</p>
                                    @endif

                                    <img id="newImagePreview" src="" alt="Hình ảnh xem trước"
                                        style="max-width: 150px; height: auto; display: none;" class="mt-2">

                                    @error('image')
                                        <ul>
                                            <li class="text-danger mb-1">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="title">Tiêu đề:</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title', $banner->title) }}"
                                        placeholder="Nhập tiêu đề">
                                    @error('title')
                                        <ul>
                                            <li class="text-danger mb-1">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="button_text">Nút văn bản:</label>
                                    <input type="text" class="form-control @error('button_text') is-invalid @enderror"
                                        id="button_text" name="button_text"
                                        value="{{ old('button_text', $banner->button_text) }}"
                                        placeholder="Nhập văn bản nút">
                                    @error('button_text')
                                        <ul>
                                            <li class="text-danger mb-1">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="button_link">Liên kết nút:</label>
                                    <input type="text" class="form-control @error('button_link') is-invalid @enderror"
                                        id="button_link" name="button_link"
                                        value="{{ old('button_link', $banner->button_link) }}"
                                        placeholder="Nhập liên kết nút">
                                    @error('button_link')
                                        <ul>
                                            <li class="text-danger mb-1">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="status">Trạng thái:</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status"
                                        name="status">
                                        <option value="active"
                                            {{ old('status', $banner->status) == 'active' ? 'selected' : '' }}>Kích hoạt
                                        </option>
                                        <option value="inactive"
                                            {{ old('status', $banner->status) == 'inactive' ? 'selected' : '' }}>Vô hiệu
                                            hóa</option>
                                    </select>
                                    @error('status')
                                        <ul>
                                            <li class="text-danger mb-1">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-rounded btn-success">Cập nhật Banner</button>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="description">Mô tả:</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="3" placeholder="Nhập mô tả">{{ old('description', $banner->description) }}</textarea>
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
        function previewPostImage(event) {
            const newImagePreview = document.getElementById('newImagePreview');
            const currentImage = document.getElementById('currentImage');
            const noImageText = document.getElementById('noImageText');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Cập nhật hình ảnh hiện tại bằng hình ảnh mới
                    currentImage.src = e.target.result; // Thay thế hình ảnh hiện tại
                    currentImage.style.display = 'block'; // Hiện hình ảnh mới
                    noImageText.style.display = 'none'; // Ẩn thông báo "Không có ảnh"
                    newImagePreview.src = e.target.result; // Cập nhật hình ảnh xem trước
                    newImagePreview.style.display = 'block'; // Hiện hình ảnh xem trước
                };
                reader.readAsDataURL(file);
            } else {
                // Nếu không có tệp nào được chọn
                newImagePreview.src = ''; // Xóa ảnh xem trước
                newImagePreview.style.display = 'none'; // Ẩn hình ảnh xem trước

                if (currentImage.src) {
                    currentImage.style.display = 'block'; // Hiện hình ảnh hiện tại nếu có
                    noImageText.style.display = 'none'; // Ẩn thông báo "Không có ảnh"
                } else {
                    noImageText.style.display = 'block'; // Hiện thông báo "Không có ảnh"
                    currentImage.style.display = 'none'; // Ẩn hình ảnh hiện tại
                }
            }
        }
    </script>
@endsection

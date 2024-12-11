@extends('admin.master')

@section('title', 'Chỉnh Sửa Banner')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Chỉnh sửa quảng cáo</div>
                    <a href="{{ route('advertisements.index') }}" class="btn rounded-pill btn-sm btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">

                    <form action="{{ route('advertisements.update', $advertisement->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="image">Hình ảnh:</label>
                                    <input type="file" class="mb-3 form-control @error('image') is-invalid @enderror"
                                        name="image" id="image" accept="image/*" onchange="previewPostImage(event)">

                                    @if ($advertisement->image)
                                        <img id="currentImage" src="{{ asset('storage/' . $advertisement->image) }}"
                                            alt="" style="width: 150px; height: auto;" class="mt-2">
                                    @else
                                        <p id="noImageText">Không có ảnh</p>
                                    @endif

                                    <img id="newImagePreview" src="" alt="Hình ảnh xem trước"
                                        style="max-width: 150px; height: auto; display: none;" class="mt-2">

                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="button_text">Nút văn bản:</label>
                                    <input type="text" class="form-control" id="button_text" name="button_text"
                                        value="{{ old('button_text', $advertisement->button_text) }}"
                                        placeholder="Nhập văn bản nút">
                                    @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="button_link">Liên kết nút:</label>
                                    <input type="text" class="form-control" id="button_link" name="button_link"
                                        value="{{ old('button_link', $advertisement->button_link) }}"
                                        placeholder="Nhập liên kết nút">
                                    @error('button_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="position">Vị trí:</label>
                                    <input type="number" class="form-control @error('position') is-invalid @enderror"
                                        id="position" name="position"
                                        value="{{ old('position', $advertisement->position) }}" placeholder="Nhập vị trí"
                                        min="1">
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="status">Trạng thái:</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="active"
                                            {{ old('status', $advertisement->status) == 'active' ? 'selected' : '' }}>
                                            Kích hoạt
                                        </option>
                                        <option value="inactive"
                                            {{ old('status', $advertisement->status) == 'inactive' ? 'selected' : '' }}>
                                            Vô hiệu hóa
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-rounded btn-success">Cập nhật Banner</button>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="title">Tiêu đề:</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="{{ old('title', $advertisement->title) }}" placeholder="Nhập tiêu đề">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description">Mô tả:</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Nhập mô tả">{{ old('description', $advertisement->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
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
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        // Thay thế textarea bằng CKEditor
        CKEDITOR.replace('description');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.all.min.js"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                position: "top-center",
                icon: "success",
                title: "Cập nhật quảng cáo thành công",
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
                    currentImage.src = e.target.result; // Thay thế hình ảnh hiện tại
                    currentImage.style.display = 'block'; // Hiện hình ảnh mới
                    noImageText.style.display = 'none'; // Ẩn thông báo "Không có ảnh"
                    newImagePreview.src = e.target.result; // Cập nhật hình ảnh xem trước
                    newImagePreview.style.display = 'block'; // Hiện hình ảnh xem trước
                };
                reader.readAsDataURL(file);
            } else {
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

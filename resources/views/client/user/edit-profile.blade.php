@extends('client.master')

@section('title', 'Chỉnh sửa hồ sơ')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg p-4 border-0 rounded">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Chỉnh sửa hồ sơ</h3>
                        <form action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <!-- Name -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="name" class="form-label"><strong>Tên đầy đủ</strong></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $user->name }}" required>
                                    </div>
                                    <!-- Phone -->
                                    <div class="mb-3">
                                        <label for="phone" class="form-label"><strong>Số điện thoại</strong></label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ $user->phone }}">
                                    </div>

                                    <!-- Address -->
                                    <div class="mb-3">
                                        <label for="address" class="form-label"><strong>Địa chỉ</strong></label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            value="{{ $user->address }}">
                                    </div>
                                </div>

                                <div class="col-md-4 text-center">
                                    <!-- Image -->
                                    <div class="mb-4 text-center">
                                        <label for="image" class="form-label"><strong>Hình ảnh hồ sơ</strong></label>
                                        <div class="position-relative d-flex flex-column align-items-center">
                                            @if ($user->image)
                                                <img id="currentImage" src="{{ asset('storage/' . $user->image) }}"
                                                    alt="{{ $user->name }}" class="img-thumbnail mb-2"
                                                    style="max-width: 150px; border-radius: 50%;">
                                                <p class="form-text">Hình ảnh hiện tại</p>
                                            @else
                                                <div class="mb-2"
                                                    style="width: 150px; height: 150px; background-color: #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <span class="text-muted">Không có hình ảnh</span>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control-file position-absolute" id="image"
                                                name="image" accept="image/*"
                                                style="top: 0; left: 0; width: 150px; height: 150px; opacity: 0;">
                                            <button type="button" class="btn btn-danger mt-2" style="width: 150px;"
                                                onclick="document.getElementById('image').click();">Change Image</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" class="btn btn-danger btn-lg rounded-pill shadow">Save Changes</button>
                                <a href="{{ route('profile.show') }}" class="btn btn-outline-danger btn-lg rounded-pill shadow">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script for image preview -->
    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const reader = new FileReader();
            const newImagePreview = document.getElementById('newImagePreview');
            const currentImage = document.getElementById('currentImage');

            reader.onload = function() {
                // Cập nhật hình ảnh hiện tại
                currentImage.src = reader.result; // Thay thế hình ảnh hiện tại
                currentImage.style.display = 'block'; // Hiện hình ảnh mới
                newImagePreview.src = reader.result; // Cập nhật hình ảnh xem trước
                newImagePreview.style.display = 'block'; // Hiện hình ảnh xem trước
            };

            reader.readAsDataURL(event.target.files[0]);
        });
    </script>
@endsection

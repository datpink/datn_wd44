@extends('admin.master')

@section('title', 'Cập Nhật Thương Hiệu')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Cập nhật thương hiệu</div>
                    <a href="{{ route('brands.index') }}" class="btn rounded-pill btn-sm btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('brands.update', $brand) }}" method="POST" id="brandForm" class="was-validated">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="name">Tên thương hiệu:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $brand->name) }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Mô tả:</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $brand->description) }}</textarea>
                        </div>
                        <button type="submit" id="submitButton" class="btn btn-rounded btn-success" disabled>Cập nhật Brand</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.all.min.js"></script>
    <script>
        function validateForm() {
            const name = document.getElementById('name').value.trim();
            const description = document.getElementById('description').value.trim();
            const submitButton = document.getElementById('submitButton');

            // Kiểm tra xem cả hai trường tên và mô tả có giá trị không
            if (name && description) {
                submitButton.disabled = false; // Kích hoạt nút nếu cả hai trường có giá trị
            } else {
                submitButton.disabled = true; // Khóa nút nếu có trường trống
            }
        }

        // Thêm sự kiện input cho các trường
        document.getElementById('name').addEventListener('input', validateForm);
        document.getElementById('description').addEventListener('input', validateForm);
    </script>

    @if (session('update'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "Cập nhật thành công",
                showConfirmButton: false,
                timerProgressBar: true, // Hiển thị thanh thời gian
                timer: 1500
            });
        </script>
    @endif
@endsection
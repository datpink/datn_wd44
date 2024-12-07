@extends('admin.master')

@section('title', 'Thêm Mới Thương Hiệu')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Thêm mới thương hiệu</div>
                    <a href="{{ route('brands.index') }}" class="btn rounded-pill btn-sm btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">
                    <form action="{{ route('brands.store') }}" method="POST" id="brandForm" class="was-validated">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-4">
                                    <label for="name">Tên thương hiệu:</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') }}" placeholder="Nhập tên thương hiệu" required>

                                    @if ($errors->has('name'))
                                        <ul>
                                            <li class="text-danger mb-1">{{ $errors->first('name') }}</li>
                                        </ul>
                                    @endif
                                </div>

                                <div class="form-group mb-3 mt-4">
                                    <label for="description">Mô tả:</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Nhập mô tả" required>{{ old('description') }}</textarea>

                                    @if ($errors->has('description'))
                                        <ul>
                                            <li class="text-danger mb-1">{{ $errors->first('description') }}</li>
                                        </ul>
                                    @endif
                                </div>

                                <button type="submit" id="submitButton" class="btn btn-rounded btn-success" disabled>Thêm
                                    Mới</button>
                            </div>
                        </div>
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

    @if (session('ok'))
        <script>
            Swal.fire({
                position: "top-center",
                icon: "success",
                title: "Thương hiệu đã được thêm thành công",
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif
@endsection

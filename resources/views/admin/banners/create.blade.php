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

                    {{-- Hiển thị thông báo lỗi nếu có --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="image">Hình ảnh:</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                            @if ($errors->has('image'))
                                <ul>
                                    <li class="text-danger mb-1">{{ $errors->first('image') }}</li>
                                </ul>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="title">Tiêu đề:</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Nhập tiêu đề">
                            @if ($errors->has('title'))
                                <ul>
                                    <li class="text-danger mb-1">{{ $errors->first('title') }}</li>
                                </ul>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Mô tả:</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Nhập mô tả">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <ul>
                                    <li class="text-danger mb-1">{{ $errors->first('description') }}</li>
                                </ul>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="button_text">Văn bản nút:</label>
                            <input type="text" class="form-control" id="button_text" name="button_text" value="{{ old('button_text') }}" placeholder="Nhập văn bản nút">
                        </div>

                        <div class="form-group mb-3">
                            <label for="button_link">Liên kết nút:</label>
                            <input type="url" class="form-control" id="button_link" name="button_link" value="{{ old('button_link') }}" placeholder="Nhập liên kết nút">
                        </div>

                        <div class="form-group mb-3">
                            <label for="status">Trạng thái:</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active">Kích hoạt</option>
                                <option value="inactive">Vô hiệu hóa</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-rounded btn-success">Thêm Mới</button>
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
@endsection

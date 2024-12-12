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

                    <form action="{{ route('brands.update', $brand) }}" method="POST" id="brandForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name">Tên thương hiệu:</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name', $brand->name) }}">
                                    @if ($errors->has('name'))
                                        <div class="text-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description">Mô tả:</label>
                                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $brand->description) }}</textarea>
                                    @if ($errors->has('description'))
                                        <div class="text-danger">{{ $errors->first('description') }}</div>
                                    @endif
                                </div>
                                <button type="submit" id="submitButton" class="btn btn-rounded btn-success">Cập
                                    nhật Brand</button>
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

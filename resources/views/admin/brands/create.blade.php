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
                    <form action="{{ route('brands.store') }}" method="POST" id="brandForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-4">
                                    <label for="name">Tên thương hiệu:</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') }}" placeholder="Nhập tên thương hiệu">
                                    @if ($errors->has('name'))
                                        <div class="text-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>

                                <div class="form-group mb-3 mt-4">
                                    <label for="description">Mô tả:</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Nhập mô tả">{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <div class="text-danger">{{ $errors->first('description') }}</div>
                                    @endif
                                </div>

                                <button type="submit" id="submitButton" class="btn btn-rounded btn-success">Thêm
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

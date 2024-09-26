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

                    <form action="{{ route('brands.update', $brand) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="name">Brand Name:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $brand->name) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $brand->description) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-rounded btn-success">Cập nhật Brand</button>
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

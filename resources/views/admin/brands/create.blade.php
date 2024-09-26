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

                    {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

                    <form action="{{ route('brands.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên thương hiệu:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name') }}" placeholder="Nhập tên thương hiệu">

                            @if ($errors->has('name'))
                                <ul>
                                    <li class="text-danger mb-1">{{ $errors->first('name') }}</li>
                                </ul>
                            @endif

                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Mô tả:</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Nhập mô tả">{{ old('description') }}</textarea>

                            @if ($errors->has('description'))
                                <ul>
                                    <li class="text-danger mb-1">{{ $errors->first('description') }}</li>
                                </ul>
                            @endif

                        </div>
                        <button type="submit" class="btn btn-rounded btn-success">Thêm Mới</button>
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
                title: "Your work has been saved",
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif
@endsection

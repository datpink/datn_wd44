@extends('admin.master')

@section('title', 'Thêm mới người dùng')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Thêm  mới người dùng</div>
                    <a href="{{ route('brands.index') }}" class="btn rounded-pill btn-sm btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">
                    <form action="{{ route('brands.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Tên mới người dùng:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả:</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                        </div>

                        <button type="submit" class="btn rounded-pill btn-primary mt-3">Thêm mới người dùng</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
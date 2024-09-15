@extends('admin.master')

@section('title', 'Cập Nhật Thương Hiệu')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Cập Nhật Thương Hiệu</div>
                    <a href="{{ route('brands.index') }}" class="btn rounded-pill btn-sm btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">
                    <form action="{{ route('brands.update', $brand->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Tên thương hiệu:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $brand->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả:</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description', $brand->description) }}</textarea>
                        </div>

                        <button type="submit" class="btn rounded-pill btn-primary mt-3">Cập nhật thương hiệu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
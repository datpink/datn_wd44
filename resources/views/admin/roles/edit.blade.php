@extends('admin.master')

@section('title', 'Sửa Vai Trò')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Cập Nhật Vai Trò</div>
                    <a href="{{ route('roles.index') }}" class="btn rounded-pill btn-sm btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Tên vai trò:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $role->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Mô Tả vai trò:</label>
                            <input type="text" name="description" id="description" class="form-control" value="{{ old('description', $role->description) }}" required>
                        </div>

                        <button type="submit" class="btn rounded-pill btn-primary mt-3">Cập nhật vai trò</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
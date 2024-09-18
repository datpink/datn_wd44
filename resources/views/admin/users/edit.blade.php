@extends('admin.master')

@section('title', 'Sửa thông người dùng')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Sửa thông người dùng</div>
                    <a href="{{ route('users.index') }}" class="btn rounded-pill btn-sm btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Tên người dùng:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả:</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description', $user->description) }}</textarea>
                        </div>

                        <button type="submit" class="btn rounded-pill btn-primary mt-3">Sửa thông người dùng</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
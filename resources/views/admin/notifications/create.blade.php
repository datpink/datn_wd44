@extends('admin.master')

@section('title', 'Thêm Thông Báo')

@section('content')
<div class="content-wrapper-scroll">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Thêm Mới Thông Báo</div>
                <a href="{{ route('admin.notifications.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i> Trở về
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.notifications.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Tiêu đề:</label>
                        <input type="text" name="title" class="form-control" id="title" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="description">Mô tả:</label>
                        <textarea name="description" class="form-control" id="description" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="user_id" class="form-label">Chọn người dùng:</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value="">Chọn người dùng</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="url" class="form-label">URL:</label>
                        <input type="url" name="url" id="url" class="form-control" value="{{ old('url') }}" placeholder="https://example.com">
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill mt-3">Thêm Thông Báo</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('admin.master')

@section('title', 'Thêm Mới Người Dùng')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper p-4">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card border-0 rounded shadow-sm">
                <div class="card-header">
                    <div class="card-title mb-3">Thêm Mới Người Dùng</div>
                    <a href="{{ route('users.index') }}" class="btn rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="name">Tên:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Mật khẩu:</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation">Xác nhận mật khẩu:</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" required>
                        </div>

                        {{-- <div class="form-group mb-3">
                            <label for="roles">Chọn Vai Trò:</label>
                            <select name="roles[]" id="roles" class="form-control" multiple required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Giữ Ctrl để chọn nhiều vai trò (nếu có).</small>
                        </div> --}}

                        <button type="submit" class="btn btn-primary rounded-pill">Thêm Người Dùng</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('admin.master')

@section('title', 'Chỉnh Sửa Người Dùng')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper p-4">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

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
                    <div class="card-title">Cập Nhật Người Dùng</div>
                    <a href="{{ route('users.index') }}" class="btn rounded-pill btn-sm btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="name">Tên:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                        </div>

                        {{-- <div class="mb-3">
                            <label for="password" class="form-label">Mật Khẩu Mới</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Xác Nhận Mật Khẩu</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div> --}}

                        <div class="form-group mb-3">
                            <label for="roles">Chọn Vai Trò:</label>
                            <select name="roles[]" id="roles" class="form-control" multiple required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Giữ Ctrl để chọn nhiều vai trò (nếu có).</small>
                        </div>

                        <button type="submit" class="btn rounded-pill btn-primary">Cập Nhật Người Dùng</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
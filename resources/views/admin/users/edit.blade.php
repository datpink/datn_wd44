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
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="name">Tên:</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ $user->name }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ $user->email }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone">Số Điện Thoại:</label>
                            <input type="text" name="phone" id="phone" class="form-control"
                                value="{{ $user->phone }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="address">Địa Chỉ:</label>
                            <textarea name="address" id="address" class="form-control" required>{{ $user->address }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="image">Hình Ảnh:</label>
                            <input type="file" name="image" id="image" class="form-control-file">
                            @if ($user->image)
                                <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}"
                                    class="img-thumbnail mt-2" style="max-width: 150px;">
                                <p class="form-text">Hình ảnh hiện tại</p>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="status">Trạng Thái:</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="unlocked" {{ $user->status === 'unlocked' ? 'selected' : '' }}>Mở Khóa</option>
                                <option value="locked" {{ $user->status === 'locked' ? 'selected' : '' }}>Bị Khóa</option>
                            </select>
                        </div>

                        <div class="row">
                            @foreach ($roles ?? [] as $item)
                                <div class="form-group col-sm-2 form-check d-flex align-items-center gap-2">
                                    <input type="radio" name="role" value="{{ $item->name }}"
                                        {{ $user->hasRole($item->name) ? 'checked' : '' }}>
                                    <label class="form-check-label mb-2">{{ $item->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn rounded-pill btn-primary">Cập Nhật Người Dùng</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

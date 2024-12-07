@extends('admin.master')

@section('title', 'Thêm Quyền Mới')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Thêm Quyền Mới</div>
                    <a href="{{ route('permissions.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">
                    <form action="{{ route('permissions.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Tên Quyền:</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="guard_name">Guard Name:</label>
                                    <input type="text" name="guard_name" id="guard_name" class="form-control"
                                        value="{{ old('guard_name', 'web') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="group">Nhóm:</label>
                                    <input type="text" name="group" id="group" class="form-control"
                                        value="{{ old('group') }}">
                                </div>

                                <div class="form-group">
                                    <label for="description">Mô Tả:</label>
                                    <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                                </div>

                                <button type="submit" class="btn rounded-pill btn-primary mt-3">Thêm Quyền</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

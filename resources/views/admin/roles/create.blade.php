@extends('admin.master')

@section('title', 'Thêm Vai Trò')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Thêm Mới Vai Trò</div>
                    <a href="{{ route('roles.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="name">Tên vai trò:</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="guard_name">Guard:</label>
                                    <input type="text" name="guard_name" id="guard_name" class="form-control"
                                        value="{{ old('guard_name', 'web') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="description">Mô tả:</label>
                                    <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                                </div>
                                <div class="row">
                                    @foreach ($permissions ?? [] as $item)
                                        <div class="form-group col-sm-2 form-check d-flex align-items-center gap-2">
                                            <input type="checkbox" name="permissions[]" value="{{ $item->id }}">
                                            <label class="form-check-label mb-2">{{ $item->name }}</label>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="submit" class="btn rounded-pill btn-primary mt-3">Thêm vai trò</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

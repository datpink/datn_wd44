@extends('admin.master')

@section('title', 'Thêm Mới Phương Thức Thanh Toán')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Thêm Mới Phương Thức Thanh Toán</div>
                    <a href="{{ route('payment-methods.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">
                    <form action="{{ route('payment-methods.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Tên phương thức:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả:</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>

                            @if ($errors->has('description'))
                                <ul>
                                    <li class="text-danger mb-1">{{ $errors->first('description') }}</li>
                                </ul>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="status">Trạng thái:</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Không kích hoạt</option>
                            </select>
                        </div>

                        <button type="submit" class="btn rounded-pill btn-primary mt-3">Thêm phương thức</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
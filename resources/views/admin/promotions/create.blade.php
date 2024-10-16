@extends('admin.master')

@section('title', 'Thêm Mới Mã Giảm Giá')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Thêm Mới Mã Giảm Giá</div>
                    <a href="{{ route('promotions.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">
                    <form action="{{ route('promotions.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="code">Mã Khuyến Mãi:</label>
                            <input type="text" name="code" id="code" class="form-control"
                                value="{{ old('code') }}" required>

                            @if ($errors->has('code'))
                                <ul>
                                    <li class="text-danger mb-1">{{ $errors->first('code') }}</li>
                                </ul>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="discount_value">Giá Trị Giảm Giá (%):</label>
                            <input type="number" name="discount_value" id="discount_value" class="form-control"
                                value="{{ old('discount_value') }}" required step="0.01" min="0">

                            @if ($errors->has('discount_value'))
                                <ul>
                                    <li class="text-danger mb-1">{{ $errors->first('discount_value') }}</li>
                                </ul>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="status">Trạng Thái:</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Không kích hoạt
                                </option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Đang chờ</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="start_date">Ngày Bắt Đầu:</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ old('start_date') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="end_date">Ngày Kết Thúc:</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ old('end_date') }}" required>
                        </div>

                        <button type="submit" class="btn rounded-pill btn-primary mt-3">Thêm Khuyến Mãi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

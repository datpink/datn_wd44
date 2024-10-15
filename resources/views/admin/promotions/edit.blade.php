@extends('admin.master')

@section('title', 'Thêm mới Mã Giảm Giá')

@section('content')
<div class="container">
    <h1>Sửa Khuyến Mãi</h1>
    <form action="{{ route('promotions.update', $promotion->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="code">Mã Khuyến Mãi:</label>
            <input type="text" class="form-control" id="code" name="code" value="{{ old('code', $promotion->code) }}" required>
        </div>

        <div class="form-group">
            <label for="discount_value">Giá Trị Giảm Giá:</label>
            <input type="number" class="form-control" id="discount_value" name="discount_value" value="{{ old('discount_value', $promotion->discount_value) }}" required step="0.01" min="0">
        </div>

        <div class="form-group">
            <label for="status">Trạng Thái:</label>
            <select id="status" name="status" class="form-control" required>
                <option value="active" {{ old('status', $promotion->status) == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                <option value="inactive" {{ old('status', $promotion->status) == 'inactive' ? 'selected' : '' }}>Không kích hoạt</option>
                <option value="pending" {{ old('status', $promotion->status) == 'pending' ? 'selected' : '' }}>Đang chờ</option>
            </select>
        </div>

        <div class="form-group">
            <label for="start_date">Ngày Bắt Đầu:</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $promotion->start_date) }}" required>
        </div>

        <div class="form-group">
            <label for="end_date">Ngày Kết Thúc:</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $promotion->end_date) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập Nhật Khuyến Mãi</button>
        <a href="{{ route('promotions.index') }}" class="btn btn-secondary">Quay Lại</a>
    </form>
</div>  
@endsection
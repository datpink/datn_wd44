@extends('admin.master')

@section('title', 'Thêm mới Mã Giảm Giá')

@section('content')
    <div class="container mt-4">
        <h1>Thêm Mã Giảm Giá</h1>

        <form action="{{ route('promotions.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="code">Mã Khuyến Mãi:</label>
        <input type="text" class="form-control" id="code" name="code" required>
    </div>
    <div class="form-group">
        <label for="discount_value">Giá Trị Giảm Giá:</label>
        <input type="number" class="form-control" id="discount_value" name="discount_value" required step="0.01" min="0">
    </div>
    <div class="form-group">
        <label for="status">Trạng Thái:</label>
        <select id="status" name="status" required>
            <option value="active">Kích hoạt</option>
            <option value="inactive">Không kích hoạt</option>
            <option value="pending">Đang chờ</option>
        </select>
    </div>
    <div class="form-group">
        <label for="start_date">Ngày Bắt Đầu:</label>
        <input type="date" class="form-control" id="start_date" name="start_date" required>
    </div>
    <div class="form-group">
        <label for="end_date">Ngày Kết Thúc:</label>
        <input type="date" class="form-control" id="end_date" name="end_date" required>
    </div>
    <button type="submit" class="btn btn-primary">Thêm Khuyến Mãi</button>
</form>
    </div>
@endsection

@extends('admin.master')

@section('title', 'Sửa Đợt Giảm Giá')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('content')

    <div class="container">
        <h3>Sửa Đợt Giảm Giá</h3>
        <!-- Form sửa giảm giá -->
        <form action="{{ route('discounts.update', $discount->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="discount_value" class="form-label">Giá trị giảm giá</label>
                <input type="text" class="form-control" id="discount_value" name="discount_value"
                    value="{{ old('discount_value', $discount->discount_value) }}" required>
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">Ngày bắt đầu</label>
                <input type="date" class="form-control" id="start_date" name="start_date"
                    value="{{ old('start_date', \Carbon\Carbon::parse($discount->start_date)->format('Y-m-d')) }}" required>

            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">Ngày kết thúc</label>
                <input type="date" class="form-control" id="end_date" name="end_date"
                    value="{{ old('end_date', \Carbon\Carbon::parse($discount->end_date)->format('Y-m-d')) }}" required>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Loại giảm giá</label>
                <select class="form-select" id="type" name="type">
                    <option value="percentage" {{ $discount->type == 'percentage' ? 'selected' : '' }}>Phần trăm</option>
                    <option value="fixed" {{ $discount->type == 'fixed' ? 'selected' : '' }}>Tiền mặt</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>

@endsection

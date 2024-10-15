@extends('admin.master')

@section('title', 'Chỉnh Sửa Mã Giảm Giá')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Chỉnh Sửa Mã Giảm Giá</h4>
                            <a href="{{ route('promotions.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Trở về
                            </a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('promotions.update', $promotion->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="code" class="form-label">Mã Khuyến Mãi</label>
                                    <input type="text" class="form-control" id="code" name="code"
                                        value="{{ old('code', $promotion->code) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="discount_value" class="form-label">Giá Trị Giảm Giá (%)</label>
                                    <input type="number" class="form-control" id="discount_value" name="discount_value"
                                        value="{{ old('discount_value', $promotion->discount_value) }}" required
                                        step="0.01" min="0">
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Trạng Thái</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="active"
                                            {{ old('status', $promotion->status) == 'active' ? 'selected' : '' }}>Kích hoạt
                                        </option>
                                        <option value="inactive"
                                            {{ old('status', $promotion->status) == 'inactive' ? 'selected' : '' }}>Không
                                            kích hoạt</option>
                                        <option value="pending"
                                            {{ old('status', $promotion->status) == 'pending' ? 'selected' : '' }}>Đang chờ
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Ngày Bắt Đầu</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="{{ old('start_date', $promotion->start_date) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="end_date" class="form-label">Ngày Kết Thúc</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="{{ old('end_date', $promotion->end_date) }}" required>
                                </div>

                                <button type="submit" class="btn rounded-pill btn-primary">Cập nhật</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
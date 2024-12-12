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
                        <form method="POST" action="{{ route('promotions.update', $promotion->id) }}" id="promotionForm" class="was-validated">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="code" class="form-label">Mã Giảm Giá</label>
                                <input type="text" class="form-control" id="code" name="code"
                                    value="{{ old('code', $promotion->code) }}" required>
                                @if ($errors->has('code'))
                                <ul>
                                    <li class="text-danger mb-1">{{ $errors->first('code') }}</li>
                                </ul>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="discount_value" class="form-label">Giá Trị Giảm Giá</label>
                                <input type="number" class="form-control @error('discount_value') is-invalid @enderror" id="discount_value" name="discount_value"
                                    value="{{ old('discount_value', $promotion->discount_value) }}" required step="0.01" min="0">
                                @if ($errors->has('discount_value'))
                                <ul>
                                    <li class="text-danger mb-1">{{ $errors->first('discount_value') }}</li>
                                </ul>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Trạng Thái</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="active" {{ old('status', $promotion->status) == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                                    <option value="inactive" {{ old('status', $promotion->status) == 'inactive' ? 'selected' : '' }}>Không kích hoạt</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="min_order_value" class="form-label">Giá Trị Đơn Hàng Tối Thiểu</label>
                                <input type="number" class="form-control" id="min_order_value" name="min_order_value"
                                    value="{{ old('min_order_value', $promotion->min_order_value) }}" step="0.01" min="0">
                                @error('min_order_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="max_value" class="form-label">Giá Trị Đơn Hàng Tối Đa</label>
                                <input type="number" class="form-control" id="max_value" name="max_value"
                                    value="{{ old('max_value', $promotion->max_value) }}" step="0.01" min="0">
                                @error('max_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="start_date" class="form-label">Ngày Bắt Đầu</label>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                    value="{{ old('start_date', $promotion->start_date) }}" required>
                                @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="end_date" class="form-label">Ngày Kết Thúc</label>
                                <input type="date" class="form-control" id="end_date" name="end_date"
                                    value="{{ old('end_date', $promotion->end_date) }}">
                                @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Loại Giảm Giá</label>
                                <select id="type" name="type" class="form-control" required>
                                    <option value="percentage" {{ old('type', $promotion->type) == 'percentage' ? 'selected' : '' }}>Phần Trăm</option>
                                    <option value="fixed_amount" {{ old('type', $promotion->type) == 'fixed_amount' ? 'selected' : '' }}>Số Tiền Cố Định</option>
                                    <option value="free_shipping" {{ old('type', $promotion->type) == 'free_shipping' ? 'selected' : '' }}>Miễn Phí Vận Chuyển</option>
                                </select>
                                @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="applies_to_order" class="form-label">Áp Dụng Cho Đơn Hàng</label>
                                <select id="applies_to_order" name="applies_to_order" class="form-control" required>
                                    <option value="1" {{ old('applies_to_order', $promotion->applies_to_order) == 1 ? 'selected' : '' }}>Có</option>
                                    <option value="0" {{ old('applies_to_order', $promotion->applies_to_order) == 0 ? 'selected' : '' }}>Không</option>
                                </select>
                                @error('applies_to_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="applies_to_shipping" class="form-label">Áp Dụng Cho Vận Chuyển</label>
                                <select id="applies_to_shipping" name="applies_to_shipping" class="form-control" required>
                                    <option value="1" {{ old('applies_to_shipping', $promotion->applies_to_shipping) == 1 ? 'selected' : '' }}>Có</option>
                                    <option value="0" {{ old('applies_to_shipping', $promotion->applies_to_shipping) == 0 ? 'selected' : '' }}>Không</option>
                                </select>
                                @error('applies_to_shipping')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" id="submitButton" class="btn rounded-pill btn-primary">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function validateForm() {
        const code = document.getElementById('code').value.trim();
        const discountValue = document.getElementById('discount_value').value;
        const status = document.getElementById('status').value;
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        const type = document.getElementById('type').value;
        const appliesToOrder = document.getElementById('applies_to_order').value;
        const appliesToShipping = document.getElementById('applies_to_shipping').value;
        const submitButton = document.getElementById('submitButton');

        // Kiểm tra xem tất cả các trường bắt buộc có giá trị không
        if (code && discountValue && status && startDate && type && appliesToOrder !== null && appliesToShipping !== null) {
            submitButton.disabled = false; // Kích hoạt nút nếu tất cả các trường có giá trị
        } else {
            submitButton.disabled = true; // Khóa nút nếu có trường trống
        }
    }

    // Thêm sự kiện input cho các trường
    document.getElementById('code').addEventListener('input', validateForm);
    document.getElementById('discount_value').addEventListener('input', validateForm);
    document.getElementById('status').addEventListener('change', validateForm);
    document.getElementById('start_date').addEventListener('change', validateForm);
    document.getElementById('end_date').addEventListener('change', validateForm);
    document.getElementById('type').addEventListener('change', validateForm);
    document.getElementById('applies_to_order').addEventListener('change', validateForm);
    document.getElementById('applies_to_shipping').addEventListener('change', validateForm);
</script>
@endsection
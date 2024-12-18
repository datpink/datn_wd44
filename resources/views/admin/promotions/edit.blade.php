@extends('admin.master')

@section('title', 'Chỉnh Sửa Mã Giảm Giá')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Chỉnh sửa mã giảm giá</h4>
                            <a href="{{ route('promotions.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Trở về
                            </a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('promotions.update', $promotion->id) }}"
                                id="promotionForm">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="code" class="form-label">Mã giảm giá</label>
                                            <input type="text" class="form-control" id="code" name="code"
                                                value="{{ old('code', $promotion->code) }}">
                                            @if ($errors->has('code'))
                                                <ul>
                                                    <li class="text-danger mb-1">{{ $errors->first('code') }}</li>
                                                </ul>
                                            @endif
                                        </div>

                                        <div class="mb-3">
                                            <label for="discount_value" class="form-label">Giá trị giảm giá</label>
                                            <input type="number"
                                                class="form-control @error('discount_value') is-invalid @enderror"
                                                id="discount_value" name="discount_value"
                                                value="{{ old('discount_value', $promotion->discount_value == (int) $promotion->discount_value ? (int) $promotion->discount_value : number_format($promotion->discount_value, 2)) }}"
                                                step="0.01" min="0">
                                            @if ($errors->has('discount_value'))
                                                <ul>
                                                    <li class="text-danger mb-1">{{ $errors->first('discount_value') }}</li>
                                                </ul>
                                            @endif
                                        </div>


                                        <div class="mb-3">
                                            <label for="status" class="form-label">Trạng Thái</label>
                                            <select id="status" name="status" class="form-control">
                                                <option value="active"
                                                    {{ old('status', $promotion->status) == 'active' ? 'selected' : '' }}>
                                                    Kích hoạt</option>
                                                <option value="inactive"
                                                    {{ old('status', $promotion->status) == 'inactive' ? 'selected' : '' }}>
                                                    Không kích hoạt</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="order_value" class="form-label">Giá Trị Đơn Hàng</label>
                                            <input type="number" class="form-control" id="order_value" name="order_value"
                                                value="{{ old('min_order_value', $promotion->min_order_value == (int) $promotion->min_order_value ? (int) $promotion->min_order_value : number_format($promotion->min_order_value, 2)) }}"
                                                step="0.01" min="0">
                                            @error('min_order_value')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="mb-3">
                                            <label for="start_date" class="form-label">Ngày bắt đầu</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date"
                                                value="{{ old('start_date', $promotion->start_date) }}">
                                            @error('start_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" id="submitButton" class="btn rounded-pill btn-primary">Cập
                                            nhật</button>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="end_date" class="form-label">Ngày kết thúc</label>
                                            <input type="date" class="form-control" id="end_date" name="end_date"
                                                value="{{ old('end_date', $promotion->end_date) }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="type" class="form-label">Loại giảm giá</label>
                                            <select id="type" name="type" class="form-control">
                                                <option value="percentage"
                                                    {{ old('type', $promotion->type) == 'percentage' ? 'selected' : '' }}>
                                                    Phần Trăm
                                                </option>
                                                <option value="fixed_amount"
                                                    {{ old('type', $promotion->type) == 'fixed_amount' ? 'selected' : '' }}>
                                                    Số Tiền
                                                    Cố Định</option>
                                                <option value="free_shipping"
                                                    {{ old('type', $promotion->type) == 'free_shipping' ? 'selected' : '' }}>
                                                    Miễn
                                                    Phí Vận Chuyển</option>
                                            </select>
                                            @error('type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                            @error('applies_to_shipping')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

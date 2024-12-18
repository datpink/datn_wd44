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
                    <form action="{{ route('promotions.store') }}" method="POST" id="promotionForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code">Mã Khuyến Mãi:</label>
                                    <input type="text" name="code" id="code" class="form-control"
                                        value="{{ old('code') }}">
                                    @if ($errors->has('code'))
                                        <div class="text-danger">{{ $errors->first('code') }}</div>
                                    @endif
                                </div>

                                <div class="form-group mt-4">
                                    <label for="discount_value">Giá Trị Giảm Giá (% hoặc Số Tiền):</label>
                                    <input type="number" name="discount_value" id="discount_value" class="form-control"
                                        value="{{ old('discount_value') }}" step="0.01" min="0">
                                    @if ($errors->has('discount_value'))
                                        <div class="text-danger">{{ $errors->first('discount_value') }}</div>
                                    @endif
                                </div>

                                <div class="form-group mt-4">
                                    <label for="status">Trạng Thái:</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Kích hoạt
                                        </option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Không
                                            kích hoạt
                                        </option>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Đang chờ
                                        </option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <div class="text-danger">{{ $errors->first('status') }}</div>
                                    @endif
                                </div>

                                <div class="form-group mt-4">
                                    <label for="start_date">Ngày Bắt Đầu:</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        value="{{ old('start_date') }}">
                                    @if ($errors->has('start_date'))
                                        <div class="text-danger">{{ $errors->first('start_date') }}</div>
                                    @endif
                                </div>

                                <div class="form-group mt-4">
                                    <label for="end_date">Ngày Kết Thúc:</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="{{ old('end_date') }}">
                                    @if ($errors->has('end_date'))
                                        <div class="text-danger">{{ $errors->first('end_date') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="min_order_value">Đơn Hàng Tối Tiểu:</label>
                                    <input type="number" name="min_order_value" id="min_order_value" class="form-control"
                                        value="{{ old('min_order_value') }}" step="0.01" min="0">
                                    @if ($errors->has('min_order_value'))
                                        <div class="text-danger">{{ $errors->first('min_order_value') }}</div>
                                    @endif
                                </div>
                                <div class="form-group mt-4">
                                    <label for="max_value">Đơn Hàng Tối Đa:</label>
                                    <input type="number" name="max_value" id="max_value" class="form-control"
                                        value="{{ old('max_value') }}" step="0.01" min="0">
                                    @if ($errors->has('max_value'))
                                        <div class="text-danger">{{ $errors->first('max_value') }}</div>
                                    @endif
                                </div>

                                <div class="form-group mt-4">
                                    <label for="type">Loại Giảm Giá:</label>
                                    <select id="type" name="type" class="form-control">
                                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Giảm
                                            Theo %</option>
                                        <option value="fixed_amount" {{ old('type') == 'fixed_amount' ? 'selected' : '' }}>
                                            Giảm Theo Tiền</option>
                                        <option value="free_shipping"
                                            {{ old('type') == 'free_shipping' ? 'selected' : '' }}>Miễn Phí Vận Chuyển
                                        </option>
                                    </select>
                                    @if ($errors->has('type'))
                                        <div class="text-danger">{{ $errors->first('type') }}</div>
                                    @endif
                                </div>
                                <button type="submit" id="submitButton" class="btn rounded-pill btn-primary mt-3">Thêm
                                    Khuyến Mãi</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

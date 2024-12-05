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
                    <form action="{{ route('promotions.store') }}" method="POST" id="promotionForm" class="was-validated">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
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

                                <div class="form-group mt-4">
                                    <label for="discount_value">Giá Trị Giảm Giá (% hoặc Số Tiền):</label>
                                    <input type="number" name="discount_value" id="discount_value" class="form-control"
                                        value="{{ old('discount_value') }}" required step="0.01" min="0">
                                    @if ($errors->has('discount_value'))
                                        <ul>
                                            <li class="text-danger mb-1">{{ $errors->first('discount_value') }}</li>
                                        </ul>
                                    @endif
                                </div>

                                <div class="form-group mt-4">
                                    <label for="status">Trạng Thái:</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Kích hoạt
                                        </option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Không
                                            kích hoạt
                                        </option>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Đang chờ
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group mt-4">
                                    <label for="start_date">Ngày Bắt Đầu:</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        value="{{ old('start_date') }}" required>
                                </div>

                                <div class="form-group mt-4">
                                    <label for="end_date">Ngày Kết Thúc:</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="{{ old('end_date') }}" required>
                                </div>

                                <button type="submit" id="submitButton" class="btn rounded-pill btn-primary mt-3" disabled>Thêm
                                    Khuyến Mãi</button>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Loại Giảm Giá:</label>
                                    <select id="type" name="type" class="form-control" required>
                                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Giảm
                                            Theo %
                                        </option>
                                        <option value="fixed_amount" {{ old('type') == 'fixed_amount' ? 'selected' : '' }}>
                                            Giảm
                                            Theo Tiền</option>
                                        <option value="free_shipping"
                                            {{ old('type') == 'free_shipping' ? 'selected' : '' }}>Miễn
                                            Phí Vận Chuyển</option>
                                    </select>
                                </div>

                                <div class="form-group mt-4">
                                    <label for="applies_to_order">Áp Dụng Cho Đơn Hàng:</label>
                                    <select id="applies_to_order" name="applies_to_order" class="form-control" required>
                                        <option value="1" {{ old('applies_to_order') == '1' ? 'selected' : '' }}>Có
                                        </option>
                                        <option value="0" {{ old('applies_to_order') == '0' ? 'selected' : '' }}>Không
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group mt-4">
                                    <label for="applies_to_shipping">Áp Dụng Cho Phí Vận Chuyển:</label>
                                    <select id="applies_to_shipping" name="applies_to_shipping" class="form-control"
                                        required>
                                        <option value="1" {{ old('applies_to_shipping') == '1' ? 'selected' : '' }}>Có
                                        </option>
                                        <option value="0" {{ old('applies_to_shipping') == '0' ? 'selected' : '' }}>
                                            Không
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group mt-4">
                                    <label for="order_value">Giá Trị Đơn Hàng:</label>
                                    <input type="number" name="order_value" id="order_value" class="form-control"
                                        value="{{ old('order_value') }}" step="0.01" min="0">
                                    @if ($errors->has('order_value'))
                                        <ul>
                                            <li class="text-danger mb-1">{{ $errors->first('order_value') }}</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
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
            if (code && discountValue && status && startDate && endDate && type && appliesToOrder && appliesToShipping) {
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

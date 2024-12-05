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
                    <form action="{{ route('payment-methods.store') }}" method="POST" id="paymentMethodForm"
                        class="was-validated">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-4">
                                    <label for="name">Tên phương thức:</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name') }}" required>
                                    @if ($errors->has('name'))
                                        <div class="text-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>

                                <div class="form-group mt-4">
                                    <label for="description">Mô tả:</label>
                                    <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <div class="text-danger">{{ $errors->first('description') }}</div>
                                    @endif
                                </div>

                                <div class="form-group mt-4">
                                    <label for="status">Trạng thái:</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="">Chọn trạng thái</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Kích hoạt
                                        </option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Không
                                            kích hoạt</option>
                                    </select>
                                </div>

                                <button type="submit" id="submitButton" class="btn rounded-pill btn-primary mt-3"
                                    disabled>Thêm phương thức</button>
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
            const name = document.getElementById('name').value.trim();
            const status = document.getElementById('status').value;
            const submitButton = document.getElementById('submitButton');

            // Kiểm tra xem các trường bắt buộc có giá trị không
            if (name && status) {
                submitButton.disabled = false; // Kích hoạt nút nếu tất cả các trường bắt buộc có giá trị
            } else {
                submitButton.disabled = true; // Khóa nút nếu có trường trống
            }
        }

        // Thêm sự kiện input cho các trường
        document.getElementById('name').addEventListener('input', validateForm);
        document.getElementById('status').addEventListener('change', validateForm);
    </script>
@endsection

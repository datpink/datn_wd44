@extends('admin.master')

@section('title', 'Chỉnh Sửa Phương Thức Thanh Toán')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Chỉnh Sửa Phương Thức Thanh Toán</h4>
                            <a href="{{ route('payment-methods.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Trở về
                            </a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('payment-methods.update', $paymentMethod) }}"
                                id="paymentMethodForm" class="was-validated">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Tên phương thức</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ old('name', $paymentMethod->name) }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Mô tả</label>
                                            <textarea class="form-control" id="description" name="description">{{ old('description', $paymentMethod->description) }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="status" class="form-label">Trạng thái</label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="active"
                                                    {{ $paymentMethod->status === 'active' ? 'selected' : '' }}>
                                                    Kích hoạt</option>
                                                <option value="inactive"
                                                    {{ $paymentMethod->status === 'inactive' ? 'selected' : '' }}>Không kích
                                                    hoạt
                                                </option>
                                            </select>
                                        </div>

                                        <button type="submit" id="submitButton" class="btn rounded-pill btn-primary"
                                            disabled>Cập
                                            nhật</button>
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

@section('scripts')
    <script>
        const originalName = "{{ old('name', $paymentMethod->name) }}";
        const originalDescription = "{{ old('description', $paymentMethod->description) }}";
        const originalStatus = "{{ $paymentMethod->status }}";

        function validateForm() {
            const name = document.getElementById('name').value.trim();
            const description = document.getElementById('description').value;
            const status = document.getElementById('status').value;
            const submitButton = document.getElementById('submitButton');

            // Kiểm tra xem các trường có khác với giá trị gốc không
            if (name !== originalName || description !== originalDescription || status !== originalStatus) {
                submitButton.disabled = false; // Kích hoạt nút nếu có thay đổi
            } else {
                submitButton.disabled = true; // Khóa nút nếu không có thay đổi
            }
        }

        // Thêm sự kiện input cho các trường
        document.getElementById('name').addEventListener('input', validateForm);
        document.getElementById('description').addEventListener('input', validateForm);
        document.getElementById('status').addEventListener('change', validateForm);
    </script>
@endsection

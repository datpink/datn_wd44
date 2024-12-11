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
                                id="paymentMethodForm">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Tên phương thức</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name"
                                                value="{{ old('name', $paymentMethod->name) }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Mô tả</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $paymentMethod->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="status" class="form-label">Trạng thái</label>
                                            <select name="status" id="status"
                                                class="form-control @error('status') is-invalid @enderror">
                                                <option value="active"
                                                    {{ old('status', $paymentMethod->status) === 'active' ? 'selected' : '' }}>
                                                    Kích hoạt
                                                </option>
                                                <option value="inactive"
                                                    {{ old('status', $paymentMethod->status) === 'inactive' ? 'selected' : '' }}>
                                                    Không kích hoạt
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" id="submitButton" class="btn rounded-pill btn-primary">Cập
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

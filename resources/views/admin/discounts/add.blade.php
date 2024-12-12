@extends('admin.master')

@section('title', 'Thêm Đợt Giảm Giá Mới')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('content')

    <div class="container">
        <h3>Thêm Đợt Giảm Giá Mới</h3>

        <form action="{{ route('discounts.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="discount_value" class="form-label">Giá trị giảm giá</label>
                        <input type="number" class="form-control" id="discount_value" name="discount_value" required>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Loại giảm giá</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="percentage">Phần trăm</option>
                            <option value="fixed">Tiền</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary rounded-pill">Thêm Giảm Giá</button>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Ngày bắt đầu</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>

                    <div class="mb-3">
                        <label for="end_date" class="form-label">Ngày kết thúc</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

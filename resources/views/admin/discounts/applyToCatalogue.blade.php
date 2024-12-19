@extends('admin.master')

@section('title', 'Áp Dụng Giảm Giá Cho Danh Mục')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('content')

<div class="row">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="container">
        <h3>Danh sách danh mục</h3>
        <a href="{{ route('discounts.index') }}" class="btn rounded-pill btn-secondary">
            <i class="bi bi-arrow-left me-2"></i> Trở về
        </a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Trạng thái giảm giá</th>
                    <th>Giá Trị giảm giá</th>
                    <th>Giá sản phẩm</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($catalogues as $catalogue)
                <tr>
                    <td>{{ $catalogue->id }}</td>
                    <td>{{ $catalogue->name }}</td>
                    <td>
                        @if ($catalogue->discounts->isNotEmpty())
                        <span class="badge bg-success">Đang được giảm giá</span>
                        <select name="discount_id" class="form-select mt-2" disabled>
                            @foreach ($catalogue->discounts as $discount)
                            <option value="{{ $discount->id }}" selected>
                                @if ($discount->type === 'percentage')
                                Phần trăm
                                @elseif ($discount->type === 'fixed')
                                Số tiền cố định
                                @else
                                Không xác định
                                @endif
                                - {{ number_format($discount->discount_value, 0, ',', '.') }}
                                ({{ \Carbon\Carbon::parse($discount->start_date)->format('d/m/Y') }} -
                                {{ \Carbon\Carbon::parse($discount->end_date)->format('d/m/Y') }})
                            </option>
                            @endforeach
                        </select>

                        @php
                        $now = \Carbon\Carbon::now();
                        $endDate = \Carbon\Carbon::parse($discount->end_date);
                        $daysLeft = $now->diffInDays($endDate, false);
                        @endphp
                        @if ($daysLeft > 0)
                        <span class="badge bg-info mt-2">Còn {{ $daysLeft }} ngày nữa</span>
                        @else
<span class="badge bg-danger mt-2">Giảm giá đã hết hạn</span>
                        @endif

                        <form action="{{ route('admin.catalogues.removeDiscount', $catalogue->id) }}"
                            method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-danger">Hủy giảm giá</button>
                        </form>
                        @else
                        <form action="{{ route('admin.catalogues.applyDiscount', $catalogue->id) }}"
                            method="POST">
                            @csrf
                            <select name="discount_id" class="form-select mt-2">
                                <option value="">-- Chọn đợt giảm giá --</option>
                                @foreach ($discounts as $discount)
                                <option value="{{ $discount->id }}">
                                    {{ $discount->type }} - {{ $discount->discount_value }}
                                    ({{ \Carbon\Carbon::parse($discount->start_date)->format('d/m/Y') }} -
                                    {{ \Carbon\Carbon::parse($discount->end_date)->format('d/m/Y') }})
                                </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-success mt-2">Áp Dụng</button>
                        </form>
                        @endif

                    </td>

                    <td>
                        @if ($catalogue->discounts->isNotEmpty())
                        @php
                        $discount = $catalogue->discounts->first();
                        @endphp
                        @if ($discount)
                            @if ($discount->type == 'percentage')
                            {{ $discount->discount_value }} %
                            @else
                            {{ number_format($discount->discount_value, 0, ',', '.') }} VNĐ
                            @endif
                        @else
                        Không có giảm giá
                        @endif
                        @else
                        Không có giảm giá
                        @endif

                    </td>
                    <td>
                        @if ($catalogue->products && $catalogue->products->isNotEmpty())
                        <p>Số lượng : {{ $catalogue->products->count() }}</p>
                        @else
                        <p>Không có sản phẩm nào đang giảm giá.</p>
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
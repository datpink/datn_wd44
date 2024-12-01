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
        <h1>Danh sách danh mục</h1>
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
                            <option value="">-- Đợt giảm giá hiện tại --</option>
                            @foreach($catalogue->discounts as $discount)
                            <option value="{{ $discount->id }}" selected>
                                {{ $discount->type }} - {{ $discount->discount_value }}
                                ({{ \Carbon\Carbon::parse($discount->start_date)->format('d/m/Y') }} -
                                {{ \Carbon\Carbon::parse($discount->end_date)->format('d/m/Y') }})
                            </option>
                            @endforeach
                        </select>

                        <!-- Tính toán ngày còn lại của đợt giảm giá -->
                        @php
                        $now = \Carbon\Carbon::now();
                        $endDate = \Carbon\Carbon::parse($discount->end_date);
                        $daysLeft = $now->diffInDays($endDate, false); // Số ngày còn lại (có thể là số âm)
                        @endphp
                        @if ($daysLeft > 0)
                        <span class="badge bg-info mt-2">Còn {{ $daysLeft }} ngày nữa</span>
                        @else
                        <span class="badge bg-danger mt-2">Giảm giá đã hết hạn</span>
                        @endif

                        <!-- Nút hủy giảm giá -->
                        <form action="{{ route('admin.catalogues.removeDiscount', $catalogue->id) }}" method="POST" class="mt-3">
                            @csrf
                            
                            <button type="submit" class="btn btn-danger">Hủy giảm giá</button>
                        </form>
                        @else
                        <!-- Form để áp dụng giảm giá mới -->
                        <form action="{{ route('admin.catalogues.applyDiscount', $catalogue->id) }}" method="POST">
                            @csrf
                            <select name="discount_id" class="form-select mt-2">
                                <option value="">-- Chọn đợt giảm giá --</option>
                                @foreach($discounts as $discount)
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
                        $discount = $catalogue->discounts->first(); // Lấy thông tin đợt giảm giá đầu tiên
                        @endphp
                        @if ($discount->type == 'percentage')
                        {{ $discount->discount_value }} %
                        @else
                        {{ number_format($discount->discount_value, 0, ',', '.') }} VNĐ
                        @endif
                        @else
                        Không có giảm giá
                        @endif

                    </td>
                    <td>
                        @if ($catalogue->products->isNotEmpty())
                        <p>Số lượng : {{ $catalogue->products->count() }}</p>
                        <!-- <ul>
                            @foreach ($catalogue->products as $product)
                            <li>
                                {{ $product->name }}:
                                @if ($product->discount_price) 
                                
                                <span style="text-decoration: line-through;">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                {{ number_format($product->discount_price, 0, ',', '.') }}₫
                                @else
                                {{ number_format($product->price, 0, ',', '.') }}₫
                                @endif
                            </li>
                            @endforeach
                        </ul>-->
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
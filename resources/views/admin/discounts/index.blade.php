@extends('admin.master')

@section('title', 'Danh Sách Giảm Giá Cho Danh Mục')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3>Danh sách giảm giá</h3>
                            <div class="d-flex justify-content-start">
                                <a href="{{ route('discounts.create') }}"
                                    class="btn btn-sm rounded-pill btn-primary d-flex align-items-center me-2">
                                    <i class="bi bi-plus-circle me-2"></i> Thêm Giảm Giá
                                </a>
                                <a href="{{ route('admin.catalogueList') }}"
                                    class="btn btn-sm rounded-pill btn-primary d-flex align-items-center">
                                    <i class="bi bi-check-circle me-2"></i> Áp dụng cho danh mục
                                </a>
                            </div>


                        </div>

                        <div class="card-body">
                            <!-- <form method="GET" action="#" class="mb-3">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" id="search" name="search"
                                            class="form-control form-control-sm" placeholder="Tìm kiếm mã giảm giá"
                                            value="{{ request()->search }}">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" id="filterRemove" class="btn btn-sm btn-warning">Xóa
                                            lọc</button>
                                    </div>
                                </div>
                            </form>-->

                            <div class="table-responsive">
                                <table class="table v-middle m-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Loại Giảm Giá</th>
                                            <th>Mức Giảm Giá</th>
                                            <th>Ngày Bắt Đầu</th>
                                            <th>Ngày Kết Thúc</th>
                                            <th>Ngày Tạo</th>
                                            <th>Ngày Sửa</th>
                                            <th colspan="2">Hành Động</th> <!-- Cột cho hành động như Edit, Delete -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($discounts as $discount)
                                            <tr>
                                                <td>{{ $discount->id }}</td>
                                                <td>
                                                    @if ($discount->type == 'percentage')
                                                        Giảm giá theo %
                                                    @else
                                                        Giảm giá theo tiền
                                                    @endif
                                                </td> <!-- Loại giảm giá (percentage/fixed) -->
                                                <td>
                                                    @if ($discount->type == 'percentage')
                                                        {{ number_format($discount->discount_value, 0) }}%
                                                    @else
                                                        {{ number_format($discount->discount_value, 0) }} VND
                                                    @endif
                                                </td>



                                                <td>{{ \Carbon\Carbon::parse($discount->start_date)->format('d-m-Y H:i') }}
                                                </td> <!-- Ngày bắt đầu -->
                                                <td>{{ \Carbon\Carbon::parse($discount->end_date)->format('d-m-Y H:i') }}
                                                </td> <!-- Ngày kết thúc -->
                                                <td>{{ \Carbon\Carbon::parse($discount->created_at)->format('d-m-Y H:i') }}
                                                </td> <!-- Ngày Tạo -->
                                                <td>{{ \Carbon\Carbon::parse($discount->updated_at)->format('d-m-Y H:i') }}
                                                </td> <!-- Ngày sửa -->
                                                <td>
                                                    <a href="{{ route('discounts.edit', $discount->id) }}" class="editRow"
                                                        title="Sửa" style="margin-right: 15px;">
                                                        <i class="bi bi-pencil-square text-warning"
                                                            style="font-size: 1.8em;"></i>
                                                    </a>

                                                    <form action="{{ route('discounts.destroy', $discount->id) }}"
                                                        method="POST" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="delete-btn"
                                                            style="background: none; border: none; padding: 0;"
                                                            title="Xóa">
                                                            <i class="bi bi-trash text-danger"
                                                                style="font-size: 1.8em;"></i>
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('products.apply', $discount->id) }}" class="btn-sm"
                                                        title="Áp dụng cho sản phẩm" style="padding: 0; border: none;">
                                                        <i class="bi bi-sort-down"
                                                        style="font-size: 1.8em;color:green;  "></i>
                                                        
                                                    </a>
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>

                            </div>
                            <div class="mt-3">
                                {{ $discounts->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#filterRemove').click(function() {
                $('#search').val('');
                $(this).closest('form').submit();
            });

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        position: "top",
                        title: 'Bạn có chắc muốn xóa?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        toast: true,
                        confirmButtonText: 'Có',
                        cancelButtonText: 'Hủy',
                        timerProgressBar: true,
                        timer: 3500
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.closest('form').submit();
                        }
                    });
                });
            });
        });

        @if (session('success'))
            Swal.fire({
                position: "top",
                icon: "success",
                toast: true,
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3500
            });
        @endif

        @if (session('errors'))
            Swal.fire({
                position: "top",
                icon: "error",
                title: "Có sản phẩm Đang được giảm giá!",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 1500
            });
        @endif
    </script>
@endsection

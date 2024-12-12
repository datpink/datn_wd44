@extends('admin.master')

@section('title', 'Danh Sách Mã Giảm Giá')

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
                        <div class="card-title">Danh sách mã giảm giá</div>
                        <div>
                            <a href="{{ route('promotions.create') }}"
                                class="btn btn-sm rounded-pill btn-primary d-flex align-items-center">
                                <i class="bi bi-plus-circle me-2"></i> Thêm mã giảm giá
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="GET" action="{{ route('promotions.index') }}" class="mb-3">
                            <div class="row g-2">
                                <!-- Tìm kiếm mã giảm giá -->
                                <div class="col-auto">
                                    <input type="text" id="search" name="search" class="form-control form-control-sm"
                                        placeholder="Tìm kiếm mã giảm giá" value="{{ request()->search }}">
                                </div>
                        
                                <!-- Lọc theo trạng thái -->
                                <div class="col-auto">
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="">Trạng thái</option>
                                        <option value="active" {{ request()->status == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                                        <option value="inactive" {{ request()->status == 'inactive' ? 'selected' : '' }}>Không kích hoạt</option>
                                    </select>
                                </div>
                        
                                <!-- Lọc áp dụng cho đơn hàng -->
                                <div class="col-auto">
                                    <select name="applies_to_order" class="form-select form-select-sm">
                                        <option value="">Áp dụng cho đơn hàng</option>
                                        <option value="1" {{ request()->applies_to_order == '1' ? 'selected' : '' }}>Có</option>
                                        <option value="0" {{ request()->applies_to_order == '0' ? 'selected' : '' }}>Không</option>
                                    </select>
                                </div>
                        
                                <!-- Lọc áp dụng cho phí vận chuyển -->
                                <div class="col-auto">
                                    <select name="applies_to_shipping" class="form-select form-select-sm">
                                        <option value="">Áp dụng cho phí vận chuyển</option>
                                        <option value="1" {{ request()->applies_to_shipping == '1' ? 'selected' : '' }}>Có</option>
                                        <option value="0" {{ request()->applies_to_shipping == '0' ? 'selected' : '' }}>Không</option>
                                    </select>
                                </div>
                        
                        
                                <!-- Nút tìm kiếm -->
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                                </div>
                        
                                <!-- Nút xóa lọc -->
                                <div class="col-auto">
                                    <a href="{{ route('promotions.index') }}" class="btn btn-sm btn-warning">Xóa lọc</a>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table v-middle m-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Code</th>
                                        <th>Mức giảm giá</th>
                                        <th>Min Order Value</th>  <!-- Thêm cột min_order_value -->
                                        <th>Trạng thái</th>
                                        <th>Áp dụng cho đơn hàng</th>
                                        <th>Áp dụng cho phí vận chuyển</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Ngày sửa mã</th>
                                        <th colspan="2">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($promotions as $promotion)
                                    <tr>
                                        <td>{{ $promotion->id }}</td>
                                        <td>{{ $promotion->code }}</td>
                                        <td>
                                            @if ($promotion->type == 'percentage')
                                            {{ number_format(round($promotion->discount_value, -1), 0) }}%
                                            @elseif ($promotion->type == 'fixed_amount')
                                            {{ number_format($promotion->discount_value, 0) }} VND
                                            @else
                                            Free Shipping
                                            @endif
                                        </td>
                                        <td>
                                            @if ($promotion->min_order_value !== null)
                                                {{ number_format($promotion->min_order_value, 2) }} VND
                                            @else
                                                Không áp dụng
                                            @endif
                                        </td>
                                        <td>
                                            @if ($promotion->status == 'active')
                                            <span class="badge bg-success rounded-pill">Kích hoạt</span>
                                            @elseif ($promotion->status == 'inactive')
                                            <span class="badge bg-danger rounded-pill">Không kích hoạt</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($promotion->applies_to_order)
                                            <span class="badge bg-info rounded-pill">Có</span>
                                            @else
                                            <span class="badge bg-secondary rounded-pill">Không</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($promotion->applies_to_shipping)
                                            <span class="badge bg-info rounded-pill">Có</span>
                                            @else
                                            <span class="badge bg-secondary rounded-pill">Không</span>
                                            @endif
                                        </td>
                                        <td>{{ $promotion->start_date }}</td>
                                        <td>{{ $promotion->end_date }}</td>
                                        <td>{{ $promotion->updated_at ?? 'Trống' }}</td>
                                        <td>
                                            <a href="{{ route('promotions.edit', $promotion->id) }}" class="editRow"
                                                title="Sửa" style="margin-right: 15px;">
                                                <i class="bi bi-pencil-square text-warning"
                                                    style="font-size: 1.8em;"></i>
                                            </a>

                                            <form action="{{ route('promotions.destroy', $promotion->id) }}"
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
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination justify-content-center mt-3">
                            {{ $promotions->links() }}
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

    @if(session('success'))
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

    @if(session('errors'))
    Swal.fire({
        position: "top",
        icon: "error",
        title: "Có lỗi xảy ra",
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 1500
    });
    @endif
</script>
@endsection

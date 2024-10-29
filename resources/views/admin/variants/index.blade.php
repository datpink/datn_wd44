@extends('admin.master')


@section('title', 'Danh sách biến thể')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Danh Sách Biến Thể</div>
                            <div>
                                <a href="{{ route('products.variants.create', $product->id) }}" 
                                   class="btn btn-primary btn-rounded d-flex align-items-center">
                                    <i class="bi bi-plus-circle me-2"></i> Thêm Mới
                                </a>
                                <a href="{{ route('products.index') }}"
                                    class="btn btn-secondary mt-2 btn-rounded d-flex align-items-center">
                                    <i class="bi bi-arrow-left me-2"></i> Trở về
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tên Biến Thể</th>
                                        <th>Giá</th>
                                        <th>SKU</th>
                                        <th>Kho</th>
                                        <th>Trạng Thái</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($variants->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center">Chưa có biến thể nào.</td>
                                        </tr>
                                    @else
                                        @foreach($variants as $variant)
                                            <tr>
                                                <td>{{ $variant->variant_name }}</td>
                                                <td>{{ number_format($variant->price, 0, ',', '.') }} VNĐ</td>
                                                <td>{{ $variant->sku }}</td>
                                                <td>{{ $variant->stock }}</td>
                                                <td>
                                                    <span class="badge rounded-pill {{ $variant->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                        <i class="bi {{ $variant->status == 'active' ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                                                        {{ ucfirst($variant->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <form action="{{ route('variants.updateStatus', $variant->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn rounded-pill btn-sm" style="background: none; border: none; padding: 0;">
                                                            <i class="bi {{ $variant->status == 'active' ? 'bi-x-circle text-warning' : 'bi-check-circle text-success' }}" style="font-size: 1.8em;"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
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
            // Hiện thông báo thành công
            @if (session('success'))
                Swal.fire({
                    position: "top",
                    icon: "success",
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 1500
                });
            @endif

            // Xác nhận đổi trạng thái
            $('form').on('submit', function(e) {
                e.preventDefault();
                const form = this;
                Swal.fire({
                    position: "top",
                    title: 'Bạn có chắc muốn thay đổi trạng thái?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
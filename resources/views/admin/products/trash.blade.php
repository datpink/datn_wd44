@extends('admin.master')

@section('title', 'Thùng rác sản phẩm')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Thùng Rác Sản Phẩm</div>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary btn-rounded">
                                <i class="bi bi-arrow-left me-2"></i> Trở về
                            </a>
                        </div>
                        <div class="card-body">
                            @if ($products->isEmpty())
                                <p>Không có sản phẩm nào trong thùng rác.</p>
                            @else
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Slug</th>
                                            <th>SKU</th>
                                            <th>Giá</th>
                                            <th>Cân nặng</th>
                                            <th>Kích thước</th>
                                            <th>Ngày xóa</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>
                                                    @if ($product->image_url && \Storage::exists($product->image_url))
                                                        <img src="{{ \Storage::url($product->image_url) }}"
                                                            alt="{{ $product->name }}"
                                                            style="max-width: 100px; height: auto;">
                                                    @else
                                                        Không có ảnh
                                                    @endif
                                                </td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->sku }}</td>
                                                <td>{{ number_format($product->price, 0, ',', '.') }}đ</td>
                                                <td>{{ $product->weight }} kg</td>
                                                <td>{{ $product->dimensions }}</td>
                                                <td>{{ $product->deleted_at }}</td>
                                                <td>
                                                    <!-- Khôi phục sản phẩm -->
                                                    <form id="restore-form-{{ $product->id }}"
                                                        action="{{ route('products.restore', $product->id) }}"
                                                        method="POST" class="d-inline-block">
                                                        @csrf
                                                        <button type="button" class="btn btn-success restore-btn"
                                                            data-id="{{ $product->id }}">Khôi phục</button>
                                                    </form>

                                                    <!-- Xóa vĩnh viễn sản phẩm -->
                                                    <form id="force-delete-form-{{ $product->id }}"
                                                        action="{{ route('products.forceDelete', $product->id) }}"
                                                        method="POST" class="d-inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger force-delete-btn"
                                                            data-id="{{ $product->id }}">Xóa vĩnh viễn</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Phân trang nếu có nhiều sản phẩm -->
                                <div class="mt-3">
                                    {{ $products->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        // Xác nhận khôi phục sản phẩm
        document.querySelectorAll('.restore-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const formId = `restore-form-${this.dataset.id}`;
                const form = document.getElementById(formId);
                Swal.fire({
                    position: 'top',
                    title: 'Bạn có chắc chắn muốn khôi phục sản phẩm này?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Hủy',
                    timer: 3500
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Gửi form để khôi phục sản phẩm
                    }
                });
            });
        });

        // Xác nhận xóa vĩnh viễn sản phẩm
        document.querySelectorAll('.force-delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const formId = `force-delete-form-${this.dataset.id}`;
                const form = document.getElementById(formId);
                Swal.fire({
                    position: 'top',
                    title: 'Bạn có chắc chắn muốn xóa vĩnh viễn sản phẩm này?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Hủy',
                    timer: 3500
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Gửi form để xóa vĩnh viễn sản phẩm
                    }
                });
            });
        });

        // Hiển thị thông báo khi khôi phục hoặc xóa thành công
        @if (session('success'))
            Swal.fire({
                position: "top",
                icon: "success",
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1500
            });
        @endif
    </script>
@endsection

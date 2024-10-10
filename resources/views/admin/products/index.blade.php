@extends('admin.master')

@section('title', 'Danh sách sản phẩm')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Danh Sách Sản Phẩm</div>
                            <div>
                                <a href="{{ route('products.create') }}"
                                    class="btn btn-primary btn-sm btn-rounded d-flex align-items-center">
                                    <i class="bi bi-plus-circle me-2"></i> Thêm Mới
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('orders.index') }}" class="mb-3">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" id="id" name="search"
                                            class="form-control form-control-sm" placeholder="Tìm kiếm"
                                            value="{{ request()->search }}">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Thương hiệu</th>
                                        <th>Danh mục</th>
                                        <th>Giá</th>
                                        <th>Kích thước</th>
                                        <th>Trạng thái</th>
                                        <th>Nổi bật</th> <!-- Thêm cột Nổi bật -->
                                        <th>Tình trạng</th> <!-- Thêm cột Tình trạng -->
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
                                                        alt="{{ $product->name }}" style="max-width: 100px; height: auto;">
                                                @else
                                                    Không có ảnh
                                                @endif
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->brand ? $product->brand->name : 'Không có' }}</td>
                                            <td>{{ $product->catalogue ? $product->catalogue->name : 'Không có' }}</td>
                                            <td>{{ number_format($product->price, 0, ',', '.') }}đ</td>
                                            <td>{{ $product->dimensions }}</td>
                                            <td>
                                                @if ($product->is_active)
                                                    <span class="badge rounded-pill bg-success">Kích hoạt</span>
                                                @else
                                                    <span class="badge rounded-pill bg-danger">Không kích hoạt</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($product->is_featured)
                                                    <span class="badge rounded-pill bg-warning">Nổi bật</span>
                                                @else
                                                    <span class="badge rounded-pill bg-secondary">Không nổi bật</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($product->condition == 'new')
                                                    <span class="badge rounded-pill bg-success">Mới</span>
                                                @elseif ($product->condition == 'used')
                                                    <span class="badge rounded-pill bg-warning">Đã qua sử dụng</span>
                                                @elseif ($product->condition == 'refurbished')
                                                    <span class="badge rounded-pill bg-info">Tái chế</span>
                                                @else
                                                    <span class="badge rounded-pill bg-secondary">Không xác định</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm rounded-pill mb-2" title="Sửa">
                                                    <i class="bi bi-pencil-square"></i> Sửa
                                                </a>
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm rounded-pill" title="Chi tiết">
                                                    <i class="bi bi-info-circle"></i> Show
                                                </a>
                                                <!-- Kiểm tra xem sản phẩm đã có biến thể chưa -->
                                                @php
                                                    $hasVariants = $product->variants->isNotEmpty(); // Kiểm tra có biến thể
                                                @endphp

                                                @if ($hasVariants)
                                                    <a href="{{ route('products.variants.index', $product->id) }}"
                                                        class="btn btn-info btn-rounded">
                                                        Quản lý Biến Thể
                                                    </a>
                                                @else
                                                    <a href="{{ route('products.variants.create', $product->id) }}"
                                                        class="btn btn-info btn-rounded">
                                                        Thêm Biến Thể
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{ $products->links() }} <!-- Hiển thị phân trang -->
                            </div>
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
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const formId = `delete-form-${this.dataset.id}`;
                const form = document.getElementById(formId);
                Swal.fire({
                    position: 'top',
                    title: 'Bạn có chắc chắn muốn xóa sản phẩm này?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Hủy',
                    timer: 3500
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Gửi form để xóa sản phẩm
                    }
                });
            });
        });

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

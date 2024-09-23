@extends('admin.master')

@section('title', 'Danh sách sản phẩm')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('errors'))
                <div class="alert alert-errors">{{ session('errors') }}</div>
            @endif

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
                                <a href="{{ route('products.trash') }}"
                                    class="btn btn-primary btn-sm btn-rounded d-flex align-items-center mt-3">
                                    <i class="bi bi-trash me-2"></i> Thùng Rác
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('orders.index') }}" class="mb-3">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" id="id" name="search" class="form-control form-control-sm" placeholder="Tìm kiếm đơn hàng" value="{{ request()->search }}">
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
                                                @if ($product->is_active == '1')
                                                    <span class="badge rounded-pill bg-success">Kích hoạt</span>
                                                @elseif ($product->is_active == '0')
                                                    <span class="badge rounded-pill bg-danger">Không kích hoạt</span>
                                                @endif
                                            </td>


                                            <td>
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm" style="font-size: 0.6rem; padding: 7px 13px;">Sửa</a>
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm" style="font-size: 0.6rem; padding: 7px 13px;">Chi tiết</a>
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline-block"
                                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" style="font-size: 0.6rem; padding: 7px 13px;">Xóa</button>
                                                </form>
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

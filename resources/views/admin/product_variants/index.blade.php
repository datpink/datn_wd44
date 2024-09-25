@extends('admin.master')

@section('title', 'Danh sách biến thể')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('errors'))
                <div class="alert alert-danger">{{ session('errors') }}</div>
            @endif

            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Danh Sách Biến Thể</div>
                            <div>
                                <!-- Route của product_variants -->
                                <a href="{{ route('product_variants.create') }}"
                                    class="btn btn-primary btn-sm btn-rounded d-flex align-items-center">
                                    <i class="bi bi-plus-circle me-2"></i> Thêm Mới
                                </a>
                                {{-- <a href="{{ route('product_variants.trash') }}"
                                    class="btn btn-primary btn-sm btn-rounded d-flex align-items-center mt-3">
                                    <i class="bi bi-trash me-2"></i> Thùng Rác
                                </a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('product_variants.index') }}" class="mb-3">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" id="id" name="search"
                                            class="form-control form-control-sm" placeholder="Tìm kiếm biến thể"
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
                                        <th>Tên biến thể</th>
                                        <th>Sản phẩm gốc</th>
                                        <th>Giá</th>
                                        <th>Kích thước</th>
                                        <th>Tồn kho</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product_variants as $variant)
                                        <tr>
                                            <td>{{ $variant->id }}</td>
                                            <td>
                                                @if ($variant->image_url)
                                                    <img src="{{ Storage::url($variant->image_url) }}"
                                                        alt="{{ $variant->variant_name }}"
                                                        style="max-width: 100px; height: auto;">
                                                @else
                                                    Không có ảnh
                                                @endif
                                            </td>
                                            <td>{{ $variant->variant_name }}</td>
                                            <td>{{ $variant->product->name }}</td>
                                            <td>{{ number_format($variant->price, 0, ',', '.') }}đ</td>
                                            <td>{{ $variant->dimension }}</td>
                                            <td>{{ $variant->stock }}</td>
                                            <td>
                                                @if ($variant->status == 'active')
                                                    <span class="badge rounded-pill bg-success">Kích hoạt</span>
                                                @elseif ($variant->status == 'inactive')
                                                    <span class="badge rounded-pill bg-danger">Không kích hoạt</span>
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Route tới trang chỉnh sửa biến thể -->
                                                <a href="{{ route('product_variants.edit', $variant->id) }}"
                                                    class="btn btn-warning btn-sm"
                                                    style="font-size: 0.6rem; padding: 7px 13px;">Sửa</a>
                                                <a href="{{ route('product_variants.show', $variant->id) }}"
                                                    class="btn btn-info btn-sm"
                                                    style="font-size: 0.6rem; padding: 7px 13px;">Chi tiết</a>

                                                <!-- Form xóa biến thể -->
                                                {{-- <form action="{{ route('product_variants.destroy', $variant->id) }}"
                                                    method="POST" class="d-inline-block"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa biến thể này?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        style="font-size: 0.6rem; padding: 7px 13px;">Xóa</button>
                                                </form> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Phân trang -->
                            <div class="mt-3">
                                {{ $product_variants->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

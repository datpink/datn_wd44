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
                            <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-rounded">
                                <i class="bi bi-arrow-left me-2"></i> Trở về
                            </a>
                        </div>
                        <div class="card-body">
                            @if ($products->isEmpty())
                                <p>Không có bài viết nào trong thùng rác.</p>
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
                                                    <form action="{{ route('products.restore', $product->id) }}"
                                                        method="POST" class="d-inline-block">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">Khôi phục</button>
                                                    </form>

                                                    <!-- Xóa vĩnh viễn sản phẩm -->
                                                    <form action="{{ route('products.forceDelete', $product->id) }}"
                                                        method="POST" class="d-inline-block"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn sản phẩm này?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Xóa vĩnh viễn</button>
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

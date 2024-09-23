@extends('admin.master')

@section('title', 'Chi tiết sản phẩm')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Chi tiết sản phẩm</div>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Chỉnh sửa</a>
                        </div>
                        <div class="card-body">
                            <!-- Tên sản phẩm -->
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <p class="form-control">{{ $product->name }}</p>
                            </div>

                            <!-- Thương hiệu -->
                            <div class="form-group">
                                <label for="brand_id">Thương hiệu</label>
                                <p class="form-control">{{ $product->brand ? $product->brand->name : 'Không có' }}</p>
                            </div>

                            <!-- Danh mục -->
                            <div class="form-group">
                                <label for="catalogue_id">Danh mục</label>
                                <p class="form-control">{{ $product->catalogue ? $product->catalogue->name : 'Không có' }}</p>
                            </div>

                            <!-- Hình ảnh sản phẩm -->
                            <div class="form-group">
                                <label for="image_url">Hình ảnh</label>
                                <br>
                                @if ($product->image_url && \Storage::exists($product->image_url))
                                    <img src="{{ \Storage::url($product->image_url) }}" alt="{{ $product->name }}" style="max-width: 100px; height: auto;">
                                @else
                                    <p>Không có ảnh</p>
                                @endif
                            </div>

                            <!-- Trạng thái hoạt động -->
                            <div class="form-group">
                                <label for="is_active">Trạng thái hoạt động</label>
                                <p class="form-control">{{ $product->is_active ? 'Hoạt động' : 'Không hoạt động' }}</p>
                            </div>

                            <!-- Giá sản phẩm -->
                            <div class="form-group">
                                <label for="price">Giá sản phẩm</label>
                                <p class="form-control">{{ number_format($product->price, 0, ',', '.') }}đ</p>
                            </div>

                            <!-- Slug -->
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <p class="form-control">{{ $product->slug }}</p>
                            </div>

                            <!-- SKU -->
                            <div class="form-group">
                                <label for="sku">SKU (Mã sản phẩm)</label>
                                <p class="form-control">{{ $product->sku }}</p>
                            </div>

                            <!-- Cân nặng (Weight) -->
                            <div class="form-group">
                                <label for="weight">Cân nặng (kg)</label>
                                <p class="form-control">{{ $product->weight }}</p>
                            </div>

                            <!-- Kích thước (Dimensions) -->
                            <div class="form-group">
                                <label for="dimensions">Kích thước (DxRxC)</label>
                                <p class="form-control">{{ $product->dimensions }}</p>
                            </div>

                            <!-- Mô tả sản phẩm -->
                            <div class="form-group">
                                <label for="description">Mô tả sản phẩm</label>
                                <p class="form-control">{{ $product->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

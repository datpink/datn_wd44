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
                            {{-- <a href="{{ route('products.edit', $product->id) }}" class="btn btn-rounded btn-warning">Chỉnh sửa</a> --}}
                            <a href="{{ route('products.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Trở về
                            </a>
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
                                <p class="form-control">{{ $product->catalogue ? $product->catalogue->name : 'Không có' }}
                                </p>
                            </div>

                            <!-- Hình ảnh sản phẩm -->
                            <div class="form-group">
                                <label for="image_url">Hình ảnh</label>
                                <br>
                                @if ($product->image_url && \Storage::exists($product->image_url))
                                    <img src="{{ \Storage::url($product->image_url) }}" alt="{{ $product->name }}"
                                        style="max-width: 100px; height: auto;">
                                @else
                                    <p>Không có ảnh</p>
                                @endif
                            </div>

                            <label for="image_url">Gallery</label>
                            <br>
                            <div class="image-gallery d-flex flex-wrap">
                                @foreach ($product->galleries as $gallery)
                                    <div class="image-item me-2 mb-2">
                                        <img src="{{ Storage::url($gallery->image_url) }}" alt="Hình ảnh"
                                            class="img-thumbnail" style="width: 150px;">
                                    </div>
                                @endforeach
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

                            <!-- Giá khuyến mãi -->
                            @if ($product->discount_price)
                                <div class="form-group">
                                    <label for="discount_price">Giá khuyến mãi</label>
                                    <p class="form-control">
                                        {{ number_format($product->discount_price, 0, ',', '.') }}đ</p>
                                </div>
                            @endif

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

                            <div class="mb-3">
                                <label for="stock" class="form-label">Số Lượng</label>
                                <p class="form-control">{{  $product->stock }}</p>
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

                            <div class="mb-3">
                                <label for="is_featured" class="form-label">Nổi bật</label>
                                <input type="checkbox" id="is_featured" name="is_featured"
                                    {{ $product->is_featured ? 'checked' : '' }} disabled>
                                <small class="form-text text-muted">Sản phẩm này
                                    {{ $product->is_featured ? 'được' : 'không được' }} đánh dấu là nổi bật.</small>
                            </div>

                            <div class="mb-3">
                                <label for="condition" class="form-label">Tình trạng</label>
                                <select class="form-select" id="condition" name="condition" disabled>
                                    <option value="new" {{ $product->condition == 'new' ? 'selected' : '' }}>Mới
                                    </option>
                                    <option value="used" {{ $product->condition == 'used' ? 'selected' : '' }}>Đã qua sử
                                        dụng</option>
                                    <option value="refurbished"
                                        {{ $product->condition == 'refurbished' ? 'selected' : '' }}>Tái chế</option>
                                </select>
                            </div>

                            <!-- Tóm tắt sản phẩm -->
                            <div class="form-group">
                                <label for="tomtat">Tóm tắt</label>
                                <p class="card">{{ $product->tomtat }}</p>
                            </div>

                            <!-- Mô tả sản phẩm -->
                            <div class="form-group">
                                <label for="description">Mô tả sản phẩm</label>
                                <p class="card">{!! $product->description !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

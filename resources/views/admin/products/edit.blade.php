@extends('admin.master')

@section('title', 'Sửa sản phẩm')

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
                            <div class="card-title">Sửa sản phẩm</div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Tên sản phẩm -->
                                <div class="form-group">
                                    <label for="name">Tên sản phẩm</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
                                </div>

                                <!-- Thương hiệu -->
                                <div class="form-group">
                                    <label for="brand_id">Thương hiệu</label>
                                    <select name="brand_id" id="brand_id" class="form-control">
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Danh mục -->
                                <div class="form-group">
                                    <label for="catalogue_id">Danh mục</label>
                                    <select name="catalogue_id" id="catalogue_id" class="form-control">
                                        @foreach($catalogues as $catalogue)
                                            <option value="{{ $catalogue->id }}" {{ $product->catalogue_id == $catalogue->id ? 'selected' : '' }}>
                                                {{ $catalogue->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Hình ảnh sản phẩm -->
                                <div class="form-group">
                                    <label for="image_url">Hình ảnh</label>
                                    <input type="file" name="image_url" id="image_url" class="form-control"><br>
                                    @if ($product->image_url && \Storage::exists($product->image_url))
                                        <img src="{{ \Storage::url($product->image_url) }}" alt="{{ $product->name }}" style="max-width: 100px; height: auto;">
                                    @else
                                        <p>Không có ảnh</p>
                                    @endif
                                </div>
                                <!-- Trạng thái hoạt động (is_active) -->
                                <div class="form-group">
                                    <label for="is_active">Trạng thái hoạt động</label>
                                    <select name="is_active" id="is_active" class="form-control">
                                        <option value="1" {{ $product->is_active ? 'selected' : '' }}>Hoạt động</option>
                                        <option value="0" {{ !$product->is_active ? 'selected' : '' }}>Không hoạt động</option>
                                    </select>
                                </div>

                                <!-- Giá sản phẩm -->
                                <div class="form-group">
                                    <label for="price">Giá sản phẩm</label>
                                    <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}" required>
                                </div>

                                <!-- Slug -->
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" value="{{ $product->slug }}">
                                </div>

                                <!-- SKU -->
                                <div class="form-group">
                                    <label for="sku">SKU (Mã sản phẩm)</label>
                                    <input type="text" name="sku" id="sku" class="form-control" value="{{ $product->sku }}">
                                </div>

                                <!-- Cân nặng (Weight) -->
                                <div class="form-group">
                                    <label for="weight">Cân nặng (kg)</label>
                                    <input type="text" name="weight" id="weight" class="form-control" value="{{ $product->weight }}">
                                </div>

                                <!-- Kích thước (Dimensions) -->
                                <div class="form-group">
                                    <label for="dimensions">Kích thước (DxRxC)</label>
                                    <input type="text" name="dimensions" id="dimensions" class="form-control" value="{{ $product->dimensions }}">
                                </div>

                                <!-- Mô tả sản phẩm -->
                                <div class="form-group">
                                    <label for="description">Mô tả sản phẩm</label>
                                    <textarea name="description" id="description" class="form-control" rows="4">{{ $product->description }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

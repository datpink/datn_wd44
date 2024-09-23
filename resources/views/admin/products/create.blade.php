@extends('admin.master')

@section('title', 'Thêm mới sản phẩm')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Thêm Mới Sản Phẩm</div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên Sản Phẩm</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="catalogue_id" class="form-label">Danh Mục</label>
                                    <select class="form-control" id="catalogue_id" name="catalogue_id">
                                        @foreach ($catalogues as $catalogue)
                                            <option value="{{ $catalogue->id }}">{{ $catalogue->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="brand_id" class="form-label">Thương Hiệu</label>
                                    <select class="form-control" id="brand_id" name="brand_id">
                                        <option value="">Không có</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="sku" class="form-label">SKU</label>
                                    <input type="text" class="form-control" id="sku" name="sku" value="{{ old('sku') }}">
                                </div>
                                <div class="form-group">
                                    <label for="weight">Cân nặng (kg)</label>
                                    <input type="text" name="weight" class="form-control" id="weight" value="{{ old('weight') }}">
                                </div>

                                <div class="form-group">
                                    <label for="dimensions">Kích thước (DxRxC)</label>
                                    <input type="text" name="dimensions" class="form-control" id="dimensions" value="{{ old('dimensions') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Giá</label>
                                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Tồn Kho</label>
                                    <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="image_url" class="form-label">Ảnh Sản Phẩm</label>
                                    <input type="file" class="form-control" id="image_url" name="image_url">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô Tả</label>
                                    <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Trạng Thái</label>
                                    <select class="form-control" id="is_active" name="is_active">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Thêm Mới</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

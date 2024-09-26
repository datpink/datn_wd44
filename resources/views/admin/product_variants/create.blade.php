@extends('admin.master')

@section('title', 'Thêm mới biến thể sản phẩm')

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
                            <div class="card-title">Thêm Mới Biến Thể Sản Phẩm</div>
                        </div>
                        <div class="card-body">
                            <!-- Form để thêm biến thể sản phẩm -->
                            <form action="{{ route('product_variants.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <!-- Thuộc tính lựa chọn sản phẩm gốc -->
                                <div class="mb-3">
                                    <label for="product_id" class="form-label">Chọn Sản Phẩm Gốc</label>
                                    <select class="form-control" id="product_id" name="product_id">
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Thuộc tính tên biến thể -->
                                <div class="mb-3">
                                    <label for="variant_name" class="form-label">Tên Biến Thể</label>
                                    <input type="text" class="form-control" id="variant_name" name="variant_name"
                                        value="{{ old('variant_name') }}">
                                </div>

                                <!-- SKU của biến thể -->
                                <div class="mb-3">
                                    <label for="sku" class="form-label">SKU</label>
                                    <input type="text" class="form-control" id="sku" name="sku"
                                        value="{{ old('sku') }}">
                                </div>

                                <!-- Cân nặng của biến thể -->
                                <div class="form-group">
                                    <label for="weight">Cân nặng (kg)</label>
                                    <input type="text" name="weight" class="form-control" id="weight"
                                        value="{{ old('weight') }}">
                                </div>

                                <!-- Kích thước của biến thể -->
                                <div class="form-group">
                                    <label for="dimension">Kích thước (DxRxC)</label>
                                    <input type="text" name="dimension" class="form-control" id="dimension"
                                        value="{{ old('dimension') }}">
                                </div>

                                <!-- Giá của biến thể -->
                                <div class="mb-3">
                                    <label for="price" class="form-label">Giá</label>
                                    <input type="number" step="0.01" class="form-control" id="price" name="price"
                                        value="{{ old('price') }}">
                                </div>

                                <!-- Tồn kho của biến thể -->
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Tồn Kho</label>
                                    <input type="number" class="form-control" id="stock" name="stock"
                                        value="{{ old('stock') }}">
                                </div>

                                <!-- Ảnh của biến thể -->
                                <div class="mb-3">
                                    <label for="image_url" class="form-label">Ảnh Biến Thể</label>
                                    <input type="file" class="form-control" id="image_url" name="image_url">
                                </div>

                                <!-- Mô tả của biến thể -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô Tả</label>
                                    <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                                </div>

                                <!-- Trạng thái của biến thể -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Trạng Thái</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="active" selected>Kích hoạt</option>
                                        <option value="inactive">Không kích hoạt</option>
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

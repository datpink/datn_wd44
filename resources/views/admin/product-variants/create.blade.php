@extends('admin.master')

@section('title', 'Thêm mới sản phẩm variant')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Thêm Mới Sản Phẩm Variant</div>
                    <a href="{{ route('product-variants.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                <div class="card-body mt-4">

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

                    <form action="{{ route('product-variants.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="product_id">Tên sản phẩm:</label>
                            <select name="product_id" id="product_id"
                                class="form-control @error('product_id') is-invalid @enderror">
                                <option value="" disabled selected>Chọn sản phẩm</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="variant_name">Tên Variant:</label>
                            <input type="text" class="form-control @error('variant_name') is-invalid @enderror"
                                name="variant_name" id="variant_name" value="{{ old('variant_name') }}">
                            @error('variant_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="price">Giá:</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price"
                                id="price" value="{{ old('price') }}" step="0.01">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stock">Số lượng trong kho:</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock"
                                id="stock" value="{{ old('stock') }}">
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sku">SKU:</label>
                            <input type="text" class="form-control @error('sku') is-invalid @enderror" name="sku"
                                id="sku" value="{{ old('sku') }}">
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image_url">Hình ảnh:</label>
                            <input type="file" class="form-control-file @error('image_url') is-invalid @enderror"
                                name="image_url" id="image_url">
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Trạng thái:</label>
                            <select name="status" id="status"
                                class="form-control @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">Tạo Variant</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

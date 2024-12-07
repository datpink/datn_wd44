@extends('admin.master')

@section('title', 'Sửa sản phẩm variant')

@section('content')
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
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Sửa Sản Phẩm Variant</div>
                    <a href="{{ route('products.variants.index', $product->id) }}"
                        class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                <div class="card-body mt-4">

                    <form
                        action="{{ route('variants.update', ['product' => $variant->product_id, 'variant' => $variant->id]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Product Name (readonly) -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label for="product_id">Tên sản phẩm:</label>
                                    <input type="text" class="form-control" id="product_id"
                                        value="{{ $variant->product->name }}" readonly>
                                </div>

                                <!-- Variant Name -->
                                <div class="form-group mb-2">
                                    <label for="variant_name">Tên Variant:</label>
                                    <input type="text" class="form-control @error('variant_name') is-invalid @enderror"
                                        name="variant_name" id="variant_name"
                                        value="{{ old('variant_name', $variant->variant_name) }}" required>
                                    @error('variant_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Price -->
                                <div class="form-group mb-2">
                                    <label for="price">Giá:</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                        name="price" id="price"
                                        value="{{ old('price', number_format($variant->price, 0, '.', '')) }}"
                                        step="0.01" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Stock -->
                                <div class="form-group mb-2">
                                    <label for="stock">Số lượng trong kho:</label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                        name="stock" id="stock" value="{{ old('stock', $variant->stock) }}" required>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div>
                                    <button type="submit" class="btn rounded-pill btn-primary">Cập nhật</button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label for="sku">SKU:</label>
                                    <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                        name="sku" id="sku" value="{{ old('sku', $variant->sku) }}" readonly>
                                    @error('sku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="form-group mb-2">
                                    <label for="status">Trạng thái:</label>
                                    <select name="status" id="status"
                                        class="form-control @error('status') is-invalid @enderror">
                                        <option value="active"
                                            {{ old('status', $variant->status) == 'active' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="inactive"
                                            {{ old('status', $variant->status) == 'inactive' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Image URL -->
                                <div class="form-group mb-2 mt-3">
                                    <label for="image_url">Hình ảnh:</label>
                                    <input type="file" class="form-control-file @error('image_url') is-invalid @enderror"
                                        name="image_url" id="image_url" onchange="previewImage(event)">

                                    @if ($variant->image_url)
                                        <div class="mt-3">
                                            <img src="{{ Storage::url($variant->image_url) }}" alt="Image"
                                                style="max-width: 100px;">
                                        </div>
                                    @endif

                                    <img id="image-preview" src="" alt="Hình ảnh xem trước"
                                        style="max-width: 100px; height: auto; display: none;" class="mt-2">
                                </div>

                                <!-- Image Preview Script -->
                                <script>
                                    function previewImage(event) {
                                        const output = document.getElementById('image-preview');
                                        output.style.display = 'block';
                                        output.src = URL.createObjectURL(event.target.files[0]);
                                    }
                                </script>

                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

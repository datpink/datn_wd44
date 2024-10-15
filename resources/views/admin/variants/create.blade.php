@extends('admin.master')

@section('title', 'Thêm biến thể')

@section('content')
    <h4>Thêm Biến Thể cho Sản Phẩm: {{ $product->name }}</h4>

    <form action="{{ route('variants.store', $product->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="variant_name">Tên Biến Thể</label>
            <input type="text" name="variant_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="price">Giá</label>
            <input type="number" name="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="sku">SKU</label>
            <input type="text" name="sku" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="stock">Kho</label>
            <input type="number" name="stock" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="attributes">Chọn Thuộc Tính</label>
            <select name="attributes[]" class="form-control" >
                @foreach($attributeValues as $value)
                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Thêm Biến Thể</button>
    </form>
@endsection

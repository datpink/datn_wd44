@extends('admin.master')

@section('title', 'Chỉnh sửa Attribute Value')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Chỉnh sửa Attribute Value</div>
                    <a href="{{ route('attributes.attribute_values.index', $attributeId) }}" class="btn btn-sm rounded-pill btn-secondary d-flex align-items-center">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                <div class="card-body mt-4">

                    <form action="{{ route('attributes.attribute_values.update', [$attributeId, $value->id]) }}" method="POST" id="attributeValueForm" >
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="attribute_id">Attribute:</label>
                            <select name="attribute_id" id="attribute_id" class="form-control @error('attribute_id') is-invalid @enderror" disabled>
                                <option value="{{ $value->attribute_id }}" selected>{{ $value->attribute->name }}</option>
                            </select>
                            @error('attribute_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <label for="name">Tên Attribute Value:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" id="name" value="{{ old('name', $value->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <button type="submit" id="submitButton" class="btn btn-primary rounded-pill d-flex align-items-center">
                                <i class="bi bi-pencil me-2"></i> Cập nhật Attribute Value
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
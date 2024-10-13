@extends('admin.master')

@section('title', 'Chỉnh sửa Attribute')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Chỉnh sửa Thuộc Tính</div>
                    <a href="{{ route('attributes.index') }}" class="btn btn-sm rounded-pill btn-secondary d-flex align-items-center">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                <div class="card-body mt-4">

                    {{-- @if (session('success'))
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <div>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif --}}

                    <form action="{{ route('attributes.update', $attribute->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Tên Attribute:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                id="name" value="{{ old('name', $attribute->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary rounded-pill d-flex align-items-center">
                                <i class="bi bi-pencil me-2"></i> Cập nhật Attribute
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
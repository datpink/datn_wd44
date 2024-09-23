@extends('admin.master')

@section('title', 'Cập Nhật Danh Mục')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Cập Nhật Danh Mục</div>
                    <a href="{{ route('categories.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('categories.update', $category) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Tên danh mục:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="description">Mô tả:</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                        </div>
                        

                        <div class="form-group">
                            <label for="status">Trạng thái:</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status"
                                required>
                                <option value="active" {{ $category->status === 'active' ? 'selected' : '' }}>Kích hoạt
                                </option>
                                <option value="inactive" {{ $category->status === 'inactive' ? 'selected' : '' }}>Không
                                    kích hoạt</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        

                        <button type="submit" class="btn rounded-pill btn-primary mt-3">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

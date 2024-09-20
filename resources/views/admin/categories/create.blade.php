@extends('admin.master')

@section('title', 'Thêm Danh Mục')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Thêm Mới Danh Mục</div>
                    <a href="{{ route('categories.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">
                    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="name">Tên danh mục:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="parent_id">Danh mục cha:</label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">Chọn danh mục cha</option>
                                @foreach($parentCategories as $parentCategory)
                                    <option value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                                    @if($parentCategory->children->isNotEmpty())
                                        @include('admin.categories.partials.category_options', ['categories' => $parentCategory->children, 'prefix' => '--- '])
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả:</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="status">Trạng thái:</label>
                            <select name="status" id="status" class="form-control">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Không kích hoạt</option>
                            </select>
                        </div>

                        <button type="submit" class="btn rounded-pill btn-primary mt-3">Thêm danh mục</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
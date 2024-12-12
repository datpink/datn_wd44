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
                    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data"
                        id="categoryForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-4">
                                    <label for="name">Tên danh mục:</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <div class="text-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>

                                <div class="form-group mt-4">
                                    <label for="parent_id">Danh mục cha:</label>
                                    <select name="parent_id" id="parent_id" class="form-control">
                                        <option value="">Chọn danh mục cha</option>
                                        @foreach ($parentCategories as $parentCategory)
                                            <option value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                                            @if ($parentCategory->children->isNotEmpty())
                                                @include('admin.categories.partials.category_options', [
                                                    'categories' => $parentCategory->children,
                                                    'prefix' => '--- ',
                                                ])
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <div class="text-danger">{{ $errors->first('parent_id') }}</div>
                                    @enderror
                                </div>

                                <button type="submit" id="submitButton" class="btn rounded-pill btn-primary mt-4">Thêm danh
                                    mục</button>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mt-4">
                                    <label for="description">Mô tả:</label>
                                    <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $errors->first('description') }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mt-4">
                                    <label for="status">Trạng thái:</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Kích hoạt
                                        </option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Không
                                            kích hoạt</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger">{{ $errors->first('status') }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

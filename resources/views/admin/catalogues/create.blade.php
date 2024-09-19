@extends('admin.master')

@section('title', 'Thêm Danh Mục')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Thêm Mới Danh Mục</div>
                    <a href="{{ route('catalogues.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">
                    <form action="{{ route('catalogues.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="name">Tên danh mục:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="parent_id">Danh mục cha:</label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">Chọn danh mục cha</option>
                                @foreach($parentCatalogues as $parentCatalogue)
                                    <option value="{{ $parentCatalogue->id }}">{{ $parentCatalogue->name }}</option>
                                    @if($parentCatalogue->children->isNotEmpty())
                                        @include('admin.catalogues.partials.category_options', ['categories' => $parentCatalogue->children, 'prefix' => '--- '])
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="image">Hình ảnh:</label>
                            <input type="file" name="image" id="image" class="form-control" onchange="previewImage(event)">
                            <img id="imagePreview" src="{{ old('image') ? asset('storage/' . old('image')) : '' }}" alt="Hình ảnh xem trước" class="mt-2" style="display: {{ old('image') ? 'block' : 'none' }}; width: 100px;">
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

    <script>
        function previewImage(event) {
            const imagePreview = document.getElementById('imagePreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '';
                imagePreview.style.display = 'none';
            }
        }
    </script>
@endsection
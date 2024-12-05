@extends('admin.master')

@section('title', 'Thêm mới bài viết')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Thêm Mới Bài Viết</div>
                    <a href="{{ route('posts.index') }}" class="btn rounded-pill btn-sm btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                <div class="card-body mt-4">

                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="user_id" id="user_id" value="1">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Tiêu đề:</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        name="title" id="title" value="{{ old('title') }}" onkeyup="generateSlug()">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="slug">Slug:</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                        id="slug" name='slug' value="{{ old('slug') }}" readonly>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tomtat">Tóm tắt:</label>
                                    <textarea class="form-control @error('tomtat') is-invalid @enderror" name="tomtat" id="tomtat">{{ old('tomtat') }}</textarea>
                                    @error('tomtat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="category_id">Danh mục:</label>
                                    <select name="category_id"
                                        class="form-control @error('category_id') is-invalid @enderror" id="category_id">
                                        <option value="" disabled selected>Chọn danh mục</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="image">Hình ảnh:</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        name="image" id="image" onchange="previewImage(event)">

                                    <img id="imagePreview" src="" alt="Hình ảnh xem trước"
                                        style="max-width: 300px; height: auto; display: none;" class="mt-2">

                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <button type="submit" class="btn rounded-pill btn-primary">Gửi</button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editor">Nội dung:</label>
                                    <textarea name="content" id="editor" class="form-control @error('content') is-invalid @enderror">{{ old('content', $post->content ?? '') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label for="is_featured">Bài viết nổi bật:</label>
                                    <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                        {{ old('is_featured') ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>

    <script>
        function previewImage(event) {
            const imagePreview = document.getElementById('imagePreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block'; // Hiện hình ảnh xem trước
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = ''; // Xóa ảnh xem trước
                imagePreview.style.display = 'none'; // Ẩn hình ảnh xem trước
            }
        }

        function generateSlug() {
            const title = document.getElementById("title").value;
            let slug = title.toLowerCase()
                .replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a')
                .replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e')
                .replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i')
                .replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o')
                .replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u')
                .replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y')
                .replace(/đ/gi, 'd')
                .replace(/[^a-z0-9\s]/g, '') // Xóa các ký tự đặc biệt
                .trim() // Xóa khoảng trắng ở đầu và cuối
                .replace(/\s+/g, '-') // Thay thế khoảng trắng thành dấu gạch ngang
                .replace(/-+/g, '-'); // Thay thế nhiều dấu gạch ngang thành một
            document.getElementById('slug').value = slug;
        }
    </script>
@endsection

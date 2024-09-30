@extends('admin.master')

@section('title', 'Chỉnh sửa bài viết')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Chỉnh sửa Bài Viết</div>
                    <a href="{{ route('posts.index') }}" class="btn rounded-pill btn-sm btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                <div class="card-body mt-4">

                    {{-- @if (session('success'))
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
                    @endif --}}

                    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" class="form-control" name="user_id" id="user_id"
                            value="{{ $post->user_id }}">

                        <div class="form-group">
                            <label for="title">Tiêu đề:</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                id="title" value="{{ old('title', $post->title) }}" onkeyup="generateSlug()">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug:</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name='slug' value="{{ old('slug', $post->slug) }}" readonly>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tomtat">Tóm tắt:</label>
                            <textarea class="form-control @error('tomtat') is-invalid @enderror" name="tomtat" id="tomtat">{{ old('tomtat', $post->tomtat) }}</textarea>
                            @error('tomtat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category_id">Danh mục:</label>
                            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror"
                                id="category_id">
                                <option value="" disabled selected>Chọn danh mục</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Hình ảnh:</label>
                            <input type="file" class=" mb-3 form-control-file @error('image') is-invalid @enderror" name="image" id="image">
                            @if ($post->image)
                                <img src="{{ asset('images/' . $post->image) }}" alt="{{ $post->title }}"
                                    style="width: 150px">
                            @endif
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="editor">Nội dung:</label>
                            <textarea name="content" id="editor" class="form-control @error('content') is-invalid @enderror">{{ old('content', $post->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
 
                        <div class="form-group">
                            <label for="is_featured">Bài viết nổi bật:</label>
                            <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                {{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }}>
                        </div>

                        <div>
                            <button type="submit" class="btn rounded-pill btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');

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

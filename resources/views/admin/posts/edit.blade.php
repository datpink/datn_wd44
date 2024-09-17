@extends('admin.master')

@section('title', 'Thêm mới danh mục tin tức')

@section('content')
<div class="main-admin">
    <h1>Tạo Bài viết</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('errors'))
        <div class="alert alert-errors">{{ session('errors') }}</div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" class="form-control @error('user_id') is-invalid @enderror" name="user_id" id="user_id" value="1">
        <div class="form-group">
            <label for="title">Tiêu đề:</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title') }}">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="summary">Tóm tắt:</label>
            <textarea class="form-control @error('summary') is-invalid @enderror" name="summary" id="summary">{{ old('summary') }}</textarea>
            @error('summary')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="category_id">Danh mục:</label>
            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" id="category_id">
                <option value="" disabled selected>Chọn danh mục</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div id="post_parts">
            <h3>Các phần của bài viết</h3>
            <div class="post_part border p-3 mb-3">
                <div class="form-group">
                    <label for="type">Loại:</label>
                    <select name="post_parts[0][type]" class="form-control type_select @error('post_parts.0.type') is-invalid @enderror">
                        <option value="text">Văn bản</option>
                        <option value="image">Hình ảnh</option>
                    </select>
                    @error('post_parts.0.type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group content_field">
                    <label for="content">Nội dung:</label>
                    <textarea class="form-control" name="post_parts[0][content]">{{ old('post_parts.0.content') }}</textarea>
                    @error('post_parts.0.content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group image_field" style="display:none;">
                    <label for="image_path">Đường dẫn hình ảnh:</label>
                    <input type="file" class="form-control-file @error('post_parts.0.image_path') is-invalid @enderror" name="post_parts[0][image_path]">
                    @error('post_parts.0.image_path')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="order">Thứ tự:</label>
                    <input type="number" class="form-control @error('post_parts.0.order') is-invalid @enderror" name="post_parts[0][order]" value="{{ old('post_parts.0.order') }}">
                    @error('post_parts.0.order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="button" class="btn btn-danger remove_part">Xóa</button>
            </div>
        </div>

        <button type="button" id="add_part" class="btn btn-secondary mb-3">Thêm phần</button>

        <div>
            <button type="submit" class="btn btn-primary">Gửi</button>
        </div>
    </form>
</div>

<script>
    let partIndex = 1;

    function updateFields(part) {
        const typeSelect = part.find('.type_select');
        const contentField = part.find('.content_field');
        const imageField = part.find('.image_field');

        typeSelect.change(function() {
            if ($(this).val() === 'text') {
                contentField.show();
                imageField.hide();
            } else if ($(this).val() === 'image') {
                contentField.hide();
                imageField.show();
            }
        });

        typeSelect.trigger('change');
    }

    $('#add_part').click(function() {
        const newPart = $(`
            <div class="post_part border p-3 mb-3">
                <div class="form-group">
                    <label for="type">Loại:</label>
                    <select name="post_parts[${partIndex}][type]" class="form-control type_select">
                        <option value="text">Văn bản</option>
                        <option value="image">Hình ảnh</option>
                    </select>
                </div>
                <div class="form-group content_field">
                    <label for="content">Nội dung:</label>
                    <textarea class="form-control" name="post_parts[${partIndex}][content]"></textarea>
                </div>
                <div class="form-group image_field" style="display:none;">
                    <label for="image">Đường dẫn hình ảnh:</label>
                    <input type="file" class="form-control-file" name="post_parts[${partIndex}][image]">
                </div>
                <div class="form-group">
                    <label for="order">Thứ tự:</label>
                    <input type="number" class="form-control" name="post_parts[${partIndex}][order]">
                </div>
                <button type="button" class="btn btn-danger remove_part">Xóa</button>
            </div>
        `);

        $('#post_parts').append(newPart);
        updateFields(newPart);
        partIndex++;
    });

    $(document).on('click', '.remove_part', function() {
        $(this).closest('.post_part').remove();
    });

    $(document).ready(function() {
        updateFields($('.post_part'));
    });
</script>
@endsection

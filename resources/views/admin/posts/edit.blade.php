@extends('admin.master')

@section('title', 'Cập nhật Bài Đăng')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Cập Nhật Bài Đăng</div>
                    <a href="{{ route('posts.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('errors'))
                        <div class="alert alert-danger">{{ session('errors') }}</div>
                    @endif

                    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">Tiêu đề:</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="summary">Tóm tắt:</label>
                            <textarea name="summary" id="summary" class="form-control @error('summary') is-invalid @enderror">{{ old('summary', $post->summary) }}</textarea>
                            @error('summary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category_id">Danh mục:</label>
                            <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                <option value="">Chọn danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Các phần của bài đăng -->
                        <div id="post_parts">
                            <h3>Các phần bài đăng</h3>
                            @foreach($post->parts as $index => $part)
                                <div class="post_part border p-3 mb-3">
                                    <div class="form-group">
                                        <label for="type">Loại:</label>
                                        <select name="post_parts[{{ $index }}][type]" class="form-control type_select">
                                            <option value="text" {{ $part->type == 'text' ? 'selected' : '' }}>Text</option>
                                            <option value="image" {{ $part->type == 'image' ? 'selected' : '' }}>Image</option>
                                        </select>
                                    </div>
                                    <div class="form-group content_field" style="{{ $part->type == 'text' ? 'display:block;' : 'display:none;' }}">
                                        <label for="content">Nội dung:</label>
                                        <textarea class="form-control" name="post_parts[{{ $index }}][content]">{{ old('post_parts.' . $index . '.content', $part->content) }}</textarea>
                                    </div>
                                    <div class="form-group image_field" style="{{ $part->type == 'image' ? 'display:block;' : 'display:none;' }}">
                                        <label for="image_path">Đường dẫn ảnh:</label>
                                        @if($part->image && \Storage::exists($part->image))
                                            <img src="{{  \Storage::url($part->image) }}" alt="{{ $part->content }}" width="100">
                                        @endif
                                        <input type="file" class="form-control-file" name="post_parts[{{ $index }}][image]">
                                    </div>
                                    <div class="form-group">
                                        <label for="order">Thứ tự:</label>
                                        <input type="number" class="form-control" name="post_parts[{{ $index }}][order]" value="{{ old('post_parts.' . $index . '.order', $part->order) }}">
                                    </div>
                                    <button type="button" class="btn btn-danger remove_part">Xóa</button>
                                    <input type="hidden" name="post_parts[{{ $index }}][id]" value="{{ $part->id }}">
                                </div>
                            @endforeach
                        </div>

                        <button type="button" id="add_part" class="btn btn-secondary mb-3">Thêm phần</button>

                        <div>
                            <button type="submit" class="btn rounded-pill btn-primary mt-3">Cập nhật bài đăng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let partIndex = {{ count($post->parts) }};

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
                            <option value="text">Text</option>
                            <option value="image">Image</option>
                        </select>
                    </div>
                    <div class="form-group content_field" style="display:none;">
                        <label for="content">Nội dung:</label>
                        <textarea class="form-control" name="post_parts[${partIndex}][content]"></textarea>
                    </div>
                    <div class="form-group image_field" style="display:none;">
                        <label for="image_path">Đường dẫn ảnh:</label>
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

        $('#post_parts').on('click', '.remove_part', function() {
            $(this).closest('.post_part').remove();
        });

        // Cập nhật các phần đã có
        $('.post_part').each(function() {
            updateFields($(this));
        });
    </script>
@endsection

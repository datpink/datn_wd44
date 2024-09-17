@extends('admin.master')

@section('title', 'Thùng Rác Bài Viết')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Thùng Rác Bài Viết</div>
                    <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-rounded">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('errors'))
                    <div class="alert alert-errors">{{ session('errors') }}</div>
                @endif
                <div class="card-body">
                    @if ($trash->isEmpty())
                        <p>Không có bài viết nào trong thùng rác.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ảnh</th>
                                    <th>Tiêu đề</th>
                                    <th>Tóm tắt</th>
                                    <th>Danh mục</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày xóa</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trash as $post)
                                    <tr>
                                        <td>{{ $post->id }}</td>
                                        <td>
                                            @php
                                                $partWithImage = $post->parts->where('type', 'image')->first();
                                            @endphp

                                            @if ($partWithImage && $partWithImage->image && \Storage::exists($partWithImage->image))
                                                @php
                                                    $image = $partWithImage->image;
                                                @endphp
                                                <img src="{{ \Storage::url($image) }}" alt="{{ $post->title }}"
                                                    height="150"
                                                    style="width: auto; max-width: 100px; height: auto; max-height: 150px">
                                            @else
                                                Không có ảnh
                                            @endif
                                        </td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->summary }}</td>
                                        <td>{{ $post->category->name }}</td>
                                        <td>{{ $post->created_at }}</td>
                                        <td>{{ $post->deleted_at }}</td>
                                        <td>
                                            <form action="{{ route('posts.restore', $post->id) }}" method="POST"
                                                class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Khôi phục</button>
                                            </form>
                                            <form action="{{ route('posts.forceDelete', $post->id) }}" method="POST"
                                                class="d-inline-block"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn bài viết này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Xóa vĩnh viễn</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

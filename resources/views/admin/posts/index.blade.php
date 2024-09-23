@extends('admin.master')

@section('title', 'Danh sách bài viết')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            @if (session('success'))
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
            @endif

            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Danh Sách Bài Viết</div>
                            <div>
                                <a href="{{ route('posts.create') }}"
                                    class="btn btn-primary btn-rounded d-flex align-items-center">
                                    <i class="bi bi-plus-circle me-2"></i> Thêm Mới
                                </a>
                                <a href="{{ route('posts.trash') }}"
                                    class="btn btn-primary btn-rounded d-flex align-items-center mt-3">
                                    <i class="bi bi-trash me-2"></i> Thùng Rác
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="" class="mb-3">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" id="id" name="search" class="form-control form-control-sm" placeholder="Tìm kiếm đơn hàng" value="{{ request()->search }}">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tiêu đề</th>
                                        <th>Tóm tắt</th>
                                        <th>Danh mục</th>
                                        <th>Hình Ảnh</th>
                                        <th>Ngày tạo</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td>{{ $post->id }}</td>
                                            <td class="title-column" style="width: 18%;">{{ $post->title }}</td>
                                            <td class="title-column" style="width: 18%;">{{ $post->tomtat }}</td>
                                            <td>{{ $post->category->name }}</td>
                                            <td>
                                                @if ($post->image)
                                                    <img src="{{ asset('images/' . $post->image) }}"
                                                        alt="{{ $post->title }}" style="width: 100px">
                                                @endif
                                            </td>
                                            <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>


                                            <td class="title-column" style="width: 20%;">
                                                <!-- Nút sửa bài viết -->
                                                <a href="{{ route('posts.edit', $post->id) }}"
                                                    class="btn btn-warning">Sửa</a>

                                                <!-- Form để xóa bài viết -->
                                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                                    class="d-inline-block"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa mềm bài viết này?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-warning">Xóa</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

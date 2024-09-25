@extends('admin.master')

@section('title', 'Thùng Rác Bài Viết')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="card">
                {{-- @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('errors'))
                    <div class="alert alert-danger">{{ session('errors') }}</div>
                @endif --}}
                <div class="card-header">
                    <div class="card-title">Thùng Rác Bài Viết</div>
                    <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-rounded">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                <div class="card-body">
                    @if ($trash->isEmpty())
                        <p>Không có bài viết nào trong thùng rác.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tiêu đề</th>
                                    <th>Tóm tắt</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày xóa</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trash as $post)
                                    <tr>
                                        <td>{{ $post->id }}</td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->tomtat }}</td>
                                        <td>{{ $post->created_at }}</td>
                                        <td>{{ $post->deleted_at }}</td>
                                        <td>
                                            <form action="{{ route('posts.restore', $post->id) }}" method="POST" class="d-inline-block restore-form">
                                                @csrf
                                                <button type="button" class="btn btn-outline-success rounded-pill restore-btn" title="Khôi phục bài viết">
                                                    Khôi phục
                                                </button>
                                            </form>
                                            <form action="{{ route('posts.forceDelete', $post->id) }}" method="POST" class="d-inline-block force-delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-danger rounded-pill force-delete-btn" title="Xóa vĩnh viễn bài viết">
                                                    Xóa vĩnh viễn
                                                </button>
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

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    @if (session()->has('success'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 1500
            });
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            Swal.fire({
                position: "top",
                icon: "error",
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 2500
            });
        </script>
    @endif

    <script>
        document.querySelectorAll('.restore-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('.restore-form');
                Swal.fire({
                    position: "top",
                    title: 'Bạn có chắc chắn muốn khôi phục bài viết này?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Hủy',
                    timer: 3500
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        document.querySelectorAll('.force-delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('.force-delete-form');
                Swal.fire({
                    position: "top",
                    title: 'Bạn có chắc chắn muốn xóa vĩnh viễn bài viết này?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Hủy',
                    timer: 3500
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection

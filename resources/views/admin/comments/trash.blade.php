<!-- resources/views/admin/comments/trash.blade.php -->

@extends('admin.master')

@section('title', 'Thùng Rác')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper p-4">

            <div class="card border-0 rounded shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title mb-3">Thùng rác</div>
                    <a href="{{ route('comments.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Người dùng</th>
                                    <th>Bài viết</th>
                                    <th>Nội dung</th>
                                    <th style="width: 35%">Phản hồi</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comments as $comment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $comment->user->name ?? 'N/A' }}</td>
                                        <td>{{ $comment->post->title ?? 'N/A' }}</td>
                                        <td>{{ $comment->content }}</td>
                                        <td>
                                            @if ($comment->commentReplys->count() > 0)
                                                <button class="btn btn-link p-0" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#commentReplys-{{ $comment->id }}"
                                                    aria-expanded="false" aria-controls="commentReplys-{{ $comment->id }}">
                                                    Xem {{ $comment->commentReplys->count() }} phản hồi
                                                </button>
                                                <div class="collapse mt-2" id="commentReplys-{{ $comment->id }}">
                                                    <ul class="list-group" style="padding: 0; margin: 0;">
                                                        @foreach ($comment->commentReplys as $response)
                                                            <li class="list-group-item border-0"
                                                                style="border-bottom: 1px solid #dee2e6 !important;">
                                                                <strong>{{ $response->user->name ?? 'Người dùng' }}:</strong>
                                                                {{ $response->reply }}
                                                                <br>
                                                                <small class="text-muted">Đã phản hồi vào:
                                                                    {{ $response->created_at->format('d/m/Y H:i') }}</small>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @else
                                                <span>Chưa có phản hồi.</span>
                                            @endif
                                        </td>

                                        <td>
                                            <!-- Khôi phục -->
                                            <form action="{{ route('comments.restore', $comment->id) }}" method="POST"
                                                class="d-inline-block restore-form">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="restore-btn"
                                                    style="background: none; border: none; padding: 0; margin-right: 15px;"
                                                    title="Khôi phục bình luận">
                                                    <i class="bi bi-arrow-repeat text-success"
                                                        style="font-size: 1.8em;"></i>
                                                </button>
                                            </form>

                                            <!-- Xóa vĩnh viễn -->
                                            <form action="{{ route('comments.delete-permanently', $comment->id) }}"
                                                method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-btn"
                                                    style="background: none; border: none; padding: 0;"
                                                    title="Xóa vĩnh viễn bình luận">
                                                    <i class="bi bi-trash text-danger" style="font-size: 1.8em;"></i>
                                                </button>
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
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.all.min.js"></script>

    <script>
        // Xác nhận khi xóa brand
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    position: "top",
                    title: 'Bạn có chắc muốn xóa',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Hủy',
                    timerProgressBar: true, // Hiển thị thanh thời gian
                    timer: 3500

                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('form').submit();
                    }
                });
            });
        });

        document.querySelectorAll('.restore-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('.restore-form');
                Swal.fire({
                    position: "top",
                    title: 'Bạn có chắc chắn muốn khôi phục bình luận này?',
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

    @if (session('restore'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "Khôi phục thành công",
                showConfirmButton: false,
                timerProgressBar: true, // Hiển thị thanh thời gian
                timer: 1500
            });
        </script>
    @endif


    @if (session('deletePermanently'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "Đã xóa vĩnh viễn",
                showConfirmButton: false,
                timerProgressBar: true, // Hiển thị thanh thời gian
                timer: 1500
            });
        </script>
    @endif
@endsection

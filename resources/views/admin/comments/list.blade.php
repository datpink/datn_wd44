<!-- resources/views/admin/comments/index.blade.php -->
@extends('admin.master')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header mb-5">
                            <div class="card-title">Danh sách bình luận bài viết</div>
                        </div>
                        <div class="table-responsive">
                            <table class="table v-middle m-0">
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
                                                    <button class="btn btn-link p-0" type="button" data-toggle="collapse"
                                                        data-target="#commentReplys-{{ $comment->id }}"
                                                        aria-expanded="false"
                                                        aria-controls="commentReplys-{{ $comment->id }}">
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
                                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger delete-btn">Xóa</button>
                                                </form>
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#responseModal" data-id="{{ $comment->id }}"
                                                    data-user="{{ $comment->user->name ?? '' }}"
                                                    data-content="{{ $comment->content }}">Phản hồi</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="responseModal" tabindex="-1" role="dialog"
                            aria-labelledby="responseModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content rounded-lg shadow-lg">
                                    <div class="modal-header border-b-2 p-4">
                                        <h5 class="modal-title text-lg font-semibold" id="responseModalLabel">Phản hồi bình
                                            luận
                                        </h5>
                                        <button type="button" class="close rounded hover:bg-gray-200" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <form id="responseForm" action="" method="POST">
                                            @csrf
                                            <input type="hidden" id="commentId" name="comment_id">
                                            <div class="flex flex-col space-y-4">
                                                <div class="form-group flex items-center">
                                                    <label for="user" class="mr-2 font-medium">Người dùng:</label>
                                                    <input type="text"
                                                        class="form-control flex-1 border-gray-300 rounded" id="user"
                                                        readonly>
                                                </div>
                                                <div class="form-group flex items-center">
                                                    <label for="content" class="mr-2 font-medium">Nội dung bình
                                                        luận:</label>
                                                    <input type="text"
                                                        class="form-control flex-1 border-gray-300 rounded" id="content"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group mt-4">
                                                <label for="response" class="font-medium">Phản hồi:</label>
                                                <textarea class="form-control border-gray-300 rounded" id="response" name="response" rows="3"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-4">Gửi phản hồi</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Alert 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.all.min.js"></script>

    <script>
        $('#responseModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var commentId = button.data('id'); // Extract info from data-* attributes
            var userName = button.data('user');
            var commentContent = button.data('content');

            var modal = $(this);
            modal.find('#commentId').val(commentId);
            modal.find('#user').val(userName);
            modal.find('#content').val(commentContent);
            modal.find('#responseForm').attr('action', 'comments/respond/' + commentId);
        });

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
    </script>

    {{-- thông báo phản hồi  --}}
    @if (session()->has('respond'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "Phản hồi thành công",
                // text: 'Có quần què gì đâu mà phản với chả hồi?',
                showConfirmButton: false,
                timerProgressBar: true, // Hiển thị thanh thời gian
                timer: 3500
            });
        </script>
    @endif

    {{-- thông báo phản hồi  --}}
    @if (session()->has('respondError'))
        <script>
            Swal.fire({
                position: "top",
                icon: "error",
                title: "Nhập nội dung phản hồi",
                // text: 'Có quần què gì đâu mà phản với chả hồi?',
                showConfirmButton: false,
                timerProgressBar: true, // Hiển thị thanh thời gian
                timer: 3500
            });
        </script>
    @endif

    {{-- thông báo xóa thành công --}}
    @if (session()->has('destroyComment'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "Xóa thành công",
                showConfirmButton: false,
                timerProgressBar: true, // Hiển thị thanh thời gian
                timer: 1500
            });
        </script>
    @endif
@endsection

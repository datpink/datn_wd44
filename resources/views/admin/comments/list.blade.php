<!-- resources/views/admin/comments/index.blade.php -->
@extends('admin.master')

@section('title', 'Danh Sách Bình Luận')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-header mb-5">
                                <div class="card-title">Danh sách bình luận bài viết</div>
                            </div>
                            <div>
                                {{-- <a href="{{ route('comments.create') }}"
                                    class="btn btn-sm rounded-pill btn-primary d-flex align-items-center">
                                    <i class="bi bi-plus-circle me-2"></i> Thêm Mới
                                </a> --}}
                                <a href="{{ route('comments.trash') }}"
                                    class="btn btn-primary btn-rounded d-flex align-items-center mt-3">
                                    <i class="bi bi-trash me-2"></i> Thùng Rác
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <form method="GET" action="{{ route('comments.index') }}" class="mb-3">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" id="search" name="search" class="form-control form-control-sm" placeholder="Tìm kiếm bình luận" value="{{ request()->search }}">
                                    </div>
                                    <div class="col-auto">
                                        <input type="date" name="comment_date" class="form-control form-control-sm" value="{{ request()->comment_date }}">
                                    </div>
                                    {{-- <div class="col-auto">
                                        <input type="date" name="reply_date" class="form-control form-control-sm" value="{{ request()->reply_date }}">
                                    </div> --}}
                                    <div class="col-auto">
                                        <select name="responded" class="form-select form-select-sm">
                                            <option value="">Tất cả bình luận</option>
                                            <option value="1" {{ request()->responded === '1' ? 'selected' : '' }}>Đã phản hồi</option>
                                            <option value="0" {{ request()->responded === '0' ? 'selected' : '' }}>Chưa phản hồi</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" id="filterRemove" class="btn btn-sm btn-warning">Xóa lọc</button>
                                    </div>
                                </div>
                            </form>


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
                                                <td>{{ $comment->user->name ?? '' }}</td>
                                                <td>{{ $comment->post->title ?? '' }}</td>
                                                <td>{{ $comment->content }}</td>
                                                <td>
                                                    @if ($comment->commentReplys->count() > 0)
                                                        <button class="btn btn-link p-0" type="button"
                                                            data-toggle="collapse"
                                                            data-target="#commentReplys-{{ $comment->id }}"
                                                            aria-expanded="false"
                                                            aria-controls="commentReplys-{{ $comment->id }}">
                                                            Xem {{ $comment->commentReplys->count() }} phản hồi
                                                        </button>
                                                        <div class="collapse mt-2" id="commentReplys-{{ $comment->id }}">
                                                            <ul class="list-group" style="padding: 0; margin: 0;">
                                                                @foreach ($comment->commentReplys as $response)
                                                                    <li class="list-group-item border-0"
                                                                        style="border-bottom: 1px solid #dee2e6 !important;"
                                                                        data-comment-id="{{ $comment->id }}">
                                                                        <strong>{{ $response->user->name ?? 'Người dùng' }}:</strong>
                                                                        {{ $response->reply }}
                                                                        <br>
                                                                        <small class="text-muted">Đã phản hồi vào:
                                                                            {{-- {{ $response->created_at->format('d/m/Y H:i') !=null ? $response->created_at->format('d/m/Y H:i') : '' }}</small> --}}
                                                                            <button type="button"
                                                                                class="btn btn-sm btn-warning edit-reply"
                                                                                data-id="{{ $response->id }}"
                                                                                data-reply="{{ $response->reply }}">
                                                                                Sửa
                                                                            </button>
                                                                    </li>
                                                                @endforeach

                                                            </ul>
                                                        </div>
                                                    @else
                                                        <span>Chưa có phản hồi.</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <button type="button"
                                                        class="btn rounded-pill btn-primary btnModalReply"
                                                        data-toggle="modal" data-target="#responseModal" id="btnModalReply"
                                                        data-id="{{ $comment->id }}"
                                                        data-user="{{ $comment->user->name ?? '' }}"
                                                        data-content="{{ $comment->content }}">
                                                        <i class="bi bi-reply"></i> Phản hồi
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                            <!-- Modal Sửa Phản Hồi -->
                            <div class="modal fade" id="editResponseModal" tabindex="-1" role="dialog"
                                aria-labelledby="editResponseModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content rounded-lg shadow-lg">
                                        <div class="modal-header border-b-2 p-4">
                                            <h5 class="modal-title" id="editResponseModalLabel">Sửa Phản Hồi</h5>
                                            {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button> --}}
                                        </div>
                                        <div class="modal-body p-4">
                                            <form id="editResponseForm" action="" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" id="editReplyId" name="reply_id">
                                                <div class="form-group">
                                                    <label for="editReply" class="font-medium">Nội dung phản hồi:</label>
                                                    <textarea class="form-control" id="editReply" name="reply" rows="3" required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-4">Cập nhật</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!-- Modal Phản hồi-->
                            <div class="modal fade" id="responseModal" tabindex="-1" role="dialog"
                                aria-labelledby="responseModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content rounded-lg shadow-lg">
                                        <div class="modal-header border-b-2 p-4">
                                            <h5 class="modal-title text-lg font-semibold" id="responseModalLabel">Phản hồi
                                                bình luận
                                            </h5>
                                            <button type="button" class="close rounded hover:bg-gray-200"
                                                data-dismiss="modal" aria-label="Close">
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
                                                            class="form-control flex-1 border-gray-300 rounded"
                                                            id="user" disabled>
                                                    </div>
                                                    <div class="form-group flex items-center">
                                                        <label for="content" class="mr-2 font-medium">Nội dung bình
                                                            luận:</label>
                                                        <input type="text"
                                                            class="form-control flex-1 border-gray-300 rounded"
                                                            id="content" disabled>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

        {{-- Alert 2 --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.all.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#filterRemove').click(function() {
                    $('#search').val('');
                    $(this).closest('form').submit();
                });
            });
            $(document).on('click', '.edit-reply', function() {
                var replyId = $(this).data('id');
                var replyContent = $(this).data('reply');
                // Đặt giá trị vào form
                $('#editReplyId').val(replyId);
                $('#editReply').val(replyContent);
                $('#editResponseForm').attr('action', 'comments/' + $(this).closest('li').data('comment-id') +
                    '/reply/' + replyId); // Đặt đường dẫn cho form

                $('#editResponseModal').modal('show');
            });
        </script>


        <script>
            $('.btnModalReply').each(function() {

                var button = $(this); // Button that triggered the modal
                console.log(button);

                button.on('click', function(event) {


                    console.log(this.dataset);

                    var commentId = button.data('id'); // Extract info from data-* attributes
                    var userName = button.data('user');
                    var commentContent = button.data('content');
                    // console.log('Comment ID:', commentId);
                    // console.log('User Name:', userName);
                    // console.log('Comment Content:', commentContent);

                    // var modal = $(this);
                    var modal = $('#responseModal');
                    modal.find('#commentId').val(commentId);
                    modal.find('#user').val(userName);
                    modal.find('#content').val(commentContent);

                    // console.log(modal.find('#commentId').val(commentId), modal.find('#user').val(userName));

                    // console.log('modal:', modal);


                    modal.find('#responseForm').attr('action', 'comments/respond/' + commentId);
                })
            });

            // Xác nhận khi xóa brand
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        position: "top",
                        title: 'Bạn có chắc muốn xóa',
                        icon: 'warning',
                        toast: true,
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
                    toast: true,
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
                    toast: true,
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
                    toast: true,
                    title: "Xóa thành công",
                    showConfirmButton: false,
                    timerProgressBar: true, // Hiển thị thanh thời gian
                    timer: 3500
                });
            </script>
        @endif

        {{-- update pahnr hòio --}}
        @if (session()->has('updateReply'))
            <script>
                Swal.fire({
                    position: "top",
                    icon: "success",
                    toast: true,
                    title: "Phản hồi đã được cập nhật.",
                    showConfirmButton: false,
                    timerProgressBar: true, // Hiển thị thanh thời gian
                    timer: 3500
                });
            </script>
        @endif
    @endsection

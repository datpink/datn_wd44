@extends('admin.master')

@section('title', 'Danh Sách Đánh Giá Sản Phẩm')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-header mb-5">
                                <div class="card-title">Danh sách đánh giá sản phẩm</div>
                            </div>
                            <div>
                                <a href=""
                                    class="btn btn-primary btn-rounded d-flex align-items-center mt-3">
                                    <i class="bi bi-trash me-2"></i> Thùng Rác
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <form method="GET" action="{{ route('product-reviews.index') }}" class="mb-3">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" id="search" name="search"
                                            class="form-control form-control-sm" placeholder="Tìm kiếm đánh giá"
                                            value="{{ request()->search }}">
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
                                            <th>Stt</th>
                                            <th>Người dùng</th>
                                            <th>Sản phẩm</th>
                                            <th>Xếp hạng</th>
                                            <th>Đánh giá</th>
                                            <th>Phản hồi</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productReviews as $index => $review)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $review->user->name ?? 'N/A' }}</td>
                                                <td>{{ $review->product->name ?? 'N/A' }}</td>
                                                <td>{{ $review->rating }}</td>
                                                <td>{{ $review->review }}</td>
                                                <td>
                                                    @if ($review->responses->count() > 0)
                                                        <button class="btn btn-link p-0" type="button"
                                                            data-toggle="collapse"
                                                            data-target="#responses-{{ $review->id }}" aria-expanded="false"
                                                            aria-controls="responses-{{ $review->id }}">
                                                            Xem {{ $review->responses->count() }} phản hồi
                                                        </button>
                                                        <div class="collapse mt-2" id="responses-{{ $review->id }}">
                                                            <ul class="list-group" style="padding: 0; margin: 0;">
                                                                @foreach ($review->responses as $response)
                                                                    <li class="list-group-item border-0"
                                                                        style="border-bottom: 1px solid #dee2e6 !important;"
                                                                        data-review-id="{{ $review->id }}">
                                                                        <strong>{{ $response->responder->name ?? 'Người dùng' }}:</strong>
                                                                        {{ $response->response }}
                                                                        <br>
                                                                        <small class="text-muted">Đã phản hồi vào:
                                                                            {{ $response->created_at->format('d/m/Y H:i') }}</small>
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-warning edit-response"
                                                                            data-id="{{ $response->id }}"
                                                                            data-response="{{ $response->response }}">
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
                                                    <form action="{{ route('product-reviews.destroy', $review->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn rounded-pill btn-danger delete-btn">
                                                            <i class="bi bi-trash"></i> Xóa
                                                        </button>
                                                    </form>
                                                    <button type="button"
                                                        class="btn rounded-pill btn-primary btnModalResponse"
                                                        data-toggle="modal" data-target="#responseModal" id="btnModalResponse"
                                                        data-id="{{ $review->id }}"
                                                        data-user="{{ $review->user->name ?? '' }}"
                                                        data-content="{{ $review->review }}">
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
                                        </div>
                                        <div class="modal-body p-4">
                                            <form id="editResponseForm" action="" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" id="editReplyId" name="reply_id">
                                                <div class="form-group">
                                                    <label for="editReply" class="font-medium">Nội dung phản hồi:</label>
                                                    <textarea class="form-control" id="editReply" name="response" rows="3" required></textarea>
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
                                                đánh giá
                                            </h5>
                                            <button type="button" class="close rounded hover:bg-gray-200"
                                                data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form id="responseForm" action="" method="POST">
                                                @csrf
                                                <input type="hidden" id="reviewId" name="product_review_id">
                                                <div class="flex flex-col space-y-4">
                                                    <div class="form-group flex items-center">
                                                        <label for="user" class="mr-2 font-medium">Người dùng:</label>
                                                        <input type="text"
                                                            class="form-control flex-1 border-gray-300 rounded"
                                                            id="user" disabled>
                                                    </div>
                                                    <div class="form-group flex items-center">
                                                        <label for="content" class="mr-2 font-medium">Nội dung đánh giá:</label>
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
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#filterRemove').click(function() {
                $('#search').val('');
                $(this).closest('form').submit();
            });
        });
        $(document).on('click', '.edit-response', function() {
            var responseId = $(this).data('id');
            var responseContent = $(this).data('response');
            $('#editReplyId').val(responseId);
            $('#editReply').val(responseContent);
            $('#editResponseForm').attr('action', 'product-reviews/' + responseId + '/update-response');
            $('#editResponseModal').modal('show');
        });
        $(document).on('click', '.btnModalResponse', function() {
            var reviewId = $(this).data('id');
            var userName = $(this).data('user');
            var content = $(this).data('content');
            $('#user').val(userName);
            $('#content').val(content);
            $('#reviewId').val(reviewId);
            $('#responseForm').attr('action', 'product-reviews/respond/' + reviewId);
        });
    </script>
@endsection

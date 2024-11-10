<div class="kobolg-Tabs-panel kobolg-Tabs-panel--additional_information panel entry-content kobolg-tab"
    id="tab-additional_information" role="tabpanel" aria-labelledby="tab-title-additional_information">

    <h2>Bình luận ({{ $product->comments->count() }})</h2>

    <!-- Hiển thị danh sách bình luận -->
    <div class="col-md-8 mx-auto">
        <div class="comments-section">
            @foreach ($product->comments as $comment)
                <div class="comment">
                    <!-- Hiển thị tên người dùng và ngày đăng bình luận -->
                    <div class="user-info" style="display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center;">
                            @if ($comment->user->image)
                                <img src="{{ asset('storage/' . $comment->user->image) }}"
                                    alt="{{ $comment->user->name }}" class="rounded-circle user-pic"
                                    style="width: 30px; height: 30px; margin-right: 10px;">
                            @else
                                <img src="{{ asset('path/to/default-image.png') }}" alt="Hình đại diện mặc định"
                                    class="rounded-circle user-pic"
                                    style="width: 30px; height: 30px; margin-right: 10px;">
                            @endif
                            <strong>{{ $comment->user->name }}</strong>
                            <span class="date"
                                style="margin-left: 10px;">{{ $comment->created_at->format('d/m/Y') }}</span>
                        </div>

                        <!-- Nút sửa và xóa -->
                        @if ($comment->user_id == Auth::id())
                            <div class="action-icons" style="text-align: right;">
                                <!-- Biểu tượng sửa -->
                                <button class="btn btn-link" onclick="toggleEditForm({{ $comment->id }})"
                                    title="Sửa">
                                    <i class="fa fa-edit" style="font-size: 20px;"></i>
                                </button>

                                <!-- Biểu tượng xóa -->
                                <form action="{{ route('client.deleteComment', [$product->id, $comment->id]) }}"
                                    method="POST" style="display:inline;" id="delete-comment-form-{{ $comment->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-link" type="button"
                                        onclick="confirmDeleteComment({{ $comment->id }})" title="Xóa">
                                        <i class="fa fa-trash" style="font-size: 20px;"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <!-- Nội dung bình luận -->
                    <div class="comment-content" id="comment-content-{{ $comment->id }}" style="margin-top: 5px;">
                        <p>{{ $comment->comment }}</p>
                    </div> <!-- Form chỉnh sửa bình luận ẩn -->
                    <div id="edit-comment-form-{{ $comment->id }}" style="display: none;">
                        <form action="{{ route('client.updateComment', [$product->id, $comment->id]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <textarea name="comment" required>{{ $comment->comment }}</textarea>
                            <button type="submit">Lưu thay đổi</button>
                            <button type="button" onclick="toggleEditForm({{ $comment->id }})">Hủy</button>
                        </form>
                    </div>

                    <!-- Hiển thị các phản hồi -->
                    @foreach ($comment->replies as $reply)
                        <div class="reply" style="margin-bottom: 15px;">
                            <!-- Thông tin người dùng -->
                            <div class="user-info"
                                style="display: flex; align-items: center; justify-content: space-between;">
                                <div style="display: flex; align-items: center;">
                                    @if ($reply->user->image)
                                        <img src="{{ asset('storage/' . $reply->user->image) }}"
                                            alt="{{ $reply->user->name }}" class="rounded-circle user-pic"
                                            style="width: 30px; height: 30px; margin-right: 10px;">
                                    @else
                                        <img src="{{ asset('path/to/default-image.png') }}"
                                            alt="Hình đại diện mặc định" class="rounded-circle user-pic"
                                            style="width: 30px; height: 30px; margin-right: 10px;">
                                    @endif
                                    <strong>{{ $reply->user->name }}</strong>
                                    <span class="date"
                                        style="margin-left: 10px;">{{ $reply->created_at->format('d/m/Y') }}</span>
                                </div>

                                <!-- Biểu tượng sửa và xóa -->
                                @if ($reply->user_id == Auth::id())
                                    <div class="action-icons" style="text-align: right;">
                                        <!-- Biểu tượng sửa -->
                                        <button class="btn btn-link" onclick="toggleEditFormReply({{ $reply->id }})"
                                            title="Sửa">
                                            <i class="fa fa-edit" style="font-size: 20px;"></i>
                                        </button>

                                        <!-- Biểu tượng xóa -->
                                        <form action="{{ route('client.deleteReply', [$comment->id, $reply->id]) }}"
                                            method="POST" style="display:inline;"
                                            id="delete-reply-form-{{ $reply->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-link" type="button"
                                                onclick="confirmDeleteReply({{ $reply->id }})" title="Xóa">
                                                <i class="fa fa-trash" style="font-size: 20px;"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>

                            <!-- Nội dung phản hồi -->
                            <div class="reply-content" id="reply-content-{{ $reply->id }}" style="margin-top: 5px;">
                                <p>{{ $reply->reply }}</p>
                            </div>

                            <!-- Form chỉnh sửa phản hồi ẩn -->
                            <div id="edit-reply-form-{{ $reply->id }}" style="display: none;">
                                <form action="{{ route('client.updateReply', [$comment->id, $reply->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <textarea name="reply" required>{{ $reply->reply }}</textarea>
                                    <button type="submit">Lưu thay đổi</button>
                                    <button type="button"
                                        onclick="toggleEditFormReply({{ $reply->id }})">Hủy</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                    <!-- Form thêm phản hồi -->
                    @auth
                        <form action="{{ route('client.storeReply', $comment->id) }}" method="POST" class="reply-form">
                            @csrf
                            <div class="reply-input">
                                <textarea name="reply" required placeholder="Phản hồi của bạn"></textarea>
                                <button type="submit" class="tbnsend"> <img
                                        src="{{ asset('theme/client/assets/images/send.png') }}" width="30px"
                                        alt=""></button>
                            </div>
                        </form>
                    @endauth
                </div>
            @endforeach

            <!-- Form thêm bình luận -->
            @auth
                <form action="{{ route('client.storeComment', $product->id) }}" method="POST" class="comment-form">
                    @csrf
                    <div class="comment-input">
                        <textarea name="comment" required placeholder="Bình luận của bạn"></textarea>
                        <button type="submit" class="tbnsend">
                            <img src="{{ asset('theme/client/assets/images/send.png') }}" width="30px" alt="">
                        </button>
                    </div>
                </form>
            @endauth
        </div>
    </div>

    <!-- JavaScript để bật tắt form chỉnh sửa -->
    <script>
        function toggleDropdown(commentId) {
            var dropdown = document.getElementById("customDropdown-" + commentId);
            dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
        }

        function toggleDropdownReply(replyId) {
            var dropdown = document.getElementById("customDropdownReply-" + replyId);
            dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
        }

        function toggleEditForm(commentId) {
            var content = document.getElementById('comment-content-' + commentId);
            var form = document.getElementById('edit-comment-form-' + commentId);
            if (form.style.display === "none") {
                form.style.display = "block";
                content.style.display = "none";
            } else {
                form.style.display = "none";
                content.style.display = "block";
            }
        }

        function toggleEditFormReply(replyId) {
            var content = document.getElementById('reply-content-' + replyId);
            var form = document.getElementById('edit-reply-form-' + replyId);
            if (form.style.display === "none") {
                form.style.display = "block";
                content.style.display = "none";
            } else {
                form.style.display = "none";
                content.style.display = "block";
            }
        }
    </script>

    <style>
        .comments-section {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .comment {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }

        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .user-pic {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }

        .date {
            font-size: 12px;
            color: #888;
            margin-left: 5px;
        }

        .comment-content,
        .reply-content {
            margin-top: 10px;
        }

        .reply {
            margin-left: 40px;
            margin-top: 10px;
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 5px;
        }

        .reply-form,
        .comment-form {
            margin-top: 20px;
        }

        .reply-input,
        .comment-input {
            display: flex;
            align-items: center;
            /* Căn giữa theo chiều dọc */
            gap: 5px;
            /* Khoảng cách giữa textarea và nút gửi */
        }

        .reply-input textarea,
        .comment-input textarea {
            width: 100%;
            height: 80px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 8px;
            resize: none;
            /* Ngăn chặn thay đổi kích thước */
        }

        .tbnsend {
            border: none;
            background: none;
            cursor: pointer;
            margin-left: 5px;
        }

        .tbnsend img {
            width: 30px;
        }

        .dropdown-toggle {
            border: none;
            background: none;
            cursor: pointer;
        }

        .dropdown-menu {
            min-width: 150px;
        }

        .dropdown-item {
            cursor: pointer;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .col-md-8 {
                width: 100%;
                padding: 0 10px;
            }
        }
    </style>
</div>

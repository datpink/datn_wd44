<div class="kobolg-Tabs-panel kobolg-Tabs-panel--additional_information panel entry-content kobolg-tab"
    id="tab-additional_information" role="tabpanel" aria-labelledby="tab-title-additional_information">

    <h2>Bình luận ({{ $product->comments->count() }})</h2>

    <!-- Hiển thị danh sách bình luận -->
    <div class="col-md-6 mx-auto">
        <div class="comments-section">
            @foreach ($product->comments as $comment)
                <div class="comment">
                    <!-- Hiển thị tên người dùng và ngày đăng bình luận -->
                    <div class="mr-3">
                        @if ($comment->user->image)
                            <img src="{{ asset('storage/' . $comment->user->image) }}" alt="{{ $comment->user->name }}"
                                class="rounded-circle" style="width: 25px; height: 25px;">
                        @else
                            <img src="{{ asset('path/to/default-image.png') }}" alt="Hình đại diện mặc định"
                                class="rounded-circle" style="width: 25px; height: 25px;">
                        @endif
                        <strong>{{ $comment->user->name }}</strong>
                        <span>{{ $comment->created_at->format('d/m/Y') }}</span>
                    </div>

                    <!-- Nội dung bình luận -->
                    <div id="comment-content-{{ $comment->id }}">
                        <p>{{ $comment->comment }}</p>
                    </div>

                    <!-- Nút menu thả xuống -->

                    @if ($comment->user_id == Auth::id())
                        <!-- Nút menu thả xuống -->
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle"
                                onclick="toggleDropdown({{ $comment->id }})" type="button"
                                id="dropdownMenuButton{{ $comment->id }}" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            </button>
                            <div class="dropdown-menu" id="customDropdown-{{ $comment->id }}" style="display:none;"
                                aria-labelledby="dropdownMenuButton{{ $comment->id }}">
                                <button class="dropdown-item"
                                    onclick="toggleEditForm({{ $comment->id }})">Sửa</button>
                                <form action="{{ route('client.deleteComment', [$product->id, $comment->id]) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="dropdown-item" type="submit"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này không?')">Xóa</button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Form chỉnh sửa bình luận ẩn -->
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
                        <div class="reply">
                            <div class="mr-3">
                                @if ($comment->user->image)
                                    <img src="{{ asset('storage/' . $comment->user->image) }}"
                                        alt="{{ $comment->user->name }}" class="rounded-circle"
                                        style="width: 25px; height: 25px;">
                                @else
                                    <img src="{{ asset('path/to/default-image.png') }}" alt="Hình đại diện mặc định"
                                        class="rounded-circle" style="width: 25px; height: 25px;">
                                @endif
                                <strong>{{ $comment->user->name }}</strong>
                                <span>{{ $comment->created_at->format('d/m/Y') }}</span>
                            </div>

                            <div id="reply-content-{{ $reply->id }}">
                                <p>{{ $reply->reply }}</p>
                            </div>

                            <!-- Nút menu thả xuống cho phản hồi -->
                            @if ($reply->user_id == Auth::id())
                                <!-- Nút menu thả xuống cho phản hồi -->
                                <div class="dropdown">
                                    <button class=" dropdown-toggle" onclick="toggleDropdownReply({{ $reply->id }})"
                                        type="button" id="dropdownMenuButtonReply{{ $reply->id }}"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu" id="customDropdownReply-{{ $reply->id }}"
                                        style="display:none;"
                                        aria-labelledby="dropdownMenuButtonReply{{ $reply->id }}">
                                        <button class="dropdown-item"
                                            onclick="toggleEditFormReply({{ $reply->id }})">Sửa</button>
                                        <form action="{{ route('client.deleteReply', [$comment->id, $reply->id]) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item" type="submit"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa phản hồi này không?')">Xóa</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
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
                        <form action="{{ route('client.storeReply', $comment->id) }}" method="POST">
                            @csrf
                            <textarea name="reply" required placeholder="Phản hồi của bạn"></textarea>
                            <button type="submit" class="tbnsend"> <img
                                    src="{{ asset('theme/client/assets/images/send.png') }}" width="30px"
                                    alt=""></button>
                        </form>
                    @endauth
                </div>
            @endforeach

            <!-- Form thêm bình luận -->
            @auth
                <form action="{{ route('client.storeComment', $product->id) }}" method="POST">
                    @csrf
                    <textarea name="comment" required placeholder="Bình luận của bạn"></textarea>
                    <button type="submit" class="tbnsend"> <img src="{{ asset('theme/client/assets/images/send.png') }}"
                            width="30px" alt=""></button>
                </form>
            @endauth
        </div>
    </div>

    <!-- JavaScript để bật tắt form chỉnh sửa -->
    <script>
        function toggleDropdown(commentId) {
            var dropdown = document.getElementById("customDropdown-" + commentId);
            if (dropdown.style.display === "none") {
                dropdown.style.display = "block";
            } else {
                dropdown.style.display = "none";
            }
        }

        function toggleDropdownReply(replyId) {
            var dropdown = document.getElementById("customDropdownReply-" + replyId);
            if (dropdown.style.display === "none") {
                dropdown.style.display = "block";
            } else {
                dropdown.style.display = "none";
            }
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
</div>

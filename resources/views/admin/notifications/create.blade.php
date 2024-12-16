@extends('admin.master')

@section('title', 'Thêm Thông Báo')

@section('content')
    <style>
        #user_ids {
            height: 150px;
        }
    </style>

    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Thêm Mới Thông Báo</div>
                    <a href="{{ route('admin.notifications.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.notifications.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">Tiêu đề:</label>
                            <input type="text" name="title" class="form-control" id="title">
                        </div>
                        <div class="form-group mt-3">
                            <label for="description">Mô tả:</label>
                            <textarea name="description" class="form-control" id="description"></textarea>
                        </div>
                        <div class="form-group mt-3">
                            <div class="form-check">
                                <input type="checkbox" name="send_to_all" id="send_to_all" class="form-check-input"
                                    value="1" {{ old('send_to_all') ? 'checked' : '' }}>
                                <label for="send_to_all" class="form-check-label">Gửi đến tất cả người dùng</label>
                            </div>
                        </div>

                        <div class="form-group mt-3" id="user_selection">
                            <label for="user_ids" class="form-label">Chọn người dùng:</label>
                            <select name="user_ids[]" id="user_ids" class="form-select" multiple>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_ids') && in_array($user->id, old('user_ids')) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Giữ phím Ctrl (Windows) hoặc Command (Mac) để chọn nhiều
                                người dùng.</small>
                        </div>

                        <div class="form-group">
                            <label for="url" class="form-label">URL:</label>
                            <input type="url" name="url" id="url" class="form-control"
                                value="{{ old('url') }}" placeholder="https://example.com">
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill mt-3">Thêm Thông Báo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sendToAllCheckbox = document.getElementById('send_to_all');
            const userSelectionDiv = document.getElementById('user_selection');

            function toggleUserSelection() {
                if (sendToAllCheckbox.checked) {
                    userSelectionDiv.style.display = 'none';
                } else {
                    userSelectionDiv.style.display = 'block';
                }
            }

            // Gọi hàm khi tải trang và khi checkbox thay đổi
            toggleUserSelection();
            sendToAllCheckbox.addEventListener('change', toggleUserSelection);
        });
    </script>

@endsection

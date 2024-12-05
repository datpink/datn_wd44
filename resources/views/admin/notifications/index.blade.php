@extends('admin.master')

@section('title', 'Danh Sách Thông Báo')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Danh Sách Thông Báo</div>
                    <div>
                        <a href="{{ route('admin.notifications.create') }}"
                            class="btn btn-primary btn-rounded d-flex align-items-center">
                            <i class="bi bi-plus-circle me-2"></i> Thêm Mới
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table v-middle m-0">
                            <thead>
                                <tr>
                                    <th>Stt</th>
                                    <th>Tiêu đề</th>
                                    <th>Mô tả</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>URL</th>
                                </tr>
                            </thead>
                            <tbody>
                             
                                @foreach ($notificationAll as $notification)
                                    <tr>
                                        <td>{{ $notification->id }}</td>
                                        <td>{{ $notification->title }}</td>
                                        <td>{{ \Str::limit($notification->description, 50) }}</td>
                                        <td>
                                            @if ($notification->read_at)
                                                <span class="badge rounded-pill bg-success">Đã đọc</span>
                                            @else
                                                <span class="badge rounded-pill bg-secondary">Chưa đọc</span>
                                            @endif
                                        </td>
                                        <td>{{ $notification->created_at->format('d-m-Y') }}</td>
                                        <td><a href="{{ $notification->url }}">Xem Thử</a></td>
                                        <td class="title-column" style="width: 20%;">
                                            <!-- Nút sửa bài viết -->
                                            <a href="#" class="editRow"
                                                 style="margin-right: 15px;">
                                                <i class="bi bi-pencil-square text-warning"
                                                    style="font-size: 1.8em;"></i>
                                            </a>

                                            <!-- Form để xóa bài viết -->
                                            <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST"
                                                class="d-inline-block delete-form"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa Thông Báo này không?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-btn"
                                                    style="background: none; border: none; padding: 0;"
                                                    >
                                                    <i class="bi bi-trash text-danger" style="font-size: 1.8em;"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination justify-content-center mt-3">
                        {{ $notificationAll->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SweetAlert2 Success Notification -->
    @if (session('success'))
        <script>
            Swal.fire({
                position: 'top',
                icon: 'success',
                toast: true,
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3500
            });
        </script>
    @endif

    <!-- SweetAlert2 Error Notification -->
    @if (session('error'))
        <script>
            Swal.fire({
                position: 'top',
                icon: 'error',
                toast: true,
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3500
            });
        </script>
    @endif
@endsection

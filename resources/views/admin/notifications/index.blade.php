@extends('admin.master')

@section('title', 'Danh Sách Thông Báo')

@section('content')
<div class="content-wrapper-scroll">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Danh Sách Thông Báo</div>
                <div>
                    <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary btn-rounded d-flex align-items-center">
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
                            @foreach ($notifications as $index => $notification)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $notification->title }}</td>
                                    <td>{{ \Str::limit($notification->description, 50) }}</td>
                                    <td>
                                        @if ($notification->read_at)
                                        <span class="badge rounded-pill bg-success">Đã đọc</span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary">Chưa đọc</span>
                                    @endif                                    </td>
                                    <td>{{ $notification->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $notification->url }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination justify-content-center mt-3">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

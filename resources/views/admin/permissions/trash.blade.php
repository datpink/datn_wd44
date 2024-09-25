@extends('admin.master')

@section('title', 'Thùng Rác Vai Trò')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper p-4">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 rounded shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title mb-3">Thùng Rác Vai Trò</div>
                    <a href="{{ route('roles.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Stt</th>
                                    <th>Tên Vai Trò</th>
                                    <th>Ngày xóa</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $index => $role)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->deleted_at ? $role->deleted_at->format('d-m-Y') : 'Chưa xóa' }}</td>
                                        <td>
                                            <form action="{{ route('roles.restore', $role->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success rounded-pill btn-sm" onclick="return confirm('Khôi phục lại vai trò?')">
                                                    <i class="fas fa-undo"></i> Khôi phục
                                                </button>
                                            </form>
                                            <form action="{{ route('roles.forceDelete', $role->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger rounded-pill btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn không?');">
                                                    <i class="fas fa-trash"></i> Xóa vĩnh viễn
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Không có vai trò nào trong thùng rác.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
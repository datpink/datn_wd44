@extends('admin.master')

@section('title', 'Danh Sách Quyền')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Danh Sách Quyền</div>
                    <a href="{{ route('permissions.create') }}" class="btn btn-sm rounded-pill btn-primary">
                        <i class="bi bi-plus-circle me-2"></i> Thêm Quyền
                    </a>
                </div>

                <div class="card-body mt-4">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên Quyền</th>
                                    <th>Guard</th>
                                    <th>Nhóm</th>
                                    <th>Mô Tả</th>
                                    <th>Ngày Tạo</th>
                                    <th>Ngày Cập Nhật</th>
                                    <th>Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->id }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->guard_name }}</td>
                                        <td>{{ $permission->group }}</td>
                                        <td>{{ $permission->description }}</td>
                                        <td>{{ $permission->created_at }}</td>
                                        <td>{{ $permission->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('permissions.edit', $permission->id) }}" class="editRow"
                                                title="Sửa" style="margin-right: 15px;">
                                                <i class="bi bi-pencil-square text-warning" style="font-size: 1.8em;"></i>
                                            </a>
                                            <form action="{{ route('permissions.destroy', $permission->id) }}"
                                                method="POST" class="d-inline-block"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa quyền này không?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-btn"
                                                    style="background: none; border: none; padding: 0;" title="Xóa">
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

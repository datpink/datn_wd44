@extends('admin.master')

@section('title', 'Danh Sách Vai Trò')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Danh Sách Vai Trò</div>
                    <a href="{{ route('roles.create') }}" class="btn btn-sm rounded-pill btn-primary">
                        <i class="bi bi-plus-circle me-2"></i> Thêm Vai Trò
                    </a>
                </div>

                <div class="card-body mt-4">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tên Vai Trò</th>
                                    <th>Quyền Hạn</th>
                                    <th>Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ implode(', ', $role->permissions->pluck('name')->toArray()) }}</td>
                                        <td>
                                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-warning rounded-pill">
                                                <i class="bi bi-pencil-square"></i> Sửa
                                            </a>
                                            <!-- Thêm chức năng xóa nếu cần -->
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa vai trò này không?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger rounded-pill">
                                                    <i class="bi bi-trash"></i> Xóa
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

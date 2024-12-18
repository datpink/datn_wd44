@extends('admin.master')

@section('title', 'Quản lý Vai Trò')

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
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Guard</th>
                                <th>Mô tả</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->guard_name }}</td>
                                    <td>{{ $role->description }}</td>
                                    <td>{{ $role->created_at }}</td>
                                    <td>
                                        <a href="{{ route('roles.edit', $role->id) }}" class="editRow" title="Sửa"
                                            style="margin-right: 15px;">
                                            <i class="bi bi-pencil-square text-warning" style="font-size: 1.8em;"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

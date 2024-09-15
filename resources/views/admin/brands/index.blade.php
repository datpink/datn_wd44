@extends('admin.master')

@section('title', 'Danh Sách Thương Hiệu')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
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

            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Danh Sách Thương Hiệu</div>
                            <div>
                                <a href="{{ route('brands.create') }}" class="btn btn-sm rounded-pill btn-primary d-flex align-items-center">
                                    <i class="bi bi-plus-circle me-2"></i> Thêm thương hiệu
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <form method="GET" action="{{ route('brands.index') }}" class="mb-3">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" id="search" name="search"
                                            class="form-control form-control-sm" placeholder="Tìm kiếm thương hiệu"
                                            value="{{ request()->search }}">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table v-middle m-0">
                                    <thead>
                                        <tr>
                                            <th>Stt</th>
                                            <th>Tên</th>
                                            <th>Mô tả</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($brands as $index => $brand)
                                            <tr>
                                                <td>{{ $brands->firstItem() + $index }}</td>
                                                <td>{{ $brand->name }}</td>
                                                <td>{{ $brand->description }}</td>
                                                <td>
                                                    <a href="{{ route('brands.edit', $brand) }}" class="btn rounded-pill btn-warning btn-sm">Sửa</a>
                                                    <form action="{{ route('brands.destroy', $brand) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger rounded-pill btn-sm"
                                                                onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Không có thương hiệu nào được tìm thấy.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="pagination justify-content-center mt-3">
                                {{ $brands->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
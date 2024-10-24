@extends('admin.master')

@section('title', 'Danh sách người dùng')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            {{-- @if (session('success'))
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
            @endif --}}

            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Danh sách người dùng</div>
                            <div>

                                <a href="{{ route('users.create') }}"
                                    class="btn btn-sm rounded-pill btn-primary d-flex align-items-center">
                                    <i class="bi bi-plus-circle me-2"></i> Thêm Mới
                                </a>
                                {{-- <a href="{{ route('users.trash') }}"
                                    class="btn btn-primary btn-rounded d-flex align-items-center mt-3">
                                    <i class="bi bi-trash me-2"></i> Thùng Rác
                                </a> --}}
                            </div>
                        </div>

                        <div class="card-body">
                            <form method="GET" action="{{ route('users.index') }}" class="mb-3">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" id="search" name="search"
                                            class="form-control form-control-sm" placeholder="Tìm kiếm Người dùng"
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
                                            <th>Email</th>
                                            <th>Số Điện Thoại</th>
                                            <th>Địa Chỉ</th>
                                            <th>Hình Ảnh</th>
                                            <th>Trạng Thái</th>
                                            <th>Hành Động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $index => $user)
                                            <tr>
                                                <td>{{ $users->firstItem() + $index }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone }}</td> <!-- Số điện thoại -->
                                                <td>{{ $user->address }}</td> <!-- Địa chỉ -->
                                                <td>
                                                    @if ($user->image)
                                                        <img src="{{ asset('storage/' . $user->image) }}" alt="User Image"
                                                            style="width: 50px; height: 50px; border-radius: 50%;">
                                                    @else
                                                        <span class="text-muted">Không có hình ảnh</span>
                                                    @endif
                                                </td> <!-- Hình ảnh -->
                                                <td>
                                                    @if ($user->status === 'locked')
                                                        <span class="badge bg-danger">Bị Khóa</span>
                                                    @else
                                                        <span class="badge bg-success">Mở Khóa</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{-- @if ($user->deleted_at)
                                                        <span class="text-muted">Đã xóa</span>
                                                    @else --}}
                                                    <a href="{{ route('users.edit', $user->id) }}" class="editRow" title="Sửa">
                                                        <i class="bi bi-pencil-square text-warning" style="font-size: 1.8em;"></i>
                                                    </a>
                                                    {{-- <form action="{{ route('users.destroy', $user->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger rounded-pill btn-sm"
                                                                onclick="return confirm('Bạn có chắc muốn xóa người dùng này?');">
                                                                <i class="fas fa-trash"></i> Xóa
                                                            </button>
                                                        </form> --}}
                                                    {{-- @endif --}}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Không có người dùng nào được tìm
                                                    thấy.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="pagination justify-content-center mt-3">
                                {{ $users->links() }} <!-- Hiển thị phân trang -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.all.min.js"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timerProgressBar: true, // Hiển thị thanh thời gian
                timer: 1500
            });
        </script>
    @endif
@endsection

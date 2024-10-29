@extends('admin.master')

@section('title', 'Danh Sách Danh Mục')

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
                            <div class="card-title">Danh Sách Danh Mục</div>
                            <div>
                                <a href="{{ route('catalogues.create') }}"
                                    class="btn btn-primary btn-rounded d-flex align-items-center">
                                    <i class="bi bi-plus-circle me-2"></i> Thêm Mới
                                </a>
                                <a href="{{ route('catalogues.trash') }}"
                                    class="btn btn-primary btn-rounded d-flex align-items-center mt-3">
                                    <i class="bi bi-trash me-2"></i> Thùng Rác
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <form method="GET" action="{{ route('catalogues.index') }}" class="mb-3">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" id="search" name="search"
                                            class="form-control form-control-sm" placeholder="Tìm kiếm danh mục"
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
                                            <th>Danh mục cha</th>
                                            <th>Slug</th>
                                            <th>Trạng thái</th>
                                            <th>Hình ảnh</th>
                                            <th>Ngày tạo</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($catalogues as $index => $catalogue)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $catalogue->name }}</td>
                                                <td>{{ $catalogue->parent ? $catalogue->parent->name : 'None' }}</td>
                                                <td>{{ $catalogue->slug }}</td>
                                                <td>
                                                    @if ($catalogue->status === 'active')
                                                        <span class="badge rounded-pill bg-success">Kích hoạt</span>
                                                    @elseif ($catalogue->status === 'inactive')
                                                        <span class="badge rounded-pill bg-secondary">Không kích hoạt</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($catalogue->image)
                                                        <img src="{{ asset('storage/' . $catalogue->image) }}"
                                                            alt="{{ $catalogue->name }}" style="width: 70px;">
                                                    @else
                                                        Không có hình
                                                    @endif
                                                </td>
                                                <td>{{ $catalogue->created_at ? $catalogue->created_at->format('d-m-Y') : 'Chưa có' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('catalogues.edit', $catalogue) }}" class="editRow"
                                                        style="margin-right: 10px;">
                                                        <i class="bi bi-pencil-square text-warning"
                                                            style="font-size: 1.8em;"></i>
                                                    </a>

                                                    <form action="{{ route('catalogues.destroy', $catalogue) }}"
                                                        method="POST" style="display:inline;" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="delete-btn"
                                                            style="background: none; border: none; padding: 0;">
                                                            <i class="bi bi-trash text-danger"
                                                                style="font-size: 1.8em;"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Không có danh mục nào được tìm thấy.
                                                </td> <!-- Cập nhật số cột -->
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="pagination justify-content-center mt-3">
                                {{ $catalogues->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('.delete-form');
                Swal.fire({
                    position: "top",
                    title: 'Bạn có chắc muốn xóa?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Hủy',
                    timerProgressBar: true,
                    timer: 3500
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    @if (session()->has('destroyCatalogue'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "Xóa danh mục thành công",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 1500
            });
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            Swal.fire({
                position: "top",
                icon: "error",
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 2500
            });
        </script>
    @endif

    @if (session()->has('success'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 1500
            });
        </script>
    @endif
@endsection

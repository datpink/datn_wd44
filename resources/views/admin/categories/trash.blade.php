@extends('admin.master')

@section('title', 'Thùng Rác Danh Mục')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper p-4">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 rounded shadow-sm">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title mb-3">Thùng Rác Danh Mục</div>
                    <a href="{{ route('categories.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Stt</th>
                                    <th>Tên</th>
                                    {{-- <th>Hình ảnh</th> --}}
                                    <th>Ngày xóa</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $index => $category)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $category->name }}</td>

                                        <td>{{ $category->deleted_at ? $category->deleted_at->format('d-m-Y') : 'Chưa xóa' }}
                                        </td>
                                        <td>
                                            <form action="{{ route('categories.restore', $category->id) }}" method="POST"
                                                style="display:inline;" class="restore-form">
                                                @csrf
                                                <button type="submit" class="restore-btn"
                                                    style="background: none; border: none; padding: 0; margin-right: 15px;"
                                                    title="Khôi phục">
                                                    <i class="bi bi-arrow-repeat text-success"
                                                        style="font-size: 1.8em;"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('categories.forceDelete', $category->id) }}"
                                                method="POST" style="display:inline;" class="force-delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="force-delete-btn"
                                                    style="background: none; border: none; padding: 0;" title="Xóa cứng">
                                                    <i class="bi bi-trash text-danger" style="font-size: 1.8em;"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Không có danh mục nào trong thùng rác.</td>
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

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    @if (session()->has('restoreCategory'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "{{ session('restoreCategory') }}",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 1500
            });
        </script>
    @endif

    @if (session()->has('forceDeleteCategory'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "{{ session('forceDeleteCategory') }}",
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

    <script>
        document.querySelectorAll('.restore-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('.restore-form');
                Swal.fire({
                    position: "top",
                    title: 'Bạn có chắc chắn muốn khôi phục danh mục này?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Hủy',
                    timer: 3500
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    <script>
        document.querySelectorAll('.force-delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('.force-delete-form');
                Swal.fire({
                    position: "top",
                    title: 'Bạn có chắc chắn muốn xóa cứng danh mục này?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Hủy',
                    timer: 3500
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

@endsection

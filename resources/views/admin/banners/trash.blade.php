@extends('admin.master')

@section('title', 'Thùng Rác Banner')

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
                    <div class="card-title mb-3">Thùng Rác Banner</div>
                    <a href="{{ route('banners.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Stt</th>
                                    <th>Tiêu đề</th>
                                    <th>Ngày xóa</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($banners as $index => $banner)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $banner->title }}</td>
                                        <td>{{ $banner->deleted_at ? $banner->deleted_at->format('d-m-Y') : 'Chưa xóa' }}</td>
                                        <td>
                                            <form action="{{ route('banners.restore', $banner->id) }}" method="POST" style="display:inline;" class="restore-form">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success rounded-pill btn-sm restore-btn">
                                                    <i class="bi bi-arrow-repeat"></i> Khôi phục
                                                </button>
                                            </form>

                                            <form action="{{ route('banners.forceDelete', $banner->id) }}" method="POST" style="display:inline;" class="force-delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger rounded-pill btn-sm force-delete-btn">
                                                    <i class="bi bi-trash"></i> Xóa cứng
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Không có banner nào trong thùng rác.</td>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    @if (session()->has('restoreBanner'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "{{ session('restoreBanner') }}",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 1500
            });
        </script>
    @endif

    @if (session()->has('forceDeleteBanner'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "{{ session('forceDeleteBanner') }}",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 1500
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
                    title: 'Bạn có chắc chắn muốn khôi phục banner này?',
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

        document.querySelectorAll('.force-delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('.force-delete-form');
                Swal.fire({
                    position: "top",
                    title: 'Bạn có chắc chắn muốn xóa cứng banner này?',
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

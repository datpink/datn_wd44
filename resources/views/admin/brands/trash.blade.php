<!-- resources/views/admin/brands/trash.blade.php -->

@extends('admin.master')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper p-4">

            <div class="card border-0 rounded shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title mb-3">Thùng rác thương hiệu</div>
                    <a href="{{ route('brands.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Stt</th>
                                    <th>Tên thương hiệu</th>
                                    <th>Mô tả</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $brand)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $brand->name }}</td>
                                        <td>{{ $brand->description }}</td>
                                        <td>
                                            <!-- Khôi phục -->
                                            <form action="{{ route('brands.restore', $brand->id) }}" method="POST"
                                                style="display:inline-block;" class="restore-form">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" class="btn btn-rounded btn-outline-success restore-btn">Khôi
                                                    phục</button>
                                            </form>
                                            <!-- Xóa vĩnh viễn -->
                                            <form action="{{ route('brands.delete-permanently', $brand->id) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-rounded delete-btn">Xóa
                                                    vĩnh
                                                    viễn</button>
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

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.all.min.js"></script>

    <script>
        // Xác nhận khi xóa brand
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    position: "top",
                    title: 'Bạn có chắc muốn xóa',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Hủy',
                    timerProgressBar: true, // Hiển thị thanh thời gian
                    timer: 3500

                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('form').submit();
                    }
                });
            });
        });

        document.querySelectorAll('.restore-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('.restore-form');
                Swal.fire({
                    position: "top",
                    title: 'Bạn có chắc chắn muốn khôi phục thương hiệu này?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    @if (session()->has('restoreBrand'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "{{ session('restoreBrand') }}",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 1500
            });
        </script>
    @endif


    @if (session('deletePermanently'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "Đã xóa vĩnh viễn",
                showConfirmButton: false,
                timerProgressBar: true, // Hiển thị thanh thời gian
                timer: 1500
            });
        </script>
    @endif
@endsection

@extends('admin.master')

@section('title', 'Danh sách thuộc tính')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Danh Sách Thuộc Tính</div>
                            <div>
                                <a href="{{ route('attributes.create') }}"
                                   class="btn btn-primary btn-rounded d-flex align-items-center">
                                    <i class="bi bi-plus-circle me-2"></i> Thêm Mới
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên thuộc tính</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attributes as $attribute)
                                        <tr>
                                            <td>{{ $attribute->id }}</td>
                                            <td>{{ $attribute->name }}</td>
                                            <td>
                                                <a href="{{ route('attributes.attribute_values.index', $attribute->id) }}" class="editRow" style="margin-right: 20px;" title="Chi tiết">
                                                    <i class="bi bi-info-circle text-warning" style="font-size: 1.8em;"></i>
                                                </a>
                                                <a href="{{ route('attributes.edit', $attribute->id) }}" class="editRow" style="margin-right: 20px;" title="Sửa">
                                                    <i class="bi bi-pencil-square text-success" style="font-size: 1.8em;"></i>
                                                </a>
                                                <form action="{{ route('attributes.destroy', $attribute->id) }}" method="POST" style="display:inline-block;" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="delete-btn" style="background: none; border: none; padding: 0;" title="Xóa">
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
                timerProgressBar: true,
                timer: 1500
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            // Xác nhận xóa thuộc tính
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                const form = this;
                Swal.fire({
                    position: "top",
                    title: 'Bạn có chắc chắn muốn xóa thuộc tính này?',
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
@endsection
@extends('admin.master')

@section('title', 'Danh Sách Quảng Cáo')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Danh sách quảng cáo</div>
                            <div>
                                <a href="{{ route('advertisements.create') }}"
                                    class="btn btn-sm rounded-pill btn-primary d-flex align-items-center">
                                    <i class="bi bi-plus-circle me-2"></i> Thêm Mới
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <form method="GET" action="{{ route('advertisements.index') }}" class="mb-3">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" id="search" name="search"
                                            class="form-control form-control-sm" placeholder="Tìm kiếm quảng cáo"
                                            value="{{ request()->search }}">
                                    </div>
                                    <div class="col-auto">
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="">Lọc theo trạng thái</option>
                                            <option value="active" {{ request()->status === 'active' ? 'selected' : '' }}>Kích hoạt</option>
                                            <option value="inactive" {{ request()->status === 'inactive' ? 'selected' : '' }}>Không kích hoạt</option>
                                        </select>
                                    </div>

                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" id="filterRemove" class="btn btn-sm btn-secondary">Xóa
                                            lọc</button>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table v-middle m-0">
                                    <thead>
                                        <tr>
                                            <th>Stt</th>
                                            <th>Hình ảnh</th>
                                            <th>Tiêu đề</th>
                                            <th>Mô Tả</th>
                                            <th>Link</th>
                                            <th>Vị trí</th> <!-- Thêm cột vị trí -->
                                            <th>Trạng thái</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($advertisements as $advertisement)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/' . $advertisement->image) }}"
                                                        alt="{{ $advertisement->title }}" width="150">
                                                </td>
                                                <td>{{ $advertisement->title }}</td>
                                                <td>{!! $advertisement->description !!}</td>
                                                <td>
                                                    <a href="{{ $advertisement->button_link }}" target="_blank">
                                                        Set
                                                    </a>
                                                </td>
                                                <td>{{ $advertisement->position }}</td> <!-- Hiển thị vị trí -->
                                                <td>
                                                    @if ($advertisement->status === 'active')
                                                        <span class="badge rounded-pill bg-success">Kích hoạt</span>
                                                    @elseif ($advertisement->status === 'inactive')
                                                        <span class="badge rounded-pill bg-secondary">Không kích hoạt</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <a href="{{ route('advertisements.edit', $advertisement->id) }}"
                                                        class="editRow" title="Sửa" style="margin-right: 15px;">
                                                        <i class="bi bi-pencil-square text-warning"
                                                            style="font-size: 1.8em;"></i>
                                                    </a>

                                                    <form
                                                        action="{{ route('advertisements.destroy', $advertisement->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="delete-btn"
                                                            style="background: none; border: none; padding: 0;"
                                                            title="Xóa">
                                                            <i class="bi bi-trash text-danger"
                                                                style="font-size: 1.8em;"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="pagination justify-content-center mt-3">
                                {{ $advertisements->links() }}
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
    <script>
        $(document).ready(function() {
            $('#filterRemove').click(function() {
                $('#search').val('');
                $(this).closest('form').submit();
            });
        });
    </script>
    @if (session('success'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                toast: true,
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3500
            });
        </script>
    @endif

    <script>
        // Xác nhận khi xóa quảng cáo
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    position: "top",
                    title: 'Bạn có chắc muốn xóa',
                    icon: 'warning',
                    toast: true,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Hủy',
                    timerProgressBar: true,
                    timer: 3500
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('form').submit();
                    }
                });
            });
        });
    </script>

    @if (session('updateError'))
        <script>
            Swal.fire({
                position: "top",
                icon: "error",
                toast: true,
                title: "Có lỗi xảy ra",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3500
            });
        </script>
    @endif
@endsection

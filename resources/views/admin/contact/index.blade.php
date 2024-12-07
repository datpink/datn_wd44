@extends('admin.master')

@section('title', 'Danh Sách Liên Hệ')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Danh Sách Liên Hệ</div>
                        </div>

                        <div class="card-body">
                            <form method="GET" action="{{ route('admin.contact.index') }}" class="mb-3">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" id="search" name="search" class="form-control form-control-sm" placeholder="Tìm kiếm liên hệ" value="{{ request()->search }}">
                                    </div>
                                    <div class="col-auto">
                                        <input type="date" name="date" class="form-control form-control-sm" value="{{ request()->date }}">
                                    </div>
                                    <div class="col-auto">
                                        <select name="reply" class="form-select form-select-sm">
                                            <option value="">Lọc theo trạng thái trả lời</option>
                                            <option value="1" {{ request()->reply === '1' ? 'selected' : '' }}>Đã trả lời</option>
                                            <option value="0" {{ request()->reply === '0' ? 'selected' : '' }}>Chưa trả lời</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                                        <a href="{{ route('admin.contact.index') }}" class="btn btn-sm btn-secondary">Reset</a>
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
                                            <th>Tin Nhắn</th>
                                            <th>Trả Lời</th>
                                            <th>Ngày tạo</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($contacts as $index => $contact)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $contact->name }}</td>
                                                <td>{{ $contact->email }}</td>
                                                <td>{{ $contact->message }}</td>
                                                <td>
                                                    @if ($contact->reply)
                                                        <span class="badge rounded-pill bg-success">Đã trả lời</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-danger">Chưa trả lời</span>
                                                    @endif
                                                </td>
                                                <td>{{ $contact->created_at ? $contact->created_at->format('d-m-Y') : 'Chưa có' }}
                                                </td>
                                                <td>
                                                    <a href="#" class="editRow" title="Trả lời"
                                                        style="margin-right: 15px;" data-bs-toggle="modal"
                                                        data-bs-target="#replyModal{{ $contact->id }}">
                                                        <i class="bi bi-pencil-square text-warning"
                                                            style="font-size: 1.8em;"></i>
                                                    </a>

                                                    <form action="{{ route('admin.contact.destroy', $contact) }}"
                                                        method="POST" style="display:inline;" class="delete-form"
                                                        onsubmit="return confirm('Bạn có chắc muốn xóa liên hệ này không?');">
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

                                            <!-- Modal trả lời -->
                                            <div class="modal fade" id="replyModal{{ $contact->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="replyModalLabel{{ $contact->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="replyModalLabel{{ $contact->id }}">Trả Lời Liên Hệ
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('admin.contact.reply', $contact->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="reply">Nội Dung Trả Lời:</label>
                                                                    <textarea name="reply" id="reply" class="form-control" rows="4" required></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Đóng</button>

                                                                @if (!$contact->reply)
                                                                    <!-- Nút "Gửi Trả Lời" chỉ hiển thị khi chưa trả lời -->
                                                                    <button type="submit" class="btn btn-primary">Gửi Trả
                                                                        Lời</button>
                                                                @else
                                                                    <!-- Hiển thị thông báo thay cho nút khi đã trả lời -->
                                                                    <button type="button" class="btn btn-primary"
                                                                        disabled>Đã trả lời</button>
                                                                @endif
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Không có liên hệ nào được tìm thấy.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $contacts->links() }}
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
                    title: 'Bạn có chắc chắn muốn xóa liên hệ này?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    toast: true,
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Hủy',
                    timer: 3500,
                    timerProgressBar: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    } else if (result.dismiss === Swal.DismissReason.timer) {
                        Swal.fire('Đã hủy', 'Hành động đã bị hủy.', 'info');
                    }
                });
            });
        });
    </script>

    @if (session()->has('success'))
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

    @if (session()->has('error'))
        <script>
            Swal.fire({
                position: "top",
                icon: "error",
                toast: true,
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3500
            });
        </script>
    @endif
@endsection

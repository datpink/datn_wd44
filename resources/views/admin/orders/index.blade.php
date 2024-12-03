@extends('admin.master')

@section('title', 'Danh Sách Đơn Hàng')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Danh Sách Đơn Hàng</div>
                            {{-- <a href="{{ route('orders.trash') }}" class="btn rounded-pill btn-primary d-flex align-items-center">
                                <i class="bi bi-trash me-2"></i> Thùng Rác
                            </a> --}}
                        </div>

                        <div class="card-body">
                            <form method="GET" action="{{ route('orders.index') }}" class="mb-3">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" id="id" name="search"
                                            class="form-control form-control-sm" placeholder="Tìm kiếm đơn hàng"
                                            value="{{ request()->search }}">
                                    </div>
                                    <div class="col-auto">
                                        <input type="date" name="date" class="form-control form-control-sm"
                                            value="{{ request()->date }}">
                                    </div>
                                    <div class="col-auto">
                                        <select name="date_filter" class="form-select form-select-sm">
                                            <option value="">Chọn khoảng thời gian</option>
                                            <option value="yesterday"
                                                {{ request()->date_filter === 'yesterday' ? 'selected' : '' }}>Hôm qua
                                            </option>
                                            <option value="this_week"
                                                {{ request()->date_filter === 'this_week' ? 'selected' : '' }}>Tuần này
                                            </option>
                                            <option value="last_week"
                                                {{ request()->date_filter === 'last_week' ? 'selected' : '' }}>Tuần trước
                                            </option>
                                            <option value="this_month"
                                                {{ request()->date_filter === 'this_month' ? 'selected' : '' }}>Tháng này
                                            </option>
                                            <option value="last_month"
                                                {{ request()->date_filter === 'last_month' ? 'selected' : '' }}>Tháng trước
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="">Chọn trạng thái</option>
                                            <option value="processing"
                                                {{ request()->status === 'processing' ? 'selected' : '' }}>Đang xử lý
                                            </option>
                                            <option value="Delivering"
                                                {{ request()->status === 'Delivering' ? 'selected' : '' }}>Đang giao hàng
                                            </option>
                                            <option value="shipped"
                                                {{ request()->status === 'shipped' ? 'selected' : '' }}>Đã giao hàng
                                            </option>
                                            <option value="canceled"
                                                {{ request()->status === 'canceled' ? 'selected' : '' }}>Đã hủy</option>
                                            <option value="refunded"
                                                {{ request()->status === 'refunded' ? 'selected' : '' }}>Hoàn trả</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <select name="payment_status" class="form-select form-select-sm">
                                            <option value="">Chọn trạng thái thanh toán</option>
                                            <option value="pending"
                                                {{ request()->payment_status === 'pending' ? 'selected' : '' }}>Chưa thanh
                                                toán</option>
                                            <option value="paid"
                                                {{ request()->payment_status === 'paid' ? 'selected' : '' }}>Đã thanh toán
                                            </option>
                                            <option value="failed"
                                                {{ request()->payment_status === 'failed' ? 'selected' : '' }}>Thanh toán
                                                thất bại</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                                        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table v-middle m-0">
                                    <thead>
                                        <tr>
                                            <th>Stt</th>
                                            <th>Người dùng</th>
                                            <th>Promotion</th>
                                            <th>Tổng tiền</th>
                                            <th>Giảm giá</th>
                                            <th>Trạng thái</th>
                                            <th>Trạng thái thanh toán</th>
                                            <th>Số điện thoại</th>
                                            <th>Địa chỉ giao hàng</th>
                                            <th>Phương thức thanh toán</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($orders as $index => $order)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $order->user ? $order->user->name : 'N/A' }}</td>
                                                <td>{{ $order->promotion ? $order->promotion->code : 'N/A' }}</td>
                                                <td>{{ number_format($order->total_amount, 0, ',', '.') }} VND</td>
                                                <td>{{ number_format($order->discount_amount, 0, ',', '.') }} VND</td>
                                                <td>
                                                    @if ($order->status === 'processing')
                                                        <span class="badge rounded-pill bg-info">Đang xử lý</span>
                                                    @elseif ($order->status === 'Delivering')
                                                        <span class="badge rounded-pill bg-warning">Đang giao hàng</span>
                                                    @elseif ($order->status === 'shipped')
                                                        <span class="badge rounded-pill bg-primary">Đã giao hàng</span>
                                                    @elseif ($order->status === 'canceled')
                                                        <span class="badge rounded-pill bg-danger">Đã hủy</span>
                                                    @elseif ($order->status === 'refunded')
                                                        <span class="badge rounded-pill bg-secondary">Hoàn trả</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-secondary">Không rõ</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($order->payment_status === 'pending')
                                                        <span class="badge rounded-pill bg-warning">Chưa thanh toán</span>
                                                    @elseif ($order->payment_status === 'paid')
                                                        <span class="badge rounded-pill bg-success">Đã thanh toán</span>
                                                    @elseif ($order->payment_status === 'failed')
                                                        <span class="badge rounded-pill bg-danger">Thanh toán thất
                                                            bại</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-secondary">Không rõ</span>
                                                    @endif
                                                </td>
                                                <td>{{ $order->phone_number }}</td>
                                                <td>{{ $order->shipping_address }}</td>
                                                <td>
                                                    <strong
                                                        class="badge rounded-pill bg-warning">{{ $order->paymentMethod ? $order->paymentMethod->name : 'N/A' }}</strong>
                                                </td>
                                                <td>
                                                    <div class="actions">
                                                        <a href="{{ route('orders.show', $order->id) }}" class="editRow">
                                                            <i class="bi bi-eye text-green"></i>
                                                        </a>

                                                        <a href="#" class="viewRow" data-bs-toggle="modal"
                                                            data-bs-target="#editOrderStatus{{ $order->id }}"
                                                            data-order-id="{{ $order->id }}"
                                                            data-order-status="{{ $order->status }}">
                                                            <i class="bi bi-pencil-square text-warning"></i>
                                                        </a>

                                                        <div class="modal modal-dark fade"
                                                            id="editOrderStatus{{ $order->id }}" tabindex="-1"
                                                            aria-labelledby="editOrderStatusLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="editOrderStatusLabel">
                                                                            Sửa Trạng Thái Đơn Hàng</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form id="orderStatusForm{{ $order->id }}"
                                                                            action="{{ route('orders.update', $order->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <!-- Trạng thái hiện tại (ẩn) -->
                                                                            <input type="hidden" name="current_status"
                                                                                value="{{ $order->status }}">
                                                                            <div class="mb-3">
                                                                                <label for="status"
                                                                                    class="form-label">Chọn Trạng
                                                                                    Thái</label>
                                                                                <select id="status" name="status"
                                                                                    class="form-select"
                                                                                    data-current-status="{{ $order->status }}"
                                                                                    required>
                                                                                    <option value="processing"
                                                                                        {{ $order->status === 'processing' ? 'selected disabled' : '' }}>
                                                                                        Đang xử lý
                                                                                    </option>
                                                                                    <option value="Delivering"
                                                                                        {{ $order->status === 'Delivering' ? 'selected' : '' }}>
                                                                                        Đang giao hàng
                                                                                    </option>
                                                                                    <option value="shipped"
                                                                                        {{ $order->status === 'shipped' ? 'selected' : '' }}>
                                                                                        Đã giao hàng
                                                                                    </option>
                                                                                    <option value="canceled"
                                                                                        {{ $order->status === 'canceled' ? 'selected' : '' }}>
                                                                                        Đã hủy
                                                                                    </option>
                                                                                    <option value="refunded"
                                                                                        {{ $order->status === 'refunded' ? 'selected' : '' }}>
                                                                                        Hoàn trả
                                                                                    </option>
                                                                                </select>
                                                                                <small
                                                                                    id="status-error-{{ $order->id }}"
                                                                                    class="text-danger d-none">
                                                                                    Không thể chuyển từ "Đang giao hàng" về
                                                                                    "Đang xử lý".
                                                                                </small>


                                                                                @if (in_array($order->status, ['shipped', 'canceled', 'refunded']))
                                                                                    <small class="text-danger">Trạng thái
                                                                                        này không thể sửa đổi.</small>
                                                                                @endif
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary rounded-pill"
                                                                            data-bs-dismiss="modal">Đóng</button>
                                                                        @if (!in_array($order->status, ['shipped', 'canceled', 'refunded']))
                                                                            <button type="submit"
                                                                                class="btn btn-success rounded-pill"
                                                                                form="orderStatusForm{{ $order->id }}">Lưu
                                                                                thay đổi</button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- <form action="{{ route('orders.destroy', $order->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-link p-0 deleteRow"
                                                                onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">
                                                                <i class="bi bi-trash text-red"></i>
                                                            </button>
                                                        </form> --}}
                                                        <!-- Kiểm tra trạng thái đơn hàng -->
                                                        @if ($order->status === 'shipped')
                                                            <!-- Thay 'completed' bằng giá trị trạng thái hoàn thành của bạn -->
                                                            <a href="{{ route('orders.invoice', $order->id) }}"
                                                                target="_blank" class="exportInvoice">
                                                                <i class="bi bi-file-earmark-pdf text-blue"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11">Không có đơn hàng nào được tìm thấy.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="pagination justify-content-center mt-3">
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const forms = document.querySelectorAll('form[id^="orderStatusForm"]');

            forms.forEach(form => {
                const select = form.querySelector('#status'); // Dropdown trạng thái
                const submitButton = form.querySelector('button[type="submit"]'); // Nút Lưu
                const errorMessage = form.querySelector(
                    `#status-error-${form.id.match(/\d+/)[0]}`); // Thông báo lỗi
                const currentStatus = select.dataset.currentStatus; // Trạng thái hiện tại

                // Kiểm tra trạng thái trước khi submit form
                form.addEventListener('submit', (event) => {
                    const newStatus = select.value; // Trạng thái mới

                    // Kiểm tra nếu trạng thái không hợp lệ
                    if (currentStatus === 'Delivering' && newStatus === 'processing') {
                        event.preventDefault(); // Ngừng submit form

                        // Hiển thị thông báo lỗi và ẩn nút Lưu
                        errorMessage.classList.remove('d-none');
                        submitButton.classList.add('d-none');

                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Không thể chuyển từ trạng thái Đang giao hàng về trạng thái Đang xử lý!',
                            confirmButtonText: 'OK'
                        });
                    }
                });

                // Lắng nghe sự kiện thay đổi trạng thái
                select.addEventListener('change', () => {
                    const newStatus = select.value; // Trạng thái mới

                    // Kiểm tra nếu trạng thái không hợp lệ
                    if (currentStatus === 'Delivering' && newStatus === 'processing') {
                        errorMessage.classList.remove('d-none'); // Hiển thị lỗi
                        submitButton.classList.add('d-none'); // Ẩn nút Lưu
                    } else {
                        errorMessage.classList.add('d-none'); // Ẩn lỗi
                        submitButton.classList.remove('d-none'); // Hiển thị lại nút Lưu
                    }
                });
            });
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                position: 'top',
                timer: 3500,
                toast: true,
                icon: 'success',
                title: 'Thành công!',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                position: 'top',
                timer: 5000,
                toast: true,
                icon: 'error',
                title: 'Lỗi!',
                text: "{{ $errors->first() }}",
                confirmButtonText: 'OK'
            });
        </script>
    @endif



@endsection

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
                                            <option value="pending_confirmation"
                                                {{ request()->status === 'pending_confirmation' ? 'selected' : '' }}>Chờ xác
                                                nhận
                                            </option>
                                            <option value="pending_pickup"
                                                {{ request()->status === 'pending_pickup' ? 'selected' : '' }}>Chờ lấy hàng
                                            </option>
                                            <option value="pending_delivery"
                                                {{ request()->status === 'pending_delivery' ? 'selected' : '' }}>Chờ giao
                                                hàng
                                            </option>
                                            <option value="returned"
                                                {{ request()->status === 'returned' ? 'selected' : '' }}>Trả hàng
                                            </option>
                                            <option value="delivered"
                                                {{ request()->status === 'delivered' ? 'selected' : '' }}>Đã giao
                                            </option>
                                            <option value="canceled"
                                                {{ request()->status === 'canceled' ? 'selected' : '' }}>Đã hủy
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <select name="payment_status" class="form-select form-select-sm">
                                            <option value="">Chọn trạng thái thanh toán</option>
                                            <option value="unpaid"
                                                {{ request()->payment_status === 'unpaid' ? 'selected' : '' }}>Chưa thanh
                                                toán</option>
                                            <option value="paid"
                                                {{ request()->payment_status === 'paid' ? 'selected' : '' }}>Đã thanh toán
                                            </option>
                                            <option value="refunded"
                                                {{ request()->payment_status === 'refunded' ? 'selected' : '' }}>Hoàn trả
                                            </option>
                                            <option value="payment_failed"
                                                {{ request()->payment_status === 'payment_failed' ? 'selected' : '' }}>
                                                Thanh toán thất bại
                                            </option>
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
                                                    @if ($order->status === 'pending_confirmation')
                                                        <span class="badge rounded-pill bg-info">Chờ xác nhận</span>
                                                    @elseif ($order->status === 'pending_pickup')
                                                        <span class="badge rounded-pill bg-warning">Chờ lấy hàng</span>
                                                    @elseif ($order->status === 'pending_delivery')
                                                        <span class="badge rounded-pill bg-primary">Chờ giao hàng</span>
                                                    @elseif ($order->status === 'returned')
                                                        <span class="badge rounded-pill bg-danger">Trả hàng</span>
                                                    @elseif ($order->status === 'delivered')
                                                        <span class="badge rounded-pill bg-secondary">Đã giao</span>
                                                    @elseif ($order->status === 'canceled')
                                                        <span class="badge rounded-pill bg-secondary">Đã hủy</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-secondary">Không rõ</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($order->payment_status === 'unpaid')
                                                        <span class="badge rounded-pill bg-warning">Chưa thanh toán</span>
                                                    @elseif ($order->payment_status === 'paid')
                                                        <span class="badge rounded-pill bg-success">Đã thanh toán</span>
                                                    @elseif ($order->payment_status === 'refunded')
                                                        <span class="badge rounded-pill bg-danger">Hoàn trả</span>
                                                    @elseif ($order->payment_status === 'payment_failed')
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

                                                        @if ($order->refund_reason && $order->admin_status === 'pending')
                                                            <!-- Icon duyệt hoàn tiền -->
                                                            <form
                                                                action="{{ route('orders.refund.approve', ['id' => $order->id]) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                <button type="button" class="btn btn-icon"
                                                                    title="Duyệt hoàn tiền"
                                                                    style="border: none; background: none;"
                                                                    onclick="confirmApproveRefund(event)">
                                                                    <i class="bi bi-check-circle text-success"></i>
                                                                </button>
                                                            </form>

                                                            <!-- Icon từ chối hoàn tiền -->
                                                            <form
                                                                action="{{ route('orders.refund.reject', ['id' => $order->id]) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                <button type="button" class="btn btn-icon"
                                                                    title="Từ chối hoàn tiền"
                                                                    style="border: none; background: none;"
                                                                    onclick="confirmRejectRefund(event)">
                                                                    <i class="bi bi-x-circle text-danger"></i>
                                                                </button>
                                                            </form>
                                                            <script>
                                                                function confirmApproveRefund(event) {
                                                                    event.preventDefault(); // Ngừng form mặc định
                                                                    Swal.fire({
                                                                        title: 'Bạn có chắc chắn muốn duyệt hoàn tiền?',
                                                                        icon: 'warning',
                                                                        showCancelButton: true,
                                                                        confirmButtonText: 'Duyệt',
                                                                        cancelButtonText: 'Hủy',
                                                                        position: 'top',
                                                                        timer: 3500,
                                                                        toast: true,
                                                                        reverseButtons: true
                                                                    }).then((result) => {
                                                                        if (result.isConfirmed) {
                                                                            event.target.closest('form').submit(); // Gửi form nếu xác nhận
                                                                        }
                                                                    });
                                                                }

                                                                function confirmRejectRefund(event) {
                                                                    event.preventDefault(); // Ngừng form mặc định
                                                                    Swal.fire({
                                                                        title: 'Bạn có chắc chắn muốn từ chối hoàn tiền?',
                                                                        icon: 'error',
                                                                        showCancelButton: true,
                                                                        confirmButtonText: 'Từ chối',
                                                                        cancelButtonText: 'Hủy',
                                                                        position: 'top',
                                                                        timer: 3500,
                                                                        toast: true,
                                                                        reverseButtons: true
                                                                    }).then((result) => {
                                                                        if (result.isConfirmed) {
                                                                            event.target.closest('form').submit(); // Gửi form nếu xác nhận
                                                                        }
                                                                    });
                                                                }
                                                            </script>
                                                        @endif

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
                                                                                    <option value="pending_confirmation"
                                                                                        {{ $order->status === 'pending_confirmation' ? 'selected disabled' : '' }}>
                                                                                        Chờ xác nhận
                                                                                    </option>
                                                                                    <option value="pending_pickup"
                                                                                        {{ $order->status === 'pending_pickup' ? 'selected' : '' }}>
                                                                                        Chờ lấy hàng
                                                                                    </option>
                                                                                    <option value="pending_delivery"
                                                                                        {{ $order->status === 'pending_delivery' ? 'selected' : '' }}>
                                                                                        Chờ giao hàng
                                                                                    </option>
                                                                                    <option value="returned"
                                                                                        {{ $order->status === 'returned' ? 'selected' : '' }}>
                                                                                        Trả hàng
                                                                                    </option>
                                                                                    <option value="delivered"
                                                                                        {{ $order->status === 'delivered' ? 'selected' : '' }}>
                                                                                        Đã giao
                                                                                    </option>
                                                                                    <option value="canceled"
                                                                                        {{ $order->status === 'canceled' ? 'selected' : '' }}>
                                                                                        Đã hủy
                                                                                    </option>
                                                                                </select>
                                                                                {{-- <small
                                                                                    id="status-error-{{ $order->id }}"
                                                                                    class="text-danger d-none">
                                                                                    Không thể chuyển từ "Đang giao hàng" về
                                                                                    "Đang xử lý".
                                                                                </small> --}}


                                                                                @if (in_array($order->status, ['returned', 'delivered', 'canceled']))
                                                                                    <small class="text-danger">Trạng
                                                                                        thái
                                                                                        này không thể sửa đổi.</small>
                                                                                @endif
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary rounded-pill"
                                                                            data-bs-dismiss="modal">Đóng</button>
                                                                        @if (!in_array($order->status, ['returned', 'delivered', 'canceled']))
                                                                            <button type="submit"
                                                                                class="btn btn-success rounded-pill"
                                                                                form="orderStatusForm{{ $order->id }}">Lưu
                                                                                thay đổi</button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Kiểm tra trạng thái đơn hàng -->
                                                        @if ($order->status === 'delivered')
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
                            <div class="mt-3">
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
                    const nonRevertibleStatuses = {
                        pending_delivery: ['pending_confirmation',
                            'pending_pickup'
                        ], // Đang giao hàng không thể về Chờ xác nhận hoặc Chờ lấy hàng
                        pending_pickup: [
                            'pending_confirmation'
                        ], // Chờ lấy hàng không thể về Chờ xác nhận
                    };

                    // Kiểm tra nếu trạng thái không hợp lệ
                    if (
                        nonRevertibleStatuses[currentStatus] &&
                        nonRevertibleStatuses[currentStatus].includes(newStatus)
                    ) {
                        event.preventDefault(); // Ngừng submit form

                        // Hiển thị thông báo lỗi và ẩn nút Lưu
                        errorMessage.classList.remove('d-none');
                        submitButton.classList.add('d-none');

                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: `Không thể chuyển từ trạng thái ${getStatusName(currentStatus)} về trạng thái ${getStatusName(newStatus)}!`,
                            confirmButtonText: 'OK'
                        });
                    }
                });

                // Hàm chuyển trạng thái thành tên hiển thị
                function getStatusName(status) {
                    const statusNames = {
                        pending_confirmation: 'Chờ xác nhận',
                        pending_pickup: 'Chờ lấy hàng',
                        pending_delivery: 'Chờ giao hàng'
                    };
                    return statusNames[status] || 'Không xác định';
                }


                // Lắng nghe sự kiện thay đổi trạng thái
                select.addEventListener('change', () => {
                    const newStatus = select.value; // Trạng thái mới
                    const nonRevertibleStatuses = {
                        pending_delivery: ['pending_confirmation',
                            'pending_pickup'
                        ], // Đang giao hàng không thể về Chờ xác nhận hoặc Chờ lấy hàng
                        pending_pickup: [
                            'pending_confirmation'
                        ], // Chờ lấy hàng không thể về Chờ xác nhận
                    };

                    // Kiểm tra nếu trạng thái không hợp lệ
                    if (
                        nonRevertibleStatuses[currentStatus] &&
                        nonRevertibleStatuses[currentStatus].includes(newStatus)
                    ) {
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

@extends('admin.master')

@section('title', 'Danh Sách Đơn Hàng')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

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
                                        <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
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
                                                                            <div class="mb-3">
                                                                                <label for="status"
                                                                                    class="form-label">Chọn Trạng
                                                                                    Thái</label>
                                                                                <select id="status" name="status"
                                                                                    class="form-select" required
                                                                                    {{ in_array($order->status, ['shipped', 'canceled', 'refunded']) ? 'disabled' : '' }}>
                                                                                    <option value="processing"
                                                                                        {{ $order->status === 'processing' ? 'selected' : '' }}>
                                                                                        Đang xử lý</option>
                                                                                    <option value="Delivering"
                                                                                        {{ $order->status === 'Delivering' ? 'selected' : '' }}>
                                                                                        Đang giao hàng</option>
                                                                                    <option value="shipped"
                                                                                        {{ $order->status === 'shipped' ? 'selected' : '' }}>
                                                                                        Đã giao hàng</option>
                                                                                    <option value="canceled"
                                                                                        {{ $order->status === 'canceled' ? 'selected' : '' }}>
                                                                                        Đã hủy</option>
                                                                                    <option value="refunded"
                                                                                        {{ $order->status === 'refunded' ? 'selected' : '' }}>
                                                                                        Hoàn trả</option>
                                                                                </select>
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
    <script>
        function confirmChangeStatus(orderId) {
            const selectElement = document.querySelector(`#editOrderStatus${orderId} #status`);
            const newStatus = selectElement.value;

            if (['canceled', 'refunded'].includes(newStatus)) {
                return true;
            }
            return true;
        }
    </script>
@endsection

@extends('admin.master')

@section('title', 'Thùng Rác Đơn Hàng')

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
                    <div class="card-title mb-3">Thùng Rác Đơn Hàng</div>
                    <a href="{{ route('orders.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Stt</th>
                                    <th>Người dùng</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $index => $order)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $order->user ? $order->user->name : 'N/A' }}</td>
                                        <td>{{ number_format($order->total_amount, 0, ',', '.') }} VND</td>
                                        <td><span class="badge bg-danger rounded-pill">Đã xóa</span></td>
                                        <td class="text-center">
                                            <form action="{{ route('orders.restore', $order->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Khôi phục lại đơn hàng?')"
                                                    class="btn btn-outline-success rounded-pill btn-sm">
                                                    <i class="fas fa-undo"></i> Khôi phục
                                                </button>
                                            </form>
                                            <form action="{{ route('orders.forceDelete', $order->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger rounded-pill btn-sm"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa cứng không?');">
                                                    <i class="fas fa-trash"></i> Xóa cứng
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Không có đơn hàng nào trong thùng rác.</td>
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

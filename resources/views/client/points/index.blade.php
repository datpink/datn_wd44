@extends('client.master')

@section('title', 'Lịch Sử Điểm Thưởng')

@section('content')

    @include('components.breadcrumb-client2', ['title' => 'Điểm Thưởng'])

    <div class="container my-5">
        <!-- Tổng Điểm Thưởng -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center" style="background-color: #fff4f2; border-left: 5px solid #e63946;">
                        <div>
                            <h3 class="mb-1 text-uppercase text-secondary fw-bold">Tổng Điểm Thưởng</h3>
                            <h1 class="text-danger fw-bold">{{ $userPoint ? $userPoint->total_points : 0 }} điểm</h1>
                        </div>
                        <div>
                            <img src="{{ asset('images/reward-icon.png') }}" alt="Reward Icon" style="height: 80px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lịch Sử Giao Dịch -->
        <div class="row">
            <div class="col-md-12">
                <h4 class="mb-3 fw-bold text-uppercase" style="color: #e63946;">Lịch Sử Giao Dịch Điểm</h4>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead style="background-color: #e63946; color: #fff;">
                            <tr>
                                <th>#</th>
                                <th>Loại Giao Dịch</th>
                                <th>Số Điểm</th>
                                <th>Mô Tả</th>
                                <th>Thời Gian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $index => $transaction)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($transaction->type == 'earn')
                                            <span class="badge bg-success">+ {{ $transaction->points }} điểm</span>
                                        @else
                                            <span class="badge bg-danger">- {{ $transaction->points }} điểm</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold">{{ $transaction->points }}</td>
                                    <td>{{ $transaction->description ?? 'Không có mô tả' }}</td>
                                    <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Không có giao dịch nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Phân Trang -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection

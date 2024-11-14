@extends('client.master')

@section('title', 'Danh sách mã giảm giá')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Danh sách mã giảm giá của bạn</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Form nhập mã giảm giá -->
                    <form action="{{ route('promotion.add') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="code" id="code" class="form-control" placeholder="Nhập mã giảm giá" required>
                            <button type="submit" class="btn btn-success">Thêm mã</button>
                        </div>
                    </form>

                    <!-- Danh sách mã giảm giá -->
                    <h4 class="mt-4">Mã giảm giá của bạn:</h4>
                    <div class="list-group">
                        @forelse($userPromotions as $userPromotion)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $userPromotion->promotion->code }}</span>
                            <span class="badge bg-info text-dark">Giảm: {{ number_format($userPromotion->promotion->discount_value) }} %</span>
                        </div>
                        @empty
                        <div class="alert alert-warning" role="alert">
                            Bạn chưa có mã giảm giá nào.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
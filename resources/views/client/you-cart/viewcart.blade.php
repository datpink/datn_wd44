@extends('client.master')
<link rel="stylesheet" href=" {{ asset('theme/admin/assets/css/animate.css') }} ">
<link rel="stylesheet" href="{{ asset('theme/admin/assets/fonts/bootstrap/bootstrap-icons.css') }}">
<link rel="stylesheet" href="{{ asset('theme/admin/assets/css/main.min.css') }}">
<link rel="stylesheet" href="{{ asset('theme/admin/assets/vendor/overlay-scroll/OverlayScrollbars.min.css') }}">
@section('title', 'Zaia Enterprise | Giỏ hàng của bạn')

@section('content')
    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Content wrapper start -->
        <div class="content-wrapper">

            <!-- Row start -->
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Giỏ hàng của bạn</div>
                            <div class="ml-auto">
                                <a href="{{ route('products.index') }}" class="btn btn-dark">Tiếp tục mua sắm</a>
                            </div>
                        </div>
                        <div class="card-body">

                            <!-- Row start -->
                            <div class="row">
                                @if(session('cart') && count(session('cart')) > 0)
                                    @php $subtotal = 0; @endphp
                                    @foreach(session('cart') as $key => $item)
                                        <div class="col-xxl-6 col-sm-12 col-12">
                                            <div class="product-added-card">
                                                <img class="product-added-img" src="{{ $item['options']['image'] }}" alt="{{ $item['name'] }}">
                                                <div class="product-added-card-body">
                                                    <h5 class="product-added-title">{{ $item['name'] }}</h5>
                                                    <div class="product-added-price">${{ number_format($item['price'], 2) }}</div>
                                                    <div class="product-added-description">
                                                        @if ($item['options']['color'] || $item['options']['storage'])
                                                            Màu: {{ $item['options']['color'] }} - Bộ nhớ: {{ $item['options']['storage'] }}
                                                        @endif
                                                    </div>
                                                    <div class="product-added-actions">
                                                        <form action="{{ route('cart.remove', ['id' => $key]) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            <button class="btn btn-light remove-from-cart">Xóa khỏi giỏ</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @php $subtotal += $item['quantity'] * $item['price']; @endphp
                                    @endforeach
                                    <div class="col-12">
                                        <div class="sub-total-container">
                                            <div class="total">Tổng cộng: ${{ number_format($subtotal, 2) }}</div>
                                            <a href="{{ route('cart.view') }}" class="btn btn-success btn-lg">Thanh toán</a>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <p>Giỏ hàng của bạn đang trống.</p>
                                    </div>
                                @endif
                            </div>
                            <!-- Row end -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- Row end -->

        </div>
        <!-- Content wrapper end -->

        <!-- App Footer start -->
        <div class="app-footer">
            <span>© Zaia Enterprise 2024</span>
        </div>
        <!-- App footer end -->

    </div>
    <!-- Content wrapper scroll end -->
@endsection

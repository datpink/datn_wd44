<div class="block-minicart block-dreaming kobolg-mini-cart kobolg-dropdown">
    <div class="shopcart-dropdown block-cart-link" data-kobolg="kobolg-dropdown">
        <a class="block-link link-dropdown" href="">
            <span class="fa fa-bell"></span> <!-- Biểu tượng thông báo -->
            <span class="count">{{ count($notifications ?? []) }}</span> <!-- Hiển thị số lượng thông báo -->
        </a>
    </div>
    <div class="widget kobolg widget_shopping_cart">
        <div class="widget_shopping_cart_content">
            <h3 class="minicart-title">
                Thông Báo 
                <span class="minicart-number-items">{{ count($notifications ?? []) }}</span>
            </h3>
        
            <div class="card">
                <div class="card-header">
                    <strong>Tất Cả Thông Báo</strong>
                </div>
                <div class="card-body">
                    @if ($allNotifications->isEmpty())
                        <p class="text-muted">Bạn chưa có thông báo nào.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($allNotifications as $notification)
                                <li class="list-group-item">
                                    <div>
                                        <strong>{{ $notification->title }}</strong>
                                        <p class="mb-1">{{ $notification->description }}</p>
                                        @if ($notification->url)
                                        <a href="{{ route('notifications.read', $notification->id) }}" class="text-primary">
                                            Xem chi tiết
                                        </a>                                        @endif
                                        <small class="text-muted d-block mt-2">
                                            {{ $notification->created_at->format('H:i d/m/Y') }}
                                        </small>
                                        @if (is_null($notification->read_at))
                                            <span class="badge bg-warning text-dark">Chưa đọc</span>
                                        @else
                                            <span class="badge bg-success">Đã đọc</span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
                </div>
    </div>
</div>



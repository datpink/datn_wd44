<div class="block-minicart block-dreaming kobolg-mini-cart kobolg-dropdown" id="cart-content">
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
            <ul class="kobolg-mini-cart cart_list product_list_widget">
                @if (isset($allNotifications))
                    @foreach ($allNotifications as $notification)
                        <li class="kobolg-mini-cart-item mini_cart_item">
                            <strong class="notification-title">
                                {{ $notification->title }}
                            </strong>
                            <p class="notification-description">
                                {{ $notification->description }}
                            </p>
                            @if ($notification->url)
                                <a href="{{ route('notifications.read', $notification->id) }}" class="text-primary">
                                    Xem chi tiết
                                </a>
                            @endif
                            <small class="text-muted d-block mt-2">
                                {{ $notification->created_at->format('H:i d/m/Y') }}
                            </small>
                            @if (is_null($notification->read_at))
                                <span class="badge bg-warning text-dark">Chưa đọc</span>
                            @else
                                <span class="badge bg-success">Đã đọc</span>
                            @endif
                        </li>
                    @endforeach
                @endif

            </ul>
        </div>
    </div>
</div>

<style>
    .notification-title {
        font-size: 1rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .notification-description {
        font-size: 0.9rem;
        color: #555;
        white-space: normal;
        word-wrap: break-word;
        line-height: 1.4;
        margin-bottom: 5px;
    }
</style>

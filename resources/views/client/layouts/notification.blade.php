<div class="block-minicart block-dreaming kobolg-mini-cart kobolg-dropdown">
    <div class="shopcart-dropdown block-cart-link" data-kobolg="kobolg-dropdown">
        <a class="block-link link-dropdown" href="">
            <span class="fa-regular fa-bell"></span> <!-- Biểu tượng thông báo -->
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
                @if (!empty($notifications) && count($notifications) > 0)
                    @foreach ($notifications as $notification)
                        <li class="kobolg-mini-cart-item mini_cart_item">
                            <form class="remove-form" style="display: inline;" method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}">
                                @csrf
                                <button type="submit" class="remove remove_from_cart_button" title="Đánh dấu đã đọc"
                                    style="border: none; background: none; cursor: pointer;">×</button>
                            </form>
                            <a href="{{ $notification->url }}">
                                <p class="notification-title">{{ $notification->title }}</p>
                                <p class="notification-desc">{{ $notification->description }}</p>
                                <p class="notification-time">{{ $notification->created_at->diffForHumans() }}</p>
                            </a>
                        </li>
                    @endforeach
                @else
                    <li class="kobolg-mini-cart-item mini_cart_item">Không có thông báo nào.</li>
                @endif
            </ul>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

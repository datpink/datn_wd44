<style>


.notification-item {
    display: flex;
    flex-direction: column; /* Hiển thị theo chiều dọc */
    gap: 5px; /* Khoảng cách giữa các phần tử bên trong */
}

.notification-content {
    display: block;
    margin-bottom: 10px;
}

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

.text-muted {
    font-size: 0.8rem;
    color: #888;
}

.badge {
    font-size: 0.8rem;
    padding: 0.3rem 0.5rem;
    border-radius: 0.2rem;
}

.badge.bg-warning {
    background-color: #ffc107;
    color: #212529;
}

.badge.bg-success {
    background-color: #28a745;
    color: #fff;
}

.view-details {
    font-size: 0.9rem;
    text-decoration: none;
    color: #007bff;
    transition: color 0.2s;
}

.view-details:hover {
    color: #0056b3;
}

</style>
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
            <ul class="kobolg-mini-cart cart_list product_list_widget" style=" border: 1px solid red;">
                @if (isset($allNotifications))
                    @foreach ($allNotifications as $notification)
                        <li class="kobolg-mini-cart-item mini_cart_item" style=" border: 1px solid red ; margin:10px; border-radius: 5px; padding:10px">
                            <div class="notification-item">
                                <!-- Nội dung thông báo -->
                                <div class="notification-content {{ is_null($notification->read_at) ? 'unread' : '' }}">
                                     <strong class="notification-title">
                                        {{ \Str::limit($notification->title, 40) }}
                                    </strong>
                                    <p class="notification-description">
                                        {{ \Str::limit($notification->description, 60) }}
                                    </p>
                                    <small class="text-muted">
                                        {{ $notification->created_at->format('H:i d/m/Y') }}
                                    </small>
                                    <!-- Trạng thái -->
                                    @if (is_null($notification->read_at))
                                        <span class="badge bg-warning text-dark">Chưa đọc</span>
                                    @else
                                        <span class="badge bg-success">Đã đọc</span>
                                    @endif
                                </div>
                                <!-- Nút xem chi tiết -->
                                @if ($notification->url)
                                    <a href="{{ route('notifications.read', $notification->id) }}" class="text-primary view-details">
                                        Xem chi tiết
                                    </a>
                                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa thông báo này?');">
                                            Xóa
                                        </button>
                                    </form>
                                @endif
                                
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>
                                    
        </div>
    </div>
</div>

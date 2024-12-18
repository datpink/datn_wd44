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
                        <li class="kobolg-mini-cart-item mini_cart_item position-relative">
                            <strong class="notification-title">
                                {{ \Str::limit($notification->title, 40) }}
                            </strong>
                            <p class="notification-description">
                                {{ \Str::limit($notification->description, 40) }}
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

                            <!-- Nút Xóa -->
                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST"
                                class="delete-form delete-button" id="delete-form-{{ $notification->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="delete-icon" data-id="{{ $notification->id }}">
                                    &times;
                                </button>
                            </form>

                        </li>
                    @endforeach
                @endif

            </ul>
        </div>
    </div>
</div>

<style>
    .position-relative {
        position: relative;
    }

    .delete-button {
        position: absolute;
        top: 0;
        right: 0;
        margin: 15px;
    }

    .delete-icon {
        background: none;
        border: none;
        color: red;
        font-size: 16px;
        cursor: pointer;
        line-height: 1;
        padding: 0;
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
</style>

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Chọn tất cả các nút xóa
        const deleteButtons = document.querySelectorAll('.delete-icon');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const notificationId = button.getAttribute('data-id');
                Swal.fire({
                    title: 'Xác nhận',
                    text: "Bạn có chắc chắn muốn Thông Báo này?",
                    icon: 'warning',
                    toast: true,
                    timer: 4000,
                    position: 'top',
                    showCancelButton: true,
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Không'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Gửi form xóa
                        document.getElementById(`delete-form-${notificationId}`)
                            .submit();
                    }
                });
            });
        });
    });
</script>

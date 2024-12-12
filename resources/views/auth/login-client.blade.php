<div class="menu-item block-user block-dreaming kobolg-dropdown">
    <a class="block-link" href="{{ Auth::check() ? '#' : route('login') }}">
        @if (Auth::check() && Auth::user()->image)
            <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="User Avatar" class="user-avatar" />
        @else
            <span class="flaticon-profile"></span>
        @endif
    </a>
    @if (Auth::check())
        <ul class="sub-menu">
            <li class="menu-item kobolg-MyAccount-navigation-link kobolg-MyAccount-navigation-link--orders">
                <a href="{{ route('order.history', ['userId' => Auth::id()]) }}">Lịch sử đơn hàng</a>
            </li>
            <li class="menu-item kobolg-MyAccount-navigation-link kobolg-MyAccount-navigation-link--edit-account">
                <a href="{{ route('profile.show') }}">Thông tin tài khoản</a>
            </li>
            <li class="menu-item kobolg-MyAccount-navigation-link kobolg-MyAccount-navigation-link--customer-logout">
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer;">Đăng
                        xuất</button>
                </form>
            </li>
        </ul>
    @endif
</div>

<style>
    .user-avatar {
        width: 40px;
        /* Đặt chiều rộng cho hình avatar */
        height: 40px;
        /* Đặt chiều cao cho hình avatar */
        border-radius: 50%;
        /* Làm cho hình tròn */
        object-fit: cover;
        /* Đảm bảo hình ảnh không bị biến dạng */
        margin-bottom: 6px
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const link = document.querySelector('.block-link');
        if (link && link.getAttribute('href') === '#') {
            link.addEventListener('click', function(event) {
                event.preventDefault(); // Ngăn không cho mặc định
                alert('Bạn đã đăng nhập. Vui lòng chọn chức năng từ menu.');
            });
        }
    });
</script>

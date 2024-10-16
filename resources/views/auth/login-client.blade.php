<div class="menu-item block-user block-dreaming kobolg-dropdown">
    <a class="block-link" href="#">
        <span class="flaticon-profile"></span>
    </a>
    <ul class="sub-menu">
        @if (Auth::check())
            <li class="menu-item kobolg-MyAccount-navigation-link kobolg-MyAccount-navigation-link--orders">
                <a href="#">Lịch sử đơn hàng</a>
            </li>
            <li class="menu-item kobolg-MyAccount-navigation-link kobolg-MyAccount-navigation-link--downloads">
                <a href="#">Downloads</a>
            </li>
            <li class="menu-item kobolg-MyAccount-navigation-link kobolg-MyAccount-navigation-link--edit-account">
                <a href="#">Thông tin tài khoản</a>
            </li>
            <li class="menu-item kobolg-MyAccount-navigation-link kobolg-MyAccount-navigation-link--edit-addresses">
                <a href="#">Cập nhật địa chỉ</a>
            </li>
            <li class="menu-item kobolg-MyAccount-navigation-link kobolg-MyAccount-navigation-link--customer-logout">
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit"
                        style="background: none; border: none; color: inherit; cursor: pointer;">Đăng xuất</button>
                </form>
            </li>
        @else
            <li class="menu-item kobolg-MyAccount-navigation-link kobolg-MyAccount-navigation-link--login">
                <a href="{{ route('login') }}">Đăng Nhập</a>
            </li>
        @endif
    </ul>
</div>

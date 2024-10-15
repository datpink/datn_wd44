<nav class="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('admin.index') }}" class="logo">
            <img src="{{ asset('theme/admin/assets/images/logozaia.png') }}" alt="Admin Dashboards" width="150px">
        </a>
    </div>

    <div class="sidebar-menu">
        <div class="sidebarMenuScroll">
            <ul>
                <li class="active">
                    <a href="{{ route('admin.index') }}">
                        <i class="bi bi-house"></i>
                        <span class="menu-text">Dashboards</span>
                    </a>
                </li>

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-list-check"></i>
                        <span class="menu-text"> Danh Mục</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('catalogues.index') }}">Danh sách danh mục</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-box"></i>
                        <span class="menu-text"> Sản Phẩm</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('products.index') }}">Danh sách sản phẩm</a>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <a href="{{ route('attributes.index') }}">Thuộc tính</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-person"></i>
                        <span class="menu-text"> Người Dùng</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('users.index') }}">Danh sách Người Dùng</a>
                            </li>
                            <li>
                                <a href="{{ route('roles.index') }}">Danh sách Vai Trò</a>
                            </li>
                            <li>
                                <a href="{{ route('permissions.index') }}">Danh sách Quyền Hạn</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-newspaper"></i>
                        <span class="menu-text"> Tin Tức</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('categories.index') }}">Danh sách danh mục</a>
                            </li>
                            <li>
                                <a href="{{ route('posts.index') }}">Danh sách tin</a>
                            </li>
                            <li>
                                <a href="{{ route('comments.index') }}">Danh sách bình luận</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-tag"></i>
                        <span class="menu-text"> Nhãn Hiệu</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('brands.index') }}">Danh sách Nhãn hiệu</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-image"></i>  <!-- Thay đổi icon ở đây -->
                        <span class="menu-text"> Banner</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('banners.index') }}">Danh sách Banner</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-cart-check"></i>
                        <span class="menu-text"> Đơn Hàng</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('orders.index') }}">Danh sách đơn hàng</a>
                            </li>
                            <li>
                                <a href="{{ route('payment-methods.index') }}">Danh sách PTTT</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-window-split"></i>
                        <span class="menu-text">Quản Lý Khuyến Mại</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('promotions.index') }}">Danh Sách Mã Giảm Giá</a>
                            </li>

                        </ul>
                    </div>
                </li>
                {{-- <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-archive"></i>
                        <span class="menu-text"> Kho Nguyên Liệu</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('ingredient.index') }}">Danh mục kho</a>
                            </li>
                            <li>
                                <a href="#">Nhà cung cấp</a>
                            </li>
                            <li>
                                <a href="#">Phiếu nhập kho</a>
                            </li>
                            <li>
                                <a href="#">Hàng tồn kho</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-file-earmark-text"></i>
                        <span class="menu-text"> Thanh Toán</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('payment.index') }}">Danh sách Payment</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-person-workspace"></i>
                        <span class="menu-text"> Nhân Viên</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('staff.index') }}">Danh sách nhân viên</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-people-fill"></i>
                        <span class="menu-text"> Khách Hàng</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('customer.index') }}">Danh sách Khách Hàng</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-gear"></i>
                        <span class="menu-text">Cài Đặt</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ url('admin/profile') }}">Profile</a>
                            </li>
                            <li>
                                <a href="{{ route('page.edit', ['page' => 1]) }}">Account Settings</a>
                            </li>
                        </ul>
                    </div>
                </li> --}}
            </ul>
        </div>
    </div>
</nav>

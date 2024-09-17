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
                        <i class="bi bi-card-list"></i>
                        <span class="menu-text">Quản lý Danh Mục</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('catalogues.index') }}">Danh sách danh mục</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-window-split"></i>
                        <span class="menu-text">Quản lý Đơn Hàng</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('orders.index') }}">Danh sách đơn hàng</a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-tag"></i>
                        <span class="menu-text">Quản lý Nhãn Hiệu</span>
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
                        <i class="bi bi-newspaper"></i>
                        <span class="menu-text">Quản lý tin tức</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('posts.index') }}">Danh sách tin</a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-window-split"></i>
                        <span class="menu-text">Quản lý bàn</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('table.index') }}">Danh sách bàn</a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-layers-half"></i>
                        <span class="menu-text">Quản lý đặt bàn</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('reservation.index') }}">Danh sách đặt bàn</a>
                            </li>
                            <li>
                                <a href="{{ route('reservationTable.index') }}">Bàn đặt trước</a>
                            </li>
                            <li>
                                <a href="{{ route('reservationHistory.index') }}">Lịch sử đặt bàn</a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-folder"></i>
                        <span class="menu-text">Quản lý Danh Mục</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('category.index') }}">Danh Mục</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-journal-bookmark-fill"></i>
                        <span class="menu-text"> Quản lý Món ăn</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('dishes.index') }}">Danh sách món</a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-boxes"></i>
                        <span class="menu-text">Quản lý Combo </span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('combo.index') }}">Danh sách combo</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-clipboard-check"></i>
                        <span class="menu-text">Quản lý Payment</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('payment.index') }}">Danh sách Payment</a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-person-workspace"></i>
                        <span class="menu-text">Quản lý nhân viên</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('staff.index') }}">Danh sách nhân viên</a>

                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-people-fill"></i>
                        <span class="menu-text">Quản lý người dùng</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('user.index') }}">Danh sách người dùng</a>

                            </li>
                        </ul>
                    </div>
                </li>


                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-pci-card"></i>
                        <span class="menu-text">Quản lý kho Ng-liệu</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('ingredient.index') }}">Danh mục kho</a>
                            </li>
                            <li>
                                <a href="#">Nhà cung cấp</a>
                            <li>
                                <a href="#">Phiếu nhập kho</a>
                            </li>
                            <li>
                                <a href="#">Combo món ăn</a>
                            </li>
                            <li>
                                <a href="#">Hàng tồn kho</a>
                            </li>
                            <li>
                                <a href="#">Xuất kho</a>
                            </li>


                        </ul>
                    </div>
                </li>


                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-github"></i>
                        <span class="menu-text">Pages</span>
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
                </li>
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-gem"></i>
                        <span class="menu-text">Customers</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('customer.index') }}">DS Customer</a>
                            <li>
                                <a href="{{ url('admin/graph-widgets') }}">Graph Widgets</a>
                            </li>
                        </ul>
                    </div>
                </li> --}}

            </ul>
        </div>
    </div>
</nav>

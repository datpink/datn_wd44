<div class="page-header">
    <div class="toggle-sidebar" id="toggle-sidebar"><i class="bi bi-list"></i></div>

    @if (isset($title))
        @include('components.breadcrumb', ['title' => $title ?? ''])
    @endif

    <div class="header-actions-container">

        <!-- Search container start -->
        <div class="search-container">

            <!-- Search input group start -->
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search anything">
                <button class="btn" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            <!-- Search input group end -->

        </div>
        <!-- Search container end -->

        <!-- Leads start -->
        <ul class="header-actions d-flex align-items-center">
            <li class="dropdown">
                <a href="javascript:void(0);" class="leads d-none d-xl-flex">
                    @if ($newOrdersCount > 0)
                        <div class="lead-details">
                            Bạn có <span class="count">{{ $newOrdersCount }}</span> đơn hàng mới
                        </div>
                    @endif
                    <span class="lead-icon">
                        <i class="bi bi-bell-fill animate__animated animate__swing animate__infinite infinite"></i>
                        <b class="dot animate__animated animate__heartBeat animate__infinite"></b>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="ordersDropdown">
                    @if ($newOrdersCount > 0)
                        <div class="dropdown-header">Thông báo</div>
                        @foreach ($newOrders as $order)
                            <div class="dropdown-item">
                                <h5 class="mb-1">Đơn hàng #{{ $order->id }}</h5>
                                <p class="mb-1">Người mua: {{ $order->user->name }}</p>
                                <p class="mb-2">Giá: {{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</p>
                                <div class="text-end">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-link">Xem chi tiết</a>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                        @endforeach
                        {{-- <a class="dropdown-item" href="orders.html">Xem tất cả đơn hàng</a> --}}
                    @else
                        <div class="dropdown-item">Không có đơn hàng mới</div>
                    @endif
                </div>
            </li>
        </ul>

        <style>
            .lead-icon {
                cursor: pointer;
                position: relative;
            }

            .dropdown-menu {
                min-width: 300px;
                padding: 15px;
            }

            .lead-details {
                display: flex;
                align-items: center;
                margin-right: 10px;
                letter-spacing: 0.5px;
                /* Giãn khoảng cách giữa các chữ */
            }

            .lead-details .count {
                font-weight: bold;
                margin-left: 5px;
                color: #007bff;
                /* Màu sắc cho số lượng */
            }

            .header-actions {
                position: relative;
            }

            .header-actions .dropdown:hover .dropdown-menu {
                display: block;
            }

            .btn-link {
                color: #007bff;
                text-decoration: none;
            }

            .btn-link:hover {
                text-decoration: underline;
            }
        </style>
        <!-- Leads end -->

        <!-- Header actions start -->
        <ul class="header-actions">
            <li class="dropdown d-none d-md-block">
                <a href="#" id="countries" data-toggle="dropdown" aria-haspopup="true">
                    <img src="{{ asset('theme/admin/assets/images/flags/1x1/br.svg') }}" class="flag-img"
                        alt="Admin Panels" />
                </a>
                <div class="dropdown-menu dropdown-menu-end mini" aria-labelledby="countries">
                    <div class="country-container">
                        <a href="index.html">
                            <img src="{{ asset('theme/admin/assets/images/flags/1x1/us.svg') }}"
                                alt="Clean Admin Dashboards" />
                        </a>
                        <a href="index.html">
                            <img src="{{ asset('theme/admin/assets/images/flags/1x1/in.svg') }}"
                                alt="Google Dashboards" />
                        </a>
                        <a href="index.html">
                            <img src="{{ asset('theme/admin/assets/images/flags/1x1/gb.svg') }}"
                                alt="AI Admin Dashboards" />
                        </a>
                        <a href="index.html">
                            <img src="{{ asset('theme/admin/assets/images/flags/1x1/tr.svg') }}"
                                alt="Modern Dashboards" />
                        </a>
                        <a href="index.html">
                            <img src="{{ asset('theme/admin/assets/images/flags/1x1/ca.svg') }}"
                                alt="Best Admin Dashboards" />
                        </a>
                    </div>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                    <span class="user-name d-none d-md-block">{{ Auth::user()->name }}</span>
                    <span class="avatar">
                        @if (Auth::user()->image)
                            <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="Admin Avatar"
                                class="img-thumbnail">
                        @endif
                        <span class="status online"></span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userSettings">
                    <div class="header-profile-actions">
                        <a href="{{ route('admin.profile') }}">Profile</a>
                        <a href="">Settings</a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                            style="display: inline;">
                            @csrf
                            <a href="#" class="logout-btn">Đăng Xuất</a>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        document.querySelector('.logout-btn').addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.getElementById('logout-form');
            Swal.fire({
                position: 'top',
                title: 'Logout?',
                icon: 'warning',
                toast: true,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có',
                cancelButtonText: 'Hủy',
                timer: 3500
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endsection

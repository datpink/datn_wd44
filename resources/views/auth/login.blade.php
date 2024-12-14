@extends('client.master')

@section('title', 'Đăng Nhập')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    @include('components.breadcrumb-client2')

    <main class="site-main main-container no-sidebar">
        <div class="container">
            <div class="row">
                <div class="main-content col-md-12">
                    <div class="page-main-content">
                        <div class="kobolg">
                            <div class="kobolg-notices-wrapper">
                            </div>
                            <div class="u-columns col2-set" id="customer_login">
                                <div class="u-column1 col-1">
                                    <h2>Đăng nhập</h2>
                                    <form class="kobolg-form kobolg-form-login login" method="POST"
                                        action="{{ route('login') }}">
                                        @csrf
                                        <p class="kobolg-form-row kobolg-form-row--wide form-row form-row-wide">
                                            <label for="username">Tên người dùng hoặc địa chỉ email&nbsp;<span
                                                    class="required">*</span></label>
                                            <input type="text" class="kobolg-Input kobolg-Input--text input-text"
                                                name="username" id="username" autocomplete="username" value=""
                                                required placeholder="Nhập địa chỉ email của bạn">
                                        </p>
                                        <p class="kobolg-form-row kobolg-form-row--wide form-row form-row-wide">
                                            <label for="password">Mật khẩu&nbsp;<span class="required">*</span></label>
                                            <input class="kobolg-Input kobolg-Input--text input-text" type="password"
                                                name="password" id="password" autocomplete="current-password" required
                                                placeholder="Nhập mật khẩu">
                                        </p>

                                        <div class="form-row d-flex justify-content-between align-items-center">
                                            <label class="kobolg-form__label kobolg-form__label-for-checkbox inline">
                                                <input class="kobolg-form__input kobolg-form__input-checkbox"
                                                    name="rememberme" type="checkbox" id="rememberme" value="forever">
                                                <span>Giữ đăng nhập</span>
                                            </label>
                                            <p class="kobolg-LostPassword lost_password mb-0">
                                                <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
                                            </p>
                                        </div>
                                        <p class="form-row">
                                            <button type="submit" class="kobolg-Button button" name="login"
                                                value="Log in">Đăng Nhập</button>
                                        </p>
                                    </form>

                                    <!-- Đường kẻ và logo đăng nhập -->
                                    <div class="line-through d-flex align-items-center my-4">
                                        <hr class="flex-grow-1" style="margin: 0; width: 30%;">
                                        <span class="or-text mx-2">hoặc</span>
                                        <hr class="flex-grow-1" style="margin: 0; width: 30%;">
                                    </div>


                                    <div class="text-center mt-2 mb-3">
                                        <a href="{{ route('login.google') }}" class="btn-light social-button"
                                            >
                                            <img src="{{ asset('images/search.png') }}" alt="Google"
                                                style="width: 30px; height: 30px;">
                                            <span style="margin-left: 5px;">Google</span>
                                        </a>

                                        {{-- <a href="{{ route('login.facebook') }}" class="btn-light social-button"
                                            style="margin-right: 5px;">
                                            <img src="{{ asset('images/facebook.png') }}" alt="Facebook"
                                                style="width: 30px; height: 30px;">
                                            <span style="margin-left: 5px;">Facebook</span>
                                        </a> --}}
                                    </div>


                                </div>
                                <div class="u-column2 col-2">
                                    <h2>Đăng ký</h2>
                                    <form method="POST" action="{{ route('register') }}"
                                        class="kobolg-form kobolg-form-register register">
                                        @csrf
                                        <p class="kobolg-form-row kobolg-form-row--wide form-row form-row-wide">
                                            <label for="reg_email">Địa Chỉ Email&nbsp;<span
                                                    class="required">*</span></label>
                                            <input type="email" class="kobolg-Input kobolg-Input--text input-text"
                                                name="email" id="reg_email" autocomplete="email" required
                                                placeholder="Nhập địa chỉ email của bạn">
                                        </p>

                                        <p class="kobolg-form-row kobolg-form-row--wide form-row form-row-wide">
                                            <label for="reg_name">Họ và tên&nbsp;<span class="required">*</span></label>
                                            <input type="text" class="kobolg-Input kobolg-Input--text input-text"
                                                name="name" id="reg_name" required
                                                placeholder="Nhập họ và tên của bạn">
                                        </p>

                                        <p class="kobolg-form-row kobolg-form-row--wide form-row form-row-wide">
                                            <label for="reg_password">Mật khẩu&nbsp;<span class="required">*</span></label>
                                            <input type="password" class="kobolg-Input kobolg-Input--text input-text"
                                                name="password" id="reg_password" required 
                                                placeholder="Nhập mật khẩu"
                                                >
                                        </p>

                                        <div class="kobolg-privacy-policy-text">
                                            <p>Dữ liệu cá nhân của bạn sẽ được sử dụng để hỗ trợ trải nghiệm của bạn trên
                                                toàn bộ trang web này, để quản lý
                                                quyền truy cập vào tài khoản của bạn và cho các mục đích khác được mô tả
                                                trong phần của chúng tôi.
                                                <a href="{{ route('privacy.policy') }}"
                                                    class="kobolg-privacy-policy-link">chính
                                                    sách bảo mật</a>.
                                            </p>
                                        </div>

                                        <p class="kobolg-FormRow form-row">
                                            <input type="hidden" id="kobolg-register-nonce" name="kobolg-register-nonce"
                                                value="45fae70a87">
                                            <button type="submit" class="kobolg-Button button" name="register"
                                                value="Register">Đăng ký</button>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <style>
        .social-button {
            text-decoration: none;
            color: inherit;
            transition: background-color 0.3s;
        }

        .social-button:hover {
            background-color: transparent;
        }
    </style>
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Có lỗi xảy ra!',
                html: '<ul>' +
                    @foreach ($errors->all() as $error)
                        '<li>{{ $error }}</li>' +
                    @endforeach
                '</ul>',
                position: 'top',
                toast: true,
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif

    @if (session('status'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: '{{ session('status') }}',
                position: 'top',
                toast: true,
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif
@endsection

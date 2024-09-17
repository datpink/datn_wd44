@extends('client.master')

@section('title', 'Đăng Nhập')

@section('content')

    @include('components.breadcrumb-client')

    <main class="site-main main-container no-sidebar">
        <div class="container">
            <div class="row">
                <div class="main-content col-md-12">
                    <div class="page-main-content">
                        <div class="kobolg">
                            <div class="kobolg-notices-wrapper">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
                            </div>
                            <div class="u-columns col2-set" id="customer_login">
                                <div class="u-column1 col-1">
                                    <h2>Login</h2>
                                    <form class="kobolg-form kobolg-form-login login" method="POST"
                                        action="{{ route('login') }}">
                                        @csrf
                                        <p class="kobolg-form-row kobolg-form-row--wide form-row form-row-wide">
                                            <label for="username">Tên người dùng hoặc địa chỉ email&nbsp;<span
                                                    class="required">*</span></label>
                                            <input type="text" class="kobolg-Input kobolg-Input--text input-text"
                                                name="username" id="username" autocomplete="username" value=""
                                                required>
                                        </p>
                                        <p class="kobolg-form-row kobolg-form-row--wide form-row form-row-wide">
                                            <label for="password">Mật khẩu&nbsp;<span class="required">*</span></label>
                                            <input class="kobolg-Input kobolg-Input--text input-text" type="password"
                                                name="password" id="password" autocomplete="current-password" required>
                                        </p>
                                        <p class="form-row">
                                            <button type="submit" class="kobolg-Button button" name="login"
                                                value="Log in">Đăng Nhập</button>
                                            <label class="kobolg-form__label kobolg-form__label-for-checkbox inline">
                                                <input class="kobolg-form__input kobolg-form__input-checkbox"
                                                    name="rememberme" type="checkbox" id="rememberme" value="forever">
                                                <span>Nhớ tôi</span>
                                            </label>
                                        </p>
                                        <p class="kobolg-LostPassword lost_password">
                                            {{-- <a href="{{ route('password.request') }}">Quên mật khẩu?</a> --}}
                                        </p>
                                    </form>
                                </div>
                                <div class="u-column2 col-2">
                                    <h2>Register</h2>
                                    <form method="POST" action="{{ route('register') }}" class="kobolg-form kobolg-form-register register">
                                        @csrf <!-- Thêm CSRF token nếu bạn đang sử dụng Laravel -->
                                        <p class="kobolg-form-row kobolg-form-row--wide form-row form-row-wide">
                                            <label for="reg_email">Email addresses&nbsp;<span class="required">*</span></label>
                                            <input type="email" class="kobolg-Input kobolg-Input--text input-text"
                                                name="email" id="reg_email" autocomplete="email" required>
                                        </p>

                                        <p class="kobolg-form-row kobolg-form-row--wide form-row form-row-wide">
                                            <label for="reg_name">Name&nbsp;<span class="required">*</span></label>
                                            <input type="text" class="kobolg-Input kobolg-Input--text input-text" name="name" id="reg_name" required>
                                        </p>

                                        <p class="kobolg-form-row kobolg-form-row--wide form-row form-row-wide">
                                            <label for="reg_password">Password&nbsp;<span class="required">*</span></label>
                                            <input type="password" class="kobolg-Input kobolg-Input--text input-text"
                                                name="password" id="reg_password" required>
                                        </p>

                                        <div class="kobolg-privacy-policy-text">
                                            <p>Your personal data will be used to support your experience throughout this
                                                website, to manage access to your account, and for other purposes described
                                                in our <a href="#" class="kobolg-privacy-policy-link"
                                                    target="_blank">privacy policy</a>.</p>
                                        </div>

                                        <p class="kobolg-FormRow form-row">
                                            <input type="hidden" id="kobolg-register-nonce" name="kobolg-register-nonce"
                                                value="45fae70a87">
                                            <button type="submit" class="kobolg-Button button" name="register"
                                                value="Register">Register</button>
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

@endsection

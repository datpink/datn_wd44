<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('theme/login/style.css') }}">
    <title>Đăng Nhập Quản Trị</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-in">
            <form action="{{ route('admin.login.post') }}" method="POST">
                @if ($message = Session::get('error'))
                    {{ $message }}
                @endif
                <h1>Đăng Nhập</h1>
                <div class="social-icons">
                    <a href="#" class="icon">A</i></a>
                    <a href="#" class="icon">D</a>
                    <a href="#" class="icon">M</a>
                    <a href="#" class="icon">I</a>
                    <a href="#" class="icon">N</a>
                </div>
                @csrf
                <span>or use your email for registeration</span>
                <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                <button type="submit" class="btn btn-primary">Đăng Nhập</button>
                <a href="#" class="d-block mt-3">Quên mật khẩu?</a>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('theme/login/script.js') }}"></script>
</body>

</html>

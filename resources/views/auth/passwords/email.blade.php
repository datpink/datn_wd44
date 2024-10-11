<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Quên mật khẩu</title>

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            width: 550px;
        }

        .login-logo {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .login-logo img {
            width: 140px;
            margin-right: 10px;
        }

        .login-welcome {
            margin-bottom: 20px;
            text-align: center;
            font-size: 16px;
            color: #555;
            line-height: 1.5;
        }

        .form-label {
            font-weight: bold;
            font-size: 18px;
            line-height: 1.5;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 10px;
            font-size: 16px;
            line-height: 1.5;
            width: 100%;
        }

        .login-form-actions {
            text-align: right;
        }

        .btn {
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        /* Style for status and error messages */
        .alert {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>

    <!-- Login box start -->
    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="login-box">
            <div class="login-form">
                <div class="login-logo">
                    <img src="{{ asset('theme/client/assets/images/logozaia.png') }}" alt="Logo" />
                    <span>Quên mật khẩu</span>
                </div>

                <!-- Hiển thị thông báo trạng thái -->
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Hiển thị lỗi nếu có -->
                @if ($errors->any())
                    <div class="alert alert-error">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="login-welcome">
                    Để truy cập tài khoản của bạn, vui lòng nhập địa chỉ email mà bạn đã cung cấp trong quá trình đăng
                    ký.
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Nhập email của bạn" required>
                </div>
                <div class="login-form-actions">
                    <button type="submit" class="btn">
                        <span class="icon">
                            <i class="bi bi-arrow-right-circle"></i>
                        </span>
                        Gửi
                    </button>
                </div>
            </div>
        </div>
    </form>
    <!-- Login box end -->

</body>

</html>

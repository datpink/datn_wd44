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
            /* Tăng padding cho box */
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            width: 550px;
            /* Tăng kích thước box */
        }

        .login-logo {
            display: flex;
            /* Sử dụng flexbox để canh logo */
            align-items: center;
            /* Canh giữa logo */
            margin-bottom: 20px;
            /* Khoảng cách giữa logo và welcome text */
        }

        .login-logo img {
            width: 140px;
            /* Kích thước logo */
            margin-right: 10px;
            /* Khoảng cách giữa logo và text */
        }

        .login-welcome {
            margin-bottom: 20px;
            text-align: center;
            font-size: 16px;
            /* Tăng kích thước chữ */
            color: #555;
            line-height: 1.5;
            /* Tăng line height */
        }

        .form-label {
            font-weight: bold;
            font-size: 18px;
            /* Tăng kích thước chữ label */
            line-height: 1.5;
            /* Tăng line height cho label */
            margin-bottom: 8px;
            /* Khoảng cách giữa label và input */
            display: block;
            /* Để label nằm trên ô input */
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 10px;
            font-size: 16px;
            /* Tăng kích thước chữ trong input */
            line-height: 1.5;
            /* Tăng line height cho input */
            width: 100%;
            /* Đặt chiều rộng đầy đủ */
        }

        .login-form-actions {
            text-align: right;
            /* Lệch nút về bên phải */
        }

        .btn {
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            /* Tăng kích thước nút submit */
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            /* Tăng kích thước chữ nút */
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <!-- Login box start -->
    <form action="{{ route('password.email') }} ">
        <div class="login-box">
            <div class="login-form">
                <div class="login-logo">
                    <img src="{{ asset('theme/client/assets/images/logozaia.png') }}" alt="Logo" />
                    <span>Quên mật khẩu</span> <!-- Tiêu đề cho giao diện -->
                </div>
                <div class="login-welcome">
                    Để truy cập tài khoản của bạn, vui lòng nhập địa chỉ email mà bạn đã cung cấp trong quá trình đăng
                    ký.
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="Nhập email của bạn" required>
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

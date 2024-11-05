<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đặt Lại Mật Khẩu</title>
</head>

<body>
    <h4>Chào Bạn!</h4>
    <p>Bạn đã yêu cầu đặt lại mật khẩu. Nhấn vào link dưới đây để đặt lại mật khẩu của bạn:</p>
    <a href="{{ route('password.reset', ['token' => $token]) }}">Đặt lại mật khẩu</a>
</body>

</html>

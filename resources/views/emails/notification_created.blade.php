<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thông Báo Đến Bạn</title>
</head>

<body>
    <h2>Chào Bạn!</h2>
    <h4>{{ $title }}</h4>
    <p>{{ $description }}</p>
    @if ($url)
        <p><a href="{{ $url }}">Click here for more details</a></p>
    @endif
</body>

</html>
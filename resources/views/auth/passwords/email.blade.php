<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('theme/client/assets/images/logo.png') }}" />

<<<<<<< HEAD
=======
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
>>>>>>> d48c587078eb2a3e569b4258a8a30a767b8842ee

    <!-- Title -->
    <title>Quên mật khẩu</title>
</head>

<body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh; margin: 0;">

    <!-- Login box start -->
    <form action="{{ route('password.email') }}" method="POST" class="w-100" style="max-width: 400px;">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-4">
<<<<<<< HEAD
                    <img src="{{ asset('theme/client/assets/images/logozaia.png') }}" alt="Logo" style="width: 100px;" />
=======
                    <img src="{{ asset('theme/client/assets/images/logozaia.png') }}" alt="Logo"
                        style="width: 100px;" />
>>>>>>> d48c587078eb2a3e569b4258a8a30a767b8842ee
                    <h2 class="h4">Quên mật khẩu</h2>
                </div>

                @if (session('status'))
                    <script>
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: 'Thành công!',
                            text: '{{ session('status') }}',
                            showConfirmButton: false,
                            timerProgressBar: true,
                            timer: 2500
                        });
                    </script>
                @endif

                @if ($errors->any())
<<<<<<< HEAD
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Nhập email của bạn" required>
=======
                    <script>
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: 'Oops...',
                            html: '<ul class="list-unstyled">' +
                                @foreach ($errors->all() as $error)
                                    '<li>{{ $error }}</li>' +
                                @endforeach
                            '</ul>',
                            showConfirmButton: false,
                            timerProgressBar: true,
                            timer: 2500
                        });
                    </script>
                @endif


                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email"
                        placeholder="Nhập email của bạn" required>
>>>>>>> d48c587078eb2a3e569b4258a8a30a767b8842ee
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Gửi</button>
                    <a href="{{ route('login') }}" class="btn btn-secondary">Quay Lại</a>
                </div>
            </div>
        </div>
    </form>
    <!-- Login box end -->

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
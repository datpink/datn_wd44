@extends('client.master')

@section('title', 'Change Password')

@section('content')
<style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .form-label {
            font-weight: 600;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .alert {
            border-radius: 5px;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white text-center">
                        <h4>Thay Đổi Mật Khẩu</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update-password', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Hiển thị thông báo lỗi -->
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Hiển thị thông báo thành công -->
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Mật khẩu cũ</label>
                                <input type="text" name="current_password" class="form-control" id="current_password" required>
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label">Mật khẩu mới</label>
                                <input type="text" name="new_password" class="form-control" id="new_password" required>
                            </div>

                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="text" name="new_password_confirmation" class="form-control" id="new_password_confirmation" required>
                            </div>

                            <button type="submit" class="btn btn btn-danger w-100">Đổi mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
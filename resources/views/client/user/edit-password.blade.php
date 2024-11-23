@extends('client.master')

@section('title', 'Thay đổi mật khẩu')

@section('content')
@include('components.breadcrumb-client2')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg p-4 border-0 rounded">
                    <h3 class="text-center mb-4">Thay đổi mật khẩu</h3>
                    <div class="card-body">
                        <form action="{{ route('profile.update-password', $user->id) }}" method="POST">
                            @csrf
                            {{-- @method('PUT') --}}

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
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

                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" class="btn btn-danger btn-lg rounded-pill">Thay đổi mật khẩu</button>
                                <a href="{{ route('profile.show') }}" class="btn btn-outline-danger btn-lg rounded-pill">Quay lại</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
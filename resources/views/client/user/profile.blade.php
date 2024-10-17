@extends('client.master')

@section('title', 'User Profile')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg p-4 border-0 rounded">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <!-- User Profile Picture -->
                            @if ($user->image)
                                <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="img-thumbnail mt-2" style="max-width: 150px; border-radius: 50%;">
                            @else
                                <div class="mb-2" style="width: 150px; height: 150px; background-color: #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <span class="text-muted">No Image Available</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <!-- User Info Display -->
                            <h3 class="text-center mb-4">{{ $user->name }}</h3>
                            <div class="mb-3">
                                <strong>Email:</strong> {{ $user->email }}
                            </div>
                            <div class="mb-3">
                                <strong>Phone Number:</strong> {{ $user->phone }}
                            </div>
                            <div class="mb-3">
                                <strong>Address:</strong> {{ $user->address }}
                            </div>
                            <!-- Action Buttons -->
                            <div class="row mt-4">
                                <div class="col-md-6 mb-3">
                                    <a href="{{ route('profile.edit') }}" class="btn btn-danger btn-lg rounded-pill shadow w-100">Edit Personal</a>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <a href="{{ route('profile.edit-password') }}" class="btn btn-danger btn-lg rounded-pill shadow w-100">Change Password</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    Swal.fire({
        position: 'top',
        icon: 'success',
        title: '{{ session('success') }}',
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 1500
    });
</script>
@endif

@if ($errors->any())
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
        confirmButtonText: 'OK'
    });
</script>
@endif
@endsection
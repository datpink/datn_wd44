@extends('client.master')

@section('title', 'Profile')

@section('content')

    {{-- @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}
    <div class="container mt-5">
        <h2 class="text-center mb-4">User Profile</h2>
        <div class="row justify-content-center">
            <div class="col-md-4 text-center">
                <!-- User Profile Picture -->
                @if ($user->image)
                    <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="img-thumbnail mt-2"
                        style="max-width: 150px; border-radius: 50%;">
                @else
                    <span class="text-muted">No Image Available</span>
                @endif
            </div>

            <div class="col-md-6">
                <!-- User Info Display -->
                <h4 class="mt-3">Personal Information</h4>
                <ul class="list-unstyled">
                    <li><strong>Name:</strong> {{ $user->name }}</li>
                    <li><strong>Email:</strong> {{ $user->email }}</li>
                    <li><strong>Phone Number:</strong> {{ $user->phone }}</li>
                    <li><strong>Address:</strong> {{ $user->address }}</li>
                </ul>

                <!-- Action Buttons -->
                <div class="mt-4">
                    <a href="{{ route('profile.edit') }}" class="btn btn-danger w-100 mb-2">Edit Personal Information</a>
                    <a href="{{ route('profile.edit-password') }}" class="btn btn-danger w-100">Change Password</a>
                </div>
            </div>
        </div>
    </div>

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

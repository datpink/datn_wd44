@extends('client.master')

@section('title', 'Profile')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="container mt-5">
        <h2 class="text-center mb-4">User Profile</h2>
        <div class="row justify-content-center">
            <div class="col-md-4 text-center">
            <!-- User Profile Picture -->
            @if ($user->image)
            <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}"
            class="img-thumbnail mt-2" style="max-width: 150px;">
            @else
                <span class="text-muted">Không có hình ảnh</span>
            @endif
            </div>
            
            <div class="col-md-6">
                <!-- User Info Display -->
                <h4>Personal Information</h4>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Phone Number:</strong> {{ $user->phone }}</p>
                <p><strong>Address:</strong> {{ $user->address }}</p>

                <!-- Edit Info Button -->
                <a href="{{ route('profile.edit') }}"><button class="btn btn-danger w-100 mt-3">Edit Personal Information</button></a>

                <!-- Change Password Button -->
                <a href="{{ route('profile.edit-password') }}"><button class="btn btn-danger w-100 mt-3">Change Password</button></a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    
@endsection

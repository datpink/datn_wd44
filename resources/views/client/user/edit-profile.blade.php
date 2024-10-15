@extends('client.master')

@section('title', 'Edit Profile')

@section('content')

<style>
        body {
            background-color: #f4f7fc;
        }
        .form-control {
            border-radius: 0.75rem;
        }
        .card {
            border-radius: 1rem;
        }
        .btn-custom {
            background-color: #007bff;
            color: #fff;
            border-radius: 0.75rem;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .profile-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #f4f7fc;
        }
        .upload-btn-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        .upload-btn {
            border: 2px solid #007bff;
            color: #007bff;
            background-color: transparent;
            padding: 5px 10px;
            border-radius: 0.75rem;
            cursor: pointer;
        }
        .upload-btn-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }
        
    </style>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow p-4">
                <div class="card-body text-center">
                    <!-- Form to edit user information -->
                    <form action="{{ route('profile.update', $user->id) }}"enctype="multipart/form-data" method="POST" >
                        @csrf
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label"><strong>Full Name</strong></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                        </div>   
                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label"><strong>Phone Number</strong></label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label"><strong>Address</strong></label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}">
                        </div>
                        <!-- image -->
                        <div class="mb-3">
                            <label for="address" class="form-label"><strong>Image</strong></label><br>
                            @if ($user->image)
                            <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}"
                                    class="img-thumbnail mt-2" style="max-width: 150px;">
                                <p class="form-text">Hình ảnh hiện tại</p>
                            @else
                                <span class="text-muted">Không có hình ảnh</span>
                            @endif
                            <input type="file" class="form-control" id="image" name="image" value="{{ $user->image }}">
                        </div>
                        <!-- Submit Button -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-custom">Save Changes</button>
                            <a href="{{ route('profile.show') }}" type="button" class="btn btn-custom" >Back</a>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script for image preview -->
<script>
    function previewImage(event) {
        const reader = new FileReader();
        const profilePreview = document.getElementById('profilePreview');
        
        reader.onload = function() {
            if (reader.readyState === 2) {
                profilePreview.src = reader.result;
            }
        }
        
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

    
@endsection

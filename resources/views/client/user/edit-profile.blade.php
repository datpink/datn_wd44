@extends('client.master')

@section('title', 'Edit Profile')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg p-4 border-0 rounded">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Edit Your Profile</h3>
                        <form action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <!-- Name -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="name" class="form-label"><strong>Full Name</strong></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $user->name }}" required>
                                    </div>
                                    <!-- Phone -->
                                    <div class="mb-3">
                                        <label for="phone" class="form-label"><strong>Phone Number</strong></label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ $user->phone }}">
                                    </div>

                                    <!-- Address -->
                                    <div class="mb-3">
                                        <label for="address" class="form-label"><strong>Address</strong></label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            value="{{ $user->address }}">
                                    </div>
                                </div>

                                <div class="col-md-4 text-center">
                                    <!-- Image -->
                                    <div class="mb-4 text-center">
                                        <label for="image" class="form-label"><strong>Profile Image</strong></label>
                                        <div class="position-relative d-flex flex-column align-items-center">
                                            @if ($user->image)
                                                <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}"
                                                    class="img-thumbnail mb-2"
                                                    style="max-width: 150px; border-radius: 50%;">
                                                <p class="form-text">Current Image</p>
                                            @else
                                                <div class="mb-2"
                                                    style="width: 150px; height: 150px; background-color: #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <span class="text-muted">No Image Available</span>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control-file position-absolute" id="image"
                                                name="image" accept="image/*"
                                                style="top: 0; left: 0; width: 150px; height: 150px; opacity: 0;">
                                            <button type="button" class="btn btn-danger mt-2" style="width: 150px;"
                                                onclick="document.getElementById('image').click();">Change Image</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" class="btn btn-danger btn-lg rounded-pill shadow">Save Changes</button>
                                <a href="{{ route('profile.show') }}" class="btn btn-outline-danger btn-lg rounded-pill shadow">Back</a>
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
        document.getElementById('image').addEventListener('change', function(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const imgPreview = document.createElement('img');
                imgPreview.src = reader.result;
                imgPreview.className = "img-thumbnail mt-2";
                imgPreview.style.maxWidth = '150px';
                const previewContainer = document.createElement('div');
                previewContainer.className = "text-center";
                previewContainer.appendChild(imgPreview);
                const currentImage = document.querySelector('.mb-3.text-center');
                currentImage.appendChild(previewContainer);
            };
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>
@endsection

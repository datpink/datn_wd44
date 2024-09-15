<!-- resources/views/admin/profile.blade.php -->
@extends('admin.master') <!-- Nếu bạn có layout chung cho admin -->

@section('content')
<!-- Row start -->
<div class="row gutters">
    <div class="col-sm-12 col-12">
        <div class="profile-header">
            <h1>Welcome, {{ Auth::user()->name }}</h1>
            <div class="profile-header-content">
                <div class="profile-header-tiles">
                    <div class="row gutters">
                        <div class="col-sm-4 col-12">
                            <div class="profile-tile">
                                <span class="icon">
                                    <i class="bi bi-pentagon"></i>
                                </span>
                                <h6>Name - <span>{{ Auth::user()->name }}</span></h6>
                            </div>
                        </div>
                        <div class="col-sm-4 col-12">
                            <div class="profile-tile">
                                <span class="icon">
                                    <i class="bi bi-pin-angle"></i>
                                </span>
                                <h6>Location - <span>{{ Auth::user()->address }}</span></h6>
                            </div>
                        </div>
                        <div class="col-sm-4 col-12">
                            <div class="profile-tile">
                                <span class="icon">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <h6>Phone - <span>{{ Auth::user()->phone }}</span></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="profile-avatar-tile">
                    {{-- <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('assets/images/default-user.png') }}" class="img-fluid" alt="User Image" /> --}}
                    <img src="{{ asset('theme/admin/assets/images/user.png') }}" class="img-fluid" alt="User Image" />
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Row end -->
@endsection
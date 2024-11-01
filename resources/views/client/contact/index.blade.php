@extends('client.master')

@section('title', 'Liên Hệ')

@section('content')

    @include('components.breadcrumb-client')

    <div class="section-042">
        <div class="container">
            <div class="row">
                <div class="col-md-12 offset-xl-1 col-xl-10 col-lg-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="az_custom_heading">WP SHOP THEME</h4>
                            <p>3100 West Cary Street Richmond, Virginia 23221<br>
                                P: 804.355.4383 F: 804.367.7901</p>
                            <h4 class="az_custom_heading">Store Hours</h4>
                            <p>Monday-Saturday 11am-7pm ET<br>
                                Sunday 11am-6pm ET</p>
                            <h4 class="az_custom_heading">Specialist Hours</h4>
                            <p>Monday-Friday 9am-5pm ET</p>
                        </div>
                        <div class="col-md-6">
                            <div role="form" class="wpcf7">
                                <form id="contactForm" method="POST" action="{{ route('contact.store') }}">
                                    @csrf
                                    <p><label> Tên *<br>
                                            <span class="wpcf7-form-control-wrap your-name">
                                                <input name="name" value="" size="40"
                                                    class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                                    type="text" required></span>
                                        </label></p>
                                    <p><label> Email *<br>
                                            <span class="wpcf7-form-control-wrap your-email">
                                                <input name="email" value="" size="40"
                                                    class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email"
                                                    type="email" required></span>
                                        </label></p>
                                    <p><label> Tin nhắn *<br>
                                            <span class="wpcf7-form-control-wrap your-message">
                                                <textarea name="message" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea" required></textarea>
                                            </span>
                                        </label></p>
                                    <p><input value="Gửi" class="wpcf7-form-control wpcf7-submit" type="submit"></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                return response.json().then(data => {
                    throw new Error(data.errors.name[0] || 'Có lỗi xảy ra!');
                });
            })
            .then(data => {
                // Hiện thông báo thành công
                Swal.fire({
                    title: 'Thành công!',
                    text: data.success,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                this.reset(); // Reset form
            })
            .catch(error => {
                // Hiện thông báo lỗi
                Swal.fire({
                    title: 'Có lỗi xảy ra!',
                    text: error.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>

@endsection
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
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.6891296378426!2d105.74367357471479!3d21.04512118721736!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313455b3f6710da1%3A0x240105831b77a1a2!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e0!3m2!1svi!2s!4v1730477033769!5m2!1svi!2s"
                                width="600" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                            <h2>Zaia EnterPrise</h2>
                            <p>Km12 Đ. Cầu Diễn, Phúc Diễn, Bắc Từ Liêm, Hà Nội, Việt Nam<br>
                                SDT: 035.371.2030</p>
                            <h4 class="az_custom_heading">Giờ Mở Cửa</h4>
                            <p>Thứ 2 - Chủ Nhật 11am-7pm</p>
                        </div>
                        <div class="col-md-6">
                            <div role="form" class="wpcf7">
                                <form id="contactForm" method="POST" action="{{ route('contact.store') }}">
                                    @csrf
                                    <p><label> Tên *<br>
                                            <span class="wpcf7-form-control-wrap your-name">
                                                <input name="name" value="" size="60"
                                                    class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                                    type="text" required></span>
                                        </label></p>
                                    <p><label> Email *<br>
                                            <span class="wpcf7-form-control-wrap your-email">
                                                <input name="email" value="" size="60"
                                                    class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email"
                                                    type="email" required></span>
                                        </label></p>
                                    <p><label> Tin nhắn *<br>
                                            <span class="wpcf7-form-control-wrap your-message">
                                                <textarea name="message" cols="60" rows="10" class="wpcf7-form-control wpcf7-textarea" required></textarea>
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

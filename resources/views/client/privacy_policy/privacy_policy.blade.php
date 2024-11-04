@extends('client.master')

@section('title', 'Chính Sách Bảo Mật')

@section('content')

    @include('components.breadcrumb-client')

    <div class="section-037">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8"> <!-- Kích thước cột rộng hơn -->
                    <div class="policy-card">
                        <div class="policy-content">
                            <h4 class="title text-center">
                                Chính Sách Bảo Mật của Zaia Enterprise
                            </h4>

                            <h2>Giới thiệu</h2>
                            <p>Tại Zaia Enterprise, chúng tôi cam kết bảo vệ thông tin cá nhân của bạn. Chính sách bảo mật
                                này
                                giải thích cách chúng tôi thu thập, sử dụng và bảo vệ thông tin của bạn.</p>

                            <h2>Thông tin chúng tôi thu thập</h2>
                            <p>Chúng tôi có thể thu thập các thông tin sau từ bạn:</p>
                            <ul>
                                <li>Thông tin cá nhân: tên, email, số điện thoại.</li>
                                <li>Thông tin giao dịch: sản phẩm đã mua, lịch sử giao dịch.</li>
                            </ul>

                            <h2>Cách chúng tôi sử dụng thông tin</h2>
                            <p>Chúng tôi sử dụng thông tin của bạn để:</p>
                            <ul>
                                <li>Cung cấp và cải thiện dịch vụ của chúng tôi.</li>
                                <li>Liên lạc với bạn về đơn hàng và dịch vụ.</li>
                                <li>Gửi thông báo và thông tin khuyến mại.</li>
                            </ul>

                            <h2>Chia sẻ thông tin</h2>
                            <p>Chúng tôi không bán hoặc cho thuê thông tin cá nhân của bạn cho bên thứ ba. Chúng tôi có thể
                                chia
                                sẻ thông tin của bạn với các đối tác đáng tin cậy để thực hiện dịch vụ của chúng tôi.</p>

                            <h2>Bảo mật thông tin</h2>
                            <p>Chúng tôi sử dụng các biện pháp bảo mật để bảo vệ thông tin của bạn khỏi việc truy cập trái
                                phép,
                                thay đổi, tiết lộ hoặc phá hủy.</p>

                            <h2>Quyền của người dùng</h2>
                            <p>Bạn có quyền yêu cầu truy cập, sửa đổi hoặc xóa thông tin cá nhân của mình. Nếu bạn muốn thực
                                hiện các quyền này, vui lòng liên hệ với chúng tôi.</p>

                            <h2>Liên hệ</h2>
                            <p>Nếu bạn có bất kỳ câu hỏi hoặc thắc mắc nào về chính sách bảo mật này, vui lòng liên hệ với
                                chúng
                                tôi qua email:
                                <a href="mailto:tranbaoai2004@gmail.com">tranbaoai2004@gmail.com</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .policy-card {
            background-color: #ffffff;
            /* Màu nền trắng */
            border-radius: 12px;
            /* Bo góc */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            /* Đổ bóng nhẹ */
            padding: 30px;
            /* Khoảng cách bên trong */
            margin-bottom: 30px;
            /* Khoảng cách dưới */
        }

        .title {
            font-size: 28px;
            /* Kích thước tiêu đề chính */
            font-weight: bold;
            /* Đậm */
            margin-bottom: 20px;
            /* Khoảng cách dưới tiêu đề */
            color: #333;
            /* Màu chữ */
        }

        h2 {
            font-size: 22px;
            /* Kích thước tiêu đề phụ */
            margin-top: 20px;
            /* Khoảng cách trên */
            color: #007bff;
            /* Màu cho tiêu đề phụ */
        }

        p,
        ul {
            font-size: 16px;
            /* Kích thước chữ cho nội dung */
            line-height: 1.6;
            /* Khoảng cách dòng */
            color: #555;
            /* Màu chữ cho nội dung */
        }

        ul {
            margin-left: 20px;
            /* Khoảng cách cho danh sách */
        }
    </style>

@endsection

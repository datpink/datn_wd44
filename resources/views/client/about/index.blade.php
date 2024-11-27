@extends('client.master')

@section('title', 'About')

@section('content')

    @include('components.breadcrumb-client2')

    <div class="site-main  main-container no-sidebar">
        <div class="section-037">
            <div class="container">
                <div class="kobolg-popupvideo style-01">
                    <div class="popupvideo-inner">
                        <div class="icon">
                            <img src="{{ asset('theme/client/assets/images/about-img.jpg') }}" class="attachment-full size-full" alt="img">
                        </div>
                        <div class="popupvideo-wrap">
                            <h4 class="title">
                                Về Chúng Tôi </h4>
                            <p class="desc">
                                Zaia Enterprise là một công ty chuyên cung cấp các sản phẩm công nghệ hiện đại,
                                từ thiết bị điện tử tiêu dùng đến các giải pháp công nghệ thông minh.
                                Chúng tôi cam kết mang đến cho khách hàng những sản phẩm chất lượng nhất,
                                kết hợp giữa thiết kế tinh tế và hiệu suất vượt trội.
                            </p>
                            <p>Chúng tôi cam kết cung cấp dịch vụ khách hàng xuất sắc,
                                đảm bảo rằng mọi sản phẩm đều đạt tiêu chuẩn chất lượng cao nhất.
                                Đội ngũ nhân viên tận tâm và chuyên nghiệp của chúng tôi luôn sẵn
                                sàng hỗ trợ bạn trong việc lựa chọn sản phẩm phù hợp nhất với nhu cầu của mình.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-001">
            <div class="container">
                <div class="kobolg-heading style-01">
                    <div class="heading-inner">
                        <h3 class="title">
                            Gặp gỡ đội ngũ của chúng tôi </h3>
                        <div class="subtitle">
                            Mang lại trải nghiệm tốt nhất cho khách hàng thông qua các sản phẩm công nghệ tiên tiến,
                            hỗ trợ việc nâng cao chất lượng cuộc sống và thúc đẩy sự phát triển bền vững.
                        </div>
                    </div>
                </div>
                <div class="kobolg-slide">
                    <div class="owl-slick equal-container better-height"
                        data-slick="{&quot;arrows&quot;:true,&quot;slidesMargin&quot;:30,&quot;dots&quot;:true,&quot;infinite&quot;:false,&quot;speed&quot;:300,&quot;slidesToShow&quot;:3,&quot;rows&quot;:1}"
                        data-responsive="[{&quot;breakpoint&quot;:480,&quot;settings&quot;:{&quot;slidesToShow&quot;:1,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:768,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:992,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1500,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;30&quot;}}]">
                        <div class="kobolg-team style-01">
                            <div class="team-inner">
                                <div class="thumb-avatar">
                                    <a href="#" target="_self" tabindex="0">
                                        <img src="{{ asset('theme/client/assets/images/team-img1.jpg') }}" class="attachment-full size-full"
                                            alt="img"></a>
                                    <div class="list-social">
                                        <a href="#" tabindex="0"><i class="az_tta-icon fa fa-facebook"></i></a>
                                        <a href="#" tabindex="0"><i class="az_tta-icon fa fa-twitter"></i></a>
                                        <a href="#" tabindex="0"><i class="az_tta-icon fa fa-instagram"></i></a>
                                    </div>
                                </div>
                                <div class="content-team">
                                    <h3 class="name">
                                        <a href="#" target="_self" tabindex="0">
                                            Hoàng Minh Hậu </a>
                                    </h3>
                                    <p class="positions">Developer</p>
                                </div>
                            </div>
                        </div>
                        <div class="kobolg-team style-01">
                            <div class="team-inner">
                                <div class="thumb-avatar">
                                    <a href="#" target="_self" tabindex="0">
                                        <img src="{{ asset('theme/client/assets/images/team-img2.jpg') }}" class="attachment-full size-full"
                                            alt="img"> </a>
                                    <div class="list-social">
                                        <a href="#" tabindex="0"><i class="az_tta-icon fa fa-facebook"></i></a>
                                        <a href="#" tabindex="0"><i class="az_tta-icon fa fa-twitter"></i></a>
                                        <a href="#" tabindex="0"><i class="az_tta-icon fa fa-instagram"></i></a>
                                    </div>
                                </div>
                                <div class="content-team">
                                    <h3 class="name">
                                        <a href="#" target="_self" tabindex="0">
                                            Nguyễn Tiến Đạt </a>
                                    </h3>
                                    <p class="positions">Team Leader</p>
                                </div>
                            </div>
                        </div>
                        <div class="kobolg-team style-01">
                            <div class="team-inner">
                                <div class="thumb-avatar">
                                    <a href="#" target="_self" tabindex="0">
                                        <img src="{{ asset('theme/client/assets/images/team5-1.jpg') }}" class="attachment-full size-full"
                                            alt="img"> </a>
                                    <div class="list-social">
                                        <a href="#" tabindex="0"><i class="az_tta-icon fa fa-facebook"></i></a>
                                        <a href="#" tabindex="0"><i class="az_tta-icon fa fa-twitter"></i></a>
                                        <a href="#" tabindex="0"><i class="az_tta-icon fa fa-instagram"></i></a>
                                    </div>
                                </div>
                                <div class="content-team">
                                    <h3 class="name">
                                        <a href="#" target="_self" tabindex="0">
                                            Đàm Đình Đào </a>
                                    </h3>
                                    <p class="positions">Developer</p>
                                </div>
                            </div>
                        </div>
                        <div class="kobolg-team style-01">
                            <div class="team-inner">
                                <div class="thumb-avatar">
                                    <a href="#" target="_self" tabindex="0">
                                        <img src="{{ asset('theme/client/assets/images/team-img3.jpg') }}" class="attachment-full size-full"
                                            alt="img"> </a>
                                    <div class="list-social">
                                        <a href="#" tabindex="0"><i class="az_tta-icon fa fa-facebook"></i></a>
                                        <a href="#" tabindex="0"><i class="az_tta-icon fa fa-twitter"></i></a>
                                        <a href="#" tabindex="0"><i class="az_tta-icon fa fa-instagram"></i></a>
                                    </div>
                                </div>
                                <div class="content-team">
                                    <h3 class="name">
                                        <a href="#" target="_self" tabindex="0">
                                            Phạm Thị Thuý Ngân </a>
                                    </h3>
                                    <p class="positions">Developer</p>
                                </div>
                            </div>
                        </div>
                        <div class="kobolg-team style-01">
                            <div class="team-inner">
                                <div class="thumb-avatar">
                                    <a href="#" target="_self" tabindex="-1">
                                        <img src="{{ asset('theme/client/assets/images/team-img4.jpg') }}" class="attachment-full size-full"
                                            alt="img"> </a>
                                    <div class="list-social">
                                        <a href="#" tabindex="-1"><i class="az_tta-icon fa fa-facebook"></i></a>
                                        <a href="#" tabindex="-1"><i class="az_tta-icon fa fa-twitter"></i></a>
                                        <a href="#" tabindex="-1"><i class="az_tta-icon fa fa-instagram"></i></a>
                                    </div>
                                </div>
                                <div class="content-team">
                                    <h3 class="name">
                                        <a href="#" target="_self" tabindex="-1">
                                            Tạ Văn Đoàn </a>
                                    </h3>
                                    <p class="positions">Developer</p>
                                </div>
                            </div>
                        </div>
                        <div class="kobolg-team style-01">
                            <div class="team-inner">
                                <div class="thumb-avatar">
                                    <a href="#" target="_self" tabindex="-1">
                                        <img src="{{ asset('theme/client/assets/images/team5-1.jpg') }}" class="attachment-full size-full"
                                            alt="img"> </a>
                                    <div class="list-social">
                                        <a href="#" tabindex="-1"><i class="az_tta-icon fa fa-facebook"></i></a>
                                        <a href="#" tabindex="-1"><i class="az_tta-icon fa fa-twitter"></i></a>
                                        <a href="#" tabindex="-1"><i class="az_tta-icon fa fa-instagram"></i></a>
                                    </div>
                                </div>
                                <div class="content-team">
                                    <h3 class="name">
                                        <a href="#" target="_self" tabindex="-1">
                                            Trần Bá Oai </a>
                                    </h3>
                                    <p class="positions">Developer</p>
                                </div>
                            </div>
                        </div>
                        <div class="kobolg-team style-01">
                            <div class="team-inner">
                                <div class="thumb-avatar">
                                    <a href="#" target="_self" tabindex="-1">
                                        <img src="{{ asset('theme/client/assets/images/team6.jpg') }}" class="attachment-full size-full"
                                            alt="img"> </a>
                                    <div class="list-social">
                                        <a href="#" tabindex="-1"><i class="az_tta-icon fa fa-facebook"></i></a>
                                        <a href="#" tabindex="-1"><i class="az_tta-icon fa fa-twitter"></i></a>
                                        <a href="#" tabindex="-1"><i class="az_tta-icon fa fa-instagram"></i></a>
                                    </div>
                                </div>
                                <div class="content-team">
                                    <h3 class="name">
                                        <a href="#" target="_self" tabindex="-1">
                                            Tăng Tiến Dũng </a>
                                    </h3>
                                    <p class="positions">Developer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@extends('client.master')

@section('title', 'About')

@section('content')

    @include('components.breadcrumb-client')

    <div class="site-main  main-container no-sidebar">
        <div class="section-037">
            <div class="container">
                <div class="kobolg-popupvideo style-01">
                    <div class="popupvideo-inner">
                        <div class="icon">
                            <img src="{{ asset('theme/client/assets/images/about-img.jpg') }}" class="attachment-full size-full" alt="img">
                            <div class="product-video-button">
                                <a class="buttonvideo" href="#" data-videosite="vimeo" data-videoid="125098197"
                                    tabindex="0">
                                    <div class="videobox_animation circle_1"></div>
                                    <div class="videobox_animation circle_2"></div>
                                    <div class="videobox_animation circle_3"></div>
                                </a>
                            </div>
                        </div>
                        <div class="popupvideo-wrap">
                            <h4 class="title">
                                Who we are </h4>
                            <p class="desc">We believe in a world where you have total freedom to be you, without
                                judgement.
                                To experiment. To express yourself. To be brave and grab life as the extraordinary adventure
                                it is. So we make sure everyone has an equal chance to discover all the amazing things
                                they’re capable of – no matter who they are, where they’re from or what looks they like to
                                boss.</p>
                            <p>Our audience (AKA you) is wonderfully unique. And we do everything we can to help you find
                                your fit, offering our Ciloe Brands in more than 30 sizes – and we’re committed to providing
                                all sizes at the same price</p>
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
                            Meet Our Team </h3>
                        <div class="subtitle">
                            A perfect blend of creativity and technical wizardry<br>
                            The best people fomula for great websites!
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
                                            Annie Taylor </a>
                                    </h3>
                                    <p class="positions">Operations</p>
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
                                            Ayomide Regan </a>
                                    </h3>
                                    <p class="positions">Marketing Personal</p>
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
                                            Violet Frase </a>
                                    </h3>
                                    <p class="positions">Director</p>
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
                                            Frank Greer </a>
                                    </h3>
                                    <p class="positions">Operations</p>
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
                                            Mark Tucker </a>
                                    </h3>
                                    <p class="positions">Partner</p>
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
                                            Perry Conner </a>
                                    </h3>
                                    <p class="positions">Partner</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-039 section-001">
            <div class="container">
                <div class="kobolg-slide">
                    <div class="owl-slick equal-container better-height"
                        data-slick="{&quot;arrows&quot;:true,&quot;slidesMargin&quot;:60,&quot;dots&quot;:false,&quot;infinite&quot;:false,&quot;speed&quot;:300,&quot;slidesToShow&quot;:5,&quot;rows&quot;:1}"
                        data-responsive="[{&quot;breakpoint&quot;:480,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;30&quot;}},{&quot;breakpoint&quot;:768,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;30&quot;}},{&quot;breakpoint&quot;:992,&quot;settings&quot;:{&quot;slidesToShow&quot;:4,&quot;slidesMargin&quot;:&quot;40&quot;}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:4,&quot;slidesMargin&quot;:&quot;50&quot;}},{&quot;breakpoint&quot;:1500,&quot;settings&quot;:{&quot;slidesToShow&quot;:5,&quot;slidesMargin&quot;:&quot;60&quot;}}]">
                        <div class="dreaming_single_image dreaming_content_element az_align_center">
                            <figure class="dreaming_wrapper az_figure">
                                <div class="az_single_image-wrapper az_box_border_grey effect bounce-in "><img
                                        src="{{ asset('theme/client/assets/images/brand-logo-1.png') }}" class="az_single_image-img attachment-full"
                                        alt="img" width="200" height="100">
                                </div>
                            </figure>
                        </div>
                        <div class="dreaming_single_image dreaming_content_element az_align_center">
                            <figure class="dreaming_wrapper az_figure">
                                <div class="az_single_image-wrapper   az_box_border_grey effect bounce-in "><img
                                        src="{{ asset('theme/client/assets/images/brand-logo-5.png') }}" class="az_single_image-img attachment-full"
                                        alt="img" width="200" height="100">
                                </div>
                            </figure>
                        </div>
                        <div class="dreaming_single_image dreaming_content_element az_align_center">
                            <figure class="dreaming_wrapper az_figure">
                                <div class="az_single_image-wrapper  az_box_border_grey effect bounce-in "><img
                                        src="{{ asset('theme/client/assets/images/brand-logo-4.png') }}" class="az_single_image-img attachment-full"
                                        alt="img" width="200" height="100">
                                </div>
                            </figure>
                        </div>
                        <div class="dreaming_single_image dreaming_content_element az_align_center">
                            <figure class="dreaming_wrapper az_figure">
                                <div class="az_single_image-wrapper az_box_border_grey effect bounce-in "><img
                                        src="{{ asset('theme/client/assets/images/brand-logo-3.png') }}" class="az_single_image-img attachment-full"
                                        alt="img" width="200" height="100">
                                </div>
                            </figure>
                        </div>
                        <div class="dreaming_single_image dreaming_content_element az_align_center">
                            <figure class="dreaming_wrapper az_figure">
                                <div class="az_single_image-wrapper az_box_border_grey effect bounce-in "><img
                                        src="{{ asset('theme/client/assets/images/brand-logo-2.png') }}" class="az_single_image-img attachment-full"
                                        alt="img" width="200" height="100">
                                </div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

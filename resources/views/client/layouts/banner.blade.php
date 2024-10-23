<div class="response-product product-list-owl owl-slick equal-container better-height"
    data-slick="{&quot;arrows&quot;:false,&quot;slidesMargin&quot;:0,&quot;dots&quot;:true,&quot;infinite&quot;:false,&quot;speed&quot;:300,&quot;slidesToShow&quot;:1,&quot;rows&quot;:1}"
    data-responsive="[{&quot;breakpoint&quot;:480,&quot;settings&quot;:{&quot;slidesToShow&quot;:1,&quot;slidesMargin&quot;:&quot;0&quot;}},{&quot;breakpoint&quot;:768,&quot;settings&quot;:{&quot;slidesToShow&quot;:1,&quot;slidesMargin&quot;:&quot;0&quot;}},{&quot;breakpoint&quot;:992,&quot;settings&quot;:{&quot;slidesToShow&quot;:1,&quot;slidesMargin&quot;:&quot;0&quot;}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:1,&quot;slidesMargin&quot;:&quot;0&quot;}},{&quot;breakpoint&quot;:1500,&quot;settings&quot;:{&quot;slidesToShow&quot;:1,&quot;slidesMargin&quot;:&quot;0&quot;}}]">

    @foreach ($banners as $banner)
        <div class="slide-wrap">
            <img src="{{ asset('storage/' . $banner->image) }}" >
            <div class="slide-info">
                <div class="slide-inner">
                    <h5>{{ $banner->title }}</h5> <!-- More space below the title -->
                    <h1>{!! $banner->description !!}</h1> <!-- More space below the description -->
                    <a href="{{ $banner->button_link }}">{{ $banner->button_text }}</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

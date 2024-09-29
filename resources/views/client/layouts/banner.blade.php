<div class="response-product product-list-owl owl-slick equal-container better-height" 
    data-slick="{&quot;arrows&quot;:false,&quot;slidesMargin&quot;:0,&quot;dots&quot;:true,&quot;infinite&quot;:false,&quot;speed&quot;:300,&quot;slidesToShow&quot;:1,&quot;rows&quot;:1}" 
    data-responsive="...">

    @foreach($banners as $banner)
    <div class="slide-wrap">
        <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}">
        <div class="slide-info">
            <div class="slide-inner">
                <h5 class="mt-4 mb-4">{{ $banner->title }}</h5> <!-- More space below the title -->
                <h1 class="h5 text-truncate mb-4">{!! $banner->description !!}</h1> <!-- More space below the description -->
                <a href="{{ $banner->button_link }}" class="btn btn-primary">{{ $banner->button_text}}</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

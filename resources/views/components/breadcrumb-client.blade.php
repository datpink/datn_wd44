@php
    $currentRoute = request()->route()->getName();
    $breadcrumbs = [
        ['name' => 'Home', 'url' => route('client.index')],
    ];

    switch ($currentRoute) {
        case 'client.products.index':
            $breadcrumbs[] = ['name' => 'Product', 'url' => ''];
            break;

        case 'client.posts.index':
            $breadcrumbs[] = ['name' => 'Post', 'url' => ''];
            break;

        case 'client.contact.index':
            $breadcrumbs[] = ['name' => 'Contact', 'url' => ''];
            break;

        case 'login':
            $breadcrumbs[] = ['name' => 'Login', 'url' => ''];
            break;

        // case 'client.products.show':
        //     $breadcrumbs[] = ['name' => 'Sản Phẩm', 'url' => route('client.products.index')];
        //     $breadcrumbs[] = ['name' => 'Chi Tiết Sản Phẩm', 'url' => ''];
        //     break;

    }
@endphp

<div class="banner-wrapper has_background">
    <img src="{{ asset('theme/client/assets/images/banner-for-all2.jpg') }}"
         class="img-responsive attachment-1920x447 size-1920x447" alt="img">
    <div class="banner-wrapper-inner">
        <h1 class="page-title container">{{ end($breadcrumbs)['name'] }}</h1>
        <div role="navigation" aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs container">
            <ul class="trail-items breadcrumb">
                @foreach ($breadcrumbs as $breadcrumb)
                    <li class="trail-item {{ $loop->last ? 'trail-end active' : '' }}">
                        @if($breadcrumb['url'])
                            <a href="{{ $breadcrumb['url'] }}"><span>{{ $breadcrumb['name'] }}</span></a>
                        @else
                            <span>{{ $breadcrumb['name'] }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
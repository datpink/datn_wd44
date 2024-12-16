<div class="header-middle-inner">
    <div class="header-logo-menu">
        <div class="block-menu-bar">
            <a class="menu-bar menu-toggle" href="#">
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>
        <div class="header-logo">
            <a href="{{ route('client.index') }}"><img alt="Zaia"
                    src="{{ asset('theme/client/assets/images/logozaia.png') }}" class="logo" width="160px"></a>
        </div>
    </div>
    <div class="header-search-mid">
        <div class="header-search">
            <div class="block-search">
                
                <form role="search" method="get" class="form-search block-search-form kobolg-live-search-form"
                    action="{{ route('client.searchAll') }} ">

                    <div class="form-content search-box results-search">

                        <div class="inner">
                            <input autocomplete="off" class="searchfield txt-livesearch input" name="searchAll"
                                value="{{ old('searchAll', $searchQuery ?? '') }}" placeholder="Tìm kiếm..." type="text">
                            <div id="suggestions-box"></div> <!-- Thêm div này để chứa gợi ý -->
                        </div>

                    </div>

                
                    <button type="submit" class="btn-submit">

                        <span class="flaticon-search"></span>

                    </button>

                </form><!-- block search -->
            </div>
        </div>
    </div>
    <div class="header-control">
        <div class="header-control-inner">
            <div class="meta-dreaming">

                {{-- you-cart --}}
                @include('client.you-cart.you-cart')

                @include('client.layouts.notification')

                {{-- login --}}
                @include('auth.login-client')



            </div>
        </div>
    </div>
</div>

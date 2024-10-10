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
            <a href="index.html"><img alt="Zaia" src="{{ asset('theme/client/assets/images/logozaia.png') }}" class="logo" width="160px"></a>
        </div>
    </div>
    <div class="header-search-mid">
        <div class="header-search">
            <div class="block-search">
                <form role="search" method="get" class="form-search block-search-form kobolg-live-search-form">
                    <div class="form-content search-box results-search">
                        <div class="inner">
                            <input autocomplete="off" class="searchfield txt-livesearch input" name="s"
                                value="" placeholder="Search here..." type="text">
                        </div>
                    </div>
                    <input name="post_type" value="product" type="hidden">
                    <input name="taxonomy" value="product_cat" type="hidden">
                    <div class="category">
                        <select title="catalogues" name="catalogue_slug" id="" class="category-search-option"
                            tabindex="-1" style="display: none;">
                            <option value="0">All Categories</option>
                            @foreach ($menuCatalogues as $catalogue)
                                <option value="{{ $catalogue->slug }}">{{ $catalogue->name }}</option>
                            @endforeach

                        </select>
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
                {{-- login --}}
                @include('auth.login-client')



            </div>
        </div>
    </div>
</div>

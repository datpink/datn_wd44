@extends('client.master')

@section('title', 'Sản phẩm')

@section('content')

    @include('components.breadcrumb-client')

    <div class="main-container left-sidebar has-sidebar">
        <!-- POST LAYOUT -->
        <div class="container">
            <div class="row">
                <div class="main-content col-xl-9 col-lg-5 col-md-12 col-sm-12">
                    <div class="blog-grid auto-clear content-post row">
                        @foreach ($posts as $post)
                            <article
                                class="post-item post-grid col-bg-4 col-xl-4 col-lg-4 col-md-4 col-sm-6 col-ts-12 post-{{ $post->id }} post type-post status-publish format-standard has-post-thumbnail hentry">
                                <div class="post-inner">
                                    <div class="post-thumb">
                                        <a href="#">
                                            <img src="{{ asset('images/' . $post->image) }}" alt="{{ $post->title }}"
                                                width="270" height="230">
                                        </a>
                                        <a class="datebox" href="#">
                                            <span>{{ $post->created_at->day }}</span>
                                            <span>{{ $post->created_at->format('M') }}</span>
                                        </a>
                                    </div>
                                    <div class="post-content">
                                        <div class="post-meta">
                                            <div class="post-author">
                                                By: <a href="#">{{ $post->author_name ?? 'Unknown' }}</a>
                                            </div>
                                            <div class="post-comment-icon">
                                                <a href="#">{{ $post->comments_count }}</a>
                                            </div>
                                        </div>
                                        <div class="post-info equal-elem">
                                            <h2 class="post-title"><a href="#">{{ $post->title }}</a></h2>
                                            <p>{{ $post->tomtat }}</p>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <nav class="navigation pagination">
                        <div class="nav-links">
                            @if ($posts->onFirstPage())
                                <span class="disabled page-numbers">« Previous</span>
                            @else
                                <a class="page-numbers" href="{{ $posts->previousPageUrl() }}">« Previous</a>
                            @endif

                            @foreach (range(1, $posts->lastPage()) as $page)
                                @if ($page == $posts->currentPage())
                                    <span class="current page-numbers">{{ $page }}</span>
                                @else
                                    <a class="page-numbers" href="{{ $posts->url($page) }}">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($posts->hasMorePages())
                                <a class="page-numbers" href="{{ $posts->nextPageUrl() }}">Next »</a>
                            @else
                                <span class="disabled page-numbers">Next »</span>
                            @endif
                        </div>
                    </nav>
                </div>

                <div class="sidebar kobolg_sidebar col-xl-3 col-lg-4 col-md-12 col-sm-12">
                    <div id="widget-area" class="widget-area sidebar-blog">
                        <div id="search-3" class="widget widget_search">
                            <form role="search" method="get" class="search-form">
                                <input class="search-field" placeholder="Your search here…" value="" name="s"
                                    type="search">
                                <button type="submit" class="search-submit"><span class="fa fa-search"
                                        aria-hidden="true"></span></button>
                                <input name="lang" value="en" type="hidden">
                            </form>
                        </div>
                        <div id="categories-3" class="widget widget_categories">
                            <h2 class="widgettitle">Categories<span class="arrow"></span></h2>
                            <ul>
                                <li class="cat-item cat-item-51"><a href="#">Camera</a>
                                </li>
                                <li class="cat-item cat-item-49"><a href="#">Fashion</a>
                                </li>
                                <li class="cat-item cat-item-52"><a href="#">Game & Consoles</a>
                                </li>
                                <li class="cat-item cat-item-53"><a href="#">Collection</a>
                                </li>
                                <li class="cat-item cat-item-50"><a href="#">Life
                                        Style</a>
                                </li>
                            </ul>
                        </div>
                        <div id="widget_kobolg_post-2" class="widget widget-kobolg-post">
                            <h2 class="widgettitle">Recent
                                Post<span class="arrow"></span></h2>
                            <div class="kobolg-posts">
                                <article
                                    class="post-195 post type-post status-publish format-standard has-post-thumbnail hentry category-light category-table category-life-style tag-light tag-life-style">
                                    <div class="post-item-inner">
                                        <div class="post-thumb">
                                            <a href="#">
                                                <img src="{{ asset('theme/client/assets/images/blogpost1-83x83.jpg') }}"
                                                    class="img-responsive attachment-83x83 size-83x83" alt="img"
                                                    width="83" height="83"> </a>
                                        </div>
                                        <div class="post-info">
                                            <div class="block-title">
                                                <h2 class="post-title"><a href="#">Not
                                                        your ordinary baby service.</a></h2>
                                            </div>
                                            <div class="date">December 19, 2018</div>
                                        </div>
                                    </div>
                                </article>
                                <article
                                    class="post-192 post type-post status-publish format-standard has-post-thumbnail hentry category-light category-fashion category-multi category-life-style tag-light tag-fashion tag-multi">
                                    <div class="post-item-inner">
                                        <div class="post-thumb">
                                            <a href="#">
                                                <img src="{{ asset('theme/client/assets/images/blogpost5-83x83.jpg') }}"
                                                    class="img-responsive attachment-83x83 size-83x83" alt="img"
                                                    width="83" height="83"> </a>
                                        </div>
                                        <div class="post-info">
                                            <div class="block-title">
                                                <h2 class="post-title"><a href="#">The
                                                        child is sleeping on the bed</a></h2>
                                            </div>
                                            <div class="date">December 19, 2018</div>
                                        </div>
                                    </div>
                                </article>
                                <article
                                    class="post-189 post type-post status-publish format-video has-post-thumbnail hentry category-table category-life-style tag-multi tag-life-style post_format-post-format-video">
                                    <div class="post-item-inner">
                                        <div class="post-thumb">
                                            <a href="#">
                                                <img src="{{ asset('theme/client/assets/images/blogpost9-83x83.jpg') }}"
                                                    class="img-responsive attachment-83x83 size-83x83" alt="img"
                                                    width="83" height="83"> </a>
                                        </div>
                                        <div class="post-info">
                                            <div class="block-title">
                                                <h2 class="post-title"><a href="#">The
                                                        light is hugging the dog on the room</a></h2>
                                            </div>
                                            <div class="date">December 19, 2018</div>
                                        </div>
                                    </div>
                                </article>
                                <article
                                    class="post-186 post type-post status-publish format-standard has-post-thumbnail hentry category-light category-life-style tag-life-style">
                                    <div class="post-item-inner">
                                        <div class="post-thumb">
                                            <a href="#">
                                                <img src="{{ asset('theme/client/assets/images/blogpost4-83x83.jpg') }}"
                                                    class="img-responsive attachment-83x83 size-83x83" alt="img"
                                                    width="83" height="83"> </a>
                                        </div>
                                        <div class="post-info">
                                            <div class="block-title">
                                                <h2 class="post-title"><a href="#">The
                                                        child is swimming with a buoy</a></h2>
                                            </div>
                                            <div class="date">December 19, 2018</div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div id="widget_kobolg_socials-2" class="widget widget-kobolg-socials">
                            <h2 class="widgettitle">Follow us<span class="arrow"></span></h2>
                            <div class="content-socials">
                                <ul class="socials-list">
                                    <li>
                                        <a href="https://facebook.com/" target="_blank">
                                            <span class="fa fa-facebook"></span>
                                            Facebook </a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/" target="_blank">
                                            <span class="fa fa-instagram"></span>
                                            Instagram </a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/" target="_blank">
                                            <span class="fa fa-twitter"></span>
                                            Twitter </a>
                                    </li>
                                    <li>
                                        <a href="https://www.pinterest.com/" target="_blank">
                                            <span class="fa fa-pinterest-p"></span>
                                            Pinterest </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="widget_kobolg_instagram-3" class="widget widget-kobolg-instagram">
                            <h2 class="widgettitle">Instagram<span class="arrow"></span></h2>
                            <div class="content-instagram">
                                <a target="_blank" href="#" class="item">
                                    <img class="img-responsive"
                                        src="{{ asset('theme/client/assets/images/insta1.jpg') }}"
                                        alt="Not your ordinary multi service.">
                                </a>
                                <a target="_blank" href="#" class="item">
                                    <img class="img-responsive"
                                        src="{{ asset('theme/client/assets/images/insta2.jpg') }}"
                                        alt="Not your ordinary multi service.">
                                </a>
                                <a target="_blank" href="#" class="item">
                                    <img class="img-responsive"
                                        src="{{ asset('theme/client/assets/images/insta3.jpg') }}"
                                        alt="Not your ordinary multi service.">
                                </a>
                                <a target="_blank" href="#" class="item">
                                    <img class="img-responsive"
                                        src="{{ asset('theme/client/assets/images/insta4.jpg') }}"
                                        alt="Not your ordinary multi service.">
                                </a>
                                <a target="_blank" href="#" class="item">
                                    <img class="img-responsive"
                                        src="{{ asset('theme/client/assets/images/insta5.jpg') }}"
                                        alt="Not your ordinary multi service.">
                                </a>
                                <a target="_blank" href="#" class="item">
                                    <img class="img-responsive"
                                        src="{{ asset('theme/client/assets/images/insta6.jpg') }}"
                                        alt="Not your ordinary multi service.">
                                </a>
                            </div>
                        </div>
                        <div id="tag_cloud-3" class="widget widget_tag_cloud">
                            <h2 class="widgettitle">Tags<span class="arrow"></span></h2>
                            <div class="tagcloud">
                                <a href="#" class="tag-cloud-link tag-link-46 tag-link-position-1"
                                    aria-label="Camera (4 items)">Camera</a>
                                <a href="#" class="tag-cloud-link tag-link-43 tag-link-position-2"
                                    aria-label="Fashion (5 items)">Fashion</a>
                                <a href="#" class="tag-cloud-link tag-link-47 tag-link-position-3"
                                    aria-label="Game & Consoles (4 items)">Game & Consoles</a>
                                <a href="#" class="tag-cloud-link tag-link-48 tag-link-position-4"
                                    aria-label="Collection (4 items)">Collection</a>
                                <a href="#" class="tag-cloud-link tag-link-45 tag-link-position-5"
                                    aria-label="Life Style (7 items)">Life Style</a>
                            </div>
                        </div>
                    </div><!-- .widget-area -->
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .navigation.pagination {
        display: flex;
        justify-content: center;
        margin: 20px 0;
    }

    .nav-links {
        display: flex;
    }

    .page-numbers {
        padding: 10px 15px;
        margin: 0 5px;
        border: 1px solid #007bff;
        background-color: #f1f1f1;
        color: #007bff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .page-numbers:hover {
        background-color: #007bff;
        color: white;
    }

    .current.page-numbers {
        background-color: #007bff;
        color: white;
        border: none;
        pointer-events: none;
    }

    .disabled.page-numbers {
        color: #ccc;
        pointer-events: none;
    }
</style>

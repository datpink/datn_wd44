<div class="sidebar kobolg_sidebar col-xl-3 col-lg-4 col-md-12 col-sm-12">
    <div id="widget-area" class="widget-area sidebar-blog">
        <div id="search-3" class="widget widget_search">
            <form role="search" method="get" class="search-form" action="{{ route('search') }}">
                <input class="search-field" placeholder="Tìm kiếm của bạn ở đây…" value="{{ request()->get('s') }}"
                    name="s" type="search">
                <button type="submit" class="search-submit"><span class="fa fa-search"
                        aria-hidden="true"></span></button>
            </form>

        </div>
        <div id="categories-3" class="widget widget_categories">
            <h2 class="widgettitle">Thể loại<span class="arrow"></span></h2>
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
            <h2 class="widgettitle">Bài đăng gần đây<span class="arrow"></span></h2>
            <div class="kobolg-posts">
                @foreach ($latestPosts as $post)
                    <article
                        class="post-{{ $post->id }} post type-post status-publish format-standard has-post-thumbnail hentry">
                        <div class="post-item-inner">
                            <div class="post-thumb">
                                <a href="{{ route('post.show', $post->id) }}">
                                    @if ($post->image && \Storage::exists($post->image))
                                        <img src="{{ \Storage::url($post->image) }}"
                                            class="img-responsive attachment-83x83 size-83x83" alt="{{ $post->title }}"
                                            width="83" height="83">
                                    @else
                                        Không có ảnh
                                    @endif
                                </a>
                            </div>
                            <div class="post-info">
                                <div class="block-title">
                                    <h2 class="post-title">
                                        <a href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a>
                                    </h2>
                                </div>
                                <div class="date">{{ $post->created_at->format('F d, Y') }}</div>
                            </div>
                        </div>
                    </article>
                @endforeach

            </div>
        </div>
        <div id="widget_kobolg_socials-2" class="widget widget-kobolg-socials">
            <h2 class="widgettitle">Theo dõi chúng tôi<span class="arrow"></span></h2>
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
                    <img class="img-responsive" src="{{ asset('theme/client/assets/images/insta1.jpg') }}"
                        alt="Not your ordinary multi service.">
                </a>
                <a target="_blank" href="#" class="item">
                    <img class="img-responsive" src="{{ asset('theme/client/assets/images/insta2.jpg') }}"
                        alt="Not your ordinary multi service.">
                </a>
                <a target="_blank" href="#" class="item">
                    <img class="img-responsive" src="{{ asset('theme/client/assets/images/insta3.jpg') }}"
                        alt="Not your ordinary multi service.">
                </a>
                <a target="_blank" href="#" class="item">
                    <img class="img-responsive" src="{{ asset('theme/client/assets/images/insta4.jpg') }}"
                        alt="Not your ordinary multi service.">
                </a>
                <a target="_blank" href="#" class="item">
                    <img class="img-responsive" src="{{ asset('theme/client/assets/images/insta5.jpg') }}"
                        alt="Not your ordinary multi service.">
                </a>
                <a target="_blank" href="#" class="item">
                    <img class="img-responsive" src="{{ asset('theme/client/assets/images/insta6.jpg') }}"
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

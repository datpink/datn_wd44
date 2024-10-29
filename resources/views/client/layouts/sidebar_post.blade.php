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
<<<<<<< HEAD
                <article
                    class="post-195 post type-post status-publish format-standard has-post-thumbnail hentry category-light category-table category-life-style tag-light tag-life-style">
                    <div class="post-item-inner">
                        <div class="post-thumb">
                            <a href="#">
                                <img src="{{ asset('theme/client/assets/images/blogpost1-83x83.jpg') }}"
                                    class="img-responsive attachment-83x83 size-83x83" alt="img" width="83"
                                    height="83"> </a>
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
                                    class="img-responsive attachment-83x83 size-83x83" alt="img" width="83"
                                    height="83"> </a>
                        </div>
                        <div class="post-info">
                            <div class="block-title">
                                <h2 class="post-title"><a href="#">The
                                        child is sleeping on the bed</a></h2>
=======
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
>>>>>>> d48c587078eb2a3e569b4258a8a30a767b8842ee
                            </div>
                        </div>
<<<<<<< HEAD
                    </div>
                </article>
                <article
                    class="post-189 post type-post status-publish format-video has-post-thumbnail hentry category-table category-life-style tag-multi tag-life-style post_format-post-format-video">
                    <div class="post-item-inner">
                        <div class="post-thumb">
                            <a href="#">
                                <img src="{{ asset('theme/client/assets/images/blogpost9-83x83.jpg') }}"
                                    class="img-responsive attachment-83x83 size-83x83" alt="img" width="83"
                                    height="83"> </a>
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
                                    class="img-responsive attachment-83x83 size-83x83" alt="img" width="83"
                                    height="83"> </a>
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
=======
                    </article>
                @endforeach

>>>>>>> d48c587078eb2a3e569b4258a8a30a767b8842ee
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
<<<<<<< HEAD
<!-- Đoạn mã JavaScript cho Ajax -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#search-input').on('input', function() {
        let query = $(this).val();

        if (query.length > 2) {
            $.ajax({
                url: "/api/search/suggestions",  // URL đến route API gợi ý
                data: { query: query },
                success: function(data) {
                    let suggestionsHtml = '';

                    // Gợi ý sản phẩm
                    if (data.products.length) {
                        suggestionsHtml += '<h4>Sản phẩm</h4><ul>';
                        data.products.forEach(product => {
                            suggestionsHtml += `<li><a href="/product/${product.id}">${product.name}</a></li>`;
                        });
                        suggestionsHtml += '</ul>';
                    }

                    // Gợi ý bài viết
                    if (data.posts.length) {
                        suggestionsHtml += '<h4>Bài viết</h4><ul>';
                        data.posts.forEach(post => {
                            suggestionsHtml += `<li><a href="/post/${post.id}">${post.title}</a></li>`;
                        });
                        suggestionsHtml += '</ul>';
                    }

                    // Hiển thị gợi ý
                    $('#suggestions').html(suggestionsHtml).show();
                },
                error: function() {
                    $('#suggestions').hide();  // Ẩn gợi ý khi có lỗi
                }
            });
        } else {
            $('#suggestions').hide();  // Ẩn gợi ý nếu không có từ khóa
        }
    });

    // Ẩn gợi ý khi người dùng nhấn ra ngoài ô tìm kiếm
    $(document).click(function(e) {
        if (!$(e.target).closest('.search-form').length) {
            $('#suggestions').hide();
        }
    });
});
</script>
<style>
    .suggestions-box {
    border: 1px solid #ddd;
    max-height: 200px;
    overflow-y: auto;
    background-color: #fff;
    display: none;
    position: absolute;
    z-index: 1000;
    width: 100%;
}

.suggestions-box h4 {
    margin: 0;
    padding: 5px;
    background-color: #f1f1f1;
    font-weight: bold;
}

.suggestions-box ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.suggestions-box ul li {
    padding: 5px;
}

.suggestions-box ul li:hover {
    background-color: #e9e9e9;
}

</style>
=======
>>>>>>> d48c587078eb2a3e569b4258a8a30a767b8842ee

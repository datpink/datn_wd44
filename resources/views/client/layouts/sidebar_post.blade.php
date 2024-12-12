<style>
    .cat-item a {
        display: inline-block;
        padding-right: 20px;
        position: relative;
        text-decoration: none;
        color: #333;
    }

    .cat-item a.active {
        font-weight: bold;
        color: #007bff;
        /* Màu sắc khi được chọn */
    }

    .cat-item a.active::after {
        content: '✔';
        /* Dấu tích */
        position: absolute;
        right: 0;
        /* Căn bên phải */
        color: #007bff;
        font-size: 16px;
    }
</style>
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
            <h2 class="widgettitle">Danh mục<span class="arrow"></span></h2>
            <ul>
                <ul>
                    @foreach ($categories as $item)
                        <li class="cat-item">
                            <a href="{{ route('client.posts.byCategory', $item->id) }}"
                                class="{{ request()->route('id') == $item->id ? 'active' : '' }}">
                                {{ $item->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>

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
    </div><!-- .widget-area -->
</div>

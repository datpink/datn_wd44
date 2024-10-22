@extends('client.master')

@section('title', 'Bài Viết')

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
                                        <td>
                                            @if ($post->image && \Storage::exists($post->image))
                                                <img src="{{ \Storage::url($post->image) }}" alt="{{ $post->name }}"
                                                    style="max-width: 100%; height: auto; margin:0 auto">
                                            @else
                                                Không có ảnh
                                            @endif

                                        </td>
                                        <a class="datebox" href="{{ route('post.show', $post->id) }}">
                                            <span>{{ $post->created_at->day }}</span>
                                            <span>{{ $post->created_at->format('M') }}</span>
                                        </a>
                                    </div>
                                    <div class="post-content">
                                        <div class="post-meta">
                                            <div class="post-author">
                                                By: <a
                                                    href="{{ route('post.show', $post->id) }}">{{ $post->author_name ?? 'Unknown' }}</a>
                                            </div>
                                            <div class="post-comment-icon">
                                                <a
                                                    href="{{ route('post.show', $post->id) }}">{{ $post->comments_count }}</a>
                                            </div>
                                        </div>
                                        <div class="post-info equal-elem">
                                            <a href="{{ route('post.show', $post->id) }}">
                                                <h2 class="post-title">{{ $post->title }}</h2>
                                            </a>
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

                @include('client.layouts.sidebar_post')

            </div>
        </div>
    </div>
@endsection

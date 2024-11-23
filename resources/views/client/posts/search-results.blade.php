@extends('client.master')

@section('title', 'Kết quả tìm kiếm')

@section('content')

    @include('components.breadcrumb-client2')

    <div class="main-container left-sidebar has-sidebar">
        <div class="container">
            <div class="row">
                <div class="main-content col-xl-9 col-lg-5 col-md-12 col-sm-12">
                    <h1>Kết quả tìm kiếm</h1>
                    <div class="blog-grid auto-clear content-post row">
                        @forelse ($posts as $post)
                            <article
                                class="post-item post-grid col-bg-4 col-xl-4 col-lg-4 col-md-4 col-sm-6 col-ts-12 post-{{ $post->id }} post type-post status-publish format-standard has-post-thumbnail hentry">
                                <div class="post-inner">
                                    <div class="post-thumb">
                                        @if ($post->image && \Storage::exists($post->image))
                                            <img src="{{ \Storage::url($post->image) }}" alt="{{ $post->name }}"
                                                style="max-width: 100%; height: auto; margin:0 auto">
                                        @else
                                            Không có ảnh
                                        @endif

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
                        @empty
                            <p>Không có kết quả nào phù hợp với từ khóa tìm kiếm.</p>
                        @endforelse
                    </div>
                </div>

                @include('client.layouts.sidebar_post')

            </div>
        </div>
    </div>

@endsection

@extends('client.master')
@section('title', $post->title . ' - Zaia Enterprise')

@section('content')
    <div class="main-container left-sidebar has-sidebar">

        <!-- POST LAYOUT -->
        <div class="container">
            <div class="row">
                <div class="main-content col-xl-9 col-lg-8 col-md-12 col-sm-12">
                    <article
                        class="post-item post-single post-195 post type-post status-publish format-standard has-post-thumbnail hentry category-light category-table category-life-style tag-light tag-life-style">
                        <div class="single-post-thumb">
                            <div class="post-thumb">
                                <div class="owl-slick">
                                    <td>
                                        @if ($post->image && \Storage::exists($post->image))
                                            <img src="{{ \Storage::url($post->image) }}" alt="{{ $post->name }}"
                                                style="max-width: 100%; height: auto; margin:0 auto">
                                        @else
                                            Không có ảnh
                                        @endif


                                    </td>

                                </div>
                            </div>
                        </div>
                        <div class="single-post-info">
                            <h2 class="post-title"><a href="#">{{ $post->title }}</a></h2>
                            <div class="post-meta">
                                <div class="date">
                                    <span>{{ $post->created_at->day }}</span>
                                    <span>{{ $post->created_at->format('M') }}</span>
                                </div>
                                <div class="post-author">
                                    By: <a href="#">{{ $post->author_name ?? 'Unknown' }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="post-content">
                            <div id="output">
                                <p>{{ $post->tomtat }}.</p>
                                <blockquote>
                                    <p>{{ $post->slug }}</p>
                                </blockquote>
                                <p>{!! $post->content !!}</p>
                            </div>
                            <p>&nbsp;</p>
                            {{-- <div id="gallery-1" class="gallery galleryid-195 gallery-columns-2 gallery-size-full">
                                <figure class="gallery-item">
                                    <div class="gallery-icon landscape">
                                        <a href="#"><img src="{{ asset('theme/client/assets/images/blog-gallery-1.jpg') }}"
                                                class="attachment-full size-full" alt="img"></a>
                                    </div>
                                </figure>
                                <figure class="gallery-item">
                                    <div class="gallery-icon landscape">
                                        <a href="#"><img src="{{ asset('theme/client/assets/images/blog-gallery-2.jpg') }}"
                                                class="attachment-full size-full" alt="img"></a>
                                    </div>
                                </figure>
                            </div> --}}
                        </div>
                        <div class="tags"><a href="#" rel="tag">Camera</a>, <a href="#"
                                rel="tag">Life Style</a></div>
                        <div class="post-footer">
                            <div class="kobolg-share-socials">
                                <h5 class="social-heading">Share: </h5>
                                <a target="_blank" class="facebook" href="#"><i class="fa fa-facebook-f"></i></a>
                                <a target="_blank" class="twitter" href="#"><i class="fa fa-twitter"></i></a>
                                <a target="_blank" class="pinterest" href="#"><i class="fa fa-pinterest"></i></a>
                                <a target="_blank" class="googleplus" href="#"><i class="fa fa-google-plus"></i></a>
                            </div>
                            <div class="categories">
                                <span>Danh Mục: </span>
                                <a href="#">Camera</a>,
                                <a href="#">Game & Consoles</a>,
                                <a href="#">Life Style</a>
                            </div>
                        </div>
                    </article>
                    <!-- Hiển thị bình luận -->
                    <div id="comments" class="comments-area">
                        <h3>Bình luận</h3>
                        @if ($post->comments->count())
                            <ul class="comment-list">
                                @foreach ($post->comments as $comment)
                                    <li>
                                        <div class="comment-body">
                                            <h4 class="comment-author">{{ $comment->user_id }}</h4>
                                            <p class="comment-content">{{ $comment->content }}</p>
                                            <p class="comment-meta">{{ $comment->created_at->diffForHumans() }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>Chưa có bình luận nào.</p>
                        @endif
                    </div>

                    <!-- Form bình luận -->
                    <div id="comments" class="comments-area">
                        <div id="respond" class="comment-respond">
                            <h3 id="reply-title" class="comment-reply-title">Để lại một bình luận</h3>
                            <form id="commentform" method="POST" action="{{ route('post.comments.store', $post->id) }}">
                                @csrf
                                <p class="comment-notes">
                                    <span id="email-notes">Địa chỉ email của bạn sẽ không được công bố.</span> 
                                    Các trường bắt buộc được đánh dấu<span class="required">*</span>
                                </p>
                                <p class="comment-reply-content">
                                    <input name="author" id="name" class="input-form name" placeholder="Name*" type="text" required>
                                </p>
                                <p class="comment-reply-content">
                                    <input name="email" id="email" class="input-form email" placeholder="Email*" type="email" required>
                                </p>
                                <p class="comment-form-comment">
                                    <textarea class="input-form" id="comment" name="comment" cols="45" rows="6" aria-required="true" placeholder="Nhập bình luận của bạn vào đây..." required></textarea>
                                </p>
                                <p class="form-submit">
                                    <input name="submit" id="submit" class="submit" value="Đăng bình luận" type="submit">
                                </p>
                            </form>
                        </div><!-- #respond -->
                    </div><!-- #comments -->
                    
                </div>
                @include('client.layouts.sidebar_post')

            </div>
        </div>
    </div>
@endsection

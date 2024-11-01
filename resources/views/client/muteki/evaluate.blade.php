<div class="kobolg-Tabs-panel kobolg-Tabs-panel--reviews panel entry-content kobolg-tab" id="tab-reviews" role="tabpanel"
    aria-labelledby="tab-title-reviews">
    <div id="reviews" class="kobolg-Reviews col-md-6 mx-auto">
        <h2 class="kobolg-Reviews-title">Đánh giá</h2>
        @if ($product->reviews->count() > 0)
            @foreach ($product->reviews as $review)
                <div class="review">
                    <div class="review-item">
                        <p><strong>{{ $review->user->name }} </strong>
                            @for ($i = 1; $i <= $review->rating; $i++)
                                <span class="star-{{ $i }}">★</span>
                            @endfor
                        </p>
                        <p>Đánh giá: <em>{{ $review->review }}</em></p>
                    </div>

                    <!-- Kiểm tra xem người dùng đã phản hồi chưa -->
                    @if ($review->responses->count() > 0)
                        @foreach ($review->responses as $response)
                            <div class="response">
                                <p><strong>Admin {{ $response->responder->name }}</strong> <i>
                                        đã phản hồi đánh giá của
                                        <strong>{{ $response->review->user->name }}</strong>
                                        hồi </i>
                                    <span>{{ $response->created_at->format('H:i:s d/m/Y') }}</span>
                                </p>
                                <p>{{ $response->response }}</p>
                            </div>
                        @endforeach
                    @endif

                    <!-- Form thêm phản hồi -->
                    @auth
                        <form action="{{ route('client.storeReviewResponse', $review->id) }}" method="POST">
                            @csrf
                            <textarea name="response" required placeholder="Phản hồi của bạn"></textarea>
                            <button type="submit" class="submit">Gửi Phản Hồi</button>
                        </form>
                    @endauth
                </div>
            @endforeach
        @else
            <p class="kobolg-noreviews">Chưa có đánh giá nào</p>
        @endif

        <!-- Kiểm tra đơn hàng của người dùng -->
        @auth
            @php
                $hasOrder = Auth::user()
                    ->orders()
                    ->whereHas('orderItems', function ($query) use ($product) {
                        $query->where('product_variant_id', $product->id);
                    })
                    ->exists();
            @endphp

            @if ($hasOrder)
                <div id="review_form_wrapper">
                    <div id="review_form">
                        <div id="respond" class="comment-respond">
                            <style>
                                .stars a {
                                    font-size: 24px;
                                    /* Kích thước của sao */
                                    color: #ccc;
                                    /* Màu của sao chưa được chọn */
                                    text-decoration: none;
                                    /* Loại bỏ gạch chân */
                                }

                                .stars a.selected {
                                    color: gold;
                                    /* Màu của sao đã được chọn */
                                }
                            </style>

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @php
                                $userReview = $product->reviews()->where('user_id', Auth::id())->first();
                            @endphp

                            @if ($userReview)
                                <div class="error">
                                    <p>Bạn đã đánh giá sản phẩm này với điểm:
                                        <strong>{{ $userReview->rating }} sao</strong>
                                    </p>
                                    <p>Đánh giá của bạn: <em>{{ $userReview->review }}</em></p>
                                </div>
                            @else
                                <form action="{{ route('client.storeReview', $product->id) }}" method="POST"
                                    id="review-form">
                                    @csrf
                                    <div class="comment-form-rating">
                                        <label for="rating">Đánh giá</label>
                                        <p class="stars">
                                            <span>
                                                <a class="star-1" href="#" data-value="1">★</a>
                                                <a class="star-2" href="#" data-value="2">★</a>
                                                <a class="star-3" href="#" data-value="3">★</a>
                                                <a class="star-4" href="#" data-value="4">★</a>
                                                <a class="star-5" href="#" data-value="5">★</a>
                                            </span>
                                        </p>
                                        <input type="hidden" name="rating" id="rating" required>
                                    </div>
                                    <p class="comment-form-comment"><label for="comment">Đánh giá
                                            của bạn&nbsp;<span class="required">*</span></label>
                                        <textarea id="comment" name="review" cols="45" rows="8" required></textarea>
                                    </p>
                                    <p class="form-submit"><input name="submit" class="submit" value="Đánh Giá"
                                            type="submit"></p>
                                </form>
                            @endif
                            <script>
                                document.querySelectorAll('.stars a').forEach(star => {
                                    star.addEventListener('click', function(e) {
                                        e.preventDefault(); // Ngăn chặn hành vi mặc định của link
                                        const ratingValue = this.getAttribute('data-value');
                                        document.getElementById('rating').value = ratingValue; // Cập nhật giá trị rating ẩn
                                        // Cập nhật giao diện sao cho phù hợp
                                        document.querySelectorAll('.stars a').forEach(s => s.classList.remove('selected'));
                                        for (let i = 1; i <= ratingValue; i++) {
                                            document.querySelector('.star-' + i).classList.add('selected');
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
    </div>
</div>

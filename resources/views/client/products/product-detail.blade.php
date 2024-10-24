@extends('client.master')

@section('title', $product->name . ' - Zaia Enterprise')

@section('content')

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> --}}

    @include('components.breadcrumb-client')
    <style>
        .variant-btn {
            height: 50px;
            background-color: white;

            border: 1px solid black;
            color: black;
            padding: 5px 10px;
            cursor: pointer;
        }

        .variant-btn:hover {
            border: 2px solid red;
        }

        .tbnsend {
            background-color: #fff
        }

        .comment,
        .reply {
            position: relative;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .send-button {
            background-image: url('https://www.flaticon.com/free-icons/message');
            background-size: contain;
            background-repeat: no-repeat;
            padding-left: 20px;
            /* Điều chỉnh để phù hợp với kích thước biểu tượng */
        }

        .dropdown {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .comment strong,
        .reply strong {
            font-size: 14px;
        }

        .comment span,
        .reply span {
            font-size: 12px;
            color: #888;
        }

        .comment p,
        .reply p {
            margin: 10px 0;
        }

        textarea {
            width: 100%;
            height: 60px;
            margin-bottom: 10px;
        }

        button {
            margin-right: 5px;
        }

        /* Khoảng cách giữa các bình luận và phản hồi */
        .comment {
            margin-bottom: 20px;
        }

        .reply {
            margin-bottom: 10px;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="single-thumb-vertical main-container shop-page no-sidebar">
        <div class="container">
            <div class="row">
                <div class="main-content col-md-12">
                    <div class="kobolg-notices-wrapper"></div>
                    <div id="product-27"
                        class="post-27 product type-product status-publish has-post-thumbnail product_cat-table product_cat-new-arrivals product_cat-lamp product_tag-table product_tag-sock first instock shipping-taxable purchasable product-type-variable has-default-attributes">
                        <div class="main-contain-summary">
                            <div class="contain-left has-gallery">
                                <div class="single-left">
                                    <div
                                        class="kobolg-product-gallery kobolg-product-gallery--with-images kobolg-product-gallery--columns-4 images">
                                        <a href="#" class="kobolg-product-gallery__trigger">
                                            <img draggable="false" class="emoji" alt="🔍"
                                                src="https://s.w.org/images/core/emoji/11/svg/1f50d.svg">
                                        </a>
                                        <div class="flex-viewport">
                                            <figure class="kobolg-product-gallery__wrapper">
                                                @if ($product->galleries->isNotEmpty())
                                                    @foreach ($product->galleries as $gallery)
                                                        <div class="kobolg-product-gallery__image">
                                                            <img src="{{ \Storage::url($gallery->image_url) }}"
                                                                alt="{{ $product->name }}"
                                                                style="max-width: 70%; margin: 0 auto; height: auto;">
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="kobolg-product-gallery__image">
                                                        <img src="{{ \Storage::url($product->image_url) }}"
                                                            alt="{{ $product->name }}"
                                                            style="max-width: 70%; margin: 0 auto; height: auto;">
                                                    </div>
                                                @endif
                                            </figure>
                                        </div>
                                        <ol class="flex-control-nav flex-control-thumbs">
                                            @if ($product->galleries->isNotEmpty())
                                                @foreach ($product->galleries as $gallery)
                                                    <li>
                                                        <img src="{{ \Storage::url($gallery->image_url) }}" alt="Thumbnail"
                                                            style="width: 100px; height: auto;">
                                                    </li>
                                                @endforeach
                                            @else
                                                <li>
                                                    <img src="{{ \Storage::url($product->image_url) }}"
                                                        alt="{{ $product->name }} Thumbnail"
                                                        style="width: 100px; height: auto;">
                                                </li>
                                            @endif
                                        </ol>
                                    </div>
                                </div>
                                <div class="summary entry-summary">
                                    <div class="flash">
                                        <span class="onnew"><span class="text">New</span></span>
                                    </div>
                                    <h1 class="product_title entry-title">{{ $product->name }}</h1>
                                    <p class="price">
                                        <span class="kobolg-Price-amount amount">
                                            <span class="kobolg-Price-currencySymbol"></span>
                                            <span id="product-price" class="kobolg-Price-amount amount">
                                                {{ number_format($product->price, 0, ',', '.') }}đ
                                            </span>
                                        </span>
                                    </p>
                                    <br>
                                    <div class="product-variants">
                                        <div class="product-attributes">
                                            <!-- Dung lượng -->
                                            @php
                                                $dungLuongVariants = [];
                                                foreach ($product->variants as $variant) {
                                                    foreach ($variant->attributeValues as $attributeValue) {
                                                        if ($attributeValue->attribute->name === 'Storage') {
                                                            $dungLuongVariants[$attributeValue->name][] = $variant;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <!-- Dung lượng -->
                                            @if (count($dungLuongVariants) > 0)
                                                <div class="attribute-group">
                                                    <h4>Dung lượng:</h4>
                                                    @foreach ($dungLuongVariants as $dungLuong => $variants)
                                                        <button class="variant-btn" data-dung-luong="{{ $dungLuong }}"
                                                            data-variant-id="{{ $variants[0]->id }}"
                                                            data-price="{{ number_format($variants[0]->price, 0, ',', '.') }}đ"
                                                            data-img-url="{{ $variants[0]->img_url }}">
                                                            @if (!empty($variants[0]->img_url))
                                                                <img src="{{ $variants[0]->img_url }}"
                                                                    alt="{{ $dungLuong }}" width="35px" height="35px"
                                                                    style="margin-right: 5px;">
                                                            @else
                                                                <img src="{{ \Storage::url($product->image_url) }}"
                                                                    alt="No Image" width="35px" height="35px"
                                                                    style="margin-right: 5px;">
                                                            @endif
                                                            {{ $dungLuong }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <!-- Màu sắc -->
                                            @php
                                                $mauSacVariants = [];
                                                foreach ($product->variants as $variant) {
                                                    foreach ($variant->attributeValues as $attributeValue) {
                                                        if ($attributeValue->attribute->name === 'Color') {
                                                            $mauSacVariants[$attributeValue->name][] = $variant;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @if (count($mauSacVariants) > 0)
                                                <div class="attribute-group">
                                                    <h4>Màu sắc:</h4>
                                                    @foreach ($mauSacVariants as $mauSac => $variants)
                                                        <button class="variant-btn" data-mau-sac="{{ $mauSac }}"
                                                            data-variant-id="{{ $variants[0]->id }}"
                                                            data-price="{{ number_format($variants[0]->price, 0, ',', '.') }}đ"
                                                            data-img-url="{{ $variants[0]->image_url }}">
                                                            @if (!empty($variants[0]->image_url))
                                                                <img src="{{ \Storage::url($variants[0]->image_url) }}"
                                                                    alt="{{ $mauSac }}" width="35px" height="35px"
                                                                    style="margin-right: 5px;">
                                                            @else
                                                                <img src="{{ \Storage::url($product->image_url) }}"
                                                                    alt="No Image" width="35px" height="35px"
                                                                    style="margin-right: 5px;">
                                                            @endif
                                                            {{ $mauSac }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                            @endif


                                        </div>
                                    </div>

                                    <div id="error-message" style="color: red;"></div>

                                    <p class="stock in-stock">
                                        Thương hiệu:
                                        <span>{{ $product->brand ? $product->brand->name : 'Không có' }}</span>
                                    </p>

                                    <div class="kobolg-product-details__short-description">
                                        <p>{{ $product->tomtat }}</p>
                                    </div>

                                    <form class="variations_form cart">
                                        <div class="single_variation_wrap">
                                            <div class="kobolg-variation single_variation"></div>
                                            <div class="kobolg-variation-add-to-cart variations_button">
                                                <div class="quantity">
                                                    <span class="qty-label">Số lượng:</span>
                                                    <div class="control">
                                                        <a class="btn-number qtyminus quantity-minus" href="#">-</a>
                                                        <input type="text" data-step="1" min="0" max=""
                                                            name="quantity[25]" value="1" title="Qty"
                                                            class="input-qty input-text qty text" size="4"
                                                            pattern="[0-9]*" inputmode="numeric">
                                                        <a class="btn-number qtyplus quantity-plus" href="#">+</a>
                                                    </div>
                                                </div>
                                                <button type="submit" id="add-to-cart"
                                                    class="single_add_to_cart_button button alt kobolg-variation-selection-needed">
                                                    Thêm vào giỏ hàng
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="yith-wcwl-add-to-wishlist">
                                        <div class="yith-wcwl-add-button show">
                                            <a href="#" rel="nofollow" data-product-id="27"
                                                data-product-type="variable" class="add_to_wishlist">
                                                Thêm vào danh sách yêu thích</a>
                                        </div>
                                    </div>

                                    <div class="clear"></div>
                                    <a href="#" class="compare button" data-product_id="27" rel="nofollow">So
                                        sánh</a>

                                    <div class="product_meta">
                                        <span class="sku_wrapper">SKU: <span
                                                class="sku">{{ $product->sku }}</span></span>
                                        <span class="posted_in">Danh mục:
                                            <a href="#"
                                                rel="tag">{{ $product->catalogue ? $product->catalogue->name : 'Không có' }}</a>
                                        </span>
                                    </div>

                                    <div class="kobolg-share-socials">
                                        <h5 class="social-heading">Chia sẻ:</h5>
                                        <a target="_blank" class="facebook" href="#">
                                            <i class="fa fa-facebook-f"></i>
                                        </a>
                                        <a target="_blank" class="twitter" href="#"><i
                                                class="fa fa-twitter"></i></a>
                                        <a target="_blank" class="pinterest" href="#"> <i
                                                class="fa fa-pinterest"></i></a>
                                        <a target="_blank" class="googleplus" href="#"><i
                                                class="fa fa-google-plus"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="kobolg-tabs kobolg-tabs-wrapper">
                            <ul class="tabs dreaming-tabs" role="tablist">
                                <li class="description_tab active" id="tab-title-description" role="tab"
                                    aria-controls="tab-description">
                                    <a href="#tab-description">Mô tả</a>
                                </li>
                                <li class="additional_information_tab" id="tab-title-additional_information"
                                    role="tab" aria-controls="tab-additional_information">
                                    <a href="#tab-additional_information">Bình luận
                                        ({{ $product->comments->count() }})</a>
                                </li>
                                <li class="reviews_tab" id="tab-title-reviews" role="tab"
                                    aria-controls="tab-reviews">
                                    <a href="#tab-reviews">Đánh giá (0)</a>
                                </li>
                            </ul>
                            <div class="kobolg-Tabs-panel kobolg-Tabs-panel--description panel entry-content kobolg-tab"
                                id="tab-description" role="tabpanel" aria-labelledby="tab-title-description">
                                <h2 class="text-center">Mô tả</h2>
                                <div class="col-md-6 mx-auto">
                                    <div id="description-content" class="content-collapsed">
                                        {!! $product->description !!}
                                    </div>
                                    <a id="toggle-link" class="toggle-link" href="javascript:void(0);"
                                        style="display: none;">
                                        <i class="fa fa-chevron-down toggle-icon"></i> Xem thêm nội dung
                                    </a>
                                </div>
                            </div>


                            <style>
                                /* Thu gọn nội dung */
                                .content-collapsed {
                                    max-height: 100px;
                                    /* Chiều cao ban đầu */
                                    overflow: hidden;
                                    position: relative;
                                    transition: max-height 0.3s ease;
                                }

                                /* Nội dung mở rộng */
                                .content-expanded {
                                    max-height: none;
                                    /* Hiển thị toàn bộ */
                                }

                                /* Link "Xem thêm" */
                                .toggle-link {
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    margin-top: 10px;
                                    font-weight: bold;
                                    color: #007bff;
                                    /* Màu sắc liên kết */
                                    cursor: pointer;
                                    text-decoration: none;
                                }

                                .toggle-icon {
                                    margin-right: 5px;
                                    transition: transform 0.3s ease;
                                    /* Hiệu ứng chuyển động của mũi tên */
                                }

                                .icon-up {
                                    transform: rotate(180deg);
                                    /* Mũi tên hướng lên */
                                }
                            </style>

                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    var content = document.getElementById("description-content");
                                    var toggleLink = document.getElementById("toggle-link");
                                    var icon = toggleLink.querySelector(".toggle-icon");

                                    // Kiểm tra nếu nội dung vượt quá giới hạn chiều cao
                                    if (content.scrollHeight > content.clientHeight) {
                                        toggleLink.style.display = "inline-flex"; // Hiển thị link "Xem thêm"
                                    }

                                    // Thêm sự kiện click cho link "Xem thêm"
                                    toggleLink.addEventListener("click", function() {
                                        if (content.classList.contains("content-collapsed")) {
                                            content.classList.remove("content-collapsed");
                                            content.classList.add("content-expanded");
                                            icon.classList.add("icon-up"); // Xoay mũi tên hướng lên
                                            this.innerHTML = '<i class="fa fa-chevron-up toggle-icon"></i> Thu gọn nội dung';
                                        } else {
                                            content.classList.remove("content-expanded");
                                            content.classList.add("content-collapsed");
                                            icon.classList.remove("icon-up"); // Mũi tên trở lại hướng xuống
                                            this.innerHTML = '<i class="fa fa-chevron-down toggle-icon"></i> Xem thêm nội dung';
                                        }
                                    });
                                });
                            </script>


                            <div class="kobolg-Tabs-panel kobolg-Tabs-panel--additional_information panel entry-content kobolg-tab"
                                id="tab-additional_information" role="tabpanel"
                                aria-labelledby="tab-title-additional_information">

                                <h2>Bình luận ({{ $product->comments->count() }})</h2>

                                <!-- Hiển thị danh sách bình luận -->
                                <div class="comments-section">
                                    @foreach ($product->comments as $comment)
                                        <div class="comment">
                                            <!-- Hiển thị tên người dùng và ngày đăng bình luận -->
                                            <p><strong>{{ $comment->user->name }}</strong>
                                                <span>{{ $comment->created_at->format('d/m/Y') }}</span>
                                            </p>

                                            <!-- Nội dung bình luận -->
                                            <div id="comment-content-{{ $comment->id }}">
                                                <p>{{ $comment->comment }}</p>
                                            </div>

                                            <!-- Nút menu thả xuống -->

                                            @if ($comment->user_id == Auth::id())
                                                <!-- Nút menu thả xuống -->
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle"
                                                        onclick="toggleDropdown({{ $comment->id }})" type="button"
                                                        id="dropdownMenuButton{{ $comment->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu" id="customDropdown-{{ $comment->id }}"
                                                        style="display:none;"
                                                        aria-labelledby="dropdownMenuButton{{ $comment->id }}">
                                                        <button class="dropdown-item"
                                                            onclick="toggleEditForm({{ $comment->id }})">Sửa</button>
                                                        <form
                                                            action="{{ route('client.deleteComment', [$product->id, $comment->id]) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="dropdown-item" type="submit"
                                                                onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này không?')">Xóa</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Form chỉnh sửa bình luận ẩn -->
                                            <div id="edit-comment-form-{{ $comment->id }}" style="display: none;">
                                                <form
                                                    action="{{ route('client.updateComment', [$product->id, $comment->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <textarea name="comment" required>{{ $comment->comment }}</textarea>
                                                    <button type="submit">Lưu thay đổi</button>
                                                    <button type="button"
                                                        onclick="toggleEditForm({{ $comment->id }})">Hủy</button>
                                                </form>
                                            </div>

                                            <!-- Hiển thị các phản hồi -->
                                            @foreach ($comment->replies as $reply)
                                                <div class="reply">
                                                    <p><strong>{{ $reply->user->name }}</strong>
                                                        <span>{{ $reply->created_at->format('d/m/Y') }}</span>
                                                    </p>

                                                    <div id="reply-content-{{ $reply->id }}">
                                                        <p>{{ $reply->reply }}</p>
                                                    </div>

                                                    <!-- Nút menu thả xuống cho phản hồi -->
                                                    @if ($reply->user_id == Auth::id())
                                                        <!-- Nút menu thả xuống cho phản hồi -->
                                                        <div class="dropdown">
                                                            <button class=" dropdown-toggle"
                                                                onclick="toggleDropdownReply({{ $reply->id }})"
                                                                type="button"
                                                                id="dropdownMenuButtonReply{{ $reply->id }}"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                            </button>
                                                            <div class="dropdown-menu"
                                                                id="customDropdownReply-{{ $reply->id }}"
                                                                style="display:none;"
                                                                aria-labelledby="dropdownMenuButtonReply{{ $reply->id }}">
                                                                <button class="dropdown-item"
                                                                    onclick="toggleEditFormReply({{ $reply->id }})">Sửa</button>
                                                                <form
                                                                    action="{{ route('client.deleteReply', [$comment->id, $reply->id]) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="dropdown-item" type="submit"
                                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa phản hồi này không?')">Xóa</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <!-- Form chỉnh sửa phản hồi ẩn -->
                                                    <div id="edit-reply-form-{{ $reply->id }}" style="display: none;">
                                                        <form
                                                            action="{{ route('client.updateReply', [$comment->id, $reply->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <textarea name="reply" required>{{ $reply->reply }}</textarea>
                                                            <button type="submit">Lưu thay đổi</button>
                                                            <button type="button"
                                                                onclick="toggleEditFormReply({{ $reply->id }})">Hủy</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <!-- Form thêm phản hồi -->
                                            @auth
                                                <form action="{{ route('client.storeReply', $comment->id) }}" method="POST">
                                                    @csrf
                                                    <textarea name="reply" required placeholder="Phản hồi của bạn"></textarea>
                                                    <button type="submit" class="tbnsend"> <img
                                                            src="{{ asset('theme/client/assets/images/send.png') }}"
                                                            width="39px" alt=""></button>
                                                </form>
                                            @endauth
                                        </div>
                                    @endforeach

                                    <!-- Form thêm bình luận -->
                                    @auth
                                        <form action="{{ route('client.storeComment', $product->id) }}" method="POST">
                                            @csrf
                                            <textarea name="comment" required placeholder="Bình luận của bạn"></textarea>
                                            <button type="submit" class="tbnsend"> <img
                                                    src="{{ asset('theme/client/assets/images/send.png') }}" width="39px"
                                                    alt=""></button>
                                        </form>
                                    @endauth
                                </div>

                                <!-- JavaScript để bật tắt form chỉnh sửa -->
                                <script>
                                    function toggleDropdown(commentId) {
                                        var dropdown = document.getElementById("customDropdown-" + commentId);
                                        if (dropdown.style.display === "none") {
                                            dropdown.style.display = "block";
                                        } else {
                                            dropdown.style.display = "none";
                                        }
                                    }

                                    function toggleDropdownReply(replyId) {
                                        var dropdown = document.getElementById("customDropdownReply-" + replyId);
                                        if (dropdown.style.display === "none") {
                                            dropdown.style.display = "block";
                                        } else {
                                            dropdown.style.display = "none";
                                        }
                                    }


                                    function toggleEditForm(commentId) {
                                        var content = document.getElementById('comment-content-' + commentId);
                                        var form = document.getElementById('edit-comment-form-' + commentId);
                                        if (form.style.display === "none") {
                                            form.style.display = "block";
                                            content.style.display = "none";
                                        } else {
                                            form.style.display = "none";
                                            content.style.display = "block";
                                        }
                                    }

                                    function toggleEditFormReply(replyId) {
                                        var content = document.getElementById('reply-content-' + replyId);
                                        var form = document.getElementById('edit-reply-form-' + replyId);
                                        if (form.style.display === "none") {
                                            form.style.display = "block";
                                            content.style.display = "none";
                                        } else {
                                            form.style.display = "none";
                                            content.style.display = "block";
                                        }
                                    }
                                </script>
                            </div>
                            <div class="kobolg-Tabs-panel kobolg-Tabs-panel--reviews panel entry-content kobolg-tab"
                                id="tab-reviews" role="tabpanel" aria-labelledby="tab-title-reviews">
                                <div id="reviews" class="kobolg-Reviews col-md-6 mx-auto">
                                    <div id="comments">
                                        <h2 class="kobolg-Reviews-title">Đánh giá</h2>
                                        <p class="kobolg-noreviews">Chưa có đánh giá nào</p>
                                    </div>
                                    <div id="review_form_wrapper">
                                        <div id="review_form">
                                            <div id="respond" class="comment-respond">
                                                <span id="reply-title" class="comment-reply-title">
                                                    Hãy là người đầu tiên đánh giá</span>
                                                <form id="commentform" class="comment-form">
                                                    <p class="comment-notes"><span id="email-notes">Địa chỉ email của bạn
                                                            sẽ không được công bố.</span>
                                                        Các trường bắt buộc được đánh dấu <span class="required">*</span>
                                                    </p>
                                                    <p class="comment-form-author">
                                                        <label for="author">Name&nbsp;<span
                                                                class="required">*</span></label>
                                                        <input id="author" name="author" value=""
                                                            size="30" required="" type="text">
                                                    </p>
                                                    <p class="comment-form-email"><label for="email">Email&nbsp;
                                                            <span class="required">*</span></label>
                                                        <input id="email" name="email" value=""
                                                            size="30" required="" type="email">
                                                    </p>
                                                    <div class="comment-form-rating"><label for="rating">Đánh
                                                            giá</label>
                                                        <p class="stars">
                                                            <span>
                                                                <a class="star-1" href="#">1</a>
                                                                <a class="star-2" href="#">2</a>
                                                                <a class="star-3" href="#">3</a>
                                                                <a class="star-4" href="#">4</a>
                                                                <a class="star-5" href="#">5</a>
                                                            </span>
                                                        </p>
                                                        <select title="product_cat" name="rating" id="rating"
                                                            required="" style="display: none;">
                                                            <option value="">Rate…</option>
                                                            <option value="5">Perfect</option>
                                                            <option value="4">Good</option>
                                                            <option value="3">Average</option>
                                                            <option value="2">Not that bad</option>
                                                            <option value="1">Very poor</option>
                                                        </select>
                                                    </div>
                                                    <p class="comment-form-comment"><label for="comment">Đánh giá của
                                                            bạn&nbsp;<span class="required">*</span></label>
                                                        <textarea id="comment" name="comment" cols="45" rows="8" required=""></textarea>
                                                    </p><input name="wpml_language_code" value="en" type="hidden">
                                                    <p class="form-submit"><input name="submit" id="submit"
                                                            class="submit" value="Đánh Giá" type="submit"> <input
                                                            name="comment_post_ID" value="27" id="comment_post_ID"
                                                            type="hidden">
                                                        <input name="comment_parent" id="comment_parent" value="0"
                                                            type="hidden">
                                                    </p>
                                                </form>
                                            </div><!-- #respond -->
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-12 col-sm-12 dreaming_related-product">
                    <div class="block-title">
                        <h2 class="product-grid-title">
                            <span>Related Products</span>
                        </h2>
                    </div>
                    <div class="owl-slick owl-products equal-container better-height"
                        data-slick="{&quot;arrows&quot;:false,&quot;slidesMargin&quot;:30,&quot;dots&quot;:true,&quot;infinite&quot;:false,&quot;slidesToShow&quot;:4}"
                        data-responsive="[{&quot;breakpoint&quot;:480,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:768,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:992,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1500,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;30&quot;}}]">
                        <div
                            class="product-item style-01 post-27 product type-product status-publish has-post-thumbnail product_cat-table product_cat-new-arrivals product_cat-lamp product_tag-table product_tag-sock  instock shipping-taxable purchasable product-type-variable has-default-attributes ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="0">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro101-1-600x778.jpg') }}"
                                            alt="Mac 27 Inch" width="600" height="778">
                                    </a>
                                    <div class="flash"><span class="onnew"><span class="text">New</span></span></div>
                                    <div class="group-button">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button show">
                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                            </div>
                                        </div>
                                        <div class="kobolg product compare-button">
                                            <a href="#" class="compare button">Compare</a>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button">Quick View</a>
                                        <div class="add-to-cart">
                                            <a href="#" class="button product_type_variable add_to_cart_button">Add
                                                to
                                                cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="0">Mac 27 Inch</a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>60.00</span></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="product-item style-01 post-30 product type-product status-publish has-post-thumbnail product_cat-light product_cat-bed product_cat-specials product_tag-light product_tag-table product_tag-sock last instock featured downloadable shipping-taxable purchasable product-type-simple  ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="0">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro41-1-600x778.jpg') }}"
                                            alt="White Watches" width="600" height="778">
                                    </a>
                                    <div class="flash">
                                        <span class="onnew"><span class="text">New</span></span>
                                    </div>
                                    <div class="group-button">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button show">
                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                            </div>
                                        </div>
                                        <div class="kobolg product compare-button">
                                            <a href="#" class="compare button">Compare</a>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button">Quick View</a>
                                        <div class="add-to-cart">
                                            <a href="#" class="button product_type_variable add_to_cart_button">Add
                                                to
                                                cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="0">White Watches</a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>134.00</span></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="product-item style-01 post-35 product type-product status-publish has-post-thumbnail product_cat-chair product_cat-new-arrivals product_cat-lamp product_tag-light product_tag-hat product_tag-sock first instock shipping-taxable purchasable product-type-simple  ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="0">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro151-1-600x778.jpg') }}"
                                            alt="Cellphone Factory" width="600" height="778">
                                    </a>
                                    <div class="flash">
                                        <span class="onsale"><span class="number">-11%</span></span>
                                        <span class="onnew"><span class="text">New</span></span>
                                    </div>
                                    <div class="group-button">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button show">
                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                            </div>
                                        </div>
                                        <div class="kobolg product compare-button">
                                            <a href="#" class="compare button">Compare</a>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button">Quick View</a>
                                        <div class="add-to-cart">
                                            <a href="#" class="button product_type_variable add_to_cart_button">Add
                                                to
                                                cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="0">Cellphone Factory</a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><del><span class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>89.00</span></del>
                                        <ins><span class="kobolg-Price-amount amount"><span
                                                    class="kobolg-Price-currencySymbol">$</span>79.00</span></ins></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="product-item style-01 post-25 product type-product status-publish has-post-thumbnail product_cat-light product_cat-chair product_cat-specials product_tag-light product_tag-sock  instock sale featured shipping-taxable purchasable product-type-simple ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="-1">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro13-1-600x778.jpg') }}"
                                            alt="Meta Watches                                                "
                                            width="600" height="778">
                                    </a>
                                    <div class="flash">
                                        <span class="onnew"><span class="text">New</span></span>
                                    </div>
                                    <div class="group-button">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button show">
                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                            </div>
                                        </div>
                                        <div class="kobolg product compare-button">
                                            <a href="#" class="compare button">Compare</a>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button">Quick View</a>
                                        <div class="add-to-cart">
                                            <a href="#" class="button product_type_variable add_to_cart_button">Add
                                                to
                                                cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="-1">Meta Watches </a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>109.00</span></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="product-item style-01 post-93 product type-product status-publish has-post-thumbnail product_cat-light product_cat-table product_cat-new-arrivals product_tag-table product_tag-sock last instock shipping-taxable purchasable product-type-simple ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="-1">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro181-2-600x778.jpg') }}"
                                            alt="Red Mouse" width="600" height="778">
                                    </a>
                                    <div class="flash">
                                        <span class="onnew"><span class="text">New</span></span>
                                    </div>
                                    <div class="group-button">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button show">
                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                            </div>
                                        </div>
                                        <div class="kobolg product compare-button">
                                            <a href="#" class="compare button">Compare</a>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button">Quick View</a>
                                        <div class="add-to-cart">
                                            <a href="#" class="button product_type_variable add_to_cart_button">Add
                                                to
                                                cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="-1">City
                                            life jumpers</a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>98.00</span></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="product-item style-01 post-22 product type-product status-publish has-post-thumbnail product_cat-table product_cat-bed product_cat-lamp product_tag-table product_tag-hat product_tag-sock first instock featured downloadable shipping-taxable purchasable product-type-simple ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="-1">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro171-1-600x778.jpg') }}"
                                            alt="Photo Camera" width="600" height="778">
                                    </a>
                                    <div class="flash">
                                        <span class="onnew"><span class="text">New</span></span>
                                    </div>
                                    <form class="variations_form cart">
                                        <table class="variations">
                                            <tbody>
                                                <tr>
                                                    <td class="value">
                                                        <select title="box_style" data-attributetype="box_style"
                                                            data-id="pa_color" class="attribute-select "
                                                            name="attribute_pa_color"
                                                            data-attribute_name="attribute_pa_color"
                                                            data-show_option_none="yes" tabindex="-1">
                                                            <option data-type="" data-pa_color="" value="">Choose
                                                                an
                                                                option
                                                            </option>
                                                            <option data-width="30" data-height="30" data-type="color"
                                                                data-pa_color="#ff63cb" value="pink"
                                                                class="attached enabled">Pink
                                                            </option>
                                                            <option data-width="30" data-height="30" data-type="color"
                                                                data-pa_color="#a825ea" value="purple"
                                                                class="attached enabled">Purple
                                                            </option>
                                                            <option data-width="30" data-height="30" data-type="color"
                                                                data-pa_color="#db2b00" value="red"
                                                                class="attached enabled">Red
                                                            </option>
                                                        </select>
                                                        <div class="data-val attribute-pa_color"
                                                            data-attributetype="box_style"><a class="change-value color"
                                                                href="#" style="background: #ff63cb;"
                                                                data-value="pink"></a><a class="change-value color"
                                                                href="#" style="background: #a825ea;"
                                                                data-value="purple"></a><a class="change-value color"
                                                                href="#" style="background: #db2b00;"
                                                                data-value="red"></a></div>
                                                        <a class="reset_variations" href="#" tabindex="-1"
                                                            style="visibility: hidden;">Clear</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                    <div class="group-button">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button show">
                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                            </div>
                                        </div>
                                        <div class="kobolg product compare-button">
                                            <a href="#" class="compare button">Compare</a>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button">Quick View</a>
                                        <div class="add-to-cart">
                                            <a href="#"
                                                class="button product_type_variable add_to_cart_button">Select
                                                options</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="-1">Photo Camera</a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>105.00</span> – <span
                                            class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>110.00</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 kobolg_dreaming_upsell-product">
                    <div class="block-title">
                        <h2 class="product-grid-title">
                            <span>Upsell Products</span>
                        </h2>
                    </div>
                    <div class="owl-slick owl-products equal-container better-height"
                        data-slick="{&quot;arrows&quot;:false,&quot;slidesMargin&quot;:30,&quot;dots&quot;:true,&quot;infinite&quot;:false,&quot;slidesToShow&quot;:4}"
                        data-responsive="[{&quot;breakpoint&quot;:480,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:768,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:992,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1500,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;30&quot;}}]">
                        <div
                            class="product-item style-01 post-27 product type-product status-publish has-post-thumbnail product_cat-table product_cat-new-arrivals product_cat-lamp product_tag-table product_tag-sock  instock shipping-taxable purchasable product-type-variable has-default-attributes ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="0">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro141-1-600x778.jpg') }}"
                                            alt="Smart Monitor" width="600" height="778">
                                    </a>
                                    <div class="flash">
                                        <span class="onnew"><span class="text">New</span></span>
                                    </div>
                                    <div class="group-button">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button show">
                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                            </div>
                                        </div>
                                        <div class="kobolg product compare-button">
                                            <a href="#" class="compare button">Compare</a>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button">Quick View</a>
                                        <div class="add-to-cart">
                                            <a href="#" class="button product_type_external add_to_cart_button">Buy
                                                it on Amazon</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="0">Dining Accessories</a>
                                    </h3>
                                    <div class="rating-wapper ">
                                        <div class="star-rating"><span style="width:100%">Rated <strong
                                                    class="rating">5.00</strong> out of 5</span></div>
                                        <span class="review">(1)</span>
                                    </div>
                                    <span class="price"><span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>207.00</span></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="product-item style-01 post-26 product type-product status-publish has-post-thumbnail product_cat-light product_cat-chair product_cat-sofas product_tag-light product_tag-hat last instock featured shipping-taxable product-type-external  ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="0">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro31-1-600x778.jpg') }}"
                                            alt="Blue Smartphone" width="600" height="778">
                                    </a>
                                    <div class="flash">
                                        <span class="onnew"><span class="text">New</span></span>
                                    </div>
                                    <div class="group-button">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button show">
                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                            </div>
                                        </div>
                                        <div class="kobolg product compare-button">
                                            <a href="#" class="compare button">Compare</a>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button">Quick View</a>
                                        <div class="add-to-cart">
                                            <a href="#" class="button product_type_simple add_to_cart_button">Add to
                                                cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="0">Blue Smartphone</a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>120.00</span></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="product-item style-01 post-37 product type-product status-publish has-post-thumbnail product_cat-chair product_cat-bed product_tag-light product_tag-hat product_tag-sock first instock shipping-taxable purchasable product-type-simple  ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link kobolg-product-gallery__image" href="#" tabindex="0">
                                        <img class="img-responsive wp-post-image"
                                            src="{{ asset('theme/client/assets/images/apro83-1-600x778.jpg') }}"
                                            alt="Glasses – Red" width="600" height="778">
                                    </a>
                                    <div class="flash">
                                        <span class="onnew"><span class="text">New</span></span>
                                    </div>
                                    <div class="group-button">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button show">
                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                            </div>
                                        </div>
                                        <div class="kobolg product compare-button">
                                            <a href="#" class="compare button">Compare</a>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button">Quick View</a>
                                        <div class="add-to-cart">
                                            <a href="#" class="button product_type_simple add_to_cart_button">Add to
                                                cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="0">Glasses – Red</a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>56.00</span></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="product-item style-01 post-1194 product_variation type-product_variation status-publish has-post-thumbnail product  instock shipping-taxable purchasable product-type-variation ">
                            <div class="product-inner tooltip-left">
                                <div class="product-thumb">
                                    <a class="thumb-link" href="#" tabindex="-1">
                                        <img class="img-responsive"
                                            src="{{ asset('theme/client/assets/images/apro302-600x778.jpg') }}"
                                            alt="Circle Watches" width="600" height="778">
                                    </a>
                                    <div class="flash">
                                        <span class="onnew"><span class="text">New</span></span>
                                    </div>
                                    <div class="group-button">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button show">
                                                <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                            </div>
                                        </div>
                                        <div class="kobolg product compare-button">
                                            <a href="#" class="compare button">Compare</a>
                                        </div>
                                        <a href="#" class="button yith-wcqv-button">Quick View</a>
                                        <div class="add-to-cart">
                                            <a href="#" class="button product_type_simple add_to_cart_button">Add to
                                                cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info equal-elem">
                                    <h3 class="product-name product_title">
                                        <a href="#" tabindex="-1">Circle Watches</a>
                                    </h3>
                                    <div class="rating-wapper nostar">
                                        <div class="star-rating"><span style="width:0%">Rated <strong
                                                    class="rating">0</strong> out of 5</span></div>
                                        <span class="review">(0)</span>
                                    </div>
                                    <span class="price"><span class="kobolg-Price-amount amount"><span
                                                class="kobolg-Price-currencySymbol">$</span>79.00</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let selectedStorage = null;
        let selectedColor = null;
        let selectedSize = null;
        let selectedStorageButton = null;
        let selectedColorButton = null;
        let selectedSizeButton = null;

        // Giá gốc của sản phẩm (giá cơ bản)
        const originalPrice = parseFloat("{{ $product->price }}");
        const priceElement = document.getElementById('product-price');

        // Lấy danh sách biến thể từ PHP (dung lượng, màu sắc, kích thước và giá tương ứng)
        const variants = {!! json_encode(
            $product->variants->map(function ($variant) {
                return [
                    'price' => $variant->price,
                    'attributes' => $variant->attributeValues->map(function ($attributeValue) {
                        return [
                            'name' => $attributeValue->attribute->name,
                            'value' => $attributeValue->name,
                        ];
                    }),
                ];
            }),
        ) !!};

        // Hiển thị giá
        function updatePrice() {
            let totalPrice = originalPrice;
            let minPrice = originalPrice; // Giá tối thiểu khởi tạo là giá gốc
            let maxPrice = originalPrice; // Giá tối đa khởi tạo là giá gốc
            let isVariantSelected = false;

            // Nếu không có biến thể nào
            if (variants.length === 0) {
                priceElement.innerHTML = new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(originalPrice);
                return;
            }

            // Tính toán giá tối thiểu và tối đa từ danh sách biến thể
            variants.forEach(variant => {
                const variantPrice = variant.price;
                if (variantPrice < minPrice) {
                    minPrice = variantPrice; // Cập nhật giá tối thiểu
                }
                if (variantPrice > maxPrice) {
                    maxPrice = variantPrice; // Cập nhật giá tối đa
                }
            });

            // Tìm biến thể lưu trữ được chọn và cộng giá nếu có
            if (selectedStorage) {
                const foundStorageVariant = variants.find(variant =>
                    variant.attributes.some(attr => attr.name === 'Storage' && attr.value ===
                        selectedStorage)
                );
                if (foundStorageVariant) {
                    totalPrice += foundStorageVariant.price - originalPrice; // Cộng thêm giá biến thể lưu trữ
                    isVariantSelected = true;
                }
            }

            // Tìm biến thể màu sắc được chọn và cộng giá nếu có
            if (selectedColor) {
                const foundColorVariant = variants.find(variant =>
                    variant.attributes.some(attr => attr.name === 'Color' && attr.value === selectedColor)
                );
                if (foundColorVariant) {
                    totalPrice += foundColorVariant.price - originalPrice; // Cộng thêm giá biến thể màu sắc
                    isVariantSelected = true;
                }
            }

            // Tìm biến thể kích thước được chọn và cộng giá nếu có
            if (selectedSize) {
                const foundSizeVariant = variants.find(variant =>
                    variant.attributes.some(attr => attr.name === 'Size' && attr.value === selectedSize)
                );
                if (foundSizeVariant) {
                    totalPrice += foundSizeVariant.price - originalPrice; // Cộng thêm giá biến thể kích thước
                    isVariantSelected = true;
                }
            }

            // Hiển thị giá
            if (!isVariantSelected && minPrice === maxPrice) {
                // Nếu không có biến thể được chọn và giá min = max, hiển thị giá đơn lẻ
                priceElement.innerHTML = new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(originalPrice);
            } else if (!isVariantSelected) {
                // Nếu không có biến thể được chọn, hiển thị giá min và max
                priceElement.innerHTML = `${new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(minPrice)} - ${new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(maxPrice)}`;
            } else {
                // Nếu có biến thể được chọn, hiển thị giá tổng
                priceElement.innerHTML = new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(totalPrice);
            }
        }


        // Sử dụng event delegation để lắng nghe sự kiện click
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('variant-btn')) {
                const storage = event.target.getAttribute('data-dung-luong');
                const color = event.target.getAttribute('data-mau-sac');
                const size = event.target.getAttribute('data-size');

                // Kiểm tra nếu là nút dung lượng
                if (storage) {
                    if (selectedStorage === storage) {
                        resetButton(selectedStorageButton);
                        selectedStorage = null;
                        selectedStorageButton = null;
                    } else {
                        if (selectedStorageButton) resetButton(selectedStorageButton);
                        selectedStorage = storage;
                        selectedStorageButton = event.target;
                        selectButton(selectedStorageButton);
                    }
                }

                // Kiểm tra nếu là nút màu sắc
                if (color) {
                    if (selectedColor === color) {
                        resetButton(selectedColorButton);
                        selectedColor = null;
                        selectedColorButton = null;
                    } else {
                        if (selectedColorButton) resetButton(selectedColorButton);
                        selectedColor = color;
                        selectedColorButton = event.target;
                        selectButton(selectedColorButton);
                    }
                }

                // Kiểm tra nếu là nút kích thước
                if (size) {
                    if (selectedSize === size) {
                        resetButton(selectedSizeButton);
                        selectedSize = null;
                        selectedSizeButton = null;
                    } else {
                        if (selectedSizeButton) resetButton(selectedSizeButton);
                        selectedSize = size;
                        selectedSizeButton = event.target;
                        selectButton(selectedSizeButton);
                    }
                }

                // Cập nhật giá dựa trên các lựa chọn hiện tại
                updatePrice();
            }
        });

        // Hàm để đặt lại trạng thái của nút về mặc định
        function resetButton(button) {
            if (button) {
                button.style.backgroundColor = 'white'; // Màu nền trắng
                button.style.border = '1px solid black'; // Viền đen
            }
        }

        // Hàm để cập nhật trạng thái của nút khi được chọn
        function selectButton(button) {
            if (button) {
                button.style.backgroundColor = 'white'; // Màu nền trắng
                button.style.border = '2px solid red'; // Viền đỏ
            }
        }

        // Hiển thị giá gốc khi trang được tải
        updatePrice();
    });

    // Giỏ hàng
    $(document).ready(function() {
        let selectedVariantId = null;
        let isSingleProduct = {{ $product->variants->isEmpty() ? 'true' : 'false' }};
        let productId = "{{ $product->id }}";

        // Khi người dùng chọn dung lượng hoặc màu sắc (có biến thể)
        $('.attribute-group .variant-btn').on('click', function() {
            selectedVariantId = $(this).data('variant-id');
            $('.variant-btn').removeClass('selected');
            $(this).addClass('selected');
        });

        // Xử lý sự kiện thêm vào giỏ hàng
        $('#add-to-cart').on('click', function() {
            let data = {
                _token: '{{ csrf_token() }}',
                quantity: 1 // Số lượng mặc định là 1
            };

            if (isSingleProduct) {
                // Nếu sản phẩm không có biến thể
                data.product_id = productId;
            } else {
                // Nếu sản phẩm có biến thể, kiểm tra xem có chọn biến thể hay chưa
                if (!selectedVariantId) {
                    alert('Vui lòng chọn dung lượng hoặc màu sắc.');
                    return;
                }
                data.variant_id = selectedVariantId;
            }

            $.ajax({
                url: '/cart/add', // Route xử lý trong Laravel
                method: 'POST',
                data: data,
                success: function(response) {
                    alert('Sản phẩm đã được thêm vào giỏ hàng.');
                    updateCartCount(response.cart_count);
                },
                error: function(xhr) {
                    alert('Có lỗi xảy ra khi thêm vào giỏ hàng. Vui lòng thử lại.');
                }
            });
        });

        // Hàm cập nhật số lượng giỏ hàng (nếu có)
        function updateCartCount(count) {
            $('#cart-count').text(count);
        }
    });

    console.log(data); // Thêm dòng này để kiểm tra dữ liệu
</script>

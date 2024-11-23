@extends('client.master')

@section('title', 'Lịch Sử Đơn Hàng')

@section('content')

    @include('components.breadcrumb-client2')

    <div class="container mt-5">

        @if ($orders->isEmpty())
            <p class="text-center">Bạn chưa có đơn hàng nào.</p>
        @else
            @php
                $statusClasses = [
                    'processing' => 'bg-primary',
                    'shipped' => 'bg-info',
                    'canceled' => 'bg-danger',
                    'refunded' => 'bg-warning',
                    'Delivering' => 'bg-secondary',
                    'delivered' => 'bg-success',
                ];

                $statusLabels = [
                    'processing' => 'Đang Xử Lý',
                    'shipped' => 'Đã Gửi',
                    'canceled' => 'Đã Hủy',
                    'refunded' => 'Đã Hoàn Tiền',
                    'Delivering' => 'Đang Giao',
                    'delivered' => 'Đã Giao',
                ];
            @endphp

            <div class="orders">
                @foreach ($orders as $order)
                    @php
                        $statusClass = $statusClasses[$order->status] ?? 'bg-primary';
                        $statusLabel = $statusLabels[$order->status] ?? 'Không Xác Định';
                    @endphp
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <!-- Thông tin người mua -->
                                <div class="col-md-3 mb-2">
                                    <h4>Thông Tin Khách Hàng</h4>
                                    <p><strong>Người Mua:</strong> {{ $order->user->name }}</p>
                                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                                    <p><strong>Địa Chỉ:</strong> {{ $order->user->address }}</p>
                                    <p><strong>Số Điện Thoại:</strong> {{ $order->user->phone ?? 'Chưa có thông tin' }}</p>
                                    <p><strong>Ngày Đặt Hàng:</strong>
                                        {{ $order->created_at ? $order->created_at->format('d/m/Y') : 'N/A' }}
                                    </p>
                                </div>

                                <!-- Chi tiết sản phẩm -->
                                <div class="col-md-4 mb-2">
                                    <h4>Thông Tin Sản Phẩm</h4>
                                    @foreach ($order->items as $item)
                                        <div>
                                            <strong>{{ $item->productVariant->product->name }}</strong>
                                            <small class="text-muted">(Mã SP: {{ $item->productVariant->id }})</small>
                                        </div>
                                        <ul>
                                            <li>Số Lượng: {{ $item->quantity }}</li>
                                            <li>Giá: {{ number_format($item->price, 0, ',', '.') }} VND</li>
                                            <li>Thương Hiệu: {{ $item->productVariant->product->brand->name }}</li>
                                        </ul>

                                        <!-- Thuộc tính của sản phẩm -->
                                        @if (isset($order->groupedVariantAttributes[$item->product_variant_id]))
                                            <div class="mt-1">
                                                <strong>Thuộc Tính:</strong>
                                                <ul class="mb-0">
                                                    @foreach ($order->groupedVariantAttributes[$item->product_variant_id] as $attribute)
                                                        <li>{{ $attribute->attribute_name }}:
                                                            {{ $attribute->attribute_value }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @else
                                            Không có Thuộc Tính nào.
                                        @endif
                                    @endforeach
                                </div>

                                <!-- Hiển thị ảnh sản phẩm -->
                                <div class="col-md-2 mb-2">
                                    <h4>Ảnh Sản Phẩm</h4>
                                    @if ($item->productVariant->product->image_url && \Storage::exists($item->productVariant->product->image_url))
                                        <img src="{{ \Storage::url($item->productVariant->product->image_url) }}"
                                            alt="{{ $item->productVariant->product->name }}"
                                            style="max-width: 130px; height: auto;">
                                    @else
                                        Không có ảnh
                                    @endif
                                </div>

                                <!-- Thông tin tổng tiền và trạng thái -->
                                <div class="col-md-3 mb-2">
                                    <h4>Tổng Cộng</h4>
                                    <p><strong>Tổng Tiền Đơn Hàng:</strong>
                                        <span class="text-success fw-bold">
                                            {{ number_format($order->items_sum_total, 0, ',', '.') }} VND
                                        </span>
                                    </p>
                                    <p><strong>Trạng Thái:</strong>
                                        <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                                    </p>
                                    <p><strong>Trạng thái thanh toán:</strong>
                                        @if ($order->payment_status === 'pending')
                                            <span class="badge rounded-pill bg-warning">Chưa thanh toán</span>
                                        @elseif ($order->payment_status === 'paid')
                                            <span class="badge rounded-pill bg-success">Đã thanh toán</span>
                                        @elseif ($order->payment_status === 'failed')
                                            <span class="badge rounded-pill bg-danger">Thanh toán thất bại</span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary">Không rõ</span>
                                        @endif
                                    </p>
                                </div>
                            </div>


                        </div>
                    </div>
                @endforeach


            </div>
        @endif
    </div>

    <style>
        .custom-file-upload {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        .custom-file-upload:hover {
            background-color: #0056b3;
        }

        .custom-file-input {
            display: none;
        }

        .image-preview-container {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
        }

        .image-preview-container img {
            margin: 5px;
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // Hiển thị/ẩn form hủy đơn hàng
            $('.cancelOrderButton').click(function() {
                var $form = $(this).siblings('.cancelOrderForm');
                $form.toggle(); // Ẩn hoặc hiện form
                // Đóng tất cả các accordion khác nếu form đang mở
                if ($form.is(':visible')) {
                    $('.cancelOrderForm').not($form).hide(); // Ẩn các form khác
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Khi nhấn nút "Trả Hàng/Hoàn Tiền"
            $('.refundOrderButton').on('click', function() {
                var $form = $(this).siblings('.refundOrderForm'); // Lấy form liên quan đến nút nhấn
                var isVisible = $form.is(':visible'); // Kiểm tra form hiện tại có đang hiển thị không

                // Đóng tất cả các form trả hàng/hoàn tiền khác
                $('.refundOrderForm').not($form).slideUp();

                // Ẩn hoặc hiển thị form hiện tại
                if (isVisible) {
                    $form.slideUp(); // Ẩn form nếu nó đang hiển thị
                } else {
                    $form.slideDown(); // Hiển thị form nếu nó đang ẩn
                }
            });
        });
    </script>

    <script>
        document.getElementById('refund_image').addEventListener('change', function(event) {
            var files = event.target.files;
            var previewContainer = document.getElementById('imagePreview');
            previewContainer.innerHTML = ''; // Xóa preview cũ trước khi hiển thị mới

            // Kiểm tra từng file và tạo preview
            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    previewContainer.appendChild(imgElement); // Thêm ảnh vào container
                };

                reader.readAsDataURL(files[i]); // Đọc tệp hình ảnh
            }
        });
    </script>



@endsection

@if ($order->status === 'shipped' && !$order->refund_reason)
                                <!-- Nếu đơn hàng đã được giao và chưa có lý do trả hàng -->
                                <button class="btn btn-warning refundOrderButton">Trả Hàng/Hoàn Tiền</button>
                                <div class="refundOrderForm" style="display: none; margin-top: 20px;">
                                    <form action="{{ route('orders.refund', $order->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')

                                        <div class="form-group">
                                            <label for="refund_reason">Lý do trả hàng/hoàn tiền:</label>
                                            <textarea name="refund_reason" id="refund_reason" rows="4" class="form-control" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="refund_image">Hình ảnh minh họa (chọn nhiều hình):</label>
                                            <label for="refund_image" class="custom-file-upload">Chọn Hình Ảnh</label>
                                            <input type="file" name="refund_image[]" id="refund_image"
                                                class="custom-file-input" accept="image/*" multiple required>
                                        </div>

                                        <!-- Preview các hình ảnh đã chọn -->
                                        <div class="image-preview-container" id="imagePreview"></div>


                                        <button type="submit" class="btn btn-warning">Xác Nhận</button>
                                    </form>

                                </div>
                            @endif



                            @if (!in_array($order->status, ['Delivering', 'shipped', 'refunded', 'canceled']))
                                <button class="btn btn-danger cancelOrderButton">Hủy Đơn Hàng</button>
                                <div class="cancelOrderForm" style="display: none; margin-top: 20px;">
                                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <div class="form-group">
                                            <label for="cancellation_reason">Lý do hủy:</label>
                                            <textarea name="cancellation_reason" id="cancellation_reason" rows="4" class="form-control" required></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-danger">Xác Nhận Hủy</button>
                                    </form>
                                </div>
                            @endif

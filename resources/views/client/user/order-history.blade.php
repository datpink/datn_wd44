@extends('client.master')

@section('title', 'Lịch Sử Đơn Hàng')

@section('content')
    <div class="container">
        <h1 class="text-center mb-5">Lịch Sử Đơn Hàng</h1>

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

            <div class="accordion" id="orderAccordion">
                @foreach ($orders as $order)
                    @php
                        $statusClass = $statusClasses[$order->status] ?? 'bg-primary';
                        $statusLabel = $statusLabels[$order->status] ?? 'Không Xác Định';
                    @endphp

                    <div class="card mb-4">
                        <div class="card-header {{ $statusClass }}" id="heading{{ $order->id }}"
                            style="border-color: {{ $statusClass }}; background-color: {{ $statusClass }};">
                            <h5>
                                <span style="color: #000; font-weight: bold">Mã Đơn Hàng: #{{ $order->id }}</span>
                            </h5>
                        </div>

                        <div class="card-body">
                            <p><strong>Ngày Đặt Hàng:</strong>
                                {{ $order->created_at ? $order->created_at->format('d/m/Y') : 'N/A' }}</p>
                            <p><strong>Trạng Thái:</strong>
                                <span class="badge {{ $statusClass }} text-white">{{ $statusLabel }}</span>
                            </p>
                            <p><strong>Tổng Tiền:</strong> {{ number_format($order->items_sum_total, 0, ',', '.') }} VND</p>

                            <a href="{{ route('order.detail', $order->id) }}" class="btn btn-secondary">
                                @if ($order->status === 'canceled')
                                    Xem Chi Tiết Đơn Hủy
                                @elseif ($order->status === 'refunded')
                                    Xem Chi Tiết Đơn Hàng Đã Hoàn Trả
                                @else
                                    Xem Chi Tiết
                                @endif
                            </a>

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

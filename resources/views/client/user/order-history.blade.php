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
                    'pending_confirmation' => 'bg-primary', // Chờ xác nhận
                    'pending_pickup' => 'bg-secondary', // Chờ lấy hàng
                    'pending_delivery' => 'bg-success', // Chờ giao hàng (sử dụng lớp Bootstrap có sẵn)
                    'delivered' => 'bg-warning', // Đã giao hàng (sử dụng lớp Bootstrap có sẵn)
                    'confirm_delivered' => 'bg-info', // Đã xác nhận giao hàng
                    'canceled' => 'bg-dark', // Đã hủy
                    'returned' => 'bg-light', // Trả hàng
                ];

                $statusLabels = [
                    'pending_confirmation' => 'Chờ xác nhận', // Chờ xác nhận
                    'pending_pickup' => 'Chờ lấy hàng', // Chờ lấy hàng
                    'pending_delivery' => 'Chờ giao hàng', // Chờ giao hàng
                    'delivered' => 'Đã nhận hàng', // Đã giao hàng
                    'confirm_delivered' => 'Đã giao hàng', // Đã giao hàng
                    'canceled' => 'Đã hủy', // Đã hủy
                    'returned' => 'Trả hàng', // Trả hàng
                ];

            @endphp

            <div class="orders">
                @foreach ($orders as $order)
                    @php
                        $statusClass = $statusClasses[$order->status] ?? 'bg-white';
                        $statusLabel = $statusLabels[$order->status] ?? 'Không Xác Định';
                    @endphp
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <!-- Thông tin người mua -->
                                <div class="col-md-4 mb-3">
                                    <div class="">
                                        <div class="card-header">
                                            <h4>Thông Tin Khách Hàng</h4>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Người Mua:</strong> {{ $order->user->name }}</p>
                                            <p><strong>Email:</strong> {{ $order->user->email }}</p>
                                            <p><strong>Địa Chỉ:</strong> {{ $order->shipping_address }}</p>
                                            <p><strong>Số Điện Thoại:</strong> {{ $order->phone_number }}</p>
                                            @if ($order->created_at)
                                                <p><strong>Ngày Đặt Hàng:</strong> {{ $order->created_at }}</p>
                                            @endif

                                            @if ($order->delivered_at)
                                                <p><strong>Ngày Giao Hàng:</strong>
                                                    {{ \Carbon\Carbon::parse($order->delivered_at)->format('d/m/Y H:i') }}
                                                </p>
                                            @endif

                                            @if ($order->canceled_at)
                                                <p><strong>Ngày Hủy:</strong>
                                                    {{ \Carbon\Carbon::parse($order->canceled_at)->format('d/m/Y H:i') }}
                                                </p>
                                            @endif

                                            @if ($order->refund_at)
                                                <p><strong>Ngày Hoàn Trả:</strong>
                                                    {{ \Carbon\Carbon::parse($order->refund_at)->format('d/m/Y H:i') }}</p>
                                            @endif


                                        </div>
                                    </div>
                                </div>

                                <!-- Chi Tiết Sản Phẩm -->
                                <div class="col-md-5 mb-3">
                                    <div class="">
                                        <div class="card-header">
                                            <h4>Chi Tiết Sản Phẩm</h4>
                                        </div>
                                        <div class="card-body" id="productDetails"
                                            style="max-height: 350px; overflow-y: auto;">
                                            @foreach ($order->items as $item)
                                                <div class="row border p-2 mb-2 align-items-center">
                                                    <!-- Cột ảnh sản phẩm -->
                                                    <div class="col-md-4 text-center">
                                                        @if (
                                                            $item->product_variant_id &&
                                                                $item->productVariant->product->image_url &&
                                                                \Storage::exists($item->productVariant->product->image_url))
                                                            <img src="{{ \Storage::url($item->productVariant->product->image_url) }}"
                                                                alt="{{ $item->productVariant->product->name }}"
                                                                style="max-width: 100%; height: auto; object-fit: cover; border-radius: 5px;">
                                                        @elseif ($item->product && $item->product->image_url && \Storage::exists($item->product->image_url))
                                                            <img src="{{ \Storage::url($item->product->image_url) }}"
                                                                alt="{{ $item->product->name }}"
                                                                style="max-width: 100%; height: auto; object-fit: cover; border-radius: 5px;">
                                                        @else
                                                            <div class="d-flex align-items-center justify-content-center"
                                                                style="height: 150px; background-color: #f8f9fa; border-radius: 5px;">
                                                                Không có ảnh
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <!-- Cột thông tin sản phẩm -->
                                                    <div class="col-md-8">
                                                        <strong>
                                                            @if ($item->product_variant_id)
                                                                {{ $item->productVariant->product->name }}
                                                            @else
                                                                {{ $item->product->name }}
                                                            @endif
                                                        </strong>
                                                        <small class="text-muted">
                                                            @if ($item->product_variant_id)
                                                                (Mã SP: {{ $item->productVariant->id }})
                                                            @else
                                                                (Mã SP: {{ $item->product->id }})
                                                            @endif
                                                        </small>
                                                        <ul class="mt-2">
                                                            <li>Số Lượng: {{ $item->quantity }}</li>
                                                            <li>Giá: {{ number_format($item->price, 0, ',', '.') }} VND
                                                            </li>
                                                            <li>Thương Hiệu:
                                                                @if ($item->product_variant_id && $item->productVariant->product->brand)
                                                                    {{ $item->productVariant->product->brand->name }}
                                                                @elseif ($item->product && $item->product->brand)
                                                                    {{ $item->product->brand->name }}
                                                                @else
                                                                    Không xác định
                                                                @endif
                                                            </li>
                                                        </ul>
                                                        <!-- Thuộc tính sản phẩm -->
                                                        @if ($item->product_variant_id && isset($order->groupedVariantAttributes[$item->product_variant_id]))
                                                            <div>
                                                                <strong>Thuộc Tính:</strong>
                                                                <ul>
                                                                    @foreach ($order->groupedVariantAttributes[$item->product_variant_id] as $attribute)
                                                                        <li>{{ $attribute->attribute_name }}:
                                                                            {{ $attribute->attribute_value }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @else
                                                            <small>Không có thuộc tính nào.</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Thông tin tổng tiền và trạng thái -->
                                <div class="col-md-3 mb-3">
                                    <div class="">
                                        <div class="card-header">
                                            <h4>Tổng Cộng</h4>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Tổng Tiền Đơn Hàng:</strong>
                                                <span
                                                    class="text-success fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }}
                                                    VND (Bao gồm phí ship)</span>
                                            </p>
                                            <p><strong>Trạng Thái:</strong>
                                                <span
                                                    class="badge {{ $statusClass }} text-white">{{ $statusLabel }}</span>
                                            </p>
                                            <p><strong>Trạng thái thanh toán:</strong>
                                                @if ($order->payment_status === 'unpaid')
                                                    <span class="badge rounded-pill bg-warning text-white">Chưa thanh
                                                        toán</span>
                                                @elseif ($order->payment_status === 'paid')
                                                    <span class="badge rounded-pill bg-success text-white">Đã thanh
                                                        toán</span>
                                                    {{-- @elseif ($order->payment_status === 'payment_failed')
                                                    <span class="badge rounded-pill bg-danger text-white">Thanh toán thất
                                                        bại</span> --}}
                                                @elseif ($order->payment_status === 'refunded')
                                                    <!-- Thêm trạng thái trả hàng -->
                                                    <span class="badge rounded-pill bg-secondary text-white">Trả hàng</span>
                                                @else
                                                    <span class="badge rounded-pill bg-warning text-white">Không rõ</span>
                                                @endif
                                            </p>

                                            <div class="card-body" id="productDetails"
                                                style="max-height: 200px; overflow-y: auto;">
                                                <!-- Lý do hủy đơn -->
                                                @if ($order->cancellation_reason)
                                                    <div class="mb-3">
                                                        <strong>Lý do hủy đơn:</strong>
                                                        <p class="m-0">{{ $order->cancellation_reason }}</p>
                                                    </div>
                                                @endif

                                                <!-- Lý Do Trả Hàng và Hình Ảnh Minh Họa -->
                                                @if ($order->status === 'returned' && $order->refund_images)
                                                    <div class="mb-3">
                                                        <strong>Lý Do Trả Hàng:</strong>
                                                        <p class="m-0">{{ $order->refund_reason }}</p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Hình Ảnh Minh Họa:</strong>
                                                        <div>
                                                            @foreach (json_decode($order->refund_images) as $image)
                                                                <img src="{{ Storage::url($image) }}" alt="Refund Image"
                                                                    class="img-thumbnail"
                                                                    style="max-width: 50px; margin: 5px;">
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- Hình ảnh chứng minh -->
                                                @if ($order->status === 'returned' && $order->proof_image)
                                                    <div class="mb-3">
                                                        <strong>Hình ảnh chứng minh:</strong>
                                                        <div>
                                                            <img src="{{ Storage::url($order->proof_image) }}"
                                                                alt="Proof Image" class="img-fluid"
                                                                style="max-width: 150px;">
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- Lời nhắn từ Admin -->
                                                @if ($order->admin_message)
                                                    <div class="mb-3">
                                                        <strong>Lời nhắn từ Admin:</strong>
                                                        <p>{{ $order->admin_message }}</p>
                                                    </div>
                                                @endif
                                            </div>


                                            @if ($order->admin_status === 'pending' && $order->refund_reason)
                                                <p class="text-warning">
                                                    Yêu cầu hoàn trả của bạn đang được xử lý. Vui lòng chờ phê duyệt từ quản
                                                    trị viên.
                                                </p>
                                            @elseif ($order->admin_status === 'approved')
                                                <p class="text-success">
                                                    Yêu cầu hoàn trả của bạn đã được chấp nhận. Vui lòng kiểm tra thông tin
                                                    hoàn tiền.
                                                </p>
                                            @elseif ($order->admin_status === 'rejected')
                                                <p class="text-danger">
                                                    Yêu cầu hoàn trả của bạn đã bị từ chối. Vui lòng liên hệ hỗ trợ để biết
                                                    thêm chi tiết.
                                                </p>
                                            @endif


                                        </div>
                                    </div>
                                </div>
                            </div>


                            @if ($order->status === 'delivered' && !$order->refund_reason && $order->admin_status !== 'rejected')
                                <!-- Nếu đơn hàng đã được giao và chưa có lý do trả hàng -->
                                <button class="btn btn-warning refundOrderButton" data-order-id="{{ $order->id }}">Trả
                                    Hàng/Hoàn Tiền</button>
                                <div class="refundOrderForm" id="refundForm-{{ $order->id }}"
                                    style="display: none; margin-top: 20px;">
                                    <form action="{{ route('orders.refund', $order->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')

                                        <div class="form-group">
                                            <label for="refund_reason_{{ $order->id }}">Lý do trả hàng/hoàn
                                                tiền:</label>
                                            <textarea name="refund_reason" id="refund_reason_{{ $order->id }}" rows="4" class="form-control" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="refund_image_{{ $order->id }}">Hình ảnh minh họa (chọn nhiều
                                                hình):</label>
                                            <input type="file" name="refund_image[]"
                                                id="refund_image_{{ $order->id }}" class="custom-file-input"
                                                accept="image/*" multiple required>
                                        </div>

                                        <!-- Preview các hình ảnh đã chọn -->
                                        <div class="image-preview-container" id="imagePreview-{{ $order->id }}"></div>

                                        <div class="form-group">
                                            <label for="refund_method_{{ $order->id }}">Phương thức hoàn tiền:</label>
                                            <select name="refund_method" id="refund_method_{{ $order->id }}"
                                                class="form-control" required>
                                                <option value=""></option>
                                                {{-- <option value="cash">Tiền mặt</option> --}}
                                                <option value="store_credit">Thanh Toán Chuyển Khoản</option>
                                                {{-- <option value="exchange">Đổi sản phẩm</option> --}}
                                            </select>
                                        </div>

                                        <!-- Các trường hiển thị khi chọn phương thức Store Credit -->
                                        <div id="storeCreditFields-{{ $order->id }}" style="display: none;">
                                            <div class="form-group">
                                                <label for="qr_code_{{ $order->id }}">Tải QR (Chỉ chọn hình
                                                    ảnh):</label>
                                                <input type="file" name="qr_code" id="qr_code_{{ $order->id }}"
                                                    class="custom-file-input" accept="image/*">
                                            </div>
                                            <div class="image-preview-container" id="qrPreview-{{ $order->id }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="account_number_{{ $order->id }}">Nhập số tài khoản:</label>
                                                <input type="text" name="account_number"
                                                    id="account_number_{{ $order->id }}" class="form-control"
                                                    placeholder="Số tài khoản">
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-warning">Xác Nhận</button>
                                    </form>
                                </div>
                            @endif




                            @if (!in_array($order->status, ['pending_delivery', 'returned', 'delivered', 'confirm_delivered', 'canceled']))
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

                            @if ($order->status === 'pending_delivery')
                                <!-- Nút xác nhận đã nhận hàng -->
                                <button class="btn btn-success confirmReceivedButton" id="confirmReceivedButton"
                                    data-order-id="{{ $order->id }}">
                                    Xác nhận đã nhận hàng
                                </button>
                            @endif

                            @if ($order->status === 'confirm_delivered')
                                <!-- Nút xác nhận giao hàng -->
                                <button class="btn btn-success confirmReceivedButton" id="confirmReceivedButton"
                                    data-order-id="{{ $order->id }}">
                                    Xác nhận đã nhận hàng
                                </button>
                            @endif



                        </div>
                    </div>
                @endforeach


            </div>
        @endif
    </div>

    <style>
        .image-preview-container img {
            max-width: 150px;
            /* Giới hạn kích thước ảnh */
            margin: 5px;
            /* Khoảng cách giữa các ảnh */
            border: 1px solid #ddd;
            padding: 5px;
        }

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
            // Khi nhấn nút "Trả Hàng/Hoàn Tiền"
            $('.refundOrderButton').on('click', function() {
                var orderId = $(this).data('order-id'); // Lấy ID đơn hàng
                var $form = $('#refundForm-' + orderId); // Lấy form liên quan đến đơn hàng
                var isVisible = $form.is(':visible'); // Kiểm tra form có đang hiển thị không

                // Đóng tất cả các form khác
                $('.refundOrderForm').not($form).slideUp();

                // Hiển thị hoặc ẩn form hiện tại
                if (isVisible) {
                    $form.slideUp();
                } else {
                    $form.slideDown();
                }
            });

            $(document).ready(function() {
                // Xử lý preview hình ảnh minh họa
                $(document).on('change', 'input[type="file"]', function() {
                    var inputId = $(this).attr('id'); // Lấy ID input
                    var previewContainer;

                    if (inputId.startsWith('qr_code')) {
                        // Nếu là trường QR Code
                        previewContainer = $('#qrPreview-' + inputId.split('_')[2]);
                    } else {
                        // Nếu là trường hình ảnh minh họa
                        previewContainer = $('#imagePreview-' + inputId.split('_')[2]);
                    }

                    previewContainer.html(''); // Xóa preview cũ

                    Array.from(this.files).forEach(file => {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            var imgElement = $('<img>').attr('src', e.target.result)
                                .css({
                                    maxWidth: '100px',
                                    margin: '5px'
                                });
                            previewContainer.append(
                            imgElement); // Thêm ảnh vào container
                        };

                        reader.readAsDataURL(file); // Đọc file
                    });
                });
            });


            // Xử lý hiển thị các trường khi chọn Store Credit
            $(document).on('change', 'select[name="refund_method"]', function() {
                var selectId = $(this).attr('id');
                var orderId = selectId.split('_')[2]; // Lấy ID đơn hàng
                var storeCreditFields = $('#storeCreditFields-' + orderId);

                if ($(this).val() === 'store_credit') {
                    storeCreditFields.show();
                } else {
                    storeCreditFields.hide();
                }
            });
        });
    </script>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Lấy tất cả các nút có class confirmReceivedButton
            const confirmReceivedButtons = document.querySelectorAll('.confirmReceivedButton');

            // Duyệt qua tất cả các nút và gán sự kiện click
            confirmReceivedButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Lấy ID đơn hàng từ thuộc tính data-order-id của nút được nhấn
                    const orderId = this.getAttribute('data-order-id');

                    // Hiển thị hộp thoại xác nhận với SweetAlert2
                    Swal.fire({
                        title: 'Xác nhận đã nhận hàng?',
                        text: "Bạn có chắc chắn rằng bạn đã nhận hàng này không?",
                        icon: 'question',
                        position: "top",
                        toast: true,
                        showCancelButton: true,
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        timerProgressBar: true,
                        timer: 3500
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log("Yêu cầu PATCH gửi đi với ID: " + orderId);

                            // Gửi yêu cầu PATCH để cập nhật trạng thái đơn hàng
                            fetch(`/shop/orders/${orderId}/confirm-delivered`, {
                                    method: 'PATCH',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content'),
                                    },
                                    body: JSON.stringify({
                                        // Truyền thêm dữ liệu nếu cần thiết
                                    }),
                                })
                                .then(response => response.json())
                                .then(data => {
                                    console.log("Phản hồi từ server:", data);

                                    if (data.success) {
                                        Swal.fire({
                                            position: "top",
                                            toast: true,
                                            icon: 'success',
                                            title: 'Đơn hàng đã được xác nhận!',
                                            showConfirmButton: false,
                                            timerProgressBar: true,
                                            timer: 3500
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire({
                                            position: "top",
                                            toast: true,
                                            icon: 'error',
                                            title: 'Có lỗi xảy ra!',
                                            showConfirmButton: false,
                                            timerProgressBar: true,
                                            timer: 3500
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error("Lỗi khi gửi yêu cầu:", error);
                                    Swal.fire({
                                        position: "top",
                                        toast: true,
                                        icon: 'error',
                                        title: 'Đã xảy ra lỗi khi cập nhật!',
                                        showConfirmButton: false,
                                        timerProgressBar: true,
                                        timer: 3500
                                    });
                                });
                        }
                    });
                });
            });
        });
    </script>



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

@endsection

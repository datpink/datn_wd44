@extends('admin.master')

@section('title', 'Giảm Giá Cho Sản Phẩm')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('content')
<style>
    /* Overlay làm tối giao diện */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        /* Màu tối */
        display: none;
        /* Ẩn mặc định */
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    /* Box xác nhận */
    .confirmation-box {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .confirmation-box button {
        margin: 10px;
    }

    /* Overlay */
    #confirmation-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        /* Màu nền mờ */
        display: none;
        /* Mặc định ẩn overlay */
        justify-content: center;
        /* Căn giữa theo chiều ngang */
        align-items: center;
        /* Căn giữa theo chiều dọc */
        z-index: 1000;
        /* Đảm bảo overlay luôn hiển thị phía trên */
    }

    /* Box chứa nội dung */
    .confirmation-box {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 500px;
        /* Độ rộng box */
    }
</style>
<div class="">
    <h4>Áp Dụng Giảm Giá
        @if ($discount->type === "percentage")
        {{ number_format($discount->discount_value,  0, ',', '.') }} %
        @else
        {{ number_format($discount->discount_value, 0, ',', '.') }} ₫
        @endif
        cho các sản phẩm
    </h4>
    <form method="GET" action="{{ route('products.apply', ['discountId' => $discount->id]) }}" class="mb-3">
        <div class="row g-2">
            <!-- Lọc theo tên sản phẩm -->
            <div class="col-auto">
                <input type="text" name="name" class="form-control form-control-sm" placeholder="Tên sản phẩm" value="{{ request('name') }}">
            </div>

            <!-- Lọc theo danh mục -->
            <div class="col-auto">
                <select name="catalogue_id" class="form-select form-select-sm">
                    <option value="">Tất cả danh mục</option>
                    @foreach ($catalogues as $catalogue)
                    <option value="{{ $catalogue->id }}" {{ request('catalogue_id') == $catalogue->id ? 'selected' : '' }}>
                        {{ $catalogue->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Nút tìm kiếm -->
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary">Lọc</button>
            </div>

            <!-- Nút xóa lọc -->
            <div class="col-auto">
                <a href="{{ route('products.apply', ['discountId' => $discount->id]) }}" class="btn btn-sm btn-warning">Xóa lọc</a>
            </div>
        </div class="col-auto">
        <div>
            <a href="{{ route('discounts.index') }}" class="btn rounded-pill btn-secondary">
                <i class="bi bi-arrow-left me-2"></i> Trở về
            </a>
        </div>
    </form>

</div>
<form action="{{ route('discount.applyToProducts', ['discountId' => $discount->id]) }}" method="POST">
    @csrf




    <table class="table">
        <thead>
            <tr>
                <th>
                    <!-- Checkbox "Chọn tất cả" -->
                    <input type="checkbox" id="select-all" onclick="toggleSelectAll(this)">
                    Chọn tất cả
                </th>
                <th>Tên sản phẩm</th>
                <th>Hình Ảnh</th>
                <th>Giá gốc</th>
                <th>Giảm giá</th>
                <th>Thời gian giảm giá</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr onclick="toggleCheckbox(event, {{ $product->id }})" style="cursor: pointer;">
                <td>
                    <input type="checkbox"
                        name="product_ids[]"
                        value="{{ $product->id }}"
                        id="checkbox-{{ $product->id }}"
                        @if($product->discounts->isNotEmpty()) checked @endif
                    > <!-- Đánh dấu checked nếu đã có giảm giá -->
                </td>
                <td>{{ $product->name }}</td>
                <td>
                    @if ($product->image_url && \Storage::exists($product->image_url))
                    <img src="{{ \Storage::url($product->image_url) }}"
                        alt="{{ $product->name }}" style="max-width: 100px; height: auto;">
                    @else
                    Không có ảnh
                    @endif
                </td>
                <td class="price-cell">{{ number_format($product->price, 0, ',', '.') }}₫</td>
                <td class="discount-price-cell">
                    {{ $product->discount_price ? number_format($product->discount_price, 0, ',', '.') : '-' }}₫
                </td>
                <td class="discount-time-cell">
                    @if (isset($product->remaining_time))
                    <span class="badge bg-info">{{ $product->remaining_time }}</span>
                    @else
                    <span class="badge bg-warning">Chưa áp dụng giảm giá</span>
                    @endif
                </td>
                <td class="status-cell">
                    @if ($product->status)
                    @if ($product->status['type'] === 'percentage')
                    <span class="badge bg-success">
                        Đang giảm giá {{ number_format($product->status['value'], 0, ',', '.') }} %
                    </span>
                    @else
                    <span class="badge bg-success">
                        Đã giảm giá {{ number_format($product->status['value'], 0, ',', '.') }} VND
                    </span>
                    @endif
                    @else
                    <span class="badge bg-warning ">Chưa giảm giá</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="fixed-bottom bg-light py-2 shadow" style="height: 60px;">
        <div class="container text-end">
            <button type="submit" class="btn btn-success me-2">Áp dụng giảm giá</button>
            <button type="button" id="cancel-discount-button" class="btn btn-danger">Hủy giảm giá</button>
        </div>
    </div>

</form>

<!-- Form hủy giảm giá -->
<form id="cancel-discount-form" method="POST" action="{{ route('discounts.remove', ['discountId' => $discount->id]) }}">
    @csrf
    <input type="hidden" name="discount_id" value="{{ $discount->id }}">
    <div id="product-ids-container"></div> <!-- Thêm các input hidden ở đây -->
</form>
<!-- Thẻ xác nhận hủy giảm giá (ẩn ban đầu) -->
<div id="confirmation-overlay" class="overlay" style="display:none;">
    <div class="confirmation-box" style="width:500px;">
        <h3>Bạn thực sự muốn hủy giảm giá cho <span id="selected-product-count">0</span> sản phẩm này?</h3>
        <button id="confirm-cancel" class="btn btn-success">Đồng ý</button>
        <button id="cancel-cancel" class="btn btn-danger">Hủy</button>
    </div>
</div>

<script>
    // Hàm chọn hoặc bỏ chọn tất cả checkbox
    function toggleSelectAll(selectAllCheckbox) {
        // Lấy tất cả các checkbox sản phẩm
        const checkboxes = document.querySelectorAll('input[name="product_ids[]"]');

        // Lặp qua tất cả checkbox và thay đổi trạng thái theo checkbox "Chọn tất cả"
        checkboxes.forEach((checkbox) => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    }

    // Hàm toggle checkbox khi click vào hàng
    function toggleCheckbox(event, productId) {
        // Ngăn chặn hành động mặc định nếu click vào checkbox
        if (event.target.tagName === 'INPUT') {
            return; // Nếu click trực tiếp vào checkbox thì không xử lý
        }

        // Lấy checkbox tương ứng với productId
        const checkbox = document.getElementById(`checkbox-${productId}`);

        // Đổi trạng thái của checkbox (checked <=> unchecked)
        checkbox.checked = !checkbox.checked;
    }
    document.getElementById('cancel-discount-button').addEventListener('click', function() {
        var selectedProducts = []; // Lấy các sản phẩm đã chọn để hủy giảm giá
        document.querySelectorAll('input[name="product_ids[]"]:checked').forEach(function(checkbox) {
            selectedProducts.push(checkbox.value);
        });

        if (selectedProducts.length === 0) {
            alert('Vui lòng chọn sản phẩm cần hủy giảm giá.');
            return;
        }
        // Hiển thị số lượng sản phẩm trong overlay
        document.getElementById('selected-product-count').textContent = selectedProducts.length;
        // Hiển thị thẻ xác nhận
        document.getElementById('confirmation-overlay').style.display = 'flex';

        // Xử lý khi nhấn đồng ý
        document.getElementById('confirm-cancel').onclick = function() {
            const form = document.getElementById('cancel-discount-form');
            const productIdsContainer = document.getElementById('product-ids-container'); // Thêm một thẻ div trong form

            // Kiểm tra phần tử product-ids-container có tồn tại không
            if (productIdsContainer) {
                // Xóa các input hidden cũ để tránh dữ liệu trùng lặp
                productIdsContainer.innerHTML = '';

                // Tạo input hidden cho từng sản phẩm
                selectedProducts.forEach(productId => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'product_ids[]'; // Laravel nhận key này dưới dạng mảng
                    input.value = productId;
                    productIdsContainer.appendChild(input);
                });

                // Submit form
                form.submit();
            } else {
                console.error('Không tìm thấy phần tử product-ids-container.');
            }
        };

        // Xử lý khi nhấn hủy
        document.getElementById('cancel-cancel').addEventListener('click', function() {
            document.getElementById('confirmation-overlay').style.display = 'none';
        });
    });
</script>


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        // Xóa bộ lọc
        $('#filterRemove').click(function() {
            $('input[name="name"]').val(''); // Reset ô input "Tên sản phẩm"
            $('select[name="catalogue_id"]').val(''); // Reset dropdown "Danh mục"
            $(this).closest('form').submit(); // Submit form
        });
    });
    @if(session('success') || session('error'))
    Swal.fire({
        position: "top",
        icon: "{{ session('success') ? 'success' : 'error' }}",
        title: "{{ session('success') ?? session('error') }}",
        showConfirmButton: false,
        timerProgressBar: true,
        timer: "{{ session('success') ? 5000 : 5000 }}"
    });
    @endif
</script>
@endsection


@endsection
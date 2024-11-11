<style>
    .single_variation_wrap {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .quantity {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .control {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .qty-label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
    }

    /* Nút Thêm vào giỏ hàng */
    .button.alt {
        padding: 10px 15px;
        font-size: 14px;
    }

    /* Nút Mua ngay với màu nền đỏ giống Shopee */
    .button.buy-now {
        background-color: #ff424e;
        /* Màu đỏ Shopee */
        color: white;
        font-weight: bold;
        border: none;
        padding: 10px 15px;
        font-size: 14px;
        cursor: pointer;
    }

    .button.buy-now:hover {
        background-color: #e60023;
        /* Màu đỏ đậm hơn khi hover */
    }

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

    .review-item {
        border: 1px solid #fff2f4f7;
        /* Đường viền màu */
        border-radius: 8px;
        /* Bo tròn góc */
        padding: 15px;
        /* Khoảng cách bên trong */
        margin-bottom: 10px;
        /* Khoảng cách giữa các review */
        background-color: #f9f9f9;
        /* Màu nền cho khối review */
    }

    .response {
        border: 1px solid #fff2f4f7;
        /* Đường viền màu */
        border-radius: 8px;
        /* Bo tròn góc */
        padding: 10px;
        /* Khoảng cách bên trong */
        margin-left: 30px;
        margin-bottom: 10px;

        /* Khoảng cách giữa phản hồi và review */
        background-color: #f1f1f1;
        /* Màu nền cho khối response */
    }

    .error {
        background-color: rgb(252, 225, 225);

        border: 1px solid red;
        color: rgb(255, 0, 0);
        padding: 5px 5px;
        cursor: pointer;

    }
</style>

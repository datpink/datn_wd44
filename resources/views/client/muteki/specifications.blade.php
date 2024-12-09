<div class="kobolg-Tabs-panel kobolg-Tabs-panel--additional_information panel entry-content kobolg-tab"
    id="tab-additional_information" role="tabpanel" aria-labelledby="tab-title-additional_information">
    <h2>Thông số kĩ thuật</h2>
    <div class="col-md-6 mx-auto">
        <div id="specifications-content" class="content-collapsed">
            {!! $product->specifications !!}
        </div>
        <a id="specifications-toggle" class="toggle-link" href="javascript:void(0);" style="display: none;">
            <i class="fa fa-chevron-down toggle-icon"></i> Xem thêm thông số
        </a>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var content = document.getElementById("specifications-content");
        var toggleLink = document.getElementById("specifications-toggle");

        // Kiểm tra nếu nội dung vượt quá giới hạn chiều cao
        if (content.scrollHeight > content.clientHeight) {
            toggleLink.style.display = "inline-flex"; // Hiển thị link "Xem thêm"
        }

        // Thêm sự kiện click cho link "Xem thêm"
        toggleLink.addEventListener("click", function() {
            if (content.classList.contains("content-collapsed")) {
                content.classList.remove("content-collapsed");
                content.classList.add("content-expanded");
                this.innerHTML = '<i class="fa fa-chevron-up toggle-icon"></i> Thu gọn thông số';
            } else {
                content.classList.remove("content-expanded");
                content.classList.add("content-collapsed");
                this.innerHTML = '<i class="fa fa-chevron-down toggle-icon"></i> Xem thêm thông số';
            }
        });
    });
</script>

<style>
    #specifications-content {
        max-height: 100px;
        /* Giới hạn chiều cao khi nội dung bị thu gọn */
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    #specifications-content.content-expanded {
        max-height: none;
        /* Hiển thị đầy đủ nội dung khi mở rộng */
    }

    .toggle-link {
        display: inline-flex;
        align-items: center;
        font-size: 14px;
        margin-top: 10px;
        color: #007bff;
        cursor: pointer;
        text-decoration: none;
    }

    .toggle-link:hover {
        text-decoration: underline;
        text-decoration: none;
    }

    .toggle-icon {
        margin-right: 5px;
    }
</style>

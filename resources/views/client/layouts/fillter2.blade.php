<div class="shop-control shop-before-control">
    <div class="grid-view-mode">
        <form>
            <a href="shop.html" data-toggle="tooltip" data-placement="top" class="modes-mode mode-grid display-mode "
                value="grid">
                <span class="button-inner">
                    Shop Grid
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <a href="shop-list.html" data-toggle="tooltip" data-placement="top"
                class="modes-mode mode-list display-mode active" value="list">
                <span class="button-inner">
                    Shop List
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
        </form>
    </div>
    <form class="kobolg-ordering" method="get" id="orderingForm" action="">
        <select title="product_cat" name="orderby" class="orderby">
            <option value="price-latest">Sản phẩm mới nhất</option>
            <option value="price-asc">Sắp xếp theo giá: từ thấp đến cao</option>
            <option value="price-desc">Sắp xếp theo giá: từ cao đến thấp</option>
        </select>
    </form>

    <script>
        $(document).ready(function() {
            $(".orderby").change(function() {
                const orderby = $(this).val(); // Lấy giá trị đã chọn
                console.log(orderby);

                // Gửi yêu cầu AJAX với Axios
                axios.get('/api/shop/products', {
                        params: { // Sử dụng params để gửi các tham số
                            orderby: orderby
                        }
                    })
                    .then((res) => {
                        console.log(res); // Kiểm tra dữ liệu nhận được
                        $('#item-product').html(''); // Xóa danh sách cũ

                        // Lấy dữ liệu sản phẩm từ phản hồi
                        const products = res.data.data.data; // Dữ liệu sản phẩm
                        // console.log(products.data);

                        // Kiểm tra nếu products là mảng
                        if (Array.isArray(products)) {
                            // Tạo HTML cho từng sản phẩm
                            let productHtml = ''; // Khởi tạo biến chứa HTML sản phẩm
                            products.forEach(product => {
                                productHtml += `
                                    <li class="product-item wow fadeInUp product-item list col-md-12 post-${product.id} product type-product status-publish has-post-thumbnail"
                                        data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                                        <div class="product-inner images">
                                            <div class="product-thumb">
                                                    <a class="thumb-link" href="#">
                                                        ${product.image_url ? `<img class="img-responsive" src="${product.image_url}" alt="${product.name}" width="600" height="778">` : 'Không có ảnh'}
                                                    </a>
                                                <div class="flash">
                                                    ${product.condition === 'new' ? '<span class="onsale"><span class="number">-18%</span></span>' : '<span class="onnew"><span class="text">New</span></span>'}
                                                </div>
                                                <a href="#" class="button yith-wcqv-button" data-product_id="${product.id}">Quick View</a>
                                            </div>
                                            <div class="product-info">
                                                <div class="rating-wapper nostar">
                                                    <div class="star-rating">
                                                        <span style="width:${(product.ratings_avg * 20)}%">Rated <strong class="rating">${product.ratings_avg}</strong> out of 5</span>
                                                    </div>
                                                    <span class="review">(${product.ratings_count})</span>
                                                </div>
                                                <h3 class="product-name product_title">
                                                    <a href="/products/${product.id}">${product.name}</a>
                                                </h3>
                                                <span class="price">
                                                        <span class="kobolg-Price-amount amount text-danger">
                                                            <del>
                                                                ${new Intl.NumberFormat('de-DE').format(product.price)}<span class="kobolg-Price-currencySymbol">₫</span>
                                                            </del>
                                                        </span>
                                                        ${product.discount_price ? `<span class="kobolg-Price-amount amount old-price">${new Intl.NumberFormat('de-DE').format(product.discount_price)}</span>` : ''}<span class="kobolg-Price-currencySymbol">₫</span>
                                                </span>
                                                <div class="kobolg-product-details__short-description">
                                                    <p>${product.tomtat}</p>
                                                </div>
                                            </div>
                                            <div class="group-button">
                                                <div class="group-button-inner">
                                                    <div class="add-to-cart">
                                                        <a href="" class="button product_type_variable add_to_cart_button">Select options</a>
                                                    </div>
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <div class="yith-wcwl-add-button show">
                                                            <a href="#" class="add_to_wishlist">Add to Wishlist</a>
                                                        </div>
                                                    </div>
                                                    <div class="kobolg product compare-button">
                                                        <a href="#" class="compare button">Compare</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                `;
                            });

                            // Cập nhật nội dung HTML của #item-product
                            document.getElementById('item-product').innerHTML =
                                productHtml; // Sử dụng innerHTML
                            console.log(document.getElementById('item-product'));
                        } else {
                            // Nếu products không phải là mảng, log ra đối tượng chứa dữ liệu
                            console.error('Dữ liệu không phải là mảng:', products);
                        }
                    })
                    .catch((error) => {
                        console.error('Có lỗi xảy ra:', error);
                    });
            });
        });
    </script>

</div>

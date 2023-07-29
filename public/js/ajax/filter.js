$(document).ready(function () {
    $(".rand[data-cat-id]").change(function () {
        let data_r_sm = $(this).attr('data-r-sm');
        let data_r_lg = $(this).attr('data-r-lg');
        let cat_id = $(this).attr('data-cat-id');
        let data = {cat_id: cat_id, data_r_sm: data_r_sm, data_r_lg: data_r_lg};
        // console.log(data);

        $.ajax({
            url: `?mod=ajax&action=filterProcess`,
            method: "POST",
            data: data,
            dataType: 'json',
            success: function(data){

                console.log(data);

                let products_filter = data.result;
                
                if(products_filter.length){
                    let data_products_filter = '';

                    $.each(products_filter, function($item, product) {
                        let price = parseInt(product.price).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });

                        let item = `
                        <li>
                            <a href="${product.url}" title="" class="thumb">
                                <img src="admin/${product.thumbnail}")">
                            </a>
                            <a href="${product.url}" title="" class="product-name">${product.name}</a>
                            <div class="price">
                                <span class="new">${price}</span>
                            </div>
                            <div class="action clearfix">
                                <a href="${product.url_add_cart}" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="${product.url_buy_now}" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        `;
                        
                        data_products_filter += item;

                    });   
                    
                    $('#products-filter').html(data_products_filter);
                }else{
                    $('#products-filter').html("<p class = 'text-center'>Không có sản phẩm nào có khoảng giá cần lọc!</p>");
                }

                $("#display-num-on-page").html(products_filter.length);

                $("#display-pagging").html(data.data_pagging);

            },
            error: function(xhr, ajaxOptions, thrownError){
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });
});








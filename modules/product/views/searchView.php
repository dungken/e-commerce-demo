<?php
get_header();
?>

<div id="main-content-wp" class="clearfix category-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="<?php echo base_url() ?>" title="">Trang chủ</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-product-wp">
                <div class="section-detail">

                    <ul class="list-item clearfix" id="products-filter">

                        <?php
                        if (!empty($data_search)) {
                        ?>
                            <div class="desc">Có <?php echo count($data_search) ?> kết quả tìm kiếm</div>
                            <br>
                            <?php
                            foreach ($data_search as $data_item) {
                                $cat = get_product_cat($data_item['cat_id']);
                            ?>
                                <li>
                                    <a href="<?php echo base_url("san-pham/{$cat['slug']}-{$cat['id']}/{$data_item['slug']}-{$data_item['id']}") ?>" title="" class="thumb">
                                        <img src="<?php echo base_url("admin/{$data_item['thumbnail']}") ?>">
                                    </a>
                                    <a href="<?php echo base_url("san-pham/{$cat['slug']}-{$cat['id']}/{$data_item['slug']}-{$data_item['id']}") ?>" title="" class="product-name"><?php echo $data_item['name'] ?></a>
                                    <div class="price">
                                        <span class="new"><?php echo currency_format($data_item['price']) ?></span>
                                    </div>
                                    <div class="action clearfix">
                                        <a href="<?php echo base_url("gio-hang/{$data_item['slug']}-{$data_item['id']}-{$cat['id']}") ?>" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="<?php echo base_url("gio-hang/mua-ngay/{$data_item['slug']}-{$cat['id']}-{$data_item['id']}") ?>" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            <?php
                            }
                            ?>
                        <?php
                        } else {
                            echo "<p class = 'text-center'>Không có kết quả tìm kiếm!</p>";
                        }
                        ?>
                    </ul>
                </div>


            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail">
                    <?php
                    if (!empty($products)) {
                        $url = base_url("san-pham/{$cat['slug']}-{$cat['id']}/trang");
                        echo get_pagging($num_page, $page, $url, 'list-item clearfix');
                    } else
                        echo "Đang cập nhật, quay lại sau nhé!";
                    ?>
                </div>
            </div>
        </div>
        <div class="sidebar fl-left">
            <div class="section" id="category-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Danh mục sản phẩm</h3>
                </div>
                <div class="secion-detail">
                    <?php
                    foreach ($cats as $k => &$cat) {
                        $slug_cat = create_slug($cat['name']);
                        $cat['url'] = base_url("san-pham/{$slug_cat}-{$cat['id']}/");
                    }
                    echo render_menu($cats);
                    ?>

                </div>
            </div>
            <div class="section" id="filter-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Bộ lọc</h3>
                </div>
                <div class="section-detail">
                    <form method="POST" action="">
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2">Giá</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="radio" name="r-price" class="rand" id="rand-1" data-cat-id="<?php echo $product['cat_id'] ?>" data-r-sm="0" data-r-lg="500000"></td>
                                    <td><label for="rand-1">Dưới 500.000đ</label></td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price" class="rand" id="rand-2" data-cat-id="<?php echo $product['cat_id'] ?>" data-r-sm="500000" data-r-lg="1000000"></td>
                                    <td><label for="rand-2">500.000đ - 1.000.000đ</label></td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price" class="rand" id="rand-3" data-cat-id="<?php echo $product['cat_id'] ?>" data-r-sm="1000000" data-r-lg="5000000"></td>
                                    <td><label for="rand-3">1.000.000đ - 5.000.000đ</label></td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price" class="rand" id="rand-4" data-cat-id="<?php echo $product['cat_id'] ?>" data-r-sm="5000000" data-r-lg="10000000"></td>
                                    <td><label for="rand-4">5.000.000đ - 10.000.000đ</label></td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price" class="rand" id="rand-5" data-cat-id="<?php echo $product['cat_id'] ?>" data-r-sm="10000000" data-r-lg="1000000000"></td>
                                    <td><label for="rand-5">Trên 10.000.000đ</label></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <div class="section" id="banner-wp">
                <div class="section-detail">
                    <?php $ads = get_ads(); ?>
                    <a href="<?php echo $ads['link'] ?>" title="" class="thumb">
                        <img src="<?php echo base_url("admin/{$ads['banner']}") ?>" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>




<?php
get_footer();
?>
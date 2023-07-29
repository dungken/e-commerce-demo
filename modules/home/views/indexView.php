<?php
get_header();
// show_array($products);
// die();
?>

<div id="main-content-wp" class="home-page clearfix">
    <div class="wp-inner">
        <div class="main-content fl-right">
            <div class="section" id="slider-wp">
                <div class="section-detail">
                    <?php
                    $slides = get_slide();
                    foreach ($slides as $slide) {
                    ?>
                        <div class="item">
                            <a href="<?php echo $slide['link'] ?>">
                                <img src="<?php echo base_url("admin/{$slide['slide']}") ?>" alt="">
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="section" id="support-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-1.png">
                            </div>
                            <h3 class="title">Miễn phí vận chuyển</h3>
                            <p class="desc">Tới tận tay khách hàng</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-2.png">
                            </div>
                            <h3 class="title">Tư vấn 24/7</h3>
                            <p class="desc">1900.9999</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-3.png">
                            </div>
                            <h3 class="title">Tiết kiệm hơn</h3>
                            <p class="desc">Với nhiều ưu đãi cực lớn</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-4.png">
                            </div>
                            <h3 class="title">Thanh toán nhanh</h3>
                            <p class="desc">Hỗ trợ nhiều hình thức</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-5.png">
                            </div>
                            <h3 class="title">Đặt hàng online</h3>
                            <p class="desc">Thao tác đơn giản</p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="section" id="feature-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm nổi bật</h3>
                </div>
                <div class="section-detail">

                    <ul class="list-item">

                        <?php
                        $product_bestsaler = get_product_bestsaler(.5);
                        if (!empty($product_bestsaler)) {
                            foreach ($product_bestsaler as $item) {
                                $cat = get_product_cat($item['cat_id']);
                        ?>
                                <li>
                                    <a href="<?php echo base_url("san-pham/{$cat['slug']}-{$cat['id']}/{$item['slug']}-{$item['id']}") ?>" title="" class="thumb">
                                        <img src="<?php echo base_url("admin/{$item['thumbnail']}") ?>">
                                    </a>
                                    <a href="<?php echo base_url("san-pham/{$cat['slug']}-{$cat['id']}/{$item['slug']}-{$item['id']}") ?>" title="" class="product-name"><?php echo $item['name'] ?></a>
                                    <div class="price">
                                        <span class="new"><?php echo currency_format($item['price']) ?></span>
                                    </div>
                                    <div class="action clearfix">
                                        <a href="<?php echo base_url("gio-hang/{$item['slug']}-{$item['id']}-{$cat['id']}") ?>" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="<?php echo base_url("gio-hang/mua-ngay/{$item['slug']}-{$cat['id']}-{$item['id']}") ?>" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>


            <div class="section" id="list-product-wp">
                <?php
                $list_cat = get_product_cat('', 2);
                foreach ($list_cat as $cat) {
                    $products = get_product('', $cat['id'], 8);
                ?>
                    <div class="section-head d-flex">
                        <a href="<?php echo base_url("san-pham/{$cat['slug']}-{$cat['id']}/") ?>">
                            <h3 class="section-title"><?php echo $cat['name'] ?></h3>
                        </a>

                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            <?php
                            foreach ($products as $product) {
                                $cat = get_product_cat($product['cat_id']);
                            ?>
                                <li>
                                    <a href="<?php echo base_url("san-pham/{$cat['slug']}-{$cat['id']}/{$product['slug']}-{$product['id']}") ?>" title="" class="thumb">
                                        <img src="<?php echo base_url("admin/{$product['thumbnail']}") ?>">
                                    </a>
                                    <a href="<?php echo base_url("san-pham/{$cat['slug']}-{$cat['id']}/{$product['slug']}-{$product['id']}") ?>" title="" class="product-name"><?php echo $product['name'] ?></a>
                                    <div class="price">
                                        <span class="new"><?php echo currency_format($product['price']) ?></span>
                                        <!-- <span class="old">8.990.000đđ</span> -->
                                    </div>
                                    <div class="action clearfix">
                                        <a href="<?php echo base_url("gio-hang/{$product['slug']}-{$product['id']}-{$cat['id']}") ?>" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="<?php echo base_url("gio-hang/mua-ngay/{$product['slug']}-{$cat['id']}-{$product['id']}") ?>" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                <?php
                }
                ?>
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
            <div class="section" id="selling-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm bán chạy</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        <?php
                        $product_bestsaler = get_product_bestsaler(.9);
                        if (!empty($product_bestsaler)) {
                            foreach ($product_bestsaler as $item) {
                                $cat = get_product_cat($item['cat_id']);
                        ?>
                                <li class="clearfix">
                                    <a href="<?php echo base_url("san-pham/{$cat['slug']}-{$cat['id']}/{$item['slug']}-{$item['id']}") ?>" title="" class="thumb fl-left">
                                        <img src="<?php echo base_url("admin/{$item['thumbnail']}") ?>" alt="">
                                    </a>
                                    <div class="info fl-right">
                                        <a href="<?php echo base_url("san-pham/{$cat['slug']}-{$cat['id']}/{$item['slug']}-{$item['id']}") ?>" title="" class="product-name"><?php echo $item['name'] ?></a>
                                        <div class="price">
                                            <span class="new"><?php echo currency_format($item['price']) ?></span>
                                        </div>
                                        <a href="<?php echo base_url("gio-hang/mua-ngay/{$item['slug']}-{$cat['id']}-{$item['id']}") ?>" title="Mua ngay" class="buy-now">Mua ngay</a>
                                    </div>
                                </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
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
<?php
get_header();
?>


<div id="main-content-wp" class="clearfix detail-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href=" <?php echo base_url("san-pham/{$cat['slug']}-{$cat['id']}/") ?>" title=""><?php echo $cat['name'] ?></a>
                    </li>
                    <li>
                        <a href="" title=""><?php echo $product['name'] ?></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="detail-product-wp">
                <div class="section-detail clearfix">
                    <div class="thumb-wp fl-left">
                        <a href="" title="" id="main-thumb">
                            <img id="zoom" src="<?php echo base_url(resizeImage("admin/{$product['thumbnail']}", 350, 350, '350-350')) ?>" data-zoom-image="<?php echo base_url(resizeImage("admin/{$product['thumbnail']}", 700, 700, '700-700')) ?>" />
                        </a>
                        <div id="list-thumb">
                            <a href="" data-image="<?php echo base_url(resizeImage("admin/{$product['thumbnail']}", 350, 350, '350-350')) ?>" data-zoom-image="<?php echo base_url(resizeImage("admin/{$product['thumbnail']}", 700, 700, '700-700')) ?>">
                                <img id="zoom" src="<?php echo base_url(resizeImage("admin/{$product['thumbnail']}", 50, 50, '50-50')) ?>" />
                            </a>
                            <?php
                            foreach ($imgs_relate_product as $item) {
                                if ($item['thumb_id'] == $product['id']) {
                            ?>
                                    <!-- Các hình ảnh liên quan -->
                                    <a href="" data-image="<?php echo base_url(resizeImage("admin/{$item['path']}", 350, 350, '350-350')) ?>" data-zoom-image="<?php echo base_url(resizeImage("admin/{$item['path']}", 700, 700, '700-700')) ?>">
                                        <img id="zoom" src="<?php echo base_url(resizeImage("admin/{$item['path']}", 50, 50, '50-50')) ?>" />
                                    </a>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    <!-- RESPONSIVE -->
                    <div class="thumb-respon-wp fl-left">
                        <img src="<?php echo base_url("admin/{$product['thumbnail']}") ?>" alt="">
                    </div>
                    <!-- END -->

                    <div class="info fl-right">
                        <h3 class="product-name"><?php echo $product['name'] ?></h3>
                        <div class="desc">
                            <?php echo $product['desc'] ?>
                        </div>
                        <div class="num-product">
                            <span class="title">Sản phẩm: </span>
                            <?php
                            $status = ['inStock' => 'Còn hàng', 'soldOut' => 'Hết hàng'];
                            ?>
                            <span class="status"><?php echo $status[$product['status']] ?></span>
                        </div>
                        <p class="price"><?php echo currency_format($product['price']) ?></p>
                        <form action="<?php echo base_url("gio-hang/{$product['slug']}-{$product['id']}-{$cat['id']}") ?>" method="post">
                            <div id="num-order-wp">
                                <label for="num-order">Số lượng: </label>
                                <input type="number" name="num-order" id="num-order" min='1' max="<?php echo $product['qty_on_hand'] ?>" value="1">
                            </div>
                            <input type="submit" value="Thêm giỏ hàng" name="btn_add_cart" class="add-cart" title="Thêm giỏ hàng">
                        </form>
                    </div>

                </div>
            </div>
            <div class="section" id="post-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Mô tả sản phẩm</h3>
                </div>
                <div class="section-detail">
                    <?php echo $product['detail']
                    ?>
                </div>
            </div>
            <div class="section" id="same-category-wp">
                <div class="section-head">
                    <h3 class="section-title">Cùng chuyên mục</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        <?php
                        foreach ($products as $item) {
                        ?>
                            <li>
                                <a href="<?php echo base_url("san-pham/{$cat['slug']}-{$cat['id']}/{$item['slug']}-{$item['id']}") ?>" title="" class="thumb">
                                    <img src="<?php echo base_url("admin/{$item['thumbnail']}") ?>">
                                </a>
                                <a href="<?php echo base_url("san-pham/{$cat['slug']}-{$cat['id']}/{$item['slug']}-{$item['id']}") ?>" title="" class="product-name"><?php echo $item['name'] ?></a>
                                <div class="price">
                                    <span class="new"><?php echo currency_format($item['price']) ?></span>
                                    <!-- <span class="old">20.900.000đ</span> -->
                                </div>
                                <div class="action clearfix">
                                    <a href="<?php echo base_url("gio-hang/{$item['slug']}-{$item['id']}-{$cat['id']}") ?>" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                    <a href="<?php echo base_url("gio-hang/mua-ngay/{$item['slug']}-{$cat['id']}-{$item['id']}") ?>" title="" class="buy-now fl-right">Mua ngay</a>
                                </div>
                            </li>
                        <?php
                        }

                        ?>

                    </ul>
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
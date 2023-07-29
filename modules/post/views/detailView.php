<?php
get_header();
// show_array($post);
?>
<div id="main-content-wp" class="clearfix detail-blog-page">

    <div class="wp-inner">
        <?php
        if (!empty($post)) {
        ?>
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="<?php echo base_url(); ?>" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("bai-viet/") ?>" title="">Blog</a>
                        </li>
                        <li>
                            <a href="" title=""><?php echo $post['title'] ?></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="detail-blog-wp">
                    <div class="section-head clearfix">
                        <h3 class="section-title"><?php echo $post['title'] ?></h3>
                    </div>
                    <div class="section-detail">
                        <span class="create-date"><?php echo $post['created_at'] ?></span>
                        <div class="detail">
                            <?php echo $post['content'] ?>
                        </div>
                    </div>
                </div>
                <div class="section" id="social-wp">
                    <div class="section-detail">
                        <div class="fb-like" data-href="" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                        <div class="g-plusone-wp">
                            <div class="g-plusone" data-size="medium"></div>
                        </div>
                        <div class="fb-comments" id="fb-comment" data-href="" data-numposts="5"></div>
                    </div>
                </div>
            </div>
        <?php
        } else echo "Không có dữ liệu!";
        ?>

        <div class="sidebar fl-left">
            <div class="section" id="selling-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm bán chạy</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        <?php
                        $product_bestsaler = get_product_bestsaler(.8);
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
                                        <a href="<?php echo base_url("gio-hang/mua-ngay/{$item['slug']}-{$item['id']}-{$cat['id']}") ?>" title="Mua ngay" class="buy-now">Mua ngay</a>
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
                    <a href="?page=detail_product" title="" class="thumb">
                        <img src="public/images/banner.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>
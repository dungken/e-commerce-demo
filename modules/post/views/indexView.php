<?php
get_header();
// show_array($posts);
?>
<div id="main-content-wp" class="clearfix blog-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="<?php echo base_url() ?>" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url("bai-viet/") ?>" title="">Blog</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title">Blog</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        <?php
                        if (!empty($posts)) {
                            foreach ($posts as $post) {
                                $slug = create_slug($post['title']);
                        ?>
                                <li class="clearfix">
                                    <a href="<?php echo base_url("bai-viet/{$slug}-{$post['id']}.html") ?>" title="" class="thumb fl-left">
                                        <img src="<?php echo base_url('admin/') . "{$post['thumbnail']}" ?>" alt="">
                                    </a>
                                    <div class="info fl-right">
                                        <a href="<?php echo base_url("bai-viet/{$slug}-{$post['id']}.html") ?>" title="" class="title"><?php echo $post['title'] ?></a>
                                        <span class="create-date"><?php echo $post['created_at'] ?></span>
                                        <p class="desc"><?php if (strlen($post['desc']) > 100) echo substr($post['desc'], 0, 100) . '...';  ?></p>
                                    </div>
                                </li>
                            <?php
                            }
                            ?>
                        <?php
                        } else {
                            echo "<p>Không có bài viết nào!</p>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail">
                    <?php
                    $url = base_url("bai-viet/trang");
                    echo get_pagging($num_page, $page, $url, 'list-item clearfix');
                    ?>
                </div>
            </div>
        </div>
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
<!DOCTYPE html>
<html>

<head>
    <title>VDHSTORE</title>
    <base href="http://localhost/Project/vandunghastore.com/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url('public/css/bootstrap/bootstrap-theme.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('public/css/bootstrap/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('public/reset.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('public/css/carousel/owl.carousel.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('public/css/carousel/owl.theme.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('public/css/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('public/style.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('public/responsive.css') ?>" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url('public/js/jquery-2.2.4.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('public/js/elevatezoom-master/jquery.elevatezoom.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('public/js/bootstrap/bootstrap.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('public/js/carousel/owl.carousel.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('public/js/main.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('public/js/ajax/search.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('public/js/ajax/filter.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('public/js/ajax/shopping-cart.js') ?>" type="text/javascript"></script>
</head>


<body>
    <div id="site">
        <div id="container">
            <div id="header-wp">
                <div id="head-top" class="clearfix">
                    <div class="wp-inner">
                        <a href="<?php echo base_url('') ?>" title="" id="payment-link" class="fl-left">Hình thức thanh toán</a>
                        <div id="main-menu-wp" class="fl-right">
                            <ul id="main-menu" class="clearfix">
                                <li>
                                    <a href="<?php echo base_url('') ?>" title="">Trang chủ</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url("bai-viet/") ?>" title="">Blog</a>
                                </li>
                                <?php
                                $page_intro = get_page("`name` LIKE 'Giới thiệu'");
                                $page_contact = get_page("`name` LIKE 'Liên hệ'");
                                ?>
                                <li>
                                    <a href="<?php echo base_url("{$page_intro['slug']}-{$page_intro['id']}.html") ?>" title=""><?php echo $page_intro['name'] ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url("{$page_contact['slug']}-{$page_contact['id']}.html") ?>" title=""><?php echo $page_contact['name'] ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="head-body" class="clearfix">
                    <div class="wp-inner">
                        <a href="<?php echo base_url('') ?> " title="" id="logo" class="fl-left"><img src="<?php echo base_url('public/images/logo.png') ?> " /></a>
                        <div id="search-wp" class="fl-left">
                            <form method="POST" action="<?php echo base_url("san-pham/tim-kiem/") ?>" autocomplete="off">
                                <input type="text" name="keyword" id="s" placeholder="Nhập từ khóa tìm kiếm tại đây!">
                                <button type="submit" name="btn-search" value="search" id="sm-s">Tìm kiếm</button>
                            </form>
                            <ul class="list-search d-flex">
                                <!-- Hiển thị result search -->
                            </ul>
                        </div>
                        <div id="action-wp" class="fl-right">
                            <a href="<?php echo base_url("{$page_contact['slug']}-{$page_contact['id']}.html") ?>">
                                <div id="advisory-wp" class="fl-left">
                                    <span class="title">Tư vấn</span>
                                    <span class="phone">032.725.0461</span>
                                </div>
                            </a>
                            <div id="btn-respon" class="fl-right"><i class="fa fa-bars" aria-hidden="true"></i></div>
                            <a href="<?php echo base_url("gio-hang/"); ?>" title="giỏ hàng" id="cart-respon-wp" class="fl-right">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <span id="number_cart" class="num"><?php echo num_cart(); ?></span>
                            </a>

                            <div id="cart-wp" class="fl-right">
                                <a href="<?php echo base_url("gio-hang/") ?>">
                                    <div id="btn-cart">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        <span id="number_cart" class="num"><?php echo num_cart(); ?></span>
                                    </div>
                                </a>
                                <?php
                                if (num_cart()) {
                                ?>
                                    <div id="dropdown">
                                        <p class="desc">Có <span id="number_cart"><?php echo num_cart(); ?> </span> sản phẩm trong giỏ hàng</p>
                                        <ul class="list-cart">
                                            <?php
                                            foreach (get_cart() as $item) {
                                            ?>
                                                <li class="clearfix">
                                                    <a href="<?php echo $item['url'] ?>" title="" class="thumb fl-left">
                                                        <img src="<?php echo base_url("admin/{$item['thumbnail']}") ?>" alt="">
                                                    </a>
                                                    <div class="info fl-right">
                                                        <a href="<?php echo $item['url'] ?>" title="" class="product-name"><?php echo $item['name'] ?></a>
                                                    </div>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                        <div class="total-price clearfix">
                                            <p class="title fl-left">Tổng giỏ hàng:</p>
                                            <p class="price-total fl-right"><?php echo currency_format(total_cart()); ?></p>
                                        </div>
                                        <dic class="action-cart clearfix">
                                            <a href="<?php echo base_url("gio-hang/") ?>" title="Giỏ hàng" class="view-cart fl-left">Giỏ hàng</a>
                                            <a href="<?php echo base_url("gio-hang/thanh-toan/") ?>" title="Thanh toán" class="checkout fl-right">Thanh toán</a>
                                        </dic>
                                    </div>
                                <?php
                                } else {
                                    echo "<div id='dropdown'><p class = 'desc text-center'><strong>Không có sản phẩm nào được thêm vào giỏ hàng!</strong></p></div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
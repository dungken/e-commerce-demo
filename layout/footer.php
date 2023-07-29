<?php global $status; ?>

<div id="footer-wp">
    <div id="foot-body">
        <div class="wp-inner clearfix">
            <div class="block" id="info-company">
                <h3 class="title">VDHSTORE</h3>
                <p class="desc">VDHSTORE luôn cung cấp luôn là sản phẩm chính hãng có thông tin rõ ràng, chính sách ưu đãi cực lớn cho khách hàng có thẻ thành viên.</p>
                <div id="payment">
                    <div class="thumb">
                        <img src="public/images/img-foot.png" alt="">
                    </div>
                </div>
            </div>
            <div class="block menu-ft" id="info-shop">
                <h3 class="title">Thông tin cửa hàng</h3>
                <ul class="list-item">
                    <li>
                        <p>2112 - Xuân An - An Khê - Gia Lai</p>
                    </li>
                    <li>
                        <p>032.725.0461 - 0344.175.899</p>
                    </li>
                    <li>
                        <p>vdh@vandungstore.com</p>
                    </li>
                </ul>
            </div>
            <div class="block menu-ft policy" id="info-shop">
                <h3 class="title">Chính sách mua hàng</h3>
                <ul class="list-item">
                    <li>
                        <a href="" title="">Quy định - chính sách</a>
                    </li>
                    <li>
                        <a href="" title="">Chính sách bảo hành - đổi trả</a>
                    </li>
                    <li>
                        <a href="" title="">Chính sách hội viện</a>
                    </li>
                    <li>
                        <a href="" title="">Giao hàng - lắp đặt</a>
                    </li>
                </ul>
            </div>
            <div class="block" id="newfeed">
                <h3 class="title">Bảng tin</h3>
                <p class="desc">Đăng ký với chung tôi để nhận được thông tin ưu đãi sớm nhất</p>
                <div id="form-reg">
                    <form method="POST" action="<?php echo base_url() ?>">
                        <input type="email" name="email" id="email" placeholder="Nhập email tại đây">
                        <?php echo form_error('email') ?>
                        <button type="submit" value="reg" name="btn_sm_reg" id="sm-reg">Đăng ký</button>
                        <?php if (!empty($status)) echo $status; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="foot-bot">
        <div class="wp-inner">
            <p id="copyright">© Bản quyền thuộc về unitop.vn | Php Master</p>
        </div>
    </div>
</div>
</div>


<div id="menu-respon">
    <a href="<?php echo base_url("/") ?>" title="" class="logo">VDHSTORE</a>
    <div id="menu-respon-wp">
        <ul class="" id="main-menu-respon">
            <li>
                <a href="<?php echo base_url("/") ?>" title>Trang chủ</a>
            </li>
            <?php
            $cats = get_product_cat();
            foreach ($cats as $k => &$cat) {
                $slug_cat = create_slug($cat['name']);
                $cat['url'] = base_url("san-pham/{$slug_cat}-{$cat['id']}/");
            }
            echo render_menu($cats);
            ?>

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


<div id="btn-top"><img src="public/images/icon-to-top.png" alt="" /></div>

<div id="fb-root"></div>

<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=849340975164592";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>


</body>

</html>
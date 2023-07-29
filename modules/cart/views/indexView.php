<?php
get_header();

?>


<div id="main-content-wp" class="cart-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="<?php echo base_url() ?>" title="">Trang chủ</a>
                    </li>
                    <?php
                    if (!empty($cat) || !empty($product)) {
                    ?>
                        <li>
                            <a href=" <?php echo base_url("san-pham/{$cat['slug']}-{$cat['id']}/") ?>" title=""><?php echo $cat['name']; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("san-pham/{$cat['slug']}-{$cat['id']}/{$product['slug']}-{$product['id']}") ?>" title=""><?php echo $product['name'] ?></a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <?php
    if (!empty($cart) && !empty($sum)) {
    ?>
        <div id="wrapper" class="wp-inner clearfix">
            <div class="section" id="info-cart-wp">
                <div class="section-detail table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Ảnh sản phẩm</td>
                                <td>Tên sản phẩm</td>
                                <td>Giá sản phẩm</td>
                                <td>Số lượng</td>
                                <td>Thành tiền</td>
                                <td>Tác vụ</td>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($cart as $item) {
                            ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo $item['url'] ?>" title="" class="thumb">
                                            <img src="<?php echo base_url("admin/{$item['thumbnail']}") ?>" alt="">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo $item['url'] ?>" title="" class="name-product"><?php echo $item['name'] ?></a>
                                    </td>
                                    <td><?php echo currency_format($item['price']) ?></td>
                                    <td>
                                        <input type="number" min='1' max='<?php echo $product['qty_on_hand'] ?>' name="num-order" value="<?php echo $item['qty'] ?>" id="num-order" data-id="<?php echo $item['id'] ?>">
                                    </td>
                                    <td id="sub_total" data-id="<?php echo $item['id'] ?>"><?php echo currency_format($item['sub_total']) ?></td>
                                    <td>
                                        <a href="?mod=cart&action=delete&id=<?php echo $item['id'] ?>" onclick="return confirm('Bạn có chắc chắn xóa sản phẩm này không!');" title="Xóa" class="del-product"><i id="trash" class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <div class="clearfix">
                                        <p id="total-price" class="fl-right">Tổng giá: <span id="total"><?php echo currency_format(total_cart()); ?></span></p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <div class="clearfix">
                                        <div class="fl-right">
                                            <a href="<?php echo base_url("gio-hang/thanh-toan/") ?>" title="" id="checkout-cart">Thanh toán</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="section" id="action-cart-wp">
                <div class="section-detail">
                    <a href="<?php echo base_url("san-pham/{$cat['slug']}-{$cat['id']}/") ?>" title="" id="buy-more">Mua tiếp</a><br />
                    <a href="<?php echo base_url("?mod=cart&action=delete") ?>" onclick="return confirm('Bạn có chắc chắn xóa toàn bộ giỏ hàng không!');" title="" id="delete-cart">Xóa giỏ hàng</a>
                </div>
            </div>
        </div>
    <?php
    } else {
        echo "<p class = 'text-center'>Không có sản phẩm nào trong giỏ hàng</p>";
    }

    ?>

</div>



<?php
get_footer();
?>
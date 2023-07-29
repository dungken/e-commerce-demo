<?php
get_header();
$cart = get_cart();
global $status;

?>
<div id="main-content-wp" class="checkout-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="<?php echo base_url() ?>" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url("gio-hang/") ?>" title="">Giỏ hàng</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url("gio-hang/thanh-toan/") ?>" title="">Thanh toán</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <form method="POST" action="<?php echo base_url("gio-hang/thanh-toan/") ?>" name="form-checkout">
        <div id="wrapper" class="wp-inner clearfix">
            <div class="section" id="customer-info-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin khách hàng</h1>
                </div>
                <div class="section-detail">
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="fullname">Họ tên</label>
                            <input type="text" name="fullname" id="fullname" value="<?php echo set_value('fullname') ?>">
                            <?php echo form_error('fullname') ?>
                        </div>
                        <div class="form-col fl-right">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="<?php echo set_value('email') ?>">
                            <?php echo form_error('email') ?>
                        </div>
                    </div>
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="address">Địa chỉ nhận hàng</label>
                            <input type="text" name="address" id="address" value="<?php echo set_value('address') ?>">
                            <?php echo form_error('address') ?>
                        </div>
                        <div class="form-col fl-right">
                            <label for="phone">Số điện thoại</label>
                            <input type="tel" name="phone" id="phone" value="<?php echo set_value('phone') ?>">
                            <?php echo form_error('phone') ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="notes">Ghi chú</label>
                            <textarea name="note" id="notes"><?php echo set_value('note') ?></textarea>
                        </div>
                    </div>

                </div>
            </div>
            <div class="section" id="order-review-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin đơn hàng</h1>
                </div>
                <div class="section-detail">
                    <table class="shop-table">
                        <thead>
                            <tr>
                                <td>Sản phẩm</td>
                                <td>Tổng</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($cart)) {
                                foreach ($cart as $e) {
                            ?>
                                    <tr class="cart-item">
                                        <td class="product-name"><?php echo $e['name'] ?><strong class="product-quantity">x <?php echo $e['qty'] ?></strong></td>
                                        <td class="product-total"><?php echo currency_format($e['sub_total']) ?></td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr class="order-total">
                                <td>Tổng đơn hàng:</td>
                                <td><strong class="total-price"><?php echo currency_format(total_cart()); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div id="payment-checkout-wp">
                        <ul id="payment_methods">
                            <li>
                                <input type="radio" id="payment-home" name="payment-method" <?php if (!empty($payment) && $payment == 'payment-home') echo "checked = 'checked'" ?> checked="checked" value="home">
                                <label for="payment-home">Thanh toán tại nhà</label>
                            </li>
                            <li>
                                <input type="radio" id="direct-payment" name="payment-method" <?php if (!empty($payment) && $payment == 'payment-direct') echo "checked = 'checked'" ?> value="direct">
                                <label for="direct-payment">Thanh toán tại cửa hàng</label>
                            </li>
                        </ul>
                    </div>
                    <?php if (!empty($status)) echo $status; ?>
                    <div class="place-order-wp clearfix">
                        <input type="submit" name="btn-order" id="order-now" value="Đặt hàng">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?php
get_footer();
?>
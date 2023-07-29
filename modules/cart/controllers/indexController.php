<?php


function construct()
{
    load_model('index');
    load('lib', 'sendmail');
}


function addAction()
{
    if ($_POST['num-order'])
        $num_order =  $_POST['num-order'];
    else
        $num_order = 1;

    $id = (int)$_GET['id'];
    $cat_id = $_GET['cat_id'];

    $product = get_product($id, '');
    $cat = get_product_cat($cat_id);

    add_cart($product, $cat, $num_order);

    $_SESSION['cat_id'] = $cat_id;
    $_SESSION['id'] = $id;

    redirect_to(base_url("gio-hang/"));
}


function indexAction()
{
    if (!empty($_SESSION['cat_id'])) {
        $cat_id = $_SESSION['cat_id'];
        $cat = get_product_cat($cat_id);
        $data['cat'] = $cat;
    }

    if (!empty($_SESSION['id'])) {
        $id = $_SESSION['id'];
        $product = get_product($id, '');
        $data['product'] = $product;
    }


    if (!empty($_SESSION['cart'])) {
        $cart = $_SESSION['cart'];
        $sum = $_SESSION['sum'];
        $data['cart'] = $cart;
        $data['sum'] = $sum;
    } else {
        $data = [];
    }

    load_view('index', $data);
}


function deleteAction()
{
    $id = (int)$_GET['id'];

    delete_cart($id);

    redirect_to('gio-hang/');
}


function checkoutAction()
{
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = date('y-m-d h:i:s');

    global $fullname, $email, $address, $phone, $note, $payment, $error, $status;

    if (!empty($_POST['btn-order'])) {
        $error = array();
        //fullname
        if (!empty($_POST['fullname'])) {
            $fullname = $_POST['fullname'];
        } else {
            $error['fullname'] = "Không được để trống tên!";
        }

        //email
        if (!empty($_POST['email'])) {
            $email = $_POST['email'];
        } else {
            $error['email'] = "Không được để trống email!";
        }
        //address
        if (!empty($_POST['address'])) {
            $address = $_POST['address'];
        } else {
            $error['address'] = "Không được để trống địa chỉ!";
        }
        //tel
        if (!empty($_POST['phone'])) {
            $phone = $_POST['phone'];
        } else {
            $error['phone'] = "Không được để trống số điện thoại!";
        }
        // notes
        $note = $_POST['note'];
        // method payment
        $payment = $_POST['payment-method'];

        if (empty($error)) {

            $payment_translate = [
                'home' => 'Thanh toán khi nhận hàng tại nhà',
                'direct' => 'Thanh toán tại cửa hàng VDHSTORE'
            ];

            // Thêm data cho table client
            $num_client = get_count_client();

            $cnt_code_client = $num_client + 1;

            $data_client = [
                'name' => $fullname,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'note' => $note,
                'status' => 'pending',
                'payment' => $payment,
                'code_order' => 'VDHSTORE#' . "{$cnt_code_client}",
                'code_client' => 'VDH#' . "{$cnt_code_client}",
                'num_order' => $_SESSION['sum']['num_order'],
                'total' => $_SESSION['sum']['total'],
                'created_at' => $date
            ];

            $client_id = add_client($data_client);

            // Thêm data cho table orders
            $cart = get_cart();

            foreach ($cart as $item) {
                $data_order = [
                    'product_id' => $item['id'],
                    'client_id' => $client_id,
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'sub_total' => $item['sub_total'],
                    'created_at' => $date
                ];
                add_order($data_order);
            }

            // Gửi mail xác nhận
            $data_order = [
                'name' => $fullname,
                'payment_translate' => $payment_translate[$payment],
                'phone' => $phone,
                'address' => $address,
                'code_order' => 'VDHSTORE#' . "{$cnt_code_client}",
            ];

            $content = get_template_order($data_order);

            $check = send_mail($email, "VDHSTORE", "THÔNG TIN ĐƠN HÀNG", $content);
            if ($check == 1) {
                $status = "<p style = 'color: green;text-align: right;font-size: 16px;padding-top: 20px;'>Đã đặt hàng thành công, kiểm tra email để xác nhận đơn hàng!</p>";
            } else {
                $status = "<p style = 'color: #c12449;text-align: right;font-size: 16px;padding-top: 20px;'>Đặt hàng không thành công, kiểm tra và vui lòng đặt lại nhé!</p>";
            }

            //Cập nhật số lượng bán ra
            foreach($cart as $item){
                $qty_current_sold = get_product($item['id'], '', '')['qty_sold'];
                db_update('products', ['qty_sold' => $qty_current_sold + $item['qty']], "`id` = {$item['id']}");
            }
        }
    }

    load_view('checkout');
}


function buyNowAction()
{
    $id = (int)$_GET['id'];
    $cat_id = $_GET['cat_id'];

    $product = get_product($id, '');
    $cat = get_product_cat($cat_id);

    add_cart($product, $cat);

    $_SESSION['cat_id'] = $cat_id;
    $_SESSION['id'] = $id;

    redirect_to(base_url("gio-hang/thanh-toan/"));
}



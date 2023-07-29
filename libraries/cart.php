<?php

function update_cart()
{
    $_SESSION['sum']['total'] = 0;
    $_SESSION['sum']['num_order'] = 0;
    foreach ($_SESSION['cart'] as $item) {
        $_SESSION['sum']['total'] += $item['sub_total'];
        $_SESSION['sum']['num_order'] += $item['qty'];
    }
}

function num_cart()
{
    // update_cart();
    if (!empty($_SESSION['sum']) && $_SESSION['sum']['num_order'] > 0)
        return $_SESSION['sum']['num_order'];
    return 0;
}

function total_cart()
{
    // update_cart();
    if (!empty($_SESSION['sum']) && $_SESSION['sum']['total'] > 0)
        return $_SESSION['sum']['total'];
    return 0;
}


function get_cart()
{
    // update_cart();
    if (!empty($_SESSION['cart'])) {
        return $_SESSION['cart'];
    }
}




function add_cart($product, $cat, $num_order = 1)
{

    if (!empty($_SESSION)) {
        $ok = 0;
        foreach ($_SESSION['cart'] as $k => $item) {
            if ($product['name'] == $item['name']) {
                $ok = 1;
                $_SESSION['cart'][$k]['qty'] += $num_order;
                $_SESSION['cart'][$k]['sub_total'] +=  $_SESSION['cart'][$k]['price'];
            }
        }
        if (!$ok) {
            $_SESSION['cart'][] = [
                'id' => $product['id'],
                'cat_id' => $cat['id'],
                'name' => $product['name'],
                'thumbnail' => $product['thumbnail'],
                'price' => $product['price'],
                'qty' => $num_order,
                'sub_total' => $product['price'],
                'url' => base_url("san-pham/{$cat['slug']}-{$cat['id']}/{$product['slug']}-{$product['id']}")
            ];
        }

        update_cart();
    } else {
        $_SESSION['cart'][] = [
            'id' => $product['id'],
            'cat_id' => $cat['id'],
            'name' => $product['name'],
            'thumbnail' => $product['thumbnail'],
            'price' => $product['price'],
            'qty' => $num_order,
            'sub_total' => $product['price'],
            'url' => base_url("san-pham/{$cat['slug']}-{$cat['id']}/{$product['slug']}-{$product['id']}")
        ];
        update_cart();
    }

    // unset($_SESSION['cart']);
    // unset($_SESSION['sum']);
}


function delete_cart($id = '')
{
    if ($id) {
        foreach ($_SESSION['cart'] as $k => $item) {
            if ($id == $item['id']) {
                unset($_SESSION['cart'][$k]);
            }
        }
    } else {
        unset($_SESSION['cart']);
    }

    update_cart();
}


function get_template_order($data)
{

    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = date('d-m-y h:i:s');
    $cart = get_cart();


    $template = "
    <div style='max-width: 960px;margin: 0px auto;padding: 20px;text-align: center;font-family: roboto;border: 1px solid #d5cbcb;'>
    <div style='margin-bottom: 20px;font-size: 15px;'>
        <div>
            <h3 style='font-weight: bold;text-transform: uppercase;font-size: 25px;letter-spacing: 4px;'>Thông tin đơn hàng</h3>
        </div>
        <ul style='list-style: none;text-align: left;'>
            <li style='margin-bottom: 10px;'>
                <h3 style='color: #931a1a;font-size: 20px;'>Mã đơn hàng</h3>
                <span style='color: #444;font-size: 14px;'>{$data['code_order']}</span>
            </li>
            <li style='margin-bottom: 10px;'>
                <h3 style='color: #931a1a;font-size: 20px;'>Tên khách hàng</h3>
                <span style='color: #444;font-size: 14px;'>{$data['name']} <br> {$data['phone']}</span>
            </li>
            <li style='margin-bottom: 10px;'>
                <h3 style='color: #931a1a;font-size: 20px;'>Địa chỉ nhận hàng</h3>
                <span style='color: #444;font-size: 14px;'>{$data['address']}</span>
            </li>
            <li style='margin-bottom: 10px;'>
                <h3 style='color: #931a1a;font-size: 20px;'>Thông tin vận chuyển</h3>
                <span style='color: #444;font-size: 14px;'>{$data['payment_translate']}</span>
            </li>
            <li style='margin-bottom: 10px;'>
                <h3 style='color: #931a1a;font-size: 20px;'>Thời gian đặt hàng</h3>
                <span style='color: #444;font-size: 14px;'>{$date}</span>
            </li>
        </ul>
    </div>
    <div style='margin-bottom: 20px;font-size: 15px;'>
        <div>
            <h3 style='font-size: 22px;letter-spacing: 2px;'>Sản phẩm đơn hàng</h3>
        </div>
        <div>
            <table style='text-align: center;padding: 30px; width: 100%;'>
                <thead style='font-weight: 600; color: #931a1a;'>
                    <tr>
                        <td style='padding: 4px;border: 1px solid #ceb7b7;'>STT</td>
                        <td style='padding: 4px; border: 1px solid #ceb7b7;'>Ảnh sản phẩm</td>
                        <td style='padding: 4px;border: 1px solid #ceb7b7;'>Tên sản phẩm</td>
                        <td style='padding: 4px; border: 1px solid #ceb7b7;'>Đơn giá</td>
                        <td style='padding: 4px; border: 1px solid #ceb7b7;'>Số lượng</td>
                        <td style='padding: 4px; border: 1px solid #ceb7b7;'>Thành tiền</td>
                    </tr>
                </thead>
                <tbody>
                ";

    $cnt = 0;

    foreach ($cart as $item) {
        $cnt++;
        $price = currency_format($item['price']);
        $sub_total = currency_format($item['sub_total']);
        $thumbnail = base_url("admin/{$item['thumbnail']}");

        $template .= "
                    <tr>
                    <td style='padding: 4px;border: 1px solid #ceb7b7;'>{$cnt}</td>
                    <td style='padding: 4px; border: 1px solid #ceb7b7;'>
                        <img style='max-width: 80px; height: auto;' src='{$thumbnail}' alt=''>
                    </td>
                    <td style='padding: 4px;border: 1px solid #ceb7b7;'>{$item['name']}</td>
                    <td style='padding: 4px;border: 1px solid #ceb7b7;'>{$price}</td>
                    <td style='padding: 4px; border: 1px solid #ceb7b7;'>{$item['qty']}</td>
                    <td style='padding: 4px; border: 1px solid #ceb7b7;'>{$sub_total}</td>
                </tr>
                    ";
    };

    $num_order = num_cart();
    $total = currency_format(total_cart());

    $template .= "
        </tbody>
        </table>
        </div>
        </div>
        <div style='margin-bottom: 20px;font-size: 15px;'>
        <h3 style=' font-size: 20px;letter-spacing: 2px;color: #e01111;'>Giá trị đơn hàng</h3>
        <div style='color: #444;font-size: 14px;'>
        <ul style='list-style: none;text-align: right;'>
            <li>
                <span style=' padding: 10px;'>Tổng số lượng</span>
                <span style='padding: 8px;'>Tổng đơn hàng</span>
            </li>
            <li style='color: #db435d; font-size: 16px;  font-weight: 600;'>
                <span style='padding: 10px;'>{$num_order} sản phẩm</span>
                <span style='padding: 8px;'>{$total}</span>
            </li>
        </ul>
        </div>
        </div>
        </div>
        ";

    return $template;
}


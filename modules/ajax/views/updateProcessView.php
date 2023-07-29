<?php

$id = (int)$_POST['id'];
$num_order = $_POST['num_order'];

$index = 0;

foreach ($_SESSION['cart'] as $key => $item) {
    if ($item['id'] == $id) {
        $index = $key;
        $_SESSION['cart'][$key]['qty'] = $num_order;
        $_SESSION['cart'][$key]['sub_total'] = $_SESSION['cart'][$key]['qty'] * $_SESSION['cart'][$key]['price'];
    }
}

update_cart();


$sub_total = $_SESSION['cart'][$index]['sub_total'];
$total = total_cart();
$num_cart = num_cart();

$result = array(
    'sub_total' => currency_format($sub_total),
    'total' => currency_format($total),
    'num_cart' => $num_cart
);

echo json_encode($result);

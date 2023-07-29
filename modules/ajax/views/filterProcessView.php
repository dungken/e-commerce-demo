<?php

$data_r_sm = (int)$_POST['data_r_sm'];
$data_r_lg = (int)$_POST['data_r_lg'];
$cat_id = (int)$_POST['cat_id'];

$num_per_page = 8;
$total_row = db_num_rows("SELECT * FROM `products` WHERE `cat_id` = {$cat_id} AND `status` = 'inStock' AND `deleted_at` IS NULL");
$num_page = ceil($total_row / $num_per_page);
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $num_per_page;

$where = "(`cat_id` = {$cat_id}) AND (`status` = 'inStock') AND (`price` >= {$data_r_sm} AND `price` <= {$data_r_lg}) AND (`deleted_at` IS NULL)";

$products_filter = get_product_paginate($start, $num_per_page, $where);

foreach ($products_filter as &$item) {
    $cat = get_product_cat($cat_id);
    $item['url'] = base_url("san-pham/{$cat['slug']}-{$cat['id']}/{$item['slug']}-{$item['id']}");
    $item['url_add_cart'] = base_url("gio-hang/{$item['slug']}-{$item['id']}-{$cat['id']}");
    $item['url_buy_now'] = base_url("gio-hang/mua-ngay/{$item['slug']}-{$cat['id']}-{$item['id']}");
}

$_SESSION['products_filter'] = $products_filter;

if (!empty($_SESSION['products_filter']) && $num_page > 0) {
    $url = base_url("san-pham/{$cat['slug']}-{$cat['id']}/trang");
    $data_pagging = get_pagging($num_page, $page, $url, 'list-item clearfix');
} else
    $data_pagging = "";



$result = [
    'result' => $_SESSION['products_filter'],
    'cat_id' => $cat_id,
    'data_pagging' => $data_pagging
];



echo json_encode($result);

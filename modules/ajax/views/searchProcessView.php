<?php
$userInput = $_POST['userInput'];

if (empty($userInput))
    $userInput = 'null';

$data_search = get_data_search($userInput);


foreach ($data_search as &$item) {
    $cat = get_product_cat($item['cat_id']);
    $item['url'] = base_url("san-pham/{$cat['slug']}-{$cat['id']}/{$item['slug']}-{$item['id']}");
    $item['url_buy_now'] = base_url("gio-hang/mua-ngay/{$item['slug']}-{$cat['id']}-{$item['id']}");
}


$result = ['data_search' => $data_search];


echo json_encode($result);

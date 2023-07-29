<?php



function construct()
{
    load_model('index');
}

function indexAction()
{
    $cat_id = $_GET['cat_id'];

    if (!empty($_POST['select'])) {
        $val = $_POST['select'];
    } else {
        $val = 0;
    }

    if ($val == 1) {
        $field = 'name';
        $val = 'asc';
    } else if ($val == 2) {
        $field = 'name';
        $val = 'desc';
    } else if ($val == 3) {
        $field = 'price';
        $val = 'desc';
    } else {
        $field = 'price';
        $val = 'asc';
    }


    $num_per_page = 8;
    $total_row = db_num_rows("SELECT * FROM `products` WHERE `cat_id` = {$cat_id} AND `status` = 'inStock' AND `deleted_at` IS NULL");
    $num_page = ceil($total_row / $num_per_page);
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1) * $num_per_page;




    $where = "`cat_id` = {$cat_id} AND `status` = 'inStock' AND `deleted_at` IS NULL ORDER BY `{$field}` {$val} ";

    $products = get_product_paginate($start, $num_per_page, $where);

    foreach ($products as &$item) {
        $cat = get_product_cat($cat_id);
        $item['url'] = base_url("san-pham/{$cat['slug']}-{$cat['id']}/{$item['slug']}-{$item['id']}");
        $item['url_add_cart'] = base_url("gio-hang/{$item['slug']}-{$item['id']}-{$cat['id']}");
        $item['url_buy_now'] = base_url("gio-hang/mua-ngay/{$item['slug']}-{$cat['id']}-{$item['id']}");
    }


    $cats = get_product_cat();

    $cat = get_product_cat($cat_id);

    $data['cats'] = $cats;
    $data['cat'] = $cat;
    $data['products'] = $products;

    $data['page'] = $page;
    $data['num_page'] = $num_page;

    load_view('index', $data);
}

function detailAction()
{

    $id = (int)$_GET['id'];
    $cat_id = $_GET['cat_id'];

    $cat = get_product_cat($cat_id);

    $product = get_product($id, '');

    $products = get_product('', $cat_id);

    $imgs_relate_product = get_imgs_relate_product();

    // show_array($imgs_relate_product);


    $cats = get_product_cat();


    $data['cats'] = $cats;
    $data['cat'] = $cat;
    $data['product'] = $product;
    $data['products'] = $products;
    $data['imgs_relate_product'] = $imgs_relate_product;


    load_view('detail', $data);
}


function searchAction()
{
    $cats = get_product_cat();
    $data['cats'] = $cats;

    if (!empty($_POST['btn-search'])) {
        if (!empty($_POST['keyword'])) {
            $key_word = $_POST['keyword'];
            $data['key_word'] = $key_word;
            $data_search = get_data_search($key_word);
        }
    }


    if (!empty($data_search)) {
        $data['data_search'] = $data_search;
    } else
        $data['data_search'] = [];

    load_view('search', $data);
}

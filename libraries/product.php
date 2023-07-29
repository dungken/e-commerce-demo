<?php
function get_product_cat($cat_id = '', $limit = '')
{
    if ($cat_id) {
        $sql = "SELECT * FROM `product_cats` WHERE `status` = 'public' AND `id` = '{$cat_id}'";
        return db_fetch_row($sql);
    } else {
        if ($limit) {
            $sql = "SELECT * FROM `product_cats` WHERE `status` = 'public' LIMIT {$limit}";
            return db_fetch_array($sql);
        } else {
            $sql = "SELECT * FROM `product_cats` WHERE `status` = 'public'";
            return db_fetch_array($sql);
        }
    }
}


function get_product($id = '', $cat_id = '', $limit = '')
{
    if ($id) {
        $sql = "SELECT * FROM `products` WHERE `status` = 'inStock' AND `id` = '{$id}' AND `deleted_at` IS NULL";
        $data = db_fetch_row($sql);
    } else if ($cat_id) {
        if ($limit) {
            $sql = "SELECT * FROM `products` WHERE `status` = 'inStock' AND `cat_id` = {$cat_id} AND `deleted_at` IS NULL LIMIT {$limit} ";
            $data = db_fetch_array($sql);
        } else {
            $sql = "SELECT * FROM `products` WHERE `status` = 'inStock' AND `cat_id` = {$cat_id} AND `deleted_at` IS NULL";
            $data = db_fetch_array($sql);
        }
    } else {
        if ($limit) {
            $sql = "SELECT * FROM `products` WHERE `status` = 'inStock' AND `deleted_at` IS NULL LIMIT {$limit} ";
            $data = db_fetch_array($sql);
        } else {
            $sql = "SELECT * FROM `products` WHERE `status` = 'inStock' AND `deleted_at` IS NULL";
            $data = db_fetch_array($sql);
        }
    }

    return $data;
}


function get_product_bestsaler($percent)
{
    $data = [];
    $products = get_product('', '', '');
    foreach ($products as $product) {
        $qty_on_hand = $product['qty_on_hand'];
        $qty_sold = $product['qty_sold'];
        if ($qty_sold) {
            $qty_sold = $qty_sold;
        } else {
            $qty_sold = 0;
        }
        if ($qty_sold / $qty_on_hand > $percent) {
            $data[] = $product;
        }
    }
    return $data;
}


function get_product_paginate($start = 0, $num_per_page = 4, $where = "")
{
    if (!empty($where)) {
        $where = "WHERE $where";
    }
    return db_fetch_array("SELECT * FROM `products` {$where} LIMIT {$start}, {$num_per_page}");
}

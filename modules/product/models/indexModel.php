<?php


function get_imgs_relate_product()
{
    $sql = "SELECT * FROM `images_relate_products`";
    return db_fetch_array($sql);
}


function get_data_search($keyword)
{
    $sql = "SELECT * FROM `products` WHERE `name` LIKE '%{$keyword}%'";
    return db_fetch_array($sql);
}

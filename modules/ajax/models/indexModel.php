<?php 

function get_data_search($keyword)
{
    $sql = "SELECT * FROM `products` WHERE `name` LIKE '{$keyword}%'";
    return db_fetch_array($sql);
}

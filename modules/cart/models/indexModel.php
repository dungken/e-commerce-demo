<?php
function add_client($data)
{
    return db_insert('clients', $data);
}

function add_order($data)
{
    return db_insert('orders', $data);
}

function get_count_client()
{
    $sql = "SELECT * FROM `clients`";
    return count(db_fetch_array($sql));
}

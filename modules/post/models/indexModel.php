<?php

function get_post($id = '')
{
    if ($id) {
        $sql = "SELECT * FROM `posts` WHERE `id` = {$id} AND `status` = 'public'";
        return db_fetch_row($sql);
    } else {
        $sql = "SELECT * FROM `posts` WHERE `status` = 'public'";
        return db_fetch_array($sql);
    }
}


function get_post_paginate($start = 0, $num_per_page = 4, $where = "")
{
    if (!empty($where)) {
        $where = "WHERE $where";
    }
    return db_fetch_array("SELECT * FROM `posts` {$where} LIMIT {$start}, {$num_per_page}");
}


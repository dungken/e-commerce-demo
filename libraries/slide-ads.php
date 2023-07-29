<?php 
function get_ads()
{
    $sql = "SELECT * FROM `ads` order by RAND() LIMIT 1";
    return db_fetch_row($sql);
}

function get_slide($id = '')
{
    if ($id) {
        $sql = "SELECT * FROM `slides` WHERE `status` = 'public' AND `id` = '{$id}'";
        return db_fetch_row($sql);
    } else {
        $sql = "SELECT * FROM `slides` WHERE `status` = 'public'";
        return db_fetch_array($sql);
    }
}

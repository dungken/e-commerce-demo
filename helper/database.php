<?php
function get_pages()
{
    $sql = "SELECT * FROM `tbl_pages`";
    return db_fetch_array($sql);
}

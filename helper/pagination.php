<?php 
function get_pagging($num_page, $page, $base_url, $class = '', $id = '')
{
    $str_pagging = "<ul id='{$id}' class = '{$class}'>";
    if ($page > 1) {
        $page_prev = $page - 1;
        $str_pagging .= "<li><a href='{$base_url}-{$page_prev}.htm'><</a></li>";
    }
    for ($i = 1; $i <= $num_page; $i++) {
        $active = "";
        if($page == $i)
            $active = "class = 'active'";
        $str_pagging .= "<li><a {$active} href='{$base_url}-{$i}.htm'>{$i}</a></li>";
    }
    if ($page < $num_page) {
        $page_next = $page + 1;
        $str_pagging .= "<li><a href='{$base_url}-{$page_next}.htm'>></a></li>";
    }
    $str_pagging .= "</ul>";
    return $str_pagging;
}

<?php

function has_child($data, $cat_id)
{
    foreach ($data as $v) {
        if ($v['parent_id'] == $cat_id)
            return true;
    }
    return false;
}

function render_menu($data, $parent_id = 0, $level = 0)
{
    if ($level == 0)
        $res = "<ul class='list-item'>";
    else
        $res = "<ul class='sub-menu'>";
    foreach ($data as $v) {
        if ($v['parent_id'] == $parent_id) {
            $res .= "<li>";
            $res .= "<a href='{$v['url']}'>{$v['name']}</a>";
            if (has_child($data, $v['id'])) {
                $res .= render_menu($data, $v['id'], $level + 1);
            }
            $res .= "</li>";
        }
    }
    $res .= "</ul>";
    return $res;
}

?>

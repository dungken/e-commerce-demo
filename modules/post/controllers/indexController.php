<?php
function construct()
{
    load_model('index');
}

function indexAction()
{
    $num_per_page = 6;

    $total_row = db_num_rows("SELECT * FROM `posts` WHERE `status` = 'public'");

    $num_page = ceil($total_row / $num_per_page);

    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    $start = ($page - 1) * $num_per_page;

    $posts = get_post_paginate($start, $num_per_page, "`status` = 'public'");

    $data['posts'] = $posts;
    $data['page'] = $page;
    $data['num_page'] = $num_page;

    load_view('index', $data);
}


function detailAction()
{
    $id = (int)$_GET['id'];
    $post = get_post($id);

    // show_array($post);

    $data['post'] = $post;

    load_view('detail', $data);
}

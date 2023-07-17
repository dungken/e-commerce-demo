<?php
/*
 * --------------------------------
 * EMAIL
 * --------------------------------
 * Trong phần này chúng ta khai báo các thông số để cấu hình
 * gửi mail bằng php
 * --------------------------------
 * GIẢI THÍCH BIẾN
 * --------------------------------
 * protocol: Giao thức gửi mail
 * smtp_host: Host gửi mail
 * smtp_port: Cổng
 * smtp_user: Tên đăng nhập tài khoản gửi mail
 * smtp_pass: Password tài khoản gửi mail
 * smtp_port: Cổng
 * mailtype: Định dạng nội dung mail
 * charset: Mã ký tự nội dung mail(UTF-8)
 */

$config['email'] = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 465,
    'smtp_user' => 'phpmaster.dungken.dev@gmail.com',
    'smtp_pass' => 'ntxtktklrnwprjru',
    'fullname' => 'Dung Dev',
    'smtp_timeout' => '7',
    'mailtype' => 'html',
    'charset' => 'UTF-8'
);

global $config;

// $config = array(
//     'host' => 'smtp.gmail.com',
//     'username' => 'phpmaster.dungken.dev@gmail.com',
//     'fullname' => 'Dung Dev',
//     'password'=> 'ntxtktklrnwprjru',
//     'port' => 465
// );

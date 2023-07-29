<?php

function construct()
{
    load_model('index');
}
function indexAction()
{

    global $error, $email, $status;

    if (!empty($_POST['btn_sm_reg'])) {
        $error = array();
        if (empty($_POST['email'])) {
            $error['email'] = "Nhập email để nhận thông báo từ shop nha!";
        } else {
            if (!is_email($_POST['email'])) {
                $error['email'] = "Email chưa đúng định dạng!";
            } else {
                $email = $_POST['email'];
            }
        }

        if (empty($error)) {
            $data = ['email' => $email];
            db_insert('news', $data);
            $status = "<p class = 'success'>Cảm ơn bạn đã đăng ký, sẽ có nhiều ưu đãi trong thời gian tới!</p>";
        }
        return redirect_to(base_url());
    }


    
    $cats = get_product_cat('');
    $data['cats'] = $cats;

    load_view('index', $data);
}


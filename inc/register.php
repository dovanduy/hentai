<?php

function registration_form($username,$email,$password, $repassword, $referer) {

    $html ='<form  id="loginForm" action="'.$_SERVER["REQUEST_URI"].'" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" id="username" name="username" placeholder="*Tài khoản" value="'.(isset($_POST['username'])? $username : null).'">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" id="email" placeholder="*Địa chỉ email" value="'.(isset($_POST['email'])? $email : null).'">
                </div>
                <div class="form-group psw">
                    <input type="password" class="form-control" name="password" id="password" placeholder="*Mật khẩu" value="'.(isset($_POST['password'])? $password : null).'">
                    <i class="zi icon_btn zi_eyeslash" zico=""></i>
                </div>
                <div class="form-group psw_sec">
                    <input type="password" class="form-control" id="repassword" name="repassword" placeholder="*Nhập lại mật khẩu" value="'.(isset($_POST['repassword'])? $repassword : null).'">
                    <i class="zi icon_btn zi_eyeslash" zico=""></i>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="referer" name="referer" placeholder="Mã giới thiệu(không bắt buộc)" value="'.(isset($_POST['referer'])? $referer : null).'">
                </div>
                <div class="form-check">
                    <label class="text-light mr-auto">
                        <input class="form-check-input" type="checkbox"> Đồng ý
                        <a href="javascript:;" class="nav-link d-inline" data-toggle="modal" data-target="#exampleModalCenter" style="color: aqua;padding: 0">điều khoản sử dụng</a>
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Đồng Ý Quay Tay Với Hentaivn

                                    </div>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Đăng ký</button>
            </form>';
    echo $html;
}

function registration_validation($username,$email,$password,$repassword,$referer) {
    global $reg_errors;
    $reg_errors = new WP_Error;

    if(empty($username) || empty($password) || empty($email)) {
        $reg_errors->add('field', 'Thông Tin Đăng Đăng Ký Không Được Để Trống!');
    }
    if(4 > strlen($username)) {
        $reg_errors->add('username_length', 'Tên Đăng Nhập Không Được Nhỏ Hơn 4 Ký Tự');
    }
    if(username_exists($username)) {
        $reg_errors->add('user_name', 'Tên Đăng Nhập Đã Được Sử Dụng');
    }
    if($repassword != $password) {
        $reg_errors->add('password_err', 'Mật Khẩu Không Trùng nhau');
    }
    if(!validate_username($username)) {
        $reg_errors->add('username_invalid', 'Tên Đăng Nhập Không Hợp Lệ');
    }
    if(5 >strlen($password)) {
        $reg_errors->add('password_length', 'Mật Khẩu phải nhiều hơn 5 ký tự');
    }

    if(!is_email($email)) {
        $reg_errors->add('email_invalid', 'Email không hợp lệ');
    }

    if(email_exists($email)) {
        $reg_errors->add('email', 'Địa Chỉ Email đã được sử dụng');
    }

    if (is_wp_error($reg_errors)) {
        echo '<div class="erro_dk" >';
        foreach ($reg_errors->get_error_messages() as $error) {
            echo '<div class="err">';
            echo '<strong>ERROR</strong>:';
            echo $error . '<br/>';
            echo '</div>';
        }
        echo '</div>';
    }
}

function complete_registration() {
    global $reg_errors, $username, $password, $email;
    if(1 > count($reg_errors->get_error_messages())) {
        $userdata = [
            'user_login'=>$username,
            'user_email'=>$email,
            'user_pass' =>$password
        ];
        $user = wp_insert_user($userdata);
        echo '<script>
            document.querySelector(".alert1").style.display="block";
            document.querySelector(".alert__close").addEventListener("click", function() {
                document.querySelector(".alert1").style.display = "none";
            })
        </script>';
    }
}

function custom_registration_function() {
    $username   = '';
    $password   = '';
    $email      = '';
    $referer    = '';
    $repassword = '';

    if(isset($_POST['submit'])) {
        registration_validation($_POST['username'],$_POST['email'],$_POST['password'],$_POST['repassword'],$_POST['referer']);
        global $username, $password, $email;
        $username   = sanitize_user( $_POST['username'] );
        $password   = esc_attr( $_POST['password'] );
        $email      = sanitize_email( $_POST['email'] );
        $referer    = esc_attr( $_POST['referer'] );
        $repassword = esc_attr( $_POST['repassword'] );
        complete_registration();

    }
    
    registration_form($username,$email,$password,$repassword,$referer);
}
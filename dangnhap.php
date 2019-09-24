<?php
/* Template Name: Login */
if(is_user_logged_in()) {
    $home_url = home_url();
    wp_redirect($home_url);
}
get_header();?>

<div class="main_box">
    <div class="container">
        <div class="login_box text-center animated fadeIn">
            <h2 class="text-light">Đăng Nhập</h2>
            <form id="loginForm" action="<?php echo site_url( '/wp-login.php' ); ?>" method="post">
                <div class="form-group">
                    <input type="text" class="form-control"  name="log" id="log" placeholder="Tên Đăng Nhập">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Mật Khẩu">
                    <i class="zi zi_eyeslash icon_btn" zico=""></i>
                </div>

                <button type="submit" class="btn btn-primary">Đăng Nhập</button>
                <div class="form-check">
                    <label class="text-light mr-auto">
                        <input class="form-check-input" type="checkbox"> Nhớ mật khẩu
                    </label>
                    <a href="<?php echo home_url('/').'wp-login.php?action=lostpassword';?>" class="nav-link text-light">Quên mật khẩu?</a>
                </div>
                <hr>
                <div class="form-group">
                    <a href="<?php echo home_url('/').'dang-ky/';?>" class="register btn btn-outline-info">Đăng Ký ngay</a>
                </div>
            </form>
        </div>

    </div>
</div>

<?php get_footer();?>
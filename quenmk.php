<?php
/* Template Name: ForgetPwd */
get_header();?>

<div class="main_box">
    <div class="container">
        <div class="login_box text-center animated fadeIn">
            <h2 class="text-light">Khôi Phục Mật Khẩu Của Bạn</h2>
            <div class="lost-info">
                Vui Lòng Nhập Tên Đăng Nhập Hoặc Email Để Reset Mật Khẩu. Mật Khẩu Mới Sẽ Được Gửi Tới Bạn Qua Email Đăng Ký
            </div>
            <form id="loginForm" name="lostpasswordform" action="<?php echo home_url('/').'wp-login.php?action=lostpassword';?>" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" id="user_login" name="user_login"  placeholder="Tên Đăng Nhập Hoặc Email">
                </div>

                <button type="submit"  name="wp-submit" class="btn btn-primary">Khôi Phục Mật Khẩu</button>
                <div class="form-group">
                    <a href="<?php echo home_url('/');?>" class="register btn btn-outline-info">Trở Lại Trang Chủ</a>
                </div>
            </form>
        </div>

    </div>
</div>

<?php get_footer();?>

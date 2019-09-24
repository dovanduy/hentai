<?php
/* Template Name: Register */

if(is_user_logged_in()) {
    wp_redirect(home_url('/'));
}

get_header();?>

<div class="main_box">
    <div class="container">
        <div class="login_box text-center animated fadeIn">
            <h2 class="text-light">Đăng ký</h2>
            <?php custom_registration_function();?>
        </div>

    </div>
</div>

<?php get_footer();?>
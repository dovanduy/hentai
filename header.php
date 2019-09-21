<?php
/**
 * The template for displaying the header.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body>
<div class="header">
    <nav class="navbar navbar-expand-md  fixed-top">
        <a class="navbar-brand" href="<?php echo home_url('/');?>"><img src="<?php echo HENTAI_URL.'/img/logo.png';?>" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation"> 
            <span class="navbar-toggler-icon"></span> 
        </button>
        <div class="collapse navbar-collapse" id="navbarsExample04">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-light" href="http://example.com" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Thể Loại</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown04">
                        <?php
                            $categories = get_categories();
                            if($categories) {
                                foreach($categories as $cat) {
                                    echo '<a class="dropdown-item" href="'.get_category_link($cat->term_id).'">'.$cat->name.'</a>';
                                }
                            }
                        ?>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-md-0 mr-auto form-inline-search">
                <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                <button class="btn my-2 my-sm-0" type="submit"><i class="zi zi_searchBlack"></i></button>
            </form>
            <?php if(!is_user_logged_in()):?>
            <div class="unlogin">
                <a class="text-light nav-link" href="<?php echo home_url('/').'dang-ky/';?>">đăng ký</a>
                <a class="text-light nav-link" href="<?php echo home_url('/').'dang-nhap/';?>">đăng nhập</a>
                <div class="dropdown d-inline">
                    <button class="btn btn-outline-dark dropdown-toggle text-light" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        VI
                    </button>

                    <div class="dropdown-menu dropdown-menu-right text-light" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">VI</a>
                        <a class="dropdown-item" href="#">EN</a>
                    </div>
                </div>
            </div>
            <?php else:
                
                $current_user = wp_get_current_user(); 
                $userimg = get_user_meta($current_user->ID,'avatar',true);
                if($userimg == '') {
                  $userimg = HENTAI_URL.'/img/user.png';
                }      
            ?>
            <div class="islogin">
                <div class="dropdown d-inline">
                    <a class="nav-link dropdown-toggle text-light" href="javascript:;" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo $userimg;?>" width="40" alt="" style="margin-right: 10px;"><?php echo $current_user->user_login;?></a>
                    <div class="dropdown-menu dropdown-menu-right text-light" aria-labelledby="dropdown03">
                        <a class="dropdown-item" href="<?php echo home_url('/').'profile/';?>">
                            <i class="zi zi_idCheck"></i> Thông Tin Cá Nhân
                        </a>
                        <a class="dropdown-item" href="<?php echo home_url('/').'doi-mat-khau/';?>"><i class="zi zi_key"></i> Đổi Mật Khẩu</a>
                        <a class="dropdown-item" href="<?php echo home_url('/').'danh-sach-cua-toi/';?>"><i class="zi zi_fileGraph"></i> Danh Sách Của Tôi</a>
                        <a class="dropdown-item" href="<?php echo wp_logout_url(home_url()); ?>"><i class="zi zi_poweroff"></i> Đăng Xuất</a>
                    </div>
                </div>
                <div class="dropdown d-inline">
                    <button class="btn btn-outline-dark dropdown-toggle text-light" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            VI
                        </button>
                    <div class="dropdown-menu dropdown-menu-right text-light" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="javascript:;">VI</a>
                        <a class="dropdown-item" href="javascript:;">EN</a>
                    </div>
                </div>
            </div>
            <?php endif;?>
        </div>
    </nav>

</div>
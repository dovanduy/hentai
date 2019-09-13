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
        <a class="navbar-brand" href="#"><img src="<?php echo HENTAI_URL.'/img/logo.png';?>" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation"> 
            <span class="navbar-toggler-icon"></span> 
        </button>
        <div class="collapse navbar-collapse" id="navbarsExample04">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-light" href="http://example.com" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown04">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-md-0 mr-auto form-inline-search">
                <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                <button class="btn my-2 my-sm-0" type="submit"><i class="zi zi_searchBlack"></i></button>
            </form>
            <div class="unlogin">
                <a class="text-light nav-link" href="/login.html">đăng ký</a>
                <a class="text-light nav-link" href="/register.html">đăng nhập</a>
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
            <div class="islogin">
                <div class="dropdown d-inline">
                    <a class="nav-link dropdown-toggle text-light" href="javascript:;" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo HENTAI_URL.'/img/user.png';?>" width="40" alt="" style="margin-right: 10px;">Dropdown</a>
                    <div class="dropdown-menu dropdown-menu-right text-light" aria-labelledby="dropdown03">
                        <a class="dropdown-item" href="#"><img src="<?php echo HENTAI_URL.'/img/user.png';?>" alt="">
                            <div>
                                <router-link :to="{name:'center'}" class="text-light">user</router-link>
                                <span>email@123456455458gmail.com</span>
                            </div>
                        </a>
                        <a class="dropdown-item" href="#"><img src="<?php echo HENTAI_URL.'/img/set.png';?>" alt="">đăng ký</a>
                        <a class="dropdown-item" href="#"><img src="<?php echo HENTAI_URL.'/img/rect.png';?>" alt="">đăng ký</a>
                        <a class="dropdown-item" href="#"><img src="<?php echo HENTAI_URL.'/img/openbook.png';?>" alt="">đăng ký</a>
                    </div>
                </div>
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

        </div>
    </nav>

</div>
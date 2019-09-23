<?php
/* Template Name: Hentai Search */

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
<body >
<div class="wp" id="hentai-search">
    <div class="header">
        <nav class="navbar navbar-expand-md  fixed-top">
            <a class="navbar-brand" href="<?php echo home_url('/');?>"><img src="<?php echo HENTAI_URL.'/img/logo.png';?>" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation"> 
                <span class="navbar-toggler-icon"></span> 
            </button>
            <div class="collapse navbar-collapse" id="navbarsExample04">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="javascript:;" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Thể Loại</a>
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
                <form class="form-inline my-2 my-md-0 mr-auto form-inline-search" action="<?php echo home_url('/');?>" method="get">
                    <input class="form-control"  id="search" v-model="search" @keyup="loadMovie()" placeholder="Search" aria-label="Search">
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
    <div class="search_box" >
    <div class="nav_list">
        <span id="search_1"><i></i><em>taget</em></span>
        <span id="search_2"><i></i><em>black</em></span>
        <span id="search_3"><i></i><em>reset</em></span>
        <span id="search_4">
            <i></i><em>sort</em>
            <div class="dialog3 hide">
                <ul>
                <li class="">new</li>
                <li class="">hot</li>
                <li class="">old</li>
                <li class="cur">like</li>
                </ul>
            </div>
        </span>
    </div>
    <div class="dialog-box" id="search_dialog" style="display: none;">
        <div class="dialog dialog1" style="display: none;">
            <div class="dialog_head">
                <i class="zi zi_windowclose close"></i>
                <span class="title">Bao gồm tag</span>
                <span class="reset">Reset</span>
            </div>
            <div class="cnt">
                <h2>Bao gồm tag</h2>
                <span>Tìm phim bao gồm các tag sau</span>
                <div class="box_list" v-if="tags.length">
                <span class="" v-for="(tag,index) in tags">{{tag.name}}</span>
                </div>
            </div>
            <div class="foot">
                <button class="subimit_taget1">xác nhận</button>
                <div><a href="javascript:;" class="close_1">Hủy</a></div>
            </div>
        </div>
        <div class="dialog dialog2" style="display: none;">
            <div class="dialog_head">
                <i class="zi zi_windowclose close"></i>
                <span class="title">Bao gồm tag</span>
                <span class="reset">Reset</span>
            </div>
            <div class="cnt">
                <h2>Bao gồm tag</h2>
                <span>Tìm phim bao gồm các tag sau</span>
                <div class="box_list" v-if="cats.length">
                <span v-for="(cat,index) in cats">{{cat.name}}</span>
                </div>
            </div>
            <div class="foot">
                <button class="subimit_taget2">xác nhận</button>
                <div><a href="javascript:;" class="close_2">Hủy</a></div>
            </div>
        </div>
    </div>
    <div class="search_cnt">
        <ul class="cnt_box" v-if="movies.length">

            <li v-for="(movie,index) in movies" :key="movie.id">
                <a href="url">
                <img :src="movie.img" :alt="movie.title" width="100%">
                <div class="cnt">
                    <h2>{{movie.title}}</h2>
                    <span>{{movie.views}} lượt xem</span>
                </div>
                </a>
            </li>
            
        </ul>
    </div>
    <div id="ampagination-bootstrap" >
        <ul class="pagination" v-if="pageNumber.length">
            <li v-for="(num,index) in pageNumber" :key="index" :class="num == page ? 'active':''">
                <a href="javascript:;" @click="updatePage(num)">{{num}}</a>
            </li>
        </ul>
    </div>
    </div>
</div>
<script>
    <?php
        global $wp_query;
        
        $cats = getCategoryVue('cat');
        $tags = getCategoryVue('tag');
    ?>
    const search = new Vue({
        el:'#hentai-search',
        data: {
            movies:[],
            tags:<?php echo $tags;?>,
            cats:<?php echo $cats;?>,
            page:1,
            itemPerPage:<?php echo get_option('posts_per_page');?>,
            totalItems:0,
            search:'',
            isSearch:false,
        },
        methods: {
            async getMovie() {
                let body = new FormData;
                body.append('action','hentai_movie_paginate');
                body.append('page', this.page);
                body.append('nonce','<?php echo wp_create_nonce("hentaivn");?>');
                const res = await axios.post('<?php echo admin_url("admin-ajax.php");?>',body,{headers:{'Content-type': 'application/x-www-form-urlencoded'}});
                if(res.data.status === 'success') {
                    this.movies = res.data.movie;
                    this.totalItems = res.data.total;
                }

            },
            async loadSearch() {
                let body = new FormData;
                body.append('action','hentai_load_search');
                body.append('page', this.page);
                body.append('query', this.search);
                body.append('nonce','<?php echo wp_create_nonce("hentaivn");?>');
                const res = await axios.post('<?php echo admin_url("admin-ajax.php");?>',body,{headers:{'Content-type': 'application/x-www-form-urlencoded'}});
                if(res.data.status === 'success') {
                    this.movies = res.data.movie;
                    this.totalItems = res.data.total;
                }
            },
            pagination(c, m) {
                var current = c,
                    last = m,
                    delta = 2,
                    left = current - delta,
                    right = current + delta + 1,
                    range = [],
                    rangeWithDots = [],
                    l;

                for (let i = 1; i <= last; i++) {
                    if (i == 1 || i == last || i >= left && i < right) {
                        range.push(i);
                    }
                }

                for (let i of range) {
                    if (l) {
                        if (i - l === 2) {
                            rangeWithDots.push(l + 1);
                        } else if (i - l !== 1) {
                            rangeWithDots.push('...');
                        }
                    }
                    rangeWithDots.push(i);
                    l = i;
                }

                return rangeWithDots;
            },
            updatePage(number) {
                if(number == '...') return;
                this.page = number;
                if(this.isSearch == false) {
                    this.getMovie();
                }
                
            },
           

            loadMovie() {
                this.loadSearch();
            }
        },
        created(){
            this.getMovie();
        },
        computed: {
            pageNumber() {

                if(this.itemPerPage >= this.totalItems ) return [];
                var totalpage = Math.ceil(this.totalItems / this.itemPerPage);
                return this.pagination(this.page, totalpage);
            },
        }
    });
</script>
<?php get_footer();?>

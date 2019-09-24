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
                <form class="form-inline my-2 my-md-0 mr-auto form-inline-search">
                    <input class="form-control"  id="search" v-model="search" @keyup="loadMovie" placeholder="Search" aria-label="Search">
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
        <span id="search_1" @click="openTag"><i></i><em>Tags</em></span>
        <span id="search_2" @click="openCat"><i></i><em>Thể Loại</em></span>
        <span id="search_3" @click="resetAll"><i></i><em>Reset</em></span>
        <span id="search_4" @click="isSortOpen = !isSortOpen">
            <i></i><em>Sắp Xếp</em>
            <div class="dialog3" v-if="isSortOpen">
                <ul>
                <li class="" @click="getLastestMovie">New</li>
                <li class="" @click="getHotestMovie">Hot</li>
                </ul>
            </div>
        </span>
    </div>
    <div class="dialog-box" id="search_dialog" v-if="isTagOpen || isCatOpen">
        <div class="dialog dialog1" v-if="isTagOpen">
            <div class="dialog_head">
                <i class="zi zi_windowclose close" @click="closeDialog"></i>
                <span class="title">Bao gồm tag</span>
                <span class="reset" @click="resetTag">Reset</span>
            </div>
            <div class="cnt">
                <h2>Bao gồm tag</h2>
                <span>Tìm phim bao gồm các tag sau</span>
                <div class="box_list" v-if="tags.length">
                <span class="" v-for="(tag,index) in tags" @click="toogleTags(tag.id)" :class="tag_ids.length && tag_ids.includes(tag.id)? 'cur':''">{{tag.name}}</span>
                </div>
            </div>
            <div class="foot">
                <button class="subimit_taget1" @click="loadFilter">xác nhận</button>
                <div><a href="javascript:;" class="close_1"  @click="closeDialog">Hủy</a></div>
            </div>
        </div>
        <div class="dialog dialog2" v-if="isCatOpen">
            <div class="dialog_head">
                <i class="zi zi_windowclose close"  @click="closeDialog"></i>
                <span class="title">Bao gồm tag</span>
                <span class="reset" @click="resetCat">Reset</span>
            </div>
            <div class="cnt">
                <h2>Bao gồm tag</h2>
                <span>Tìm phim bao gồm các tag sau</span>
                <div class="box_list" v-if="cats.length">
                <span v-for="(cat,index) in cats" @click="toogleCats(cat.id)" :class="cat_ids.length && cat_ids.includes(cat.id)? 'cur':''">{{cat.name}}</span>
                </div>
            </div>
            <div class="foot">
                <button class="subimit_taget2"  @click="loadFilter">xác nhận</button>
                <div><a href="javascript:;" class="close_2"  @click="closeDialog">Hủy</a></div>
            </div>
        </div>
    </div>
    <div class="search_cnt">
   
        <ul class="cnt_box" v-if="movies.length" key="okokoo" :class="animate? 'animated fadeIn':''">
           
            <li v-for="(movie,index) in movies" :key="movie.id">
                <a :href="movie.url">
                <img v-hentai-lazyload :data-src="movie.img" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" :alt="movie.title" width="100%">
                <div class="cnt">
                    <h2>{{movie.title}}</h2>
                    <span>{{movie.views}} lượt xem</span>
                </div>
                </a>
            </li>
        
        </ul>
 
        <div class="not-found" v-else-if="isSearch || isFilter"> Xin Lỗi Chúng Tôi Không Tìm Thấy Movie Bạn Yêu Cầu</div>
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
    Vue.directive('hentai-lazyload',{
        inserted: function(el) {
            function loadImage() {
                el.addEventListener('error',function() {
                    console.log('error');
                })
                el.src = el.dataset.src
            }
            function handleIntersect(entries, observer) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        loadImage();
                        observer.unobserve(el);
                    }
                });
            }
            function createObserver() {
                const options = {
                    root: null,
                    threshold: "0"
                };
                const observer = new IntersectionObserver(handleIntersect, options);
                observer.observe(el);
                
            }
            if (window["IntersectionObserver"]) {
                createObserver();
            } else {
                loadImage();
                
            }
 
        }
    });
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
            isFilter: false,
            tag_ids:[],
            cat_ids:[],
            isTagOpen:false,
            isCatOpen:false,
            isSortOpen: false,
            animate: false
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
                    this.animate = true;
                }

            },
            async loadSearch() {
                let body = new FormData;
                if(this.search === '') {
                    this.isSearch = false;
                    this.getMovie();
                    return;
                }
                body.append('action','hentai_load_search');
                body.append('page', this.page);
                body.append('query', this.search);
                body.append('nonce','<?php echo wp_create_nonce("hentaivn");?>');
                const res = await axios.post('<?php echo admin_url("admin-ajax.php");?>',body,{headers:{'Content-type': 'application/x-www-form-urlencoded'}});
                if(res.data.status === 'success') {
                    this.isSearch = true;
                    this.movies = res.data.movie;
                    this.totalItems = res.data.total;
                    this.animate = true;
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
                if(this.isFilter == false) {
                    if(this.isSearch == false) {
                        this.getMovie();
                    } else {
                        this.loadSearch();
                    }
                } else {
                    this.loadFilter();
                }
                
            },
           
            loadMovie(e) {
                this.loadSearch();
            },
            toogleTags(id) {
                this.isFilter = true;
                let index = this.tag_ids.map(tag => tag).indexOf(id)
                if( index > -1) {
                    this.tag_ids = this.tag_ids.filter(tag => tag != id);
                } else {
                
                    this.tag_ids = [... this.tag_ids,id];
                }
            },
            toogleCats(id) {
                this.isFilter = true;
                let index = this.cat_ids.map(cat => cat).indexOf(id)
                if( index > -1) {
                    this.cat_ids = this.cat_ids.filter(cat => cat != id);
                } else {
                
                    this.cat_ids = [... this.cat_ids,id];
                }
            },
            async loadFilter() {
                if(this.tag_ids.length || this.cat_ids.length) {
                    let body = new FormData;
                    body.append('action','hentai_load_filter');
                    body.append('page',this.page);
                    body.append('tag_ids',this.tag_ids);
                    body.append('cat_ids',this.cat_ids);
                    body.append('nonce','<?php echo wp_create_nonce("hentaivn");?>');
                    const res = await axios.post('<?php echo admin_url("admin-ajax.php");?>',body,{headers:{'Content-type': 'application/x-www-form-urlencoded'}});
                    if(res.data.status ==='success') {
                        this.movies = res.data.movie;
                        this.totalItems = res.data.total;
                        this.closeDialog();
                        this.animate = true;
                    }
                } else {
                    this.closeDialog();
                }
            },
            resetAll() {
                this.cat_ids = [];
                this.tag_ids = [];
                this.search = '';
                this.isSearch = false;
                this.isFilter = false;
                this.page = 1;
                this.loadMovie();
            },
            resetTag() {
                this.tag_ids = [];
                
                if(this.cat_ids.length) {
                    this.page = 1;
                    this.loadFilter();
                } else {
                    this.isFilter = false;
                    this.loadMovie();
                }
            },
            resetCat() {
                this.cat_ids = [];
               
                if(this.tag_ids.length) {
                    this.page = 1;
                    this.loadFilter();
                } else {
                    this.isFilter = false;
                    this.loadMovie();
                }
            },
            openTag() {
                this.isTagOpen = true;
            },
            openCat() {
                this.isCatOpen = true;
            },
            closeDialog() {
                this.isTagOpen = false;
                this.isCatOpen = false;
            },
            async getLastestMovie() {
                let body = new FormData;
                body.append('action','hentai_lastest_movie');
                body.append('nonce','<?php echo wp_create_nonce("hentaivn");?>');
                const res = await axios.post('<?php echo admin_url("admin-ajax.php");?>',body,{headers:{'Content-type': 'application/x-www-form-urlencoded'}});
                if(res.data.status === 'success') {
                    this.movies = res.data.movie;
                    this.animate = true;
                }

            },
            async getHotestMovie() {
                let body = new FormData;
                body.append('action','hentai_hot_movie');
                body.append('nonce','<?php echo wp_create_nonce("hentaivn");?>');
                const res = await axios.post('<?php echo admin_url("admin-ajax.php");?>',body,{headers:{'Content-type': 'application/x-www-form-urlencoded'}});
                if(res.data.status === 'success') {
                    this.movies = res.data.movie;
                    this.animate = true;
                }

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
            
            
        },
        watch: {
            animate(newvl) {
                if(newvl == true) {
                    const that = this;
                    setTimeout(function() {
                        that.animate = false;
                    },1000);
                }
            }
        }
    });
</script>
<?php get_footer();?>

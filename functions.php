<?php

define('HENTAI_URL',get_template_directory_uri());
define('HENTAI_PATH',get_template_directory());

add_action('after_setup_theme', 'hentai_after_setup_theme' );
function hentai_after_setup_theme() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'automatic-feed-links' );

    add_theme_support( 'post-thumbnails' );

    register_nav_menus( array(
        'primary-menu' => __( 'Primary', 'hentaivn' ),
        'footer-menu' => __( 'Footer', 'hentaivn' ),
        'mobile' => __( 'Mobile', 'hentaivn' )
    ) );

    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

add_action( 'widgets_init', 'hentai_register_sidebars' );
function hentai_register_sidebars() {
    
    register_sidebar( array(
        'name' => __('right-sidebar', 'hentaivn'),
        'description'   => __( 'Default sidebar.', 'hentaivn' ),
        'id' => 'sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    register_sidebar( array(
        'name' => __('home-sidebar', 'hentaivn'),
        'description'   => __( 'homepage sidebar for slider.', 'hentaivn' ),
        'id' => 'home-sidebar',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ) );
}

add_action('wp_enqueue_scripts','hentai_add_css',999);
function hentai_add_css() {
    wp_enqueue_style('hentai_style',get_stylesheet_uri());
    wp_enqueue_style('bootstrap_css', HENTAI_URL.'/css/bootstrap.css');
    wp_enqueue_style('zico_css', HENTAI_URL.'/css/zico.min.css');
    wp_enqueue_style('public_css', HENTAI_URL.'/css/public.css');
    wp_enqueue_style('serach_css', HENTAI_URL.'/css/search.css');
    wp_enqueue_style('video_css', HENTAI_URL.'/css/video.css');
    wp_enqueue_style('swiper_css', HENTAI_URL.'/css/swiper.min.css');
    wp_enqueue_style('index_css', HENTAI_URL.'/css/index.css');
}

add_action('wp_enqueue_scripts','hentai_add_scripts');
function hentai_add_scripts() {
    wp_enqueue_script('bootstrap_js',HENTAI_URL.'/js/bootstrap.js',['jquery'],'1.0.0', true);
    wp_enqueue_script('popper_js',HENTAI_URL.'/js/popper.min.js',['jquery'],'1.0.0', true);
    wp_enqueue_script('public_js',HENTAI_URL.'/js/public.js',['jquery'],'1.0.0', true);
    wp_enqueue_script('swiper_js',HENTAI_URL.'/js/swiper.min.js',['jquery'],'1.0.0', false);
    
    if(is_page_template('img-gallery.php') || is_page_template('hentai-search.php')) {
        wp_enqueue_script('vue','//cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js',[],'1.0.0', false);
        wp_enqueue_script('axios','//cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js',[],'1.0.0', false);
    }
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
    }
    if(is_single()) {
        wp_enqueue_script('jwplayer','//ssl.p.jwpcdn.com/player/v/8.1.3/jwplayer.js',[],'1.0.0', false);
        wp_add_inline_script('jwplayer','jwplayer.key = "W7zSm81+mmIsg7F+fyHRKhF3ggLkTqtGMhvI92kbqf/ysE99";');
    }
}

add_action( 'init', 'rename_posts_hentai_label' );
add_action( 'admin_menu', 'rename_posts_hentai' );
function rename_posts_hentai() {
    global $menu;
    global $submenu;
    $menu[5][0] = __("Hentai", 'hentaivn');
    $submenu['edit.php'][5][0] = __("Tất Cả Phim", 'hentaivn');
    $submenu['edit.php'][10][0] = __("Thêm Phim Mới", 'hentaivn');
    echo '';
}
function rename_posts_hentai_label() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = __("Hentai", 'hentaivn');
    $labels->singular_name = __("Phim", 'hentaivn');
    $labels->add_new = __("Phim Mới", 'hentaivn');
    $labels->add_new_item = __("Phim Mới", 'hentaivn');
    $labels->edit_item = __("Sửa Phim", 'hentaivn');
    $labels->new_item = __("Phim", 'hentaivn');
    $labels->view_item = __("Xem Phim", 'hentaivn');
    $labels->search_items = __("Tìm Phim", 'hentaivn');
    $labels->not_found = __("Không Tìm Thấy Phim", 'hentaivn');
    $labels->not_found_in_trash = __("Không Tìm Thấy Phim", 'hentaivn');
}

require_once HENTAI_PATH.'/inc/support.php';
global $support;
$support = new HenTai_Theme_Support;

require_once HENTAI_PATH.'/inc/login-register-redirect.php';

require_once HENTAI_PATH.'/inc/register.php';

require_once HENTAI_PATH.'/inc/metabox.php';

require_once HENTAI_PATH.'/inc/movie-slider.php';

require_once HENTAI_PATH.'/inc/model.php';

require_once HENTAI_PATH.'/inc/hentai-ajax.php';

function setpostview($postID){
    $count_key ='views';
    $count = get_post_meta($postID, $count_key, true);
    if($count == ''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
function getpostviews($postID){
    $count_key ='views';
    $count = get_post_meta($postID, $count_key, true);
    if($count == ''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}

function HentaiCropImg($postID, $postcontent, $width, $height, $suffixes){

    global $support;

    $feature_img = wp_get_attachment_url(get_post_thumbnail_id($postID));

    if($feature_img == false){
        $imgUrl1 = $support->get_img_url($postcontent);

        if($imgUrl1 == false){
            return false;
        } else {
           $imgUrl = $support->get_new_img_url($imgUrl1,$width,$height,$suffixes);
        }

    } else {
        $imgUrl = $support->get_new_img_url($feature_img,$width,$height,$suffixes);
    }

    return $imgUrl;
}


function archiveTitle() {

    if(is_category()){  
        $title = __('Category: ','hentaivn').single_cat_title('',false);
    }
    if(is_tag()){
         $title = __('Tags: ','hentaivn').single_tag_title('',false);
    }
    if(is_search()){
        $title = __('Search: ','hentaivn').get_search_query('',false);
    }
    if(is_date()){
        $title = __('Date: ','hentaivn').single_month_title('',false);
    }
    return $title;
}

function hentaiPagination( $custom_query = false ) {
    global $wp_query;
    if ( !$custom_query ) $custom_query = $wp_query;

    $paged_get = 'paged';
    if( is_front_page() && ! is_home() ):
        $paged_get = 'page';
    endif;
    $current = max( 1, get_query_var( $paged_get ) );
    $big = 999999999; // need an unlikely integer
    $pagination = paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var( $paged_get ) ),
        'total' => $custom_query->max_num_pages,
        'type'   => 'array',
        'prev_text'    => 'Trang Trước',
        'next_text'    => 'Trang Sau',
    ) );
    if ( $pagination ) {
        $return='<ul class="pagination">';
        foreach ($pagination as $key => $value) {
            if($current == wp_strip_all_tags($value)){
                $return.='<li class="paginate_button active"><a href="javascript:void(0)">'.wp_strip_all_tags($value).'</a></li>';
            }else{
                $return.='<li class="paginate_button ">'.$value.'</li>';
            }
            
        }
        $return .='</ul>';
        return $return;
    }

}

/**
 * @param $type: lastest, random, most
 * @param $opt: related-tag -- tags, related-cat -- categories
 * @param $cat: ID of cateogry
 * @param $number: number of post to show
 * @param $post_id; ID of post for related opt
 * @param $title: Custom title of SLide
 * @param $pos: position of Slide -- homepage, single, sidebar
 */

function ShowSlider($type = "lastest",$opt = "",$cat = 0, $number = 12, $post_id = "", $title = "Phim Mới Nhất",$pos="home") {
    
    $args = ['post_type' => 'post','post_per_page' => $number];

    $link = $cat!= 0? get_category_link($cat): 'javascript:;';

    if($type == 'lastest') {
        $args['orderby'] = 'ID';
        $args['order'] = 'DESC';
        if($cat != 0) {
            $args['category__in'] = [$cat];
        }
    }
    if($type == 'random') {
        $args['orderby'] = 'rand';

        if($cat != 0) {
            $args['category__in'] = [$cat];
        }
    }

    if($type == 'most') {
        $args['meta_key'] = 'views';
        $args['orderby'] = 'meta_value_num';
        
        if($cat != 0) {
            $args['category__in'] = [$cat];
        }
    }
    if($opt == 'related-cat' || $opt == 'related-tag') {
        if($post_id != '' && $cat == 0) {
            if($opt == 'related-cat') {
                $categories = get_the_category($post_id);
                $category_ids = [];
                foreach($categories as $cat) {
                    $category_ids[] = $cat->term_id;
                }
                $args['category__in'] = $category_ids;
                $args['post__not_in'] = [$post_id];
            }
            if($opt == 'related-tag') {
                $tags = get_the_tags($post_id);
                $tag_ids = [];
                foreach($tags as $tag) {
                    $tag_ids[] = $tag->term_id;
                }
                $args['tag__in'] = $tag_ids;
                $args['post__not_in'] = [$post_id];
            }
        }
    }
    $wrap = '';
    $head = '';
    $item = 6.3;
    $space = 30;

    if($pos === 'home') {
        $wrap = 'main_type1';
        $head = '<div class="list_head clear">
                    <div class="fl title">'.$title.'</div>
                    <div class="fr all_list"><a href="'.$link.'">'.__("All","hentaivn").'</a></div>
                </div>';
    } else if($pos === 'single') {
        $wrap = 'video_ralate';
        $head = '<div class="list_head clear">
                    <div class="fl title">'.$title.'</div>
                    <div class="fr all_list"><a href="'.$link.'">'.__("All","hentaivn").'</a></div>
                </div>';
    } else {
        $wrap = 'video_hot';
        $head = '<div class="mv_title">'.$title.'</div>';
        $item = 2;
        $space = 10;
    }

    $oxx = new WP_Query($args);
    $class_number = rand(1, 1000000);
    ob_start();
    if($oxx->have_posts()):
    ?>
    <div class="<?php echo $wrap;?>">
        <?php echo $head;?>
        <div class="swiper-container swiper-container-<?php echo $class_number;?>">
            <div class="swiper-wrapper">
                <?php while($oxx->have_posts()) : $oxx->the_post();
                    $img = HentaiCropImg($oxx->post->ID,$oxx->post->post_content,268,394,'-hentai-img-slider-');
                ?>
                <div class="swiper-slide">
                    <a href="<?php the_permalink();?>">
                        <img data-src="<?php echo $img;?>" class="swiper-lazy" width="100%">
                        <div class="swiper-lazy-preloader"></div>
                        <div class="cnt">
                            <h2><?php echo mb_substr(get_the_title(),0,20).'...';?></h2>
                            <span><?php echo getpostviews(get_the_ID());?>  <?php echo __(' views','hentaivn');?></span>
                        </div>
                    </a>
                </div>
                <?php endwhile; wp_reset_postdata();?>
            </div>
            <!-- Add Arrows -->
            <div class="swiper-button-next swiper-button-white"></div>
            <div class="swiper-button-prev swiper-button-white"></div>
        </div>
    </div>
    <script>
        var swiper<?php echo $class_number;?> = new Swiper('.swiper-container-<?php echo $class_number;?>', {
            lazy: {
                loadPrevNext: true,
                loadPrevNextAmount: 1,
            },
            effect: 'slide',
            freeMode: true,
            direction: 'horizontal',
            speed: 300,
            slidesPerView: <?php echo $item;?>,
            spaceBetween: <?php echo $space;?>,
            centeredSlides: false,
            slidesPerGroup: <?php echo $item;?>,
            breakpoints: { 
                767: {
                    slidesPerView: 2, 
                    spaceBetween: 5 ,
                    slidesPerGroup: 2
                }
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
    <?php endif;
    return ob_get_clean();
}

// Comment List

if ( ! function_exists( 'hentaivn_comments' ) ) {
    /**
     * Custom comments template.
     * @param $comment
     * @param $args
     * @param $depth
     */
    function hentaivn_comments( $comment, $args, $depth ) {
    	$GLOBALS['comment'] = $comment; ?>
    	<li class="list_list" id="li-comment-<?php comment_ID() ?>">
    		<?php
            switch( $comment->comment_type ) :
                case 'pingback':
                case 'trackback': ?>
                    <div id="comment-<?php comment_ID(); ?>" class="commentID">
                        <div class="comment-author vcard">
                            Pingback: <?php comment_author_link(); ?>
                           
                                <span class="ago"><?php comment_date( get_option( 'date_format' ) ); ?></span>
                        </div>
                        <?php if ( $comment->comment_approved == '0' ) : ?>
                            <em><?php _e( 'Bình luận của bạn đang chờ phê duyệt.', 'hentaivn' ) ?></em>
                            <br />
                        <?php endif; ?>
                    </div>
                <?php
                    break;

                default: ?>
                    <div id="comment-<?php comment_ID(); ?>" class="commentID" itemscope itemtype="http://schema.org/UserComments">
                        <div class="comment-author vcard">
                            <?php 
                                
                                $avatar = get_user_meta($comment->user_id,'avatar',true);
                                if($avatar == '') {
                                    $avatar = HENTAI_URL.'/img/user1.png';
                                }
                            ?>
                            <img src="<?php echo $avatar;?>" alt="avatar" width="100%">
                        </div>
                        
                        <div class="commentmetadata">
                            <div class="comment__header">
                                <?php printf( '<span class="fn" itemprop="creator" itemscope itemtype="http://schema.org/Person"><span itemprop="name">%s</span></span>', get_comment_author_link() ) ?>
                                <span class="ago"> - <?php comment_date( get_option( 'date_format' ) ); ?></span>
                            </div>
                            <?php if ( $comment->comment_approved == '0' ) : ?>
                                <em><?php _e( 'Bình luận của bạn đang chờ phê duyệt.', 'hentaivn' ) ?></em>
                                <br />
                            <?php endif; ?>
                            <div class="commenttext" itemprop="commentText">
                                <?php comment_text() ?>
                            </div>
                            <div class="commentdate-reply">
                                
                                <div class="reply">
                                    <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'],'reply_text' => __('Trả Lời', 'hentaivn') )) ) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                   break;
             endswitch; ?>
    	<!-- WP adds </li> -->
    <?php }
}

function getCategoryVue($type) {
    $categories = [];
    if($type ==  'cat') {
        $categories = get_categories('category');
    } else {
        $categories = get_terms('post_tag');
    }
    $output = [];
    if(count($categories) > 0) {
        foreach($categories as $cat) {
           $output[] = new Category($cat->term_id,$cat->name);
        }  
    }
    return json_encode($output);
}
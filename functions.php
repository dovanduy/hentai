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
    if(is_page_template('img-gallery.php')) {
        wp_enqueue_script('vue','//cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js',[],'1.0.0', false);
        wp_enqueue_script('axios','//cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js',[],'1.0.0', false);
    }
}


// Set Post Views

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

// Add Theme Support
require_once HENTAI_PATH.'/inc/support.php';
global $support;
$support = new HenTai_Theme_Support;

// Redirect When Login And Register Page
require_once HENTAI_PATH.'/inc/login-register-redirect.php';


// Add Register Page Func
require_once HENTAI_PATH.'/inc/register.php';



//Add MetaBox
require_once HENTAI_PATH.'/inc/metabox.php';



// Crop Image
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

// Add Movie Widget Slider

require_once HENTAI_PATH.'/inc/movie-slider.php';


// Archive Title

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


// Ajax Load Gallery

add_action('wp_ajax_nopriv_get_gallery_vue', 'get_gallery_vue');
add_action('wp_ajax_get_gallery_vue', 'get_gallery_vue');
function get_gallery_vue() {
    if ( ! wp_verify_nonce( $_POST['nonce'], 'hentaivn' ) ) die('Nope');
    $image_ids = get_posts(
        array(
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'post_status'    => 'inherit',
            'posts_per_page' => - 1,
            'fields'         => 'ids',
        ) );
    
    $images = array_map( "wp_get_attachment_url", $image_ids );
    header('Content-Type: application/json');
    echo json_encode($images);
    exit;
}
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
}

add_action('wp_enqueue_scripts','hentai_add_css',999);
function hentai_add_css() {
    wp_enqueue_style('hentai_style',get_stylesheet_uri());
    wp_enqueue_style('bootstrap_css', HENTAI_URL.'/css/bootstrap.css');
    wp_enqueue_style('zico_css', HENTAI_URL.'/css/zico.min.css');
    wp_enqueue_style('public_css', HENTAI_URL.'/css/public.css');
    wp_enqueue_style('serach_css', HENTAI_URL.'/css/search.css');
}


add_action('wp_enqueue_scripts','hentai_add_scripts');
function hentai_add_scripts() {
    wp_enqueue_script('bootstrap_js',HENTAI_URL.'/js/bootstrap.js',['jquery'],'1.0.0', true);
    wp_enqueue_script('popper_js',HENTAI_URL.'/js/popper.min.js',['jquery'],'1.0.0', true);
    wp_enqueue_script('public_js',HENTAI_URL.'/js/public.js',['jquery'],'1.0.0', true);
}

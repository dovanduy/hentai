<?php
$redirectLoginAndRegister = new CustomLoginAndRegisterPage;
class CustomLoginAndRegisterPage {

    public function __construct() {
        add_filter( 'login_redirect', array($this,'after_login_redirect'), 10, 3 );
        add_filter( 'authenticate', array($this,'verify_username_password'), 1, 3);
        add_action('init',array($this,'redirect_login_page'));
        add_action( 'wp_login_failed', array($this,'login_failed' ));
        add_action( 'init', array($this,'blockusers_init' ));
    }
    public function after_login_redirect($redirect_to,$request,$user) {
        global $user;
        if(isset($user->roles) && is_array($user->roles)) {
            if(in_array('administrator',$user->roles)) {
                return admin_url();
            } else {
                return home_url();
            }
        } else {
            return $redirect_to;
        }
    }

    public function redirect_login_page() {
        $login_page = home_url('/dang-nhap/');
        $page_viewed = basename($_SERVER['REQUEST_URI']);
        if($page_viewed == 'wp-login.php' && $_SERVER['REQUEST_METHOD'] == 'GET') {
            wp_redirect($login_page);
            exit;
        }
    }

    public function login_failed() {
        $login_page  = home_url( '/dang-nhap/' );
        wp_redirect( $login_page . '?login=failed' );
        exit;
    }

    public function verify_username_password( $user, $username, $password ) {
        $login_page  = home_url( '/dang-nhap/' );
        if( $username == "" || $password == "" ) {
            wp_redirect( $login_page . "?login=empty" );
            exit;
        }
    }
    function blockusers_init() {
        if ( is_admin() && ! current_user_can( 'administrator' ) && 
           ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
            wp_redirect( home_url() );
            exit;
        }
    }
 
}
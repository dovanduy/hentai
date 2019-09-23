<?php
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


// Ajax Upload Avatar

add_action('wp_ajax_nopriv_hentaivn_upload_avatar', 'hentaivn_upload_avatar');
add_action('wp_ajax_hentaivn_upload_avatar', 'hentaivn_upload_avatar');
function hentaivn_upload_avatar() {
    $nonce = $_POST['nonce'];
	if ( ! wp_verify_nonce( $nonce, 'hentaivn' ) )
    die ( 'Nope!' );
    $img_link = '';
    $file = $_FILES['file'];
    $uid = $_POST['uid'];
    $target_dir = HENTAI_PATH.'/img/userava/';
    $target_file = $target_dir.basename($file['name']);
    $uploadOk = 1;
    $error = '';

    if (file_exists($target_file)) {
        $error = "Avatar này đã tồn tại";
        $uploadOk = 0;
    }

    if ($file['size'] > 3000000) {
        $error = "Kích Thước ẢNh Của Bạn Quá Lớn. Vui Long Chọn Ảnh Khác, Xin Cảm Ơn!";
        $uploadOk = 0;
    }
    
    if ($uploadOk == 0) {
        $error = "Kích Thước ẢNh Của Bạn Quá Lớn. Vui Long Chọn Ảnh Khác, Xin Cảm Ơn!";
    
    } else {
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $imgDir = $target_dir.$file["name"];
            $wpImageEditor =  wp_get_image_editor( $imgDir);
            if ( ! is_wp_error( $wpImageEditor ) ) {
                $wpImageEditor->resize(200, 200, array('center','center'));
                $wpImageEditor->save( $imgDir);
            }

            $img_link = HENTAI_URL.'/img/userava/'.$file["name"];
            update_user_meta($uid,'avatar',$img_link);

        } else {
            $error = 'Kích Thước ẢNh Của Bạn Quá Lớn. Vui Long Chọn Ảnh Khác, Xin Cảm Ơn!';
        }
    }

    if($error == '') {
        echo json_encode(['status'=>'ok','img'=>$img_link]);
    } else {
        echo json_encode(['status'=>'nope','error'=>$error]);
    }
    exit;
}

// Ajax Add Favorite

add_action('wp_ajax_nopriv_hentai_add_favorite', 'hentai_add_favorite');
add_action('wp_ajax_hentai_add_favorite', 'hentai_add_favorite');
function hentai_add_favorite() {
    $nonce = $_POST['nonce'];
	if ( ! wp_verify_nonce( $nonce, 'hentaivn' ) )
    die ( 'Nope!' );
    $post_id = isset($_POST['post_id'])? $_POST['post_id']: '';
    $user_id = get_current_user_id();
    $val = get_user_meta($user_id,'hentai_favorite',true);
    if($val == '') {
        update_user_meta($user_id,'hentai_favorite',$post_id);
        echo 'ok';
    } else {
        $vals = explode(',',$val);
        if(in_array($post_id,$vals)) {
            echo 'no';
        } else {
            $newval = $val.','.$post_id;
            update_user_meta($user_id,'hentai_favorite',$newval);
            echo 'ok';
        }
    }
    exit;
}


// Ajax Remove Favorite
add_action('wp_ajax_nopriv_hentai_remove_fav', 'hentai_remove_fav');
add_action('wp_ajax_hentai_remove_fav', 'hentai_remove_fav');
function hentai_remove_fav() {
    $nonce = $_POST['nonce'];
	if ( ! wp_verify_nonce( $nonce, 'hentaivn' ) )
    die ( 'Nope!' );
    $movie_id = $_POST['post_id'];
    $uid = get_current_user_id();
    $list = get_user_meta($uid,'hentai_favorite',true);
    $lists = explode(',',$list);
    if (($key = array_search($movie_id, $lists)) !== false) {
        unset($lists[$key]);
        $newlist = implode(',',$lists);
        update_user_meta($uid,'hentai_favorite',$newlist);
        echo 'ok';
    }
    exit;
}


// Ajax Get Movie Paginate;

add_action('wp_ajax_nopriv_hentai_movie_paginate', 'hentai_movie_paginate');
add_action('wp_ajax_hentai_movie_paginate', 'hentai_movie_paginate');

function hentai_movie_paginate() {
    $nonce = $_POST['nonce'];
	if ( ! wp_verify_nonce( $nonce, 'hentaivn' ) )
    die ( 'Nope!' );
    $page = isset($_POST['page']) ? $_POST['page']: 1;
    $args = [
        'post_type'=>'post',
        'paged'=>$page,
        'orderby'=>'rand',
    ];
    $data = [];
    $data['status'] = 'fail';
    $query = new wp_query($args);
    if($query ->found_posts != '') {
        $data['status'] = 'success';
        $data['total'] = (int)$query ->found_posts;
    }
    
    if($query->have_posts()) while($query->have_posts()) : $query->the_post();
        $img = HentaiCropImg($query->post->ID,$query->post->post_content,268,394,'-hentai-img-slider-');
        $views = getpostviews(get_the_ID());
        $title = mb_substr(get_the_title(),0,20).'...';
        $data['movie'][] = new Movie(get_the_ID(),$title,get_the_permalink(),$img,$views);
    endwhile; wp_reset_postdata();
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}



add_action('wp_ajax_nopriv_hentai_load_search', 'hentai_load_search');
add_action('wp_ajax_hentai_load_search', 'hentai_load_search');
function hentai_load_search() {
    $nonce = $_POST['nonce'];
	if ( ! wp_verify_nonce( $nonce, 'hentaivn' ) )
    die ( 'Nope!' );
    $page = isset($_POST['page']) ? $_POST['page']: 1;
    $query = isset($_POST['query']) ? $_POST['query']: '';
    $args = [
        'post_type'=>'post',
        'paged'=>$page,
        's' => $query
    ];
    $data = [];
    $data['status'] = 'fail';
    $query = new wp_query($args);
    if($query ->found_posts != '') {
        $data['status'] = 'success';
        $data['total'] = (int)$query ->found_posts;
    }
    
    if($query->have_posts()) while($query->have_posts()) : $query->the_post();
        $img = HentaiCropImg($query->post->ID,$query->post->post_content,268,394,'-hentai-img-slider-');
        $views = getpostviews(get_the_ID());
        $title = mb_substr(get_the_title(),0,20).'...';
        $data['movie'][] = new Movie(get_the_ID(),$title,get_the_permalink(),$img,$views);
    endwhile; wp_reset_postdata();
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}


add_action('wp_ajax_nopriv_hentai_load_filter', 'hentai_load_filter');
add_action('wp_ajax_hentai_load_filter', 'hentai_load_filter');

function hentai_load_filter() {
    $nonce = $_POST['nonce'];
	if ( ! wp_verify_nonce( $nonce, 'hentaivn' ) )
    die ( 'Nope!' );
    $page = isset($_POST['page']) ? $_POST['page']: 1;
    $tag_ids = isset($_POST['tag_ids'])? $_POST['tag_ids']: '';
    $cat_ids = isset($_POST['cat_ids'])? $_POST['cat_ids']: '';

    $args = [
        'post_type'=>'post',
        'paged'=>$page,
    ];

    if($tag_ids != '' && $cat_ids != '') {
        $tagArr = explode(',',$tag_ids);
        $catArr = explode(',',$cat_ids);
        $args['tax_query']['relation'] = 'AND';
        foreach($tagArr as $tag) {
            
            $args['tax_query'][] = [
                'taxonomy'=>'post_tag',
                'field' =>'term_id',
                'terms'=> $tag
            ];
        }
        foreach($catArr as $cat) {
            $args['tax_query'][] = [
                'taxonomy'=>'category',
                'field' =>'term_id',
                'terms'=> $cat
            ];
        }
        

    } 
    if($tag_ids != '' && $cat_ids == ''){
        $tagArr = explode(',',$tag_ids);
        $args['tax_query']['relation'] = 'AND';
        foreach($tagArr as $tag) {
            
            $args['tax_query'][] = [
                'taxonomy'=>'post_tag',
                'field' =>'term_id',
                'terms'=> $tag
            ];
        }
    }
    if($tag_ids == '' && $cat_ids != '') {
        $catArr = explode(',',$cat_ids);
        $args['tax_query']['relation'] = 'AND';
        foreach($catArr as $cat) {
            $args['tax_query'][] = [
                'taxonomy'=>'category',
                'field' =>'term_id',
                'terms'=> $cat
            ];
        }
    }

    $data = [];
    $data['status'] = 'success';
    $data['total'] = 0;
    $data['movie'] = [];
    $query = new wp_query($args);
    if($query ->found_posts != '') {
        $data['status'] = 'success';
        $data['total'] = (int)$query ->found_posts;
    }
    if($query->have_posts()) while($query->have_posts()): $query->the_post();
        $img = HentaiCropImg($query->post->ID,$query->post->post_content,268,394,'-hentai-img-slider-');
        $views = getpostviews(get_the_ID());
        $title = mb_substr(get_the_title(),0,20).'...';
        $data['movie'][] = new Movie(get_the_ID(),$title,get_the_permalink(),$img,$views);
    endwhile; wp_reset_postdata();

    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}



add_action('wp_ajax_nopriv_hentai_lastest_movie', 'hentai_lastest_movie');
add_action('wp_ajax_hentai_lastest_movie', 'hentai_lastest_movie');

function hentai_lastest_movie() {
    $nonce = $_POST['nonce'];
	if ( ! wp_verify_nonce( $nonce, 'hentaivn' ) )
    die ( 'Nope!' );
    $args = [
        'post_type'=>'post',
        'orderby'=>'ID',
        'order'=> 'DESC'
    ];
    $data = [];
    $data['status'] = 'fail';
    $query = new wp_query($args);
    if($query ->found_posts != '') {
        $data['status'] = 'success';
        $data['total'] = (int)$query ->found_posts;
    }
    
    if($query->have_posts()) while($query->have_posts()) : $query->the_post();
        $img = HentaiCropImg($query->post->ID,$query->post->post_content,268,394,'-hentai-img-slider-');
        $views = getpostviews(get_the_ID());
        $title = mb_substr(get_the_title(),0,20).'...';
        $data['movie'][] = new Movie(get_the_ID(),$title,get_the_permalink(),$img,$views);
    endwhile; wp_reset_postdata();
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

add_action('wp_ajax_nopriv_hentai_hot_movie', 'hentai_hot_movie');
add_action('wp_ajax_hentai_hot_movie', 'hentai_hot_movie');

function hentai_hot_movie() {
    $nonce = $_POST['nonce'];
	if ( ! wp_verify_nonce( $nonce, 'hentaivn' ) )
    die ( 'Nope!' );
    $args = [
        'post_type'=>'post',
        'meta_key' =>'views',
        'orderby'=>'meta_value_num'
    ];
    $data = [];
    $data['status'] = 'fail';
    $query = new wp_query($args);
    if($query ->found_posts != '') {
        $data['status'] = 'success';
        $data['total'] = (int)$query ->found_posts;
    }
    
    if($query->have_posts()) while($query->have_posts()) : $query->the_post();
        $img = HentaiCropImg($query->post->ID,$query->post->post_content,268,394,'-hentai-img-slider-');
        $views = getpostviews(get_the_ID());
        $title = mb_substr(get_the_title(),0,20).'...';
        $data['movie'][] = new Movie(get_the_ID(),$title,get_the_permalink(),$img,$views);
    endwhile; wp_reset_postdata();
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
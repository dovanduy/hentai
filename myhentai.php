<?php
/* Template Name: PlayList */

if(!is_user_logged_in()) {
    $home_url = home_url();
    wp_redirect($home_url);
}

get_header();?>

<div class="search_box animated fadeIn">
    <div class="title">Phim Của Tôi</div>
    <div class="search_cnt">
        <ul class="cnt_box">
            <?php 
                $user_id = get_current_user_id();
                $posts = get_user_meta($user_id,'hentai_favorite','true');
                $post_ids = explode(',',$posts);
                $args = array('post_type'=>'post','post__in'=>$post_ids);
                $query = new wp_query($args);
                if($query->have_posts()) while($query->have_posts()) : $query->the_post();
                $img = HentaiCropImg($query->post->ID,$query->post->post_content,268,394,'-hentai-img-slider-');
            ?>
            <li>
                <a href="<?php the_permalink();?>"><img src="<?php echo $img;?>" alt="" width="100%">
                    <div class="cnt">
                        <h2><?php echo mb_substr(get_the_title(),0,20).'...';?></h2>
                        <span><?php echo getpostviews(get_the_ID());?>  <?php echo __(' views','hentaivn');?></span>
                    </div>
                </a>
                <button class="close1" onclick="removeFav(this,<?php echo get_the_ID();?>)">X</button>
            </li>
            <?php endwhile; wp_reset_postdata();?>
        </ul>
    </div>
    <div id="ampagination-bootstrap">
        <?php echo hentaiPagination();?>
    </div>
</div>
<script>
    function removeFav(dom,id) {
        jQuery.ajax({
            type:'POST',
            dataType:'text',
            url: '<?php echo admin_url("admin-ajax.php");?>',
            data: {
                'action':'hentai_remove_fav',
                'post_id': id,
                'nonce':'<?php echo wp_create_nonce("hentaivn");?>'
            },
            success: function(data) {
                if(data === 'ok') {
                    jQuery(dom).parent().remove();
                }
            }
        })
    }
</script>
<?php get_footer();?>
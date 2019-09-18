<?php get_header();?>
<div class="search_box">
    <div class="title"><?php echo archiveTitle();?></div>
    <div class="search_cnt">
        <ul class="cnt_box">
            <?php if(have_posts()) while(have_posts()): the_post();
                    $img = HentaiCropImg($post->ID,$post->post_content,268,394,'-hentai-img-slider-');
            ?>
            <li>
                <a href="<?php the_permalink();?>"><img src="<?php echo $img;?>" alt="" width="100%">
                    <div class="cnt">
                        <h2><?php echo mb_substr(get_the_title(),0,20).'...';?></h2>
                        <span><?php echo getpostviews(get_the_ID());?>  <?php echo __(' views','hentaivn');?></span>
                    </div>
                </a>
            </li>
            <?php endwhile; wp_reset_postdata();?>
        </ul>
    </div>
    <div id="ampagination-bootstrap">
        <?php echo hentaiPagination();?>
    </div>
</div>
<?php get_footer();?>
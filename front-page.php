<?php get_header();
?>
<div class="index_box">
    <div class="banner animated fadeIn">
        <img src="<?php echo HENTAI_URL.'/img/banner.png';?>" alt="">
        <div class="banner_info text-left">
            <span class="title">Xem miễn phí Hentai &amp; clip Anime 18+</span>
            <span class="cnt">
                Thưởng thức <em>không giới hạn</em> tuyệt phẩm hentai &amp; anime lớn nhất Châu Á. Với kho video clip chất lượng HD, Full HD sẽ làm thỏa mãn niềm hứng thú trong bạn.
            </span>
        </div>
    </div>
    <?php if(is_active_sidebar('home-sidebar')): dynamic_sidebar('home-sidebar'); endif;?>
</div>
<?php get_footer();?>
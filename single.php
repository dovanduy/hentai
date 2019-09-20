<?php
get_header();?>
<div class="video_box">
   <nav aria-label="breadcrumb">
   <?php
        if ( function_exists('yoast_breadcrumb') ) {
            yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
        }
    ?>
   </nav>
   <?php if(have_posts()) while(have_posts()): the_post();
        setpostview(get_the_ID());
   ?>
   <div class="video_layout">
      <div class="video_part">
         <div class="player">
            <video src="http://vjs.zencdn.net/v/oceans.mp4" controls="" width="100%"></video>
         </div>
         <div class="video_detail">
            <div class="top__video">
               <div class="video__title">
                  <h1><?php the_title();?></h1>
               </div>
               <div class="video__viewslike">
                  <span><em><i class="zi zi_heart"></i> DS Yêu Thích</em></span>
                  <span><?php echo getpostviews(get_the_ID());?> lượt xem</span>
               </div>
            </div>
            <div class="video__content">
                <div class="video__left">
                    <img src="<?php echo get_the_post_thumbnail_url();?>" alt="<?php the_title();?>">
                </div>
                <div class="video__right">
                    <div class="right__top">
                        <div class="top__left">
                            <span> Chuyên Mục: </span>
                            <?php
                                $categories = get_the_category();
                                if($categories) {
                                    echo '<h4><a href="'.get_category_link($categories[0]->term_id).'">'.$categories[0]->name.'</a></h4>';
                                }
                            ?>
                        </div>
                        <div class="top__right">
                            <span>Ngày Upload:</span>
                            <span class="top__date">
                                <?php echo get_the_date('d/m/Y H:i');?>
                            </span>
                        </div>
                    </div>
                    <div class="right__body">
                        <div class="body__ct">
                            <span>Chi Tiết Phim: </span>
                        </div>
                        <div class="body__content">
                            <?php the_content();?>
                        </div>
                        <div class="espisode_number">
                            Các Tập Phim:
                        </div>
                        <?php $espisode = get_post_meta(get_the_ID(),'espisode_movie',true);
                            if($espisode != ''): 
                            $espiArr = json_decode($espisode,true);
                            ksort($espiArr);
                        ?>
                        <div class="espisode">
                            <ul>
                                <?php foreach($espiArr as $key => $ep):?>
                                    <li><a href="javascript:;"><?php echo $key;?></a></li>
                                <?php endforeach;?>

                            </ul>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <?php $tags = get_the_tags(get_the_ID());
                if($tags):
            ?>
            <div class="video__ft">
                <?php foreach($tags as $tag):?>
                    <a href="<?php echo get_tag_link($tag->term_id);?>"><?php echo $tag->name;?></a>
                <?php endforeach;?>
            </div>
            <?php endif;?>
         </div>
      </div>
      <div class="add_part">
         <a href="javascript:;" class="ad"><img src="<?php echo HENTAI_URL.'/img/ad.png';?>" alt="ads"></a>
         <?php echo ShowSlider("lastest","",0,12, "","Phim Mới Nhất","side");?>
         <a href="javascript:;" class="ad"><img src="<?php echo HENTAI_URL.'/img/ad2.png';?>" alt="ads"></a>
      </div>
   </div>
   <?php echo ShowSlider("random","",128,12, "","Phim Liên Quan","single");?>
   <?php endwhile; wp_reset_postdata();?>
</div>
<?php get_footer();?>

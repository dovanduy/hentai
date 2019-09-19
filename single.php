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
            <div class="top">
               <span class="title"><?php the_title();?></span>
               <span><em><i class="zi zi_heart"></i> DS Yêu Thích</em> <?php echo getpostviews(get_the_ID());?> lượt xem</span>
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
         <a href="http://" class="ad"><img src="./img/ad.png" alt=""></a>
         <div class="video_hot">
            <div class="mv_title">mới cập nhật</div>
            <div class="swiper-container swiper-container-hot swiper-container-initialized swiper-container-horizontal swiper-container-free-mode">
               <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px);">
                  <div class="swiper-slide swiper-slide-active" style="width: 106.5px; margin-right: 6px;">
                     <a href="url">
                        <img class="swiper-lazy swiper-lazy-loaded" width="100%" src="./img/pic1/2.jpg">
                        <div class="cnt">
                           <h2>title</h2>
                           <h2>title2</h2>
                           <span>10</span>
                        </div>
                     </a>
                  </div>
                  <div class="swiper-slide swiper-slide-next" style="width: 106.5px; margin-right: 6px;">
                     <a href="url">
                        <img class="swiper-lazy swiper-lazy-loaded" width="100%" src="./img/pic1/2.jpg">
                        <div class="cnt">
                           <h2>title</h2>
                           <h2>title2</h2>
                           <span>10</span>
                        </div>
                     </a>
                  </div>
                  <div class="swiper-slide" style="width: 106.5px; margin-right: 6px;">
                     <a href="url">
                        <img class="swiper-lazy swiper-lazy-loaded" width="100%" src="./img/pic1/2.jpg">
                        <div class="cnt">
                           <h2>title</h2>
                           <h2>title2</h2>
                           <span>10</span>
                        </div>
                     </a>
                  </div>
                  <div class="swiper-slide" style="width: 106.5px; margin-right: 6px;">
                     <a href="url">
                        <img class="swiper-lazy swiper-lazy-loaded" width="100%" src="./img/pic1/2.jpg">
                        <div class="cnt">
                           <h2>title</h2>
                           <h2>title2</h2>
                           <span>10</span>
                        </div>
                     </a>
                  </div>
                  <div class="swiper-slide" style="width: 106.5px; margin-right: 6px;">
                     <a href="url">
                        <img data-src="./img/pic1/2.jpg" class="swiper-lazy" width="100%">
                        <div class="swiper-lazy-preloader"></div>
                        <div class="cnt">
                           <h2>title</h2>
                           <h2>title2</h2>
                           <span>10</span>
                        </div>
                     </a>
                  </div>
                  <div class="swiper-slide" style="width: 106.5px; margin-right: 6px;">
                     <a href="url">
                        <img data-src="./img/pic1/2.jpg" class="swiper-lazy" width="100%">
                        <div class="swiper-lazy-preloader"></div>
                        <div class="cnt">
                           <h2>title</h2>
                           <h2>title2</h2>
                           <span>10</span>
                        </div>
                     </a>
                  </div>
                  <div class="swiper-slide" style="width: 106.5px; margin-right: 6px;">
                     <a href="url">
                        <img data-src="./img/pic1/2.jpg" class="swiper-lazy" width="100%">
                        <div class="swiper-lazy-preloader"></div>
                        <div class="cnt">
                           <h2>title</h2>
                           <h2>title2</h2>
                           <span>10</span>
                        </div>
                     </a>
                  </div>
                  <div class="swiper-slide" style="width: 106.5px; margin-right: 6px;">
                     <a href="url">
                        <img data-src="./img/pic1/2.jpg" class="swiper-lazy" width="100%">
                        <div class="swiper-lazy-preloader"></div>
                        <div class="cnt">
                           <h2>title</h2>
                           <h2>title2</h2>
                           <span>10</span>
                        </div>
                     </a>
                  </div>
                  <div class="swiper-slide" style="width: 106.5px; margin-right: 6px;">
                     <a href="url">
                        <img data-src="./img/pic1/2.jpg" class="swiper-lazy" width="100%">
                        <div class="swiper-lazy-preloader"></div>
                        <div class="cnt">
                           <h2>title</h2>
                           <h2>title2</h2>
                           <span>10</span>
                        </div>
                     </a>
                  </div>
                  <div class="swiper-slide" style="width: 106.5px; margin-right: 6px;">
                     <a href="url">
                        <img data-src="./img/pic1/2.jpg" class="swiper-lazy" width="100%">
                        <div class="swiper-lazy-preloader"></div>
                        <div class="cnt">
                           <h2>title</h2>
                           <h2>title2</h2>
                           <span>10</span>
                        </div>
                     </a>
                  </div>
                  <div class="swiper-slide" style="width: 106.5px; margin-right: 6px;">
                     <a href="url">
                        <img data-src="./img/pic1/2.jpg" class="swiper-lazy" width="100%">
                        <div class="swiper-lazy-preloader"></div>
                        <div class="cnt">
                           <h2>title</h2>
                           <h2>title2</h2>
                           <span>10</span>
                        </div>
                     </a>
                  </div>
               </div>
               <!-- Add Arrows -->
               <div class="swiper-button-next swiper-button-white" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false"></div>
               <div class="swiper-button-prev swiper-button-white swiper-button-disabled" tabindex="0" role="button" aria-label="Previous slide" aria-disabled="true"></div>
               <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
            </div>
         </div>
         <a href="http://" class="ad"><img src="./img/ad2.png" alt=""></a>
      </div>
   </div>
   <div class="video_ralate">
      <div class="list_head clear">
         <div class="fl title">mới cập nhật</div>
         <div class="fr all_list"><a href="calss">all</a></div>
      </div>
      <div class="swiper-container swiper-container-ralate swiper-container-initialized swiper-container-horizontal swiper-container-free-mode">
         <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px);">
            <div class="swiper-slide swiper-slide-active" style="width: 149.167px; margin-right: 30px;">
               <a href="url">
                  <img class="swiper-lazy swiper-lazy-loaded" width="100%" src="./img/pic1/2.jpg">
                  <div class="cnt">
                     <h2>title</h2>
                     <h2>title2</h2>
                     <span>10</span>
                  </div>
               </a>
            </div>
            <div class="swiper-slide swiper-slide-next" style="width: 149.167px; margin-right: 30px;">
               <a href="url">
                  <img class="swiper-lazy swiper-lazy-loaded" width="100%" src="./img/pic1/2.jpg">
                  <div class="cnt">
                     <h2>title</h2>
                     <h2>title2</h2>
                     <span>10</span>
                  </div>
               </a>
            </div>
            <div class="swiper-slide" style="width: 149.167px; margin-right: 30px;">
               <a href="url">
                  <img class="swiper-lazy swiper-lazy-loaded" width="100%" src="./img/pic1/2.jpg">
                  <div class="cnt">
                     <h2>title</h2>
                     <h2>title2</h2>
                     <span>10</span>
                  </div>
               </a>
            </div>
            <div class="swiper-slide" style="width: 149.167px; margin-right: 30px;">
               <a href="url">
                  <img class="swiper-lazy swiper-lazy-loaded" width="100%" src="./img/pic1/2.jpg">
                  <div class="cnt">
                     <h2>title</h2>
                     <h2>title2</h2>
                     <span>10</span>
                  </div>
               </a>
            </div>
            <div class="swiper-slide" style="width: 149.167px; margin-right: 30px;">
               <a href="url">
                  <img class="swiper-lazy swiper-lazy-loaded" width="100%" src="./img/pic1/2.jpg">
                  <div class="cnt">
                     <h2>title</h2>
                     <h2>title2</h2>
                     <span>10</span>
                  </div>
               </a>
            </div>
            <div class="swiper-slide" style="width: 149.167px; margin-right: 30px;">
               <a href="url">
                  <img class="swiper-lazy swiper-lazy-loaded" width="100%" src="./img/pic1/2.jpg">
                  <div class="cnt">
                     <h2>title</h2>
                     <h2>title2</h2>
                     <span>10</span>
                  </div>
               </a>
            </div>
            <div class="swiper-slide" style="width: 149.167px; margin-right: 30px;">
               <a href="url">
                  <img class="swiper-lazy swiper-lazy-loaded" width="100%" src="./img/pic1/2.jpg">
                  <div class="cnt">
                     <h2>title</h2>
                     <h2>title2</h2>
                     <span>10</span>
                  </div>
               </a>
            </div>
            <div class="swiper-slide" style="width: 149.167px; margin-right: 30px;">
               <a href="url">
                  <img class="swiper-lazy swiper-lazy-loaded" width="100%" src="./img/pic1/2.jpg">
                  <div class="cnt">
                     <h2>title</h2>
                     <h2>title2</h2>
                     <span>10</span>
                  </div>
               </a>
            </div>
            <div class="swiper-slide" style="width: 149.167px; margin-right: 30px;">
               <a href="url">
                  <img class="swiper-lazy swiper-lazy-loaded" width="100%" src="./img/pic1/2.jpg">
                  <div class="cnt">
                     <h2>title</h2>
                     <h2>title2</h2>
                     <span>10</span>
                  </div>
               </a>
            </div>
            <div class="swiper-slide" style="width: 149.167px; margin-right: 30px;">
               <a href="url">
                  <img class="swiper-lazy swiper-lazy-loaded" width="100%" src="./img/pic1/2.jpg">
                  <div class="cnt">
                     <h2>title</h2>
                     <h2>title2</h2>
                     <span>10</span>
                  </div>
               </a>
            </div>
         </div>
         <!-- Add Arrows -->
         <div class="swiper-button-next swiper-button-white" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false"></div>
         <div class="swiper-button-prev swiper-button-white swiper-button-disabled" tabindex="0" role="button" aria-label="Previous slide" aria-disabled="true"></div>
         <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
      </div>
   </div>
    <?php endwhile; wp_reset_postdata();?>
</div>
<?php get_footer();?>

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
        $user_id = get_current_user_id();
   ?>
   <div class="video_layout animated fadeIn">
      <div class="video_part">
         <div id="player">
         </div>
         <script>

            (function($) {
                $.fn.hentaiPlayer = function(opts) {
                    var settings = $.extend({},opts);
                    init();
                    function init() {
                        getLinkPlay(settings.post_id,settings.espisode,settings.nonce,settings.url,playVideo);
                        changeEspisode();
                    }
                    function getLinkPlay(post_id,espisode,nonce,url, callback) {
                        
                        $.ajax({
                            type:'POST',
                            url: url,
                            dataType:'json',
                            data: {
                                'post_id':post_id,
                                'espisode':espisode,
                                'nonce':nonce,
                                'action':'hentai_load_espisode'
                            },
                            success: function(data) {
                                if(data) {
                                    console.log(data);
                                    callback(data);
                                }
                            }
                        })
                    }

                    function playVideo(data) {
                        var sources = [];
                        $.each(data, function(index,value) {
                            sources.push({"file":`http://23.106.126.72/video/${value[1]}`,"label":`${value[0]}`,"type":"mp4"});
                        })
                        const player = jwplayer('player');
                        player.setup({
                            sources: sources,
                            width: "100%",
                            aspectratio: "16:9",
                            primary: "html5",
                            autostart: true
                        });
                    }

                    function changeEspisode() {
                        var a = $('.espisode li a');
                        if(a != undefined) {
                            $('.espisode li a').click(function() {
                                if($(this).hasClass('active')) return;
                                a.removeClass('active');
                                $(this).addClass('active');
                                var espisode = parseInt($(this).text());
                                getLinkPlay(settings.post_id,espisode,settings.nonce,settings.url, playVideo);
                            });
                            
                        }
                        
                    }
                    return this;
                }
            }(jQuery))
            jQuery(document).ready(function($) {
                var espisode = $('.espisode ul li a.active').text();
                if(espisode != undefined) {
                    $('.video_part').hentaiPlayer({'post_id':<?php echo get_the_ID();?>,'espisode':parseInt(espisode),'nonce':'<?php echo wp_create_nonce("hentaivn");?>','url':'<?php echo admin_url("admin-ajax.php");?>'});
                }
            });
         </script>
         <div class="video_detail">
            <div class="top__video">
               <div class="video__title">
                  <h1><?php the_title();?></h1>
               </div>
               <div class="video__viewslike">
                  <span id="addlike"><em><i class="zi zi_heart"></i> DS Yêu Thích</em></span>
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
                                
                                <?php
                                    $i = 0;
                                    foreach($espiArr as $key =>$ep) {
                                        echo ' <li><a href="javascript:;" class="'.($i == 0? 'active': '').'">'.$key.'</a></li>';
                                        $i++;
                                    }
                                ?>

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
         <?php comments_template();?>
      </div>
      <div class="add_part">
         <a href="javascript:;" class="ad"><img src="<?php echo HENTAI_URL.'/img/ad.png';?>" alt="ads"></a>
         <?php echo ShowSlider("lastest","",0,12, "","Phim Mới Nhất","side");?>
         <a href="javascript:;" class="ad"><img src="<?php echo HENTAI_URL.'/img/ad2.png';?>" alt="ads"></a>
      </div>
   </div>
   <?php echo ShowSlider("random","",128,12, "","Phim Liên Quan","single");?>

   <script>
      var user_id = <?php echo $user_id;?>;
      jQuery(document).ready(function($) {
         $('#addlike').click(function() {

            if(user_id == 0) {
               alert('Bạn Cần Đăng Nhập Để Thực Hiện Chức Năng Này!!!');
               return;
            }

            $.ajax({
               type:'POST',
               url: '<?php echo admin_url('admin-ajax.php');?>',
               dataType:'text',
               data: {
                  'action':'hentai_add_favorite',
                  'post_id':<?php echo get_the_ID();?>,
                  'nonce': '<?php echo wp_create_nonce('hentaivn');?>'
               },
               success: function(data) {
                  if(data == 'ok') {
                     alert('Đã Thêm Phim Vào Danh Sách');
                  } else {
                     alert('Phim Đã Được Thêm Vào Danh Sách Của Bạn');
                  }
               }
            });
         })
      });
   </script>
   <?php endwhile; wp_reset_postdata();?>
</div>

<?php get_footer();?>

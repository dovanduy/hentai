<?php
function oxxo_load_movie_slider_widget() {
    register_widget('movie_slider_widget');
}
add_action('widgets_init','oxxo_load_movie_slider_widget');

class movie_slider_widget extends WP_Widget {
    public function __construct() {
        $id_base = 'movie_slider_post_widget';
   		$name	= 'Movie Slider Show';
   		$widget_options = array(
   					'classname' => '',
   					'description' => 'Hiển Thị Movie Slider'
   				);
   		parent::__construct($id_base, $name,$widget_options);
    }

    public function form($instance) {
        $defaults = array(
            'title' => 'Movie mới nhất',
			'post_num' => 12,
			'type' => 'lastest',
			'cat' => 0
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        $title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : __( 'Movie mới nhất', 'oxxo' );
        $cat = isset( $instance[ 'cat' ] ) ? intval( $instance[ 'cat' ] ) : 0;
        $post_num = isset( $instance[ 'post_num' ] ) ? intval( $instance[ 'post_num' ] ) : 12;
        $type = isset( $instance[ 'type' ] ) ? $instance[ 'type' ] : __( 'lastest', 'oxxo' );
        $hot = isset( $instance[ 'hot' ] ) ? $instance[ 'hot' ] : __( 'Hot Img', 'oxxo' );
        ?>
        <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Tiêu Đề:', 'oxxo' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php _e( 'Thể Loại:', 'oxxo' ); ?></label>
			<?php wp_dropdown_categories( Array(
                        'show_option_all'    => 'All',
						'orderby'            => 'ID', 
						'order'              => 'ASC',
						'show_count'         => 1,
						'hide_empty'         => 1,
						'hide_if_empty'      => true,
						'echo'               => 1,
						'selected'           => $cat,
						'hierarchical'       => 1, 
						'name'               => $this->get_field_name( 'cat' ),
						'id'                 => $this->get_field_id( 'cat' ),
						'taxonomy'           => 'category',
					) ); ?>
        </p>
        <p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'Kiểu Hiển Thị:', 'oxxo' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" type="text" value="<?php echo esc_attr( $type ); ?>" >
                <option value="lastest" <?php echo ('lastest' === $type? 'selected="selected"':'')?>> Mới Nhất</option>
                <option value="most" <?php echo ('most' === $type? 'selected="selected"':'')?>> Xem Nhiều</option>
                <option value="rand" <?php echo ('rand' === $type? 'selected="selected"':'')?>> Random</option>
            </select>
        </p>
        <p>
			<label for="<?php echo $this->get_field_id( 'hot' ); ?>"><?php _e( 'Hot Img:', 'oxxo' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'hot' ); ?>" name="<?php echo $this->get_field_name( 'hot' ); ?>" type="text" value="<?php echo esc_attr( $hot ); ?>" >
                <option value="yes" <?php echo ('yes' === $hot? 'selected="selected"':'')?>> Yes</option>
                <option value="no" <?php echo ('no' === $hot? 'selected="selected"':'')?>> No</option>
            </select>
        </p>
        <p>
			<label for="<?php echo $this->get_field_id( 'post_num' ); ?>"><?php _e( 'Số mv hiển thị:', 'oxxo' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'post_num' ); ?>" name="<?php echo $this->get_field_name( 'post_num' ); ?>" type="text" value="<?php echo esc_attr( $post_num ); ?>" />
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = strip_tags( $new_instance['title'] );
		$instance['cat'] = intval( $new_instance['cat'] );
        $instance['post_num'] = intval( $new_instance['post_num'] );
        $instance['type'] = strip_tags( $new_instance['type'] );
        $instance['hot'] = strip_tags( $new_instance['hot'] );
		return $instance;
    }

    public function widget($args, $instance) {
        extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$cat = $instance['cat'];
        $post_num = $instance['post_num'];
        $type = $instance['type'];
        $hot = $instance['hot'];
		$link = home_url();
        $args = array('post_type'=>'post','post_status'=>'publish','posts_per_page'=>$post_num);
        $hotImg = '';
        if($hot == 'yes') {
            $hotImg = '<img src="https://ooxxhd.com/wp-content/uploads/2019/09/hot.png" />';
        }
        if($type === 'lastest') {
            $args['orderby'] = 'modified';
            $args['order'] ="DESC";
			
            if($cat != 0) {
				$link = get_category_link($cat);
                $args['tax_query'] = [
                    [
                        'taxonomy'=>'category',
                        'field'=> 'term_id',
                        'terms' => $cat
                    ]
                ];
            } else {
               
                //$link = home_url('/').'phim-moi-nhat/';
                $link = 'javascript:;';
                $term = $this->getAllTerm();
                $args['tax_query'] = [
                    [
                        'taxonomy'=>'category',
                        'field'=> 'term_id',
                        'terms' => $term
                    ]
                ];
            }
        } else if($type === 'most'){
            $args['meta_key'] = 'views';
            $args['orderby'] = 'meta_value_num';
            //$link = home_url('/').'thinh-hanh/';
            $link = 'javascript:;';
            if($cat != 0) {
                $args['tax_query'] = [
                    [
                        'taxonomy'=>'category',
                        'field'=> 'term_id',
                        'terms' => $cat
                    ]
                ];
            } else {
                $term = $this->getAllTerm();
                $args['tax_query'] = [
                    [
                        'taxonomy'=>'category',
                        'field'=> 'term_id',
                        'terms' => $term
                    ]
                ];
            }
        } else {
            $args['orderby'] = 'rand';
			
            if($cat != 0) {
				$link = get_category_link($cat);
                $args['tax_query'] = [
                    [
                        'taxonomy'=>'category',
                        'field'=> 'term_id',
                        'terms' => $cat
                    ]
                ];
            } else {
                //$link = home_url('/').'phim-moi-nhat/';
                $link = 'javascript:;';
                $term = $this->getAllTerm();
                $args['tax_query'] = [
                    [
                        'taxonomy'=>'category',
                        'field'=> 'term_id',
                        'terms' => $term
                    ]
                ];
            }
        }
        $oxx = new WP_Query($args);
        $class_number = rand(1, 1000000);
        if($oxx->have_posts()):
        ?>
        <div class="main_type1">
            <div class="list_head clear">
                <div class="fl title"><?php echo $title;?></div>
                <div class="fr all_list"><a href="<?php echo $link;?>"><?php echo __('All','hentaivn');?></a></div>
            </div>
            <div class="swiper-container swiper-container-<?php echo $class_number;?>">
                <div class="swiper-wrapper">
                    <?php while($oxx->have_posts()) : $oxx->the_post();
                        $img = HentaiCropImg($oxx->post->ID,$oxx->post->post_content,268,394,'-hentai-img-slider-');
                    ?>
                    <div class="swiper-slide">
                        <a href="<?php the_permalink();?>">
                            <img data-src="<?php echo $img;?>" class="swiper-lazy" width="100%">
                            <div class="swiper-lazy-preloader"></div>
                            <div class="cnt">
                                <h2><?php echo mb_substr(get_the_title(),0,20).'...';?></h2>
                                <span><?php echo getpostviews(get_the_ID());?>  <?php echo __(' views','hentaivn');?></span>
                            </div>
                        </a>
                    </div>
                    <?php endwhile; wp_reset_postdata();?>
                </div>
                <!-- Add Arrows -->
                <div class="swiper-button-next swiper-button-white"></div>
                <div class="swiper-button-prev swiper-button-white"></div>
            </div>
        </div>
        <script>
            var swiper<?php echo $class_number;?> = new Swiper('.swiper-container-<?php echo $class_number;?>', {
                lazy: {
                    loadPrevNext: true,
                    loadPrevNextAmount: 1,
                },
                effect: 'slide',
                freeMode: true,
                direction: 'horizontal',
                speed: 300,
                slidesPerView: 6.3,
                spaceBetween: 30,
                centeredSlides: false,
                slidesPerGroup: 6.3,
                breakpoints: { 
                    767: {
                        slidesPerView: 2, 
                        spaceBetween: 5 ,
                        slidesPerGroup: 2
                    }
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        </script>
        <?php endif;
    }
    public function getAllTerm(){
        $terms = get_terms('category');
        $termarr = [];
        foreach($terms as $term) {
            $termarr[] = $term->term_id;
        }
        return $termarr;
    }

}
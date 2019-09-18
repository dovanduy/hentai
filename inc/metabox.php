<?php
new OxxoMovieEspisode;
class OxxoMovieEspisode {

    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'create_movie_meta_boxes'),10,2);
        add_action('save_post',array($this,'oxxo_save_espisode'));
        add_action('admin_enqueue_scripts', array($this,'oxxo_movie_add_scripts'));
    }

    public function create_movie_meta_boxes() {
        add_meta_box('espisode_fields','Movie Meta', array($this,'display'),'post','normal','default');
    }

    public function display($post) {
        $producer = get_post_meta($post->ID,'producer',true);
        $espisode_movie = get_post_meta($post->ID,'espisode_movie',true);
        ?>
        <div id="api_table">
			<table class="options-table-responsive dt-options-table">
                
                <tr class="tritem">
                    <td class="label">
                        <label for="producer">Producer</label>
                    </td>
                    <td style="background: #f7f7f7"  class="field">
                        <input class="regular-text" type="text" name="producer" id="producer" value="<?php echo $producer; ?>"> 
                    </td>
                </tr>
                <tr class="tritem">
                    <td class="label">
                        <label for="espisode_movie">Episode: </label>
                    </td>
                    <td style="background: #f7f7f7"  class="field">
                        <input class="regular-text" type="text" name="espisode_movie[]" id="espisode_movie" value="<?php echo $espisode_movie; ?>"> 
                    </td>
                </tr>
                
            </table>
        </div>
		<?php
    }

    public function oxxo_save_espisode($post_id) {
        if (!isset($_POST['espisode_fields'])) return;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;
        
        if ( isset( $_POST['producer'] ) ) update_post_meta( $post_id, 'producer',$_POST['producer'] );
        if ( isset( $_POST['espisode_movie'] ) ) update_post_meta( $post_id, 'espisode_movie',$_POST['espisode_movie'] );

    }

    public function oxxo_movie_add_scripts() {
        wp_register_style('oxxo_admin_css',HENTAI_URL.'/css/admin_style.css', array(),'1.0');
	 	wp_enqueue_style('oxxo_admin_css');
    }
}
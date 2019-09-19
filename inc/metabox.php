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
						<input type="hidden" name="espisode_movie">
                    </td>
                </tr>
                
            </table>
        </div>
        <script type="text/javascript">
			jQuery(document).ready(function( $ ){
				$('#add-row').on('click', function() {
					var row = $('.empty-row.screen-reader-text').clone(true);
					row.removeClass('empty-row screen-reader-text');
					row.insertBefore('#repeatable-fieldset-one tbody>tr:last');
					return false;
				});
				$('.remove-row').on('click', function() {
					$(this).parents('tr').remove();
					return false;
				});

				$('.dt_table_admin').sortable( {
					items: '.tritem',
					opacity: 0.8,
					cursor: 'move',
				} );
			});
			</script>
			<table id="repeatable-fieldset-one" width="100%" class="dt_table_admin">
			<thead>
				<tr>
					<th>#</th>
					<th> Title </th>
					<th> Server </th>
					<th> URL Source </th>
					<th> Control </th>
				</tr>
			</thead>
			<tbody>
            <?php if ( $espisode_movie != '' ) : foreach ( json_decode($espisode_movie,true) as $key => $fields ) {
                foreach($fields as $field) { ?>
                    <tr class="tritem">
                        <td class="draggable"><span class="dashicons dashicons-move"></td>
                        
                        <td class="text_player"><input type="text" class="widefat" name="seri[]" value="<?php echo $key ?>" required/></td>
                        <td><input type="text" class="widefat" name="reso[]" placeholder="" value="<?php if ($field[0] != '') echo esc_attr( $field[0] ); else echo ''; ?>" /></td>
                        <td><input type="text" class="widefat" name="url[]" placeholder="" value="<?php if ($field[1] != '') echo esc_attr( $field[1] ); else echo ''; ?>" /></td>
                        
                        <td><a class="button remove-row" href="#">Remove</a></td>
                    </tr>
            <?php }
            } else : ?>
			<tr class="tritem">
				<td class="draggable"><span class="dashicons dashicons-move"></td>
				<td class="text_player"><input type="text" class="widefat" name="seri[]" /></td>
				<td><input type="text" class="widefat" name="reso[]" placeholder=""  /></td>
				<td><input type="text" class="widefat" name="url[]" placeholder="" /></td>
				
				<td><a class="button remove-row" href="#">Remove</a></td>
			</tr>
			<?php endif; ?>
			<tr class="empty-row screen-reader-text tritem">
				<td class="draggable"><span class="dashicons dashicons-move"></td>
				<td class="text_player"><input type="text" class="widefat" name="seri[]" /></td>
				<td><input type="text" class="widefat" name="reso[]" placeholder=""  /></td>
				<td><input type="text" class="widefat" name="url[]" placeholder="" /></td>
				
				<td><a class="button remove-row" href="#">Remove</a></td>
			</tr>
			</tbody>
			</table>
			<p class="repeater"><a id="add-row" class="add_row" href="#">Add new row</a></p>
		<?php
    }

    public function oxxo_save_espisode($post_id) {

		if (!isset($_POST['espisode_movie'])) return;
		
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

		if (!current_user_can('edit_post', $post_id)) return;
		
		if ( isset( $_POST['producer'] ) ) update_post_meta( $post_id, 'producer',$_POST['producer'] );
		
		$value = get_post_meta($post_id,'espisode_movie',true);
		$valueArr = json_decode($value,true);
		$espisode = [];
		$seri = $_POST['seri'];
		$reso = $_POST['reso'];
		$url = $_POST['url'];
		$count = count($seri);
		for($i = 0; $i < $count; $i++) {
			if($seri[$i] != '' && $reso[$i]!='' && $url[$i]!='') {
				$espisode[$seri[$i]][] = [$reso[$i],$url[$i]];
			}
		}

		if(!empty($espisode) && $espisode != $valueArr) {
			update_post_meta($post_id,'espisode_movie',json_encode($espisode));
		} else {
			delete_post_meta($post_id,'espisode_movie',$value);
		}

    }

    public function oxxo_movie_add_scripts() {
        wp_register_style('oxxo_admin_css',HENTAI_URL.'/css/admin_style.css', array(),'1.0');
	 	wp_enqueue_style('oxxo_admin_css');
    }
}
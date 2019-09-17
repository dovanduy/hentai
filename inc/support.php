<?php
class HenTai_Theme_Support{
	
	public function __construct(){
		
	}
	
	/*=========================================================================
	 * GALLERY SHORTCODE
	* XOA GALLERY DAU TIEN CO TRONG BAI VIET
	*=========================================================================*/
	public function remove_first_gallery($gallery,$content){
		//echo '<br/>' . __METHOD__;
		//	https://www.youtube.com/watch?v=-Wg0uRzURpI
	
		$gallery 	=  str_replace('[', '\[', $gallery);
		$gallery 	=  str_replace(']', '\]', $gallery);
	
		$pattern = '#'. $gallery . '#';
		//echo '<br/>' . $pattern;
		$content = preg_replace($pattern, '', $content,1);
	
		return $content;
	}
	/*=========================================================================
	 * 	GALLERY SHORTCODE
	* GET ALL IMG ID
	*=========================================================================*/
	public function get_all_img_id_gallery($postContent = null){
		
		$firstGallery = '';
		if($postContent != null){
	
			$pattern = '#\[gallery ids="(.*)"\]#imsU';
			preg_match_all($pattern, $postContent, $matches);
	
			//  echo '<pre>';
			//  print_r($matches);
			// echo '</pre>';  
			$galleryArr = $matches[1];
	
			if(count($galleryArr) > 0 ){
				$firstGallery = $galleryArr[0];
				$imgID = explode(',',$firstGallery);
			} 
		}
	
		return $imgID;
	
	}
	/*=========================================================================
	 * 	GALLERY SHORTCODE
	* LAY GALLERYDAU TIEN CO TRONG BAI VIET
	*=========================================================================*/
	public function get_first_gallery($postContent = null){
		
		$firstGallery = '';
		if($postContent != null){
	
			$pattern = '#\[gallery.*\]#im';
			preg_match_all($pattern, $postContent, $matches);
	
			/* echo '<pre>';
			 print_r($matches);
			echo '</pre>';  */
			$galleryArr = $matches[0];
	
			if(count($galleryArr) > 0 ){
				$firstGallery = $galleryArr[0];
			} 
		}
	
		return $firstGallery;
	
	}
	
	/*=========================================================================
	 * VIDEO SHORTCODE
	* XOA VIDEO HOAC YOUTUBE DAU TIEN CO TRONG BAI VIET
	*=========================================================================*/
	public function remove_first_video($video,$content){
		//echo '<br/>' . __METHOD__;
		//	https://www.youtube.com/watch?v=-Wg0uRzURpI
		
		$video 	=  str_replace('[', '\[', $video);
		$video 	=  str_replace(']', '\]', $video);
		$video 	=  str_replace('?', '\?', $video);
	
		$pattern = '#'. $video . '#';
		//echo '<br/>' . $pattern;
		$content = preg_replace($pattern, '', $content,1);
	
		return $content;
	}
	
	public function video_embed($url, $site ='youtube'){
		//https://www.youtube.com/watch?v=-Wg0uRzURpI
		//<iframe id="fitvid926254" src="https://www.youtube.com/embed/-Wg0uRzURpI?feature=oembed" 
		//allowfullscreen="" frameborder="0">
		$html = '';
		
		if($site == 'youtube'){
			$tmp = explode('v=', $url);
			$videoID = $tmp[1];
			
			$src = '//www.youtube.com/embed/' . $videoID ;
			$html = '<iframe src="' . $src . '" frameborder="0" width="100%" height="100%" allowfullscreen="" style="width: 100%; height: 100%; position: absolute;"></iframe>';
		}
		return $html;
	}
	/*=========================================================================
	 * VIDEO - PLAYLIST SHORTCODE
	* LAY VIDEO HOAC YOUTUBE DAU TIEN CO TRONG BAI VIET
	*=========================================================================*/
	public function get_first_video($postContent = null){
		/* https://www.youtube.com/watch?v=-Wg0uRzURpI
			[video width="620" height="320" mp4="http://localhost/wordpress4/wp-content/uploads/2015/03/00_01_Introduction.mp4"][/video] */
		
		$firstVideo = '';
		if($postContent != null){
	
			$pattern = '#(\[video.*\]|http.*www\.youtube\.com\S+)#im';
			preg_match_all($pattern, $postContent, $matches);
				
			/* echo '<pre>';
				print_r($matches);
			echo '</pre>'; */
			$videoArr = $matches[0];
	
			if(count($videoArr) > 0 ){
				$firstVideo = $videoArr[0];
			} 
		}
	
		return $firstVideo;
	
	}
	
	/*=========================================================================
	 * AUDIO - PLAYLIST SHORTCODE
	* XOA AUDIO HOAC PLAYLIST DAU TIEN CO TRONG BAI VIET
	*=========================================================================*/
	public function remove_first_audio($audio,$content){
		//echo '<br/>' . __METHOD__;
	
		$audio 	=  str_replace('[', '\[', $audio);
		$audio 	=  str_replace(']', '\]', $audio);
		
		$pattern = '#'. $audio . '#';
		//echo '<br/>' . $pattern;
		$content = preg_replace($pattern, '', $content,1);
	
		return $content;
	}
	
	/*=========================================================================
	 * AUDIO - PLAYLIST SHORTCODE
	* LAY AUDIO HOAC PLAYLIST DAU TIEN CO TRONG BAI VIET
	*=========================================================================*/
	public function get_first_audio($postContent = null){
		/* [audio mp3="http://localhost/wordpress4/wp-content/uploads/2015/03/Over-And-Over.mp3"][/audio]
		[playlist ids="243,244,242,241,240,239,238,237"] */
		$firstAudio = '';
		if($postContent != null){
				
			$pattern = '#(\[audio.*\/audio\]|\[playlist.*\])#imU';
			preg_match_all($pattern, $postContent, $matches);
			
			/* echo '<pre>';
			print_r($matches);
			echo '</pre>'; */
			$audioArr = $matches[0];
				
			if(count($audioArr) > 0 ){
				$firstAudio = $audioArr[0];
			}
		}
	
		return $firstAudio;
	
	}
	
	/*=========================================================================
	 * CAPTION SHORTCODE
	* XOA HINH DAU TIEN CO TRONG BAI VIET
	*=========================================================================*/
	public function remove_first_img($image,$content){
		//echo '<br/>' . __METHOD__;
		
		$pattern = '\[caption.*'. $image . '.*\[/caption\]';
		//echo '<br/>' . $pattern;
		$content = preg_replace('#' . $pattern . '#', '', $content,1);
		$content = preg_replace('#<a .*>'.$image.'</a>#imsU', '', $content,1);
		$content = preg_replace('#' . $image . '#', '', $content, 1);
		
		return $content;
	}
	/*=========================================================================
	 * CAPTION SHORTCODE
	 * LAY HINH DAU TIEN CO TRONG BAI VIET
	 *=========================================================================*/
	public function get_first_img($postContent = null){
		
		$firstImg = '';
		if($postContent != null){
			
			$pattern = '#\<img.*>#imU';
			preg_match_all($pattern, $postContent, $matches);
			
			$imgArr = $matches[0];
			
			if(count($imgArr) > 0 ){
				$firstImg = $imgArr[0];
			}
		}
		
		return $firstImg;
		
	}
	
	public function get_img_url($post_content) {
	
		$image  = '';
		if(!empty($post_content)){
			preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', $post_content, $matches );
			
		}
	
		if ( isset( $matches ) ) @$image = $matches[1][0];
		
		return $image;
	}
	
	
	public function get_new_img_url($imgUrl, $width = 0, $heigt = 0 ,	$suffixes = '-zendvn-slider-'){
		$suffixes = $suffixes . $width . 'x'. $heigt;
	
		//Lay ten tap tin hinh anh hien tai
		preg_match("/[^\/|\\\]+$/", $imgUrl, $currentName);
		$currentName = $currentName[0];
	
		//Tạo tên mới cho hình ảnh dựa trên tên cũ
		if(strpos($currentName,'.jpg')) {
			$tmpFileName = explode('.jpg', $currentName);
			$newFileName = $tmpFileName[0] . $suffixes . '.jpg';
		} else if(strpos($currentName,'.png')){
			$tmpFileName = explode('.png', $currentName);
			$newFileName = $tmpFileName[0] . $suffixes . '.png';
		} else if(strpos($currentName,'.gif')) {
			$tmpFileName = explode('.gif', $currentName);
			$newFileName = $tmpFileName[0] . $suffixes . '.gif';
		} else {
			$newFileName = $currentName;
		}
		
	
		//Chuyển từ đường dẫn URL sang PATH
		$tmp 	= explode('/wp-content/', $imgUrl);
		$imgDir = ABSPATH.'wp-content/' . @$tmp[1];
	
	
		$newImgDir = str_replace($currentName, $newFileName, $imgDir);
		//echo '<br>' . $newImgDir;
		if(!file_exists($newImgDir)){
			//echo '<br/>Chua ton tai hinh anh';
			$wpImageEditor =  wp_get_image_editor( $imgDir);
			if ( ! is_wp_error( $wpImageEditor ) ) {
				$wpImageEditor->resize($width, $heigt, array('center','center'));
				$wpImageEditor->save( $newImgDir);
			}
		}
		$newImgUrl= str_replace($currentName, $newFileName, $imgUrl);
	
		return $newImgUrl;
	}
}
<?php
/**
 * Whoop Assets
 *
 * Handles assets.
 *
 * @author   AyeCode
 * @category API
 * @package  Whoop/Assets
 * @since    2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A class to call Whoop assets.
 *
 * We call these statically so they can easily be removed by 3rd party devs.
 *
 * Class Whoop_Assets
 */
class Whoop_Hero_Background {


	/**
	 * Init
	 */
	public static function init(){

		// @todo only show this if page template is set to whoop home
		add_action('save_post', array(__CLASS__, 'save'));
		add_action('add_meta_boxes', array(__CLASS__, 'add_meta_boxes'));

		add_filter('whoop_hero_background', array(__CLASS__,'hero_background'));
		add_filter('whoop_hero_credits', array(__CLASS__,'credits'));

		add_action( 'wp_ajax_whoop_hero',  array(__CLASS__,'ajax_get_next_background') );
		add_action( 'wp_ajax_nopriv_whoop_hero',  array(__CLASS__,'ajax_get_next_background') );
	}

	public static function ajax_get_next_background(){
//		print_r( $_POST );echo '####';exit;
//
//		$data['message'] = __( 'You have successfully deleted the Listing.', 'geodirectory' );
//		$data['redirect_to'] = get_post_type_archive_link( $post_type );
		$post_id = isset($_POST['post_id']) ? absint($_POST['post_id']) : '';
		$count = isset($_POST['count']) ? absint($_POST['count']) : '';

		if($post_id && $count){
			$defaults = self::default_settings();
			$settings = get_post_meta($post_id, '_whoop_hero', true);
			$settings = wp_parse_args($settings,$defaults);

			// GD
			if(defined('GEODIRECTORY_VERSION') && $settings['type']==''){
				$settings['type']='listing';
			}

			if($settings['type']=='gallery' && !empty($settings['id'])){

				$ids = trim($settings['id']);

				$ids = explode(",",$ids);

				$item = fmod($count, count($ids));

				$image = '';
				$id = '';

				if(!empty($ids[$item])){
					$id = $ids[$item];
					$image = wp_get_attachment_image($id,  'full', false, array( 'class' => 'whoop-hero-image whoop-js-fade-in' ) );
				}


				if($image){
					$image = str_replace("<img","<img onload='jQuery(this).fadeIn(500)'",$image  );
					wp_send_json_success( array(
						'html' => $image,
						'caption' => wp_get_attachment_caption( $id ),
						'description' => get_post_field('post_content',$id),
					));
				}else{
					wp_send_json_error();
				}

			}elseif($settings['type']=='listing'){
				$image_data = self::get_listing_image();
				if(!empty($image_data)){
					$image_data['html'] = str_replace("<img","<img onload='jQuery(this).fadeIn(500)'",$image_data['html'] );
					$image_data['html'] = str_replace('class="','class="whoop-hero-image whoop-js-fade-in ',$image_data['html'] );
					wp_send_json_success( $image_data );
				}else{
					wp_send_json_error();
				}
			}else{
				wp_send_json_error();
			}
		}else{
			wp_send_json_error();
		}

		wp_die();
	}

	public static function default_settings(){
		return array(
			'type' => '',
			'id' => '',
			'time' => '',
			'brightness' => '',
		);
	}

	public static function credits($html){
		global $whoop_hero_credits;
		if(!empty($whoop_hero_credits)){
			echo '<div class="container header-credits">';
			echo '<p class="whoop-hero-credits-caption">';
			if(!empty($whoop_hero_credits['caption'])){ echo $whoop_hero_credits['caption'];}
			echo '</p>';
			echo '<p class="whoop-hero-credits-description">';
			if(!empty($whoop_hero_credits['description'])){echo $whoop_hero_credits['description'];}
			echo '</p>';
			echo '</div>';
		}
		return $html;
	}

	public static function output_featured(){
		global $whoop_hero_credits,$post;
		$post_id = isset($post->ID) ? $post->ID : '';
		$image =  get_the_post_thumbnail( $post_id, 'full', array( 'class' => 'whoop-hero-image ' ) );

		if($image){
			$id = get_post_thumbnail_id();
			$whoop_hero_credits = array(
				'caption' => get_the_post_thumbnail_caption( $post_id ),
				'description' => get_post_field('post_content',$id),
			);
		}

		return $image;
	}

	public static function output_default(){
		global $whoop_hero_credits;
		$user_name = "Dan Gold";
		$user_link = "<a href='https://www.danielcgold.com/' target='_blank' rel=\"nofollow\">$user_name</a>";
		$whoop_hero_credits = array(
			'caption' => 'City Gourmet Cafe',
			'description' => sprintf(__("Photo by %s","whoop"),$user_link ),
		);
		$image = '<img width="1600" height="1066" src="'.get_stylesheet_directory_uri().'/assets/images/whoop-splash.jpg" class="whoop-hero-image  wp-post-image " alt="" srcset="'.get_stylesheet_directory_uri().'/assets/images/whoop-splash.jpg 1600w, '.get_stylesheet_directory_uri().'/assets/images/whoop-splash-300x200.jpg 300w, '.get_stylesheet_directory_uri().'/assets/images/whoop-splash-768x512.jpg 768w, '.get_stylesheet_directory_uri().'/assets/images/whoop-splash-1024x682.jpg 1024w" sizes="(max-width: 1600px) 100vw, 1600px">';
		return $image;
	}

	public static function output_video($video_id = 'AjZXFw9iWkw'){
		global $whoop_hero_credits;
		$html = '';
		$video_id = $video_id ? $video_id : 'AjZXFw9iWkw';
		$whoop_hero_credits = array(
			'caption' => '',
			'description' => '',
		);

		$html .= '<iframe onload=\'jQuery(this).addClass("whoop-fade-in")\' src="https://www.youtube.com/embed/'.$video_id.'?controls=0&rel=0&autoplay=1&loop=1&playlist='.$video_id.'&modestbranding=1&iv_load_policy=3&disablekb=1&mute=1" frameborder="0" allowfullscreen></iframe>';
		return $html;
	}


	public static function output_gallery($ids = ''){
		global $whoop_hero_credits;

		$ids = trim($ids);
		if(empty($ids)){return '';}

		$ids = explode(",",$ids);
		$image = '';
		foreach($ids as $id ){
			$id = absint($id);
			$image = wp_get_attachment_image($id,  'full', array( 'class' => 'whoop-hero-image ' ) );
			if($image){
				break;
			}
		}

		if($image){
			$whoop_hero_credits = array(
				'caption' => wp_get_attachment_caption( $id ),
				'description' => get_post_field('post_content',$id),
			);
		}

		return $image;
	}

	public static function get_listing_image(){
		global $wpdb;
		$image = array('html'=>'','caption'=>'','description'=>'');
		$image_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . GEODIR_ATTACHMENT_TABLE . " WHERE type = %s AND featured = 1 AND is_approved = 1 ORDER BY RAND() LIMIT 1 ",'post_images'));

		if($image_data){
			$img_tag = geodir_get_image_tag($image_data,'full' );
			$meta = isset($image_data->metadata) ? maybe_unserialize($image_data->metadata) : '';
			$image_tag =  wp_image_add_srcset_and_sizes( $img_tag, $meta , 0 );
			$permalink = "<a href='".get_permalink($image_data->post_id)."'>".esc_attr( get_the_title($image_data->post_id) )."</a>";
			$image = array(
				'html'  => $image_tag,
				'caption' => $permalink,
				'description' => $image_data->title ? esc_attr($image_data->title) : '',
			);
		}

//		print_r($image);exit;

		return $image;
	}

	public static function output_listing(){
		global $whoop_hero_credits;
		$image_data =  self::get_listing_image();
		$image ='';

		if($image_data){
			$image = $image_data['html'];
			$whoop_hero_credits = array(
				'caption' => $image_data['caption'],
				'description' => $image_data['description'],
			);
		}

		return $image;
	}

	public static function hero_background($html){
		global $whoop_hero_credits,$post;

		// init default globals
		$whoop_hero_credits = array(
			'caption' => '',
			'description' => '',
		);
		$script = '';
		$brightness = '';

		// get settings
		$defaults = self::default_settings();
		$settings = get_post_meta($post->ID, '_whoop_hero', true);
		$settings = wp_parse_args($settings,$defaults);


		// get html
		if($settings['type']==''){
		//auto

			if(defined('GEODIRECTORY_VERSION')){
				$html .= self::output_listing($settings['id']);
				$script = self::hero_script($settings);
			}else{
				$html .= self::output_featured();
			}

		}elseif($settings['type']=='featured'){
			$html .= self::output_featured();
		}elseif($settings['type']=='video'){
			$html .= self::output_video($settings['id']);
//			$html .= self::output_featured();
		}elseif($settings['type']=='gallery' && !empty($settings['id'])){
			$html .= self::output_gallery($settings['id']);
			$script = self::hero_script($settings);
		}elseif($settings['type']=='listing' &&  defined('GEODIRECTORY_VERSION') ){
			$html .= self::output_listing($settings['id']);
			$script = self::hero_script($settings);
		}


		// Defaults
		if(!$html){
			$html .= self::output_default();
		}

		if( $html ){
			$html = str_replace("<img","<img onload='jQuery(this).addClass(\"whoop-fade-in\")'",$html  );
		}

		// brightness overide (default 50)
		if(!empty($settings['brightness']) && $settings['brightness'] <= 100){
			$brightness = " style='filter: brightness(".$settings['brightness']."%);' ";
		}

		$container_open = "<div $brightness class='whoop-hero-background-wrap'><div class='whoop-hero-background-wrap-inner'>";
		$container_close = "</div></div>";

		return $container_open.$html.$container_close.$script;
	}

	public static function hero_script($settings){
		global $post;
		ob_start();
		?>
		<script>
			
			function whoop_hero_get_next(wait,count){
				var params = [];
				params['action'] = 'whoop_hero';
				params['count'] = count;
				jQuery.ajax({
					type: "POST",
					url: '<?php echo admin_url( 'admin-ajax.php' );?>',
					dataType: 'json',
					data: {
						action: 'whoop_hero',
						count: count,
						post_id: <?php echo $post->ID;?>
					},
					success: function(res) {
						console.log(res);
//						alert(1);
						if (res.success && res.data) {
							if (res.data.html) {
								jQuery('.whoop-hero-background-wrap-inner').append(res.data.html);
								setTimeout(function(){jQuery('.whoop-hero-background-wrap-inner img:first-child').remove();},1000 );

								caption = res.data.caption ? res.data.caption : '';
								jQuery('.whoop-hero-credits-caption').html(caption);

								description = res.data.description ? res.data.description : '';
								jQuery('.whoop-hero-credits-description').html(description);


							}
						}
						count++;
						setTimeout(function(){whoop_hero_get_next(wait ,count)},wait );

					},
					fail: function(data) {
						alert('fail');
					}
				});
			}
			jQuery(function() {
				var whoopHeroWait = <?php echo $settings['time'] && $settings['time'] > 1000 ? absint($settings['time']) : 8000;?>;
				var whoopHeroCount = 1;
				setTimeout(function(){whoop_hero_get_next(whoopHeroWait ,whoopHeroCount)},whoopHeroWait );

			});
		</script>
		<?php

		return ob_get_clean();
	}

	public static function save($post_id)
	{
//		echo '###1';

//		print_r(array_diff(self::default_settings(),$_POST['_whoop_hero']));exit;
		if (array_key_exists('_whoop_hero', $_POST) && ( !empty(array_diff($_POST['_whoop_hero'],self::default_settings())) || !empty(get_post_meta($post_id,'_whoop_hero',true))) ) {
			$settings = array(
				'type' => !empty($_POST['_whoop_hero']['type']) ? esc_attr($_POST['_whoop_hero']['type']) : '',
				'id' => !empty($_POST['_whoop_hero']['id']) ? esc_attr($_POST['_whoop_hero']['id']) : '',
				'time' => !empty($_POST['_whoop_hero']['time']) ? absint($_POST['_whoop_hero']['time']) : '',
				'brightness' => !empty($_POST['_whoop_hero']['brightness']) ? absint($_POST['_whoop_hero']['brightness']) : '',
			);
			update_post_meta(
				$post_id,
				'_whoop_hero',
				$settings
			);
//			echo '###2';exit;
		}
	}

	public static function add_meta_boxes()
	{
		$screens = array('page');
		foreach ($screens as $screen) {
			add_meta_box(
				'whoop_hero_settings',          // Unique ID
				__('Hero Area Settings','whoop'), // Box title
				array(__CLASS__, 'meta_box_html'),   // Content callback, must be of type callable
				$screen,                 // Post type
				'side'
			);
		}
	}

	public static function meta_box_html($post)
	{
		$defaults = self::default_settings();
		$settings = get_post_meta($post->ID, '_whoop_hero', true);
		$settings = wp_parse_args($settings,$defaults);
		$options = array(
			''  => __('Auto','whoop'),
			'featured'  => __('Featured image','whoop'),
			'video'  => __('Video','whoop'),
			'gallery'  => __('Gallery','whoop'),
			'listing'  => __('Listing images (GeoDirectory)','whoop'),
		);
		?>
		<label for="whoop_hero_type"><?php _e('Show:','whoop');?></label>
		<select name="_whoop_hero[type]" id="whoop_hero_type" class="postbox">
			<?php
				
			foreach($options as $option => $desc){
				echo '<option value="'.$option.'" '.selected($settings['type'], $option).'>'.$desc.'</option>';
			}
			?>
		</select>

		<label for="whoop_hero_id"><?php _e('ID: (video id / attachments ids: 123,456,789)','whoop');?></label>
		<input type="text" name="_whoop_hero[id]" id="whoop_hero_id" value="<?php echo esc_attr($settings['id']);?>" placeholder="AjZXFw9iWkw / 123,456,789" />

		<label for="whoop_hero_time"><?php _e('Time: (time between images, 8000 =  8 seconds)','whoop');?></label>
		<input type="number" min="1000" name="_whoop_hero[time]" id="whoop_hero_time" value="<?php echo esc_attr($settings['time']);?>" placeholder="8000" />

		<label for="whoop_hero_brightness"><?php _e('Brightness: (how bright the background is, default 50%)','whoop');?></label>
		<input type="number" name="_whoop_hero[brightness]" id="whoop_hero_brightness" value="<?php echo esc_attr($settings['brightness']);?>" placeholder="50" />
		<?php
	}




}
Whoop_Hero_Background::init();
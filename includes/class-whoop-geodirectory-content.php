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
class Whoop_Geodirectory_Content {


	/**
	 * Init
	 */
	public static function init() {
		add_filter( 'geodir_wizard_content', array( __CLASS__, 'add_sections' ) );
		add_action( 'geodir_wizard_content_whoop_content', array( __CLASS__, 'wizard_settings' ) );

		add_action( 'wp_ajax_whoop_wizard_set_page_content',  array(__CLASS__,'ajax_set_page_content') );
		add_action( 'wp_ajax_whoop_wizard_set_rating_style',  array(__CLASS__,'ajax_set_rating_style') );
		add_action( 'wp_ajax_whoop_wizard_set_tabs_order',  array(__CLASS__,'ajax_set_tabs_order') );

		// set some default page contents
		add_filter("geodir_default_page_details_content", array( __CLASS__, 'page_details_content' ) );
		add_filter("geodir_default_page_archive_content", array( __CLASS__, 'page_archive_content' ) );
		add_filter("geodir_default_page_location_content", array( __CLASS__, 'page_location_content' ) );
		add_filter("geodir_default_page_search_content", array( __CLASS__, 'page_search_content' ) );
		add_filter("geodir_default_page_archive_item_content", array( __CLASS__, 'page_archive_item_content' ) );

		// dummy widget content
		add_filter('geodir_dummy_widgets',array( __CLASS__, 'dummy_widgets' ), 10, 2);
	}

	public static function dummy_widgets($widgets, $type){

		if($type==''){
			$widgets = array(
				// show the author action on the details sidebar
				'gd_author_actions' => array(
					'hide_edit'          => false,
					'hide_delete'          => false,
					'gd_wgt_showhide'   => 'show_on',
					'gd_wgt_restrict'   => array('gd-detail'),
				),
				// show details sidebar
				'gd_output_location' => array(
					'location'          => '[detail]',
					'gd_wgt_showhide'   => 'show_on',
					'gd_wgt_restrict'   => array('gd-detail'),
				),
				// show map
				'gd_map' => array(
					'width' => '100%',
					'height' => '425px',
					'maptype' => 'ROADMAP',
					'zoom' => '0',
					'sticky' => '1',
					'map_type' => 'auto',
					'map_directions' => '1',
					'gd_wgt_showhide'   => 'show_on',
					'gd_wgt_restrict'   => array('gd-author','gd-pt','gd-search','gd-listing'),
				),
				// show GD Dashboard
				'gd_dashboard' => array(
					'dashboard_title'   => __('GD Dashboard','whoop'),
					'show_login'        => true,
					'login_title'        => __('Login','whoop'),
					'gd_wgt_showhide'   => 'show',
					'gd_wgt_restrict'   => array(),
				),

			);
		}

		return $widgets;
	}

	public static function page_archive_item_content($content){
		$content = '[gd_archive_item_section type="open" position="left"]';
		$content .= "\n".'[gd_post_badge key="featured" condition="is_not_empty" badge="FEATURED" bg_color="#fd4700" txt_color="#ffffff" css_class="gd-ab-left-angle gd-badge-shadow"]';
		$content .= "\n".'[gd_post_images type="slider" ajax_load="1" animation="slide" controlnav="0" link_to="post" show_logo="1" limit="10"]';
		$content .= "\n".'[gd_archive_item_section type="close" position="left"]';
		$content .= "\n".'[gd_archive_item_section type="open" position="right"]';
		$content .= "\n".'[gd_post_title tag="h2"]';
		$content .= "\n".'[gd_post_meta key="phone" show="value" alignment="right" text_alignment="right"]';
		$content .= "\n".'[gd_author_actions author_page_only="1"]';
		$content .= "\n".'[gd_post_distance]';
		$content .= "\n".'[gd_post_rating alignment="left" list_hide_secondary="2"]';
		$content .= "\n".'[gd_post_meta key="post_category" show="icon-value" alignment="block"]';
		$content .= "\n".'[gd_post_address show="icon-value" address_template="%%street%%, %%city%%" alignment="block"]';
		$content .= "\n".'[gd_post_meta key="business_hours" location="listing" list_hide_secondary="2"]';
		$content .= "\n".'[gd_output_location location="listing"]';
		$content .= "\n".'[gd_post_content key="post_content" limit="25" ]';
		$content .= "\n".'[gd_archive_item_section type="close" position="right"]';

		return $content;
	}

	public static function page_location_content($content){
		return $content;
	}

	public static function page_search_content($content){
		$content = "\n".'[gd_loop layout=0]';
		$content .= "\n".'[gd_loop_paging]';
		return $content;
	}

	public static function page_archive_content($content){
		$content = '[gd_category_description]';
		$content .= "\n".'[gd_loop layout=0]';
		$content .= "\n".'[gd_loop_paging]';
		return $content;
	}

	public static function page_details_content($content){
		$content = '[gd_single_tabs]';
		return $content;
	}

	public static function set_page_content($page = ''){
		$result = false;
		$page_id = '';
		$content = '';
		if($page=='details'){
			$page_id = geodir_details_page_id();
			$content = GeoDir_Defaults::page_details_content();
		}elseif($page=='archive'){
			$page_id = geodir_archive_page_id();
			$content = GeoDir_Defaults::page_archive_content();
		}elseif($page=='archive_item'){
			$page_id = geodir_archive_item_page_id();
			$content = GeoDir_Defaults::page_archive_item_content();
		}elseif($page=='search'){
			$page_id = geodir_search_page_id();
			$content = GeoDir_Defaults::page_search_content();
		}elseif($page=='location'){
			$page_id = geodir_location_page_id();
			$content = GeoDir_Defaults::page_location_content();

			// set template
			if($page_id){
				update_post_meta($page_id,'_wp_page_template','page-whoop.php');
			}
		}elseif($page=='home'){
			$page = get_page_by_path( 'whoop-home' );
			if(!$page){
				$page_data = array(
					'post_status'    => 'publish',
					'post_type'      => 'page',
					'post_author'    => get_current_user_id(),
					'post_name'      => 'whoop-home',
					'post_title'     => 'Whoop!',
					'post_content'   => GeoDir_Defaults::page_location_content(),
					'post_parent'    => '',
					'comment_status' => 'closed'
				);
				$page_id   = wp_insert_post( $page_data );


				// set template
				if($page_id){
					update_post_meta($page_id,'_wp_page_template','page-whoop.php');
					$result = true;
					update_option("show_on_front","page");
					update_option("page_on_front",$page_id);
				}
			}
		}

		if($page_id && $content){
			wp_update_post( array(
				'ID'           => $page_id,
				'post_content' => $content,
			) );
			$result = true;
		}

		return $result;
	}

	public static function ajax_set_page_content(){
		// security
		check_ajax_referer( 'whoop-wizard-nonce', 'security' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( -1 );
		}

		$page = isset($_POST['page']) ? esc_attr($_POST['page']) : '';

		$result = false;
		if($page){
			$result = self::set_page_content($page);
		}

		if($result ){
			wp_send_json_success(__("Content updated successfully.","whoop"));
		}else{
			wp_send_json_error(__("Something went wrong.","whoop"));
		}


		wp_die();
	}

	public static function ajax_set_rating_style(){
		// security
		check_ajax_referer( 'whoop-wizard-nonce', 'security' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( -1 );
		}

		geodir_update_option("rating_color","#e00000");
		geodir_update_option("rating_color_off","#cecece");
		geodir_update_option("rating_type","font-awesome");
		geodir_update_option("rating_icon","fas fa-stop");
		geodir_update_option("rating_icon_fw","0");

		wp_send_json_success(__("Rating style updated successfully.","whoop"));

		wp_die();
	}

	public static function ajax_set_tabs_order(){
		global $wpdb;
		// security
		check_ajax_referer( 'whoop-wizard-nonce', 'security' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( -1 );
		}

		$wpdb->update( GEODIR_TABS_LAYOUT_TABLE, array( 'sort_order' => 0), array( 'tab_key' => 'reviews' ) );

		wp_send_json_success(__("Reviews tab order updated successfully.","whoop"));

		wp_die();
	}

	/**
	 * Add our setup wizard content sections.
	 *
	 * @param $sections
	 *
	 * @return mixed
	 */
	public static function add_sections( $sections ) {

		// add page content section
		$sections['whoop_content'] = __( "Whoop Content", "whoop" );

		return $sections;
	}

	public static function wizard_settings() {

		$pages = array(
			'home'      => __( "Home page, create and set content (should only be run once)", "whoop" ),
			'details'      => __( "Details page", "whoop" ),
			'archive_item' => __( "Archive item page", "whoop" ),
			'archive'      => __( "Archive page", "whoop" ),
			'search'      => __( "Search page", "whoop" ),
			'location'      => __( "Location page", "whoop" ),
		);
		?>
		<table class="form-table gd-dummy-table">
			<tbody>
			<tr>
				<td><strong><?php _e( "Description", "whoop" ); ?></strong></td>
				<td><strong><?php _e( "Action", "whoop" ); ?></strong></td>
			</tr>


			<?php

			// pages
			foreach ( $pages as $slug => $title ) {

				?>
				<tr>
					<td>
						<?php
						echo esc_attr( $title );
						echo geodir_notification( array( 'geodir-wizard-page-result-'.$slug => '' ) );
						?>
					</td>
					<td>
						<input type="button" value="<?php if($slug=='home'){_e( "Create page & content", "whoop" );}else{_e( "Set page content", "whoop" );} ?>"
						       class="button-primary geodir_dummy_button"
						       onclick="whoop_wizard_set_page_content('<?php echo esc_attr($slug) ?>');return false;">
					</td>
				</tr>
				<?php

			}

			?>


			<?php // ratings ?>
			<tr>
				<td>
					<?php
					esc_attr_e("Rating icon style, change to Whoop style.","whoop");
					echo geodir_notification( array( 'geodir-wizard-whoop-ratings-result' => '' ) );
					?>
				</td>
				<td>
					<input type="button" value="<?php _e( "Set rating style", "whoop" ); ?>"
					       class="button-primary geodir_dummy_button"
					       onclick="whoop_wizard_set_rating_style();return false;">
				</td>
			</tr>

			<?php // reviews tab first ?>
			<tr>
				<td>
					<?php
					esc_attr_e("Set details page reviews tab to be shown first.","whoop");
					echo geodir_notification( array( 'geodir-wizard-whoop-tabs-result' => '' ) );
					?>
				</td>
				<td>
					<input type="button" value="<?php _e( "Set tabs order", "whoop" ); ?>"
					       class="button-primary geodir_dummy_button"
					       onclick="whoop_wizard_set_tabs_order();return false;">
				</td>
			</tr>

			</tbody>
		</table>

		<script>
			/**
			 * Set the GD page content to whoop page content.
			 *
			 * @param $page
			 * @returns {boolean}
			 */
			function whoop_wizard_set_page_content($page){
				var message = "<?php esc_attr_e("This will replace the page content with one specific to the theme.","whoop") ?>";
				var container = ".geodir-wizard-page-result-"+$page;
				if (confirm(message)) {

					jQuery.ajax({
						url: '<?php echo admin_url( 'admin-ajax.php' );?>',
						type: 'POST',
						dataType: 'json',
						data: {
							action: 'whoop_wizard_set_page_content',
							security: '<?php echo wp_create_nonce( "whoop-wizard-nonce" ); ?>',
							page: $page
						},
						timeout: 20000,
						beforeSend: function()
						{
							jQuery( container  ).html('<i class="fas fa-sync fa-spin" style="font-size:18px"></i>');

						},
						success: function(data)
						{
							if(data.data){
								jQuery( container  ).html(data.data);
							}
						}
					});
					return true;
				} else {
					return false;
				}
			}

			/**
			 * Set the GD rating style to match the whoop style.
			 *
			 * @returns {boolean}
			 */
			function whoop_wizard_set_rating_style(){
				var container = ".geodir-wizard-whoop-ratings-result";

				jQuery.ajax({
					url: '<?php echo admin_url( 'admin-ajax.php' );?>',
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'whoop_wizard_set_rating_style',
						security: '<?php echo wp_create_nonce( "whoop-wizard-nonce" ); ?>'
					},
					timeout: 20000,
					beforeSend: function()
					{
						jQuery( container  ).html('<i class="fas fa-sync fa-spin" style="font-size:18px"></i>');

					},
					success: function(data)
					{
						if(data.data){
							jQuery( container  ).html(data.data);
						}
					}
				});
			}
			/**
			 * Set the details page reviews tabs to show first.
			 *
			 * @returns {boolean}
			 */
			function whoop_wizard_set_tabs_order(){
				var container = ".geodir-wizard-whoop-tabs-result";

				jQuery.ajax({
					url: '<?php echo admin_url( 'admin-ajax.php' );?>',
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'whoop_wizard_set_tabs_order',
						security: '<?php echo wp_create_nonce( "whoop-wizard-nonce" ); ?>'
					},
					timeout: 20000,
					beforeSend: function()
					{
						jQuery( container  ).html('<i class="fas fa-sync fa-spin" style="font-size:18px"></i>');

					},
					success: function(data)
					{
						if(data.data){
							jQuery( container  ).html(data.data);
						}
					}
				});
			}

		</script>
		<?php
	}


}

Whoop_Geodirectory_Content::init();
<?php
// Define Whoop theme version.
if( !defined('WHOOP_VERSION') ) {
	define( 'WHOOP_VERSION', '1.0.0');
}

// Define Whoop theme text domain.
if( !defined('WHOOP_TEXT_DOMAIN') ) {
	define( 'WHOOP_TEXT_DOMAIN', 'whoop');
}

// Define Whoop theme default logo image.
if( !defined('WHOOP_DEFAULT_LOGO_IMAGE') ) {
	define( 'WHOOP_DEFAULT_LOGO_IMAGE', get_stylesheet_directory_uri().'/images/whoop_default_logo.png');
}

// Define Whoop theme placeholder image.
if( !defined('WHOOP_PLACEHOLDER_IMAGE') ) {
	define( 'WHOOP_PLACEHOLDER_IMAGE', get_stylesheet_directory_uri().'/images/whoop_placeholder.png');
}

// Define Whoop theme featured image.
if( !defined('WHOOP_FEATURED_IMAGE') ) {
	define( 'WHOOP_FEATURED_IMAGE', get_stylesheet_directory_uri().'/images/whoop_featured.jpg');
}

if (!defined('GEODIRECTORY_VERSION')) {

	add_action('admin_notices', 'whoop_update_remove_notice');

} else{

	include_once('includes/whoop_healper_function.php');
	include_once('includes/geodirectory-compatibility.php');

}

/**
 * Check whoop_update_remove_notice function exists or not.
 *
 * @since 1.0.0
 */
if( !function_exists( 'whoop_update_remove_notice ' ) ) {

	/**
	 * Adds GeoDirectory plugin required admin notice.
	 *
	 * @since 1.0.0
	 */
	function whoop_update_remove_notice() {

		$screen = get_current_screen();

		if( !empty( $screen->id ) && $screen->id=='themes'){
			$action = 'install-plugin';
			$gd_slug = 'geodirectory';

			$install_url = wp_nonce_url(
				add_query_arg(
					array(
						'action' => $action,
						'plugin' => $gd_slug
					),
					admin_url( 'update.php' )
				),
				$action.'_'.$gd_slug
			);

			$message = sprintf( __("This theme was designed to work with the GeoDirectory plugin! <a href='%s' >Click here to install it.</a>", 'whoop'), esc_url($install_url) ) ;

			printf('<div class="notice notice-error is-dismissible"><p>%1$s</p></div>', $message);
		}

	}
}

/**
 * Check whoop_body_class function exists or not.
 *
 * @since 1.0.0
 */
if( !function_exists( 'whoop_body_class' ) ){

	/**
	 * Add body classes to the HTML where needed.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes The array of body classes.
	 *
	 * @return array $classes The array of body classes.
	 */
	function whoop_body_class( $classes ) {

		$classes[] = 'whoop-common';

		if( is_front_page() ) {
			$classes[] ='whoop-featured';
		} else{
			$classes[] ='whoop-common-header';
		}

		if( is_user_logged_in() ) {
			$classes[] = 'whoop-logged-user';
		} else{
			$classes[] = 'whoop-not-logged-user';
		}

		return $classes;
	}
}

add_filter('body_class', 'whoop_body_class');

/**
 * Check whoop_enqueue_styles function is exists or not.
 *
 * @since 1.0.0
 */
if( !function_exists( 'whoop_enqueue_styles' ) ){

	/**
	 * Register and enqueue styles and scripts.
	 *
	 * @since 1.0.0
	 */
	function whoop_enqueue_styles(){

		wp_enqueue_style('whoop-style', get_stylesheet_uri(), array('directory-theme-style', 'directory-theme-style-responsive'));
		wp_enqueue_style('whoop-media', get_stylesheet_directory_uri().'/media.css', array('directory-theme-style', 'directory-theme-style-responsive'));
		wp_register_script( 'whoop-script', get_stylesheet_directory_uri() . '/js/custom_whoop.js', array( 'jquery' ), WHOOP_VERSION, true );
		wp_enqueue_script( 'whoop-script' );

	}
}

add_action('wp_enqueue_scripts', 'whoop_enqueue_styles');

/**
 * check whoop_after_theme_setup function is exists or not.
 *
 * @since 1.0.0
 */
if( !function_exists( 'whoop_after_theme_setup' ) ){

	function whoop_after_theme_setup() {

		load_child_theme_textdomain( 'whoop', get_stylesheet_directory() . '/languages' );

		if (!current_user_can('administrator') && !is_admin()) {
			add_filter('show_admin_bar', '__return_false');
		}

		remove_action( 'dt_footer_copyright', 'dt_footer_copyright_default', 10 );
		remove_action( 'dt_before_site_logo', 'dt_add_mobile_gd_account_menu', 10 );

	}

}

add_action('after_setup_theme', 'whoop_after_theme_setup');
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
class Whoop_Assets {


	public static function init(){
		add_filter('body_class', array(__CLASS__,'body_classes') );
		add_action( 'wp_enqueue_scripts', array(__CLASS__,'styles') );
		add_action( 'wp_enqueue_scripts', array(__CLASS__,'scripts') );
		self::constants();
	}

	/**
	 * Add a theme body class so it easy to target specific things.
	 *
	 * @param $classes
	 *
	 * @return array
	 */
	public static function body_classes($classes){
		$classes[] = "whoop-whoop";
		return $classes;
	}

	public static function styles(){

		// register
		wp_register_style( 'whoop', get_stylesheet_directory_uri() . '/assets/css/style.css', array('directory-theme-style'), WHOOP_VERSION );

		// enqueue
		wp_enqueue_style( 'whoop' );

	}

	public static function scripts(){

		// register
		wp_register_script( 'whoop-js', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), WHOOP_VERSION, true );

		// enqueue
		wp_enqueue_script( 'whoop-js' );
	}

	/**
	 * Override some CSS constants
	 */
	public static function constants(){
		define('DT_P_NAV_HEIGHT', '40px');
		define('DT_P_NAV_LINE_HEIGHT', '40px');
		define('DT_LOGO_MARGIN_TOP', '0px');
		define('DT_CONTAINER_WIDTH', '1000px');
		define('DT_BODY_COLOR', '#333');
		define('DT_BTN_BG_COLOR', '#ef3d2e');
		define('DT_LINK_COLOR', '#0073bb');
		define('DT_LINK_VISITED', '#0073bb');
		define('DT_LINK_HOVER', '#048de2');

//		define('DT_HEADER_LINK_COLOR', '#d32323');
		//

		// Footer
//		define('DT_FW_TEXT_COLOR', '#048de2');
		define('DT_FW_H1TOH6_COLOR', '#d32323');
		define('DT_FW_LINK_COLOR', '#0073bb');
		define('DT_FW_LINK_HOVER', '#048de2');
		define('DT_FW_LINK_VISITED', '#0073bb');
		define('DT_FW_BG', '#f5f5f5');
		define('DT_FW_BORDER_BOTTOM_COLOR', '#f5f5f5');
//		define('', '');
//		define('', '');
//		define('', '');
		define('DT_COPYRIGHT_LINK_COLOR', '#0073bb');
		define('DT_COPYRIGHT_LINK_HOVER', '#048de2');
		define('DT_COPYRIGHT_LINK_VISITED', '#0073bb');
		define('DT_COPYRIGHT_BG', '#f5f5f5');
		define('DT_COPYRIGHT_BORDER_COLOR', '#f5f5f5');
		//
	}
}
Whoop_Assets::init();
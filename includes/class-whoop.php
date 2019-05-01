<?php
/**
 * Whoop
 *
 * Handles assets.
 *
 * @author   AyeCode
 * @package  Whoop/Core
 * @since    2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Whoop {
	
	/**
	 * Setup class.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {
		$this->includes();
		add_action( 'after_setup_theme', array( $this, 'theme_setup' ), 11 );
	}
	
	/**
	 * Include any files required.
	 */
	public function includes(){
		require_once( dirname( __FILE__ ) . '/class-whoop-assets.php' );
		require_once( dirname( __FILE__ ) . '/class-whoop-menus.php' );
		require_once( dirname( __FILE__ ) . '/class-whoop-hero-background.php' );


//		if(is_admin())
		require_once( dirname( __FILE__ ) . '/admin/class-whoop-admin-customizer.php' );

		if(defined('GEODIRECTORY_VERSION') ){
			require_once( dirname( __FILE__ ) . '/class-whoop-geodirectory-content.php' );
		}
	}

	/**
	 * Setup the theme.
	 */
	public function theme_setup(){
		load_child_theme_textdomain( 'whoop', get_stylesheet_directory() . '/languages' );
		remove_action( 'dt_footer_copyright', 'dt_footer_copyright_default', 10 );
		add_action( 'dt_footer_copyright', 'whoop_copyright_text', 10 );

		// remove support for the top widget area as we add nothing there by default (users can still add things)
		remove_theme_support( 'geodirectory-sidebar-top' );
	}
	
}
new Whoop();
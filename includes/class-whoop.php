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
		add_action('after_setup_theme', array($this,'theme_setup'));
	}

	/**
	 * Include any files required.
	 */
	public function includes(){
		require_once( dirname( __FILE__ ) . '/class-whoop-assets.php' );
	}
	
	public function theme_setup(){
//		load_child_theme_textdomain( SD_CHILD, get_stylesheet_directory() . '/languages' );
		remove_action( 'dt_footer_copyright', 'dt_footer_copyright_default', 10 );
		add_action( 'dt_footer_copyright', 'whoop_copyright_text', 10 );
	}
	
	
}
new Whoop();
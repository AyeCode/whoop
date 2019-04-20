<?php
/**
 * Whoop Admin Customizer
 *
 * Handles assets.
 *
 * @author   AyeCode
 * @category API
 * @package  Whoop/Customizer
 * @since    2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A class to add customizer settings.
 *
 * We call these statically so they can easily be modified by 3rd party devs.
 *
 * Class Whoop_Assets
 */
class Whoop_Admin_Customizer {


	/**
	 * Init
	 */
	public static function init(){

		//add_action( 'customize_register', array(__CLASS__,'customizer') );
	}

	/**
	 * Customizer settings.
	 */
	public static function customizer( $wp_customize ){


	}

}
Whoop_Admin_Customizer::init();
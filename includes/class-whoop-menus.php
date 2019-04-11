<?php
/**
 * Whoop Menus
 *
 * Handles menus.
 *
 * @author   AyeCode
 * @category API
 * @package  Whoop/Menus
 * @since    2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A class to call Whoop menus.
 *
 * We call these statically so they can easily be removed by 3rd party devs.
 *
 * Class Whoop_Menus
 */
class Whoop_Menus {


	public static function init(){
		add_action( 'after_setup_theme', array( __CLASS__, 'theme_setup' ) );
		add_filter( 'wp_nav_menu_items', array( __CLASS__, 'font_awesome_menu_icons' ), 10, 2 );
		add_filter( 'wp_nav_menu_user_items', array( __CLASS__, 'user_menu_button_classes' ), 10, 2 );
	}

	/**
	 * Register menus.
	 */
	public static function theme_setup(){
		register_nav_menus( array(
			'home_menu' => __("Home menu","whoop"),
			'home_middle_menu' => __("Home middle menu","whoop"),
			'user_menu' => __("User menu","whoop"),
		) );
	}

	/**
	 * Remove font-awesome menu classes and replce them with an icon at the start of the word.
	 *
	 * @param $items
	 * @param $args
	 *
	 * @return string
	 */
	public static function font_awesome_menu_icons($items, $args){
		$items_array = explode(PHP_EOL,$items);
		if(!empty($items_array)){
			foreach($items_array as $key=>$item){
				$m = '';
				$pattern = "/.*[\ \\\"\']+(fa[srlb] )+(fa-[a-z]*).*/";
				if(preg_match($pattern,$item,$m)){
					if(!empty($m[2])){
						$icon = "<i class='".$m[1].$m[2]."'></i>";
						$item = str_replace($m[1].$m[2],'',$item); // remove original classes
						$items_array[$key] = str_replace(array('"><a','">'),array('" ><a','">'.$icon ),$item);
					}
				}

			}
		}

		$items = implode(PHP_EOL,$items_array);
		
		return $items;
	}

	/**
	 * Add button classes to the user menu.
	 *
	 * @param $items
	 * @param $args
	 *
	 * @return mixed
	 */
	public static function user_menu_button_classes($items, $args){

		if(!empty($items)){
			$items = str_replace("><a","><a class='dt-btn button whoop-button'",$items);
		}

		return $items;
	}

}
Whoop_Menus::init();
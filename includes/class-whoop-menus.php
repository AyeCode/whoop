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


	/**
	 * Init
	 */
	public static function init(){
		add_action( 'after_setup_theme', array( __CLASS__, 'theme_setup' ) );
		add_filter( 'wp_nav_menu_items', array( __CLASS__, 'font_awesome_menu_icons' ), 10, 2 );
		add_filter( 'wp_nav_menu_user_items', array( __CLASS__, 'user_menu_button_classes' ), 10, 2 );
		add_filter( 'nav_menu_submenu_css_class', array( __CLASS__, 'sd_sub_menu_ul_class' )  , 15, 3 );

		// UWP Account items
		if( defined( 'USERSWP_VERSION' ) ){
			add_filter("whoop_menu_account_items",array( __CLASS__,'uwp_account_items') );
		}
	}

	/**
	 * Modify the menu classes to add bootstrap styling.
	 *
	 * @param $classes
	 * @param $args
	 * @param $depth
	 *
	 * @return array
	 */
	public static function sd_sub_menu_ul_class( $classes, $args, $depth ) {

//		print_r( $args );
		if(!empty($args->theme_location) && $args->theme_location=='primary-menu'){
			foreach ( $classes as $key => $class ) {
				$classes[ $key ] = str_replace( "dropdown-menu-right", "", $classes[ $key ] );
			}
		}

		return $classes;
	}

	/**
	 * Add UWP menu items.
	 * 
	 * @param $html
	 *
	 * @return string
	 */
	public static function uwp_account_items($html){

		$account_slug = uwp_get_page_slug('account_page');
		$profile_slug = uwp_get_page_slug('profile_page');
		$change_slug = uwp_get_page_slug('change_page');

		if($profile_slug){
			$html .= '<li class="gd-menu-item menu-item menu-item-uwp-profile nav-item">';
			$html .= '<a href="'.uwp_get_page_link('profile').'" class="nav-link">'.__( "Profile", "whoop" ).'</a>';
			$html .= '</li>';
		}

		if($account_slug){
			$html .= '<li class="gd-menu-item menu-item menu-item-uwp-account nav-item">';
			$html .= '<a href="'.uwp_get_page_link('account').'" class="nav-link">'.__( "Edit Account", "whoop" ).'</a>';
			$html .= '</li>';
		}

		if($change_slug){
			$html .= '<li class="gd-menu-item menu-item menu-item-uwp-change nav-item">';
			$html .= '<a href="'.uwp_get_change_page_url().'" class="nav-link">'.__( "Change Password", "whoop" ).'</a>';
			$html .= '</li>';
		}

		return $html;
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

		// remove GD user menu
		remove_action('dt_before_site_logo', 'dt_add_mobile_gd_account_menu');
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
			foreach($items_array as $key => $item){

				// check for location switcher and don't run if found
				if(strpos( $item, '#location-switcher') !== false){
					continue;
				}

				$m = '';
				$pattern = "/.*[\ \\\"\']+(fa[srlb] )+(fa-[a-z-]*).*/";
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
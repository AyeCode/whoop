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


	/**
	 * Init
	 */
	public static function init(){
		add_filter('body_class', array(__CLASS__,'body_classes') );
		add_action( 'wp_enqueue_scripts', array(__CLASS__,'styles') );
		add_action( 'wp_enqueue_scripts', array(__CLASS__,'scripts') );
		add_action( 'dt_css', array(__CLASS__,'css') );
		self::constants();
	}

	public static function css(){
		if(0){ ?><style><?php }?>
		#site-header .geodir-search .form-group,
		.featured-area .geodir-search .form-group{
			margin: 0;
		}

	body.geodir_advance_search #site-header .geodir-search .col-auto:not(:nth-last-of-type(-n+3)):after,
	body.geodir_advance_search .featured-area .geodir-search .col-auto:not(:nth-last-of-type(-n+3)):after,
	body:not(.geodir_advance_search) #site-header .geodir-search .col-auto:not(:nth-last-of-type(-n+2)):after,
	body:not(.geodir_advance_search) .featured-area .geodir-search .col-auto:not(:nth-last-of-type(-n+2)):after
	{
		content: "";
		position: absolute;
		top: 12px;
		right: 0;
		bottom: 12px;
		width: 2px;
		background-color: #eeeeef;
	}
	#site-header .geodir-search .form-group input,#site-header .geodir-search .form-group select,
	.featured-area .geodir-search .form-group input,#site-header .geodir-search .form-group select{
		border-width: 0;
	}

	#site-header .geodir-search .form-group .geodir_submit_search{
		border-top-left-radius: 0;
		border-bottom-left-radius: 0;
		padding: 10px 20px;
	}

	.featured-area .geodir-search .form-group .geodir_submit_search{
		border-top-left-radius: 0;
		border-bottom-left-radius: 0;
		/*padding: 10px 20px;*/
	}


	#site-header .geodir-search-form-wrapper{
		box-shadow: 0 2px 18px rgba(0,0,0,.15);
	}

		#menu-gd-menu .dropdown-toggle::after{
			border: solid <?php echo DT_HEADER_TEXT_COLOR;?>;
			border-width: 0 2px 2px 0;
			display: inline-block;
			padding: 3px;
			transform: rotate(45deg);
			-webkit-transform: rotate(45deg);
			margin-left: 8px;
			margin-bottom: -2px;
			border-color: inherit;
		}

		#site-header .sub-menu{
			z-index: 1050;
		}

		#site-header .gd-search-field-search-filters,
		.featured-area .gd-search-field-search-filters{
			display: none;
		}


	.gd-rating-wrap .gd-rating-background .fas.fa-stop:after {
		content: "\f005";
		margin-left: -2%;
		vertical-align: middle;
		color: #fff;
		position: absolute;
		top: 50%;
		display: block;
		-ms-transform: translateY(-50%);
		transform: translateY(-50%) scale(0.5);
		<?php if(0){ ?></style><?php }
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

	/**
	 * Enqueue styles
	 */
	public static function styles(){

		// register
		wp_register_style( 'whoop', get_stylesheet_directory_uri() . '/assets/css/style.css',array(), WHOOP_VERSION );

		// enqueue
		//wp_enqueue_style( 'whoop' );

	}

	/**
	 * Enqueue scripts
	 */
	public static function scripts(){

		// register
		//wp_register_script( 'whoop-js', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), WHOOP_VERSION, true );

		// enqueue
		//wp_enqueue_script( 'whoop-js' ); // not used yet
	}

	/**
	 * Override some CSS constants
	 */
	public static function constants(){

		// AUI
		define('AUI_PRIMARY_COLOR', "#f43939");

		// header
		define('DT_HEADER_TEXT_COLOR', "#2b273c");
		define('DT_HEADER_LINK_COLOR', "#2b273c");
		define('DT_HEADER_LINK_HOVER', '#57526f');

		//
		define('DT_HEADER_BG_COLOR', '#ffffff');
		define('DT_P_NAV_HEIGHT', '40px');
		define('DT_P_NAV_LINE_HEIGHT', '40px');
		define('DT_LOGO_MARGIN_TOP', '0px');

		// menu
		define('DT_P_NAV_SUBMENU_BG_HOVER', '#eeeeef');

		// body
		define('DT_BACKGROUND_COLOR', "#ffffff");
		define('DT_BODY_COLOR', '#333');
		define('DT_BTN_BG_COLOR', '#ef3d2e');
		define('DT_LINK_COLOR', '#00838f');
		define('DT_LINK_VISITED', '#00838f');
		define('DT_LINK_HOVER', '#00838f');
		define('DT_H1TOH6_COLOR', '#2b273c');

		// content
		define('DT_CONTENT_SHADOW', "");
		define('DT_CONTENT_PADDING', "p-0");
		define('DT_CONTENT_MARGINS', "mb-3");

		// Footer
		define('DT_FW_H1TOH6_COLOR', '#2b273c');
		define('DT_FW_LINK_COLOR', '#757280');
		define('DT_FW_LINK_HOVER', '#757280');
		define('DT_FW_LINK_VISITED', '#757280');
		define('DT_FW_BG', '#f4f4f4');
		define('DT_FW_BORDER_BOTTOM_COLOR', '#f5f5f5');
		define('DT_COPYRIGHT_LINK_COLOR', '#0073bb');
		define('DT_COPYRIGHT_LINK_HOVER', '#048de2');
		define('DT_COPYRIGHT_LINK_VISITED', '#0073bb');
		define('DT_COPYRIGHT_BG', '#f5f5f5');
		define('DT_COPYRIGHT_BORDER_COLOR', '#f5f5f5');
	}
}
Whoop_Assets::init();
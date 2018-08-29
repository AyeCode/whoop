<?php

if( !function_exists( 'whoop_before_nav_fn' ) ) {

	function whoop_before_nav_fn() {

		if( !is_front_page() ) {
			?><div class="ds-child-header-search"><?php
			echo do_shortcode( '[gd_search]');
			whoop_header_nav();
			?></div><?php

		}
	}

}

add_action('dt_after_site_logo','whoop_before_nav_fn');

if( !function_exists( 'whoop_after_nav_fn' ) ) {

	function whoop_after_nav_fn() {

		if( is_front_page() ) {
			whoop_header_nav();
		}

	}

}
add_action('whoop_after_nav','whoop_after_nav_fn');

if( !function_exists( 'whoop_page_before_main_content_fn' ) ) {

	function whoop_page_before_main_content_fn() {

		if( is_front_page() ) {

			?>
			<div class="featured-area">
				<div class="featured-header-img" style="background-image: url('<?php echo WHOOP_FEATURED_IMAGE; ?>');"></div>
				<div class="featured-header-wrap">
					<?php do_action( 'whoop_featured_content' ); ?>
				</div>
			</div>
			<?php
		}

	}
}

add_action('whoop_page_before_main_content','whoop_page_before_main_content_fn');

if( !function_exists( 'whoop_featured_content_fn' ) ) {

	function whoop_featured_content_fn() {

		if ( get_theme_mod( 'logo', false ) ) {
			?>
			<div class='site-logo'>
				<a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><img src='<?php echo esc_url( get_theme_mod( 'logo', false ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'></a>
			</div>
			<?php
		} else{
			?>
			<div class='site-logo default-logo'>
				<a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><img src='<?php echo esc_url( WHOOP_DEFAULT_LOGO_IMAGE ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'></a>
			</div>
			<?php
		}

		echo do_shortcode( '[gd_search]');
		echo do_shortcode( '[gd_popular_categories]');

	}
}

add_action('whoop_featured_content','whoop_featured_content_fn');

if( !function_exists( 'whoop_footer_copyright_content' ) ) {

	function whoop_footer_copyright_content() {

		$footer_credits = esc_attr(get_theme_mod('dt_disable_footer_credits', '' ));

		if ('1' != $footer_credits ) {

			$theme_name = "Whoop";
			$theme_url = "https://wordpress.org/themes/whoop/";

			$wp_link = '<a href="https://wordpress.org/" target="_blank" title="' . esc_attr__('WordPress', 'whoop') . '"><span>' . __('WordPress', 'whoop') . '</span></a>';

			$default_footer_text = sprintf(__('Copyright &copy; %1$s %2$s %3$s Theme %4$s', 'whoop'),date('Y'),"<a href='$theme_url' target='_blank' title='$theme_name'>", $theme_name, "</a>");
			$default_footer_text .= sprintf(__(' - Powered by %s.', 'whoop'), $wp_link);

			echo $default_footer_text;

		}else{

			$default_footer_text = __('Copyright &copy; ', 'whoop') .date( 'Y' ). ' '. get_bloginfo( 'name', 'display' ). __('. All rights reserved.', 'whoop');
			echo esc_attr( get_theme_mod( 'dt_copyright_text', $default_footer_text ) );

		}
	}

}

add_action( 'dt_footer_copyright', 'whoop_footer_copyright_content', 10 );

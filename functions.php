<?php
// Define some constants
if (!defined('WHOOP_VERSION')) define('WHOOP_VERSION', '2.0.1');

// Call Whoop
require_once( dirname( __FILE__ ) . '/includes/class-whoop.php' );

/**
 * The copyright text used in the footer.
 */
function whoop_copyright_text() {
	$dt_disable_footer_credits = esc_attr(get_theme_mod('dt_disable_footer_credits', DT_DISABLE_FOOTER_CREDITS));
	if ($dt_disable_footer_credits != '1') {
		$theme_name = "Whoop";
		$theme_url = "https://wordpress.org/themes/whoop/";

		$wp_link = '<a href="https://wordpress.org/" target="_blank" title="' . esc_attr__('WordPress', 'whoop') . '"><span>' . __('WordPress', 'whoop') . '</span></a>';
		$default_footer_value = sprintf(__('Copyright &copy; %1$s %2$s %3$s Theme %4$s', 'whoop'),date('Y'),"<a href='$theme_url' target='_blank' title='$theme_name'>", $theme_name, "</a>");
		$default_footer_value .= sprintf(__(' - Powered by %s.', 'whoop'), $wp_link);

		echo $default_footer_value;

	}else{
		echo esc_attr( get_theme_mod( 'dt_copyright_text', DT_COPYRIGHT_TEXT ) );
	}
}

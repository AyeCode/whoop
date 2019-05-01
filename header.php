<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="ds-container">
	<?php do_action( 'dt_before_header' ); ?>
	<?php
	$enable_header_top = esc_attr( get_theme_mod( 'dt_enable_header_top', DT_ENABLE_HEADER_TOP ) );
	if ( $enable_header_top == '1' ) {
		$extra_class = 'dt-header-top-enabled';
	} else {
		$extra_class = '';
	}
	?>
	<header id="site-header" class="site-header <?php echo $extra_class; ?>" role="banner"
	        style="<?php echo dt_header_image(); ?>">

		<?php
		/**
		 * This action is called before the site logo wrapper.
		 *
		 * @since 1.0.2
		 */
		do_action( 'dt_before_site_logo' ); ?>
		<div class="container header-top">



			<?php
			get_template_part( 'template-parts/header/logo');
			get_template_part( 'template-parts/header/search');
			get_template_part( 'template-parts/menu/user');
			?>




		</div>
		<?php
		if ( has_nav_menu( 'primary-menu' ) ) {
			/**
			 * Filter the mobile navigation button html.
			 *
			 * @since 1.0.2
			 */
			echo apply_filters( 'dt_mobile_menu_button', '<div class="dt-nav-toggle  dt-mobile-nav-button-wrap"><a href="#primary-nav"><i class="fas fa-bars"></i></a></div>' );

		}
		?>
		<?php
			get_template_part( 'template-parts/menu/primary');
		?>

	</header>
<?php do_action( 'dt_after_header' ); ?>
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
<div id="ds-container" >
<?php do_action('dt_before_header'); ?>

	<?php
	$enable_header_top = esc_attr(get_theme_mod('dt_enable_header_top', DT_ENABLE_HEADER_TOP));

	$extra_class = '';

	if ($enable_header_top == '1') {
		$extra_class = 'dt-header-top-enabled';
	}
	?>
	<header id="site-header" class="site-header <?php echo $extra_class; ?>" role="banner" style="<?php echo dt_header_image(); ?>">

		<div class="container">
			<?php
			/**
			 * This action is called before the site logo wrapper.
			 *
			 * @since 1.0.0
			 */
			do_action('dt_before_site_logo');
			if( !is_front_page() ) {
				?>
				<div class="site-logo-wrap">
					<div class='site-logo <?php echo empty( get_theme_mod( 'logo', false ) ) ? 'default-logo' : ''; ?>'>
						<?php $get_logo = ! empty( get_theme_mod( 'logo', false ) ) ? get_theme_mod( 'logo', false ) : WHOOP_DEFAULT_LOGO_IMAGE; ?>
						<a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><img src='<?php echo esc_url( $get_logo ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'></a>
					</div>
				</div>
				<?php
			}
			do_action('dt_after_site_logo');
			if( is_front_page() ) {

				do_action( 'whoop_before_nav');

					if ( has_nav_menu( 'primary-menu' ) ) { ?>

						<nav id="primary-nav" class="primary-nav" role="navigation">
							<?php
							wp_nav_menu( array(
								'container'      => false,
								'theme_location' => 'primary-menu',
							) );
							?>
						</nav>
						<?php
						echo apply_filters( 'dt_mobile_menu_button', '<div class="dt-nav-toggle  dt-mobile-nav-button-wrap"><a class="menu-open" href="#primary-nav"><i class="fa fa-bars"></i></a></div>' );
						?>
					<?php }

				do_action( 'whoop_after_nav');

			}
			?>
		</div>

		<?php
		if( !is_front_page() ) {

			do_action( 'whoop_before_nav');

			if ( has_nav_menu( 'primary-menu' ) ) { ?>
				<div class="whoop-common-page-menu">
					<div class="container">
						<nav id="primary-nav" class="primary-nav" role="navigation">
							<?php
							wp_nav_menu( array(
								'container'      => false,
								'theme_location' => 'primary-menu',
							) );
							?>
						</nav>
						<?php
						echo apply_filters( 'dt_mobile_menu_button', '<div class="dt-nav-toggle  dt-mobile-nav-button-wrap"><a class="menu-open" href="#primary-nav"><i class="fa fa-bars"></i></a></div>' );
						?>
					</div>
				</div>
			<?php }

			do_action( 'whoop_after_nav');

		}
		?>

	</header>

<?php do_action('dt_after_header'); ?>
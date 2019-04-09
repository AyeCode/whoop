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

		<div class="container header-top">

			<?php
			/**
			 * This action is called before the site logo wrapper.
			 *
			 * @since 1.0.2
			 */
			do_action( 'dt_before_site_logo' ); ?>

			<div class="header-top-item site-logo-wrap">
				<?php if ( get_theme_mod( 'logo', false ) ) : ?>
					<div class='site-logo'>
						<a href='<?php echo esc_url( home_url( '/' ) ); ?>'
						   title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><img
								src='<?php echo esc_url( get_theme_mod( 'logo', false ) ); ?>'
								alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'></a>
					</div>
				<?php else : ?>
					<?php
					if ( display_header_text() ) {
						$style = ' style="color:#' . get_header_textcolor() . ';"';
					} else {
						$style = ' style="display:none;"';
					}

					if ( display_header_text() ) : ?>
						<?php
						$desc  = get_bloginfo( 'description', 'display' );
						$class = '';
						if ( ! $desc ) {
							$class = 'site-title-no-desc';
						}
						?>
						<hgroup>
							<h1 class='site-title <?php echo $class; ?>'>
								<a <?php echo $style; ?> href='<?php echo esc_url( home_url( '/' ) ); ?>'
								                         title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'
								                         rel='home'><?php bloginfo( 'name' ); ?></a>
							</h1>
							<?php
							if ( $enable_header_top != '1' ) { ?>
								<h2 class="site-description">
									<a <?php echo $style; ?> href='<?php echo esc_url( home_url( '/' ) ); ?>'
									                         title='<?php echo esc_attr( $desc ); ?>'
									                         rel='home'><?php echo $desc; ?></a>
								</h2>
							<?php } ?>
						</hgroup>
					<?php endif; ?>
				<?php endif; ?>
			</div>

			<div class="header-top-item header-search">
				<?php
				if(defined('GEODIRECTORY_VERSION')){
					$whoop_search_shortcode = "[gd_search]";
					echo do_shortcode($whoop_search_shortcode);
				}
				?>
			</div>
			<div class="header-top-item header-user">
				<?php
				echo "<a href='".wp_login_url( get_permalink() )."' class='dt-btn button whoop-button whoop-login'>".__("Log in","whoop")."</a>";
				echo "<a href='".wp_registration_url()."' class='dt-btn button whoop-button whoop-register'>".__("Sign up","whoop")."</a>";
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


		</div>

		<div class="menu-wrapper">
			<div class="container menu-container">
				<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
					<nav id="primary-nav" class="primary-nav" role="navigation">
						<?php
						wp_nav_menu( array(
							'container'      => false,
							'theme_location' => 'primary-menu',
						) );
						?>
					</nav>
				<?php } ?>
			</div>
		</div>

	</header>
<?php do_action( 'dt_after_header' ); ?>
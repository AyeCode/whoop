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

	
	<header id="site-header" class="site-header site-header-hero <?php echo $extra_class; ?>" role="banner"
	        style="<?php echo dt_header_image(); ?>">





		<div id="whoop-hero" class="whoop-hero">
			<div class="featured-area type-location">

				<div id="whoop-featured-container" class="featured-img sd-fade-in" >

					<?php
					get_template_part( 'template-parts/header/hero','image');
					get_template_part( 'template-parts/menu/home');
					get_template_part( 'template-parts/header/user');
					get_template_part( 'template-parts/header/home', 'top');
					get_template_part( 'template-parts/header/hero','credits');

					?>


				</div>
				
			</div>
		</div>

	</header>
<?php do_action( 'dt_after_header' ); ?>
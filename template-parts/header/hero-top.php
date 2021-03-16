<?php
/**
 * This action is called before the site logo wrapper.
 *
 * @since 1.0.2
 */
do_action( 'dt_before_site_logo' ); ?>
<div class="container header-top my-auto">
	<?php if ( ( is_front_page() || is_home() ) && get_theme_mod( 'logo', false ) ) { ?>
	<div class="site-logo mb-3 mt-neg5">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url( get_theme_mod( 'logo', false ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
	</div>
	<?php } else { ?>
	<?php if ( $query_id = get_queried_object() ) { ?>
		<h1 class="entry-title text-white"><?php echo get_the_title( $query_id ); ?></h1>
	<?php } } ?>
	<?php
	get_template_part( 'template-parts/header/search');
	get_template_part( 'template-parts/menu/home','middle');
	?>
</div>
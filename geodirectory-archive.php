<?php
/**
 * GD Archive Page
 */
get_header();

do_action('dt_page_before_main_content');

$dt_enable_gd_sidebar = esc_attr(get_theme_mod('dt_enable_gd_sidebar', DT_ENABLE_GD_SIDEBAR));
$dt_gd_sidebar_position = esc_attr(get_theme_mod('dt_gd_sidebar_position', DT_GD_SIDEBAR_POSITION));
$dt_gd_sidebar_position_mobile = esc_attr(get_theme_mod('dt_gd_sidebar_position_mobile', DT_GD_SIDEBAR_POSITION_MOBILE));

if ( $dt_enable_gd_sidebar ) {
	$content_class = 'col col-12 col-md-8 mt-4';
	$content_class .= $dt_gd_sidebar_position == 'right' ? ' order-md-first' : ' order-md-last';
	$content_class .= $dt_gd_sidebar_position_mobile == 'bottom' ? ' order-first' : ' order-last';
} else {
	$content_class = 'col-lg-12';
}

//get_template_part( 'template-parts/content/archive',"top" );
$map_shortcode = apply_filters( 'sd_archive_gd_map_shortcode', '[gd_map width="100%" height="100vh" maptype="ROADMAP" zoom="0" map_type="auto"]' );
?>

	<div class="container-fluid whoop-archive-content">
		<div class="row">
			<section class="<?php echo $content_class; ?>">
				<div class="content-box content-single">
					<?php if (!have_posts()) : ?>
						<div class="alert alert-warning">
							<?php _e('Sorry, no results were found.', 'whoop'); ?>
						</div>
						<?php get_search_form(); ?>
					<?php endif; ?>
					<?php
					while ( have_posts() ) : the_post();
						// Include the page content template.
						get_template_part( 'template-parts/content/directory','content' );
						// End the loop.
					endwhile;
					?>
				</div>
			</section>
			<?php if ( $dt_enable_gd_sidebar ) { ?>
			<aside class="col col-12 col-md-4 px-0">
				<div class="sidebar page-sidebar geodir-sidebar sticky-top">
					<?php echo do_shortcode( $map_shortcode );?>
				</div>
			</aside>
			<?php } ?>
		</div>
	</div>

	<div class="fullwidth-sidebar-container">
		<div class="sidebar bottom-sidebar">
			<?php dynamic_sidebar('sidebar-gd-bottom'); ?>
		</div>
	</div>

<?php do_action('dt_page_after_main_content'); ?>

<?php get_footer(); ?>
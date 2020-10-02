<?php
/**
 * GD Archive Page
 */
get_header();

do_action('dt_page_before_main_content');

$dt_blog_sidebar_position = esc_attr(get_theme_mod('dt_blog_sidebar_position', DT_BLOG_SIDEBAR_POSITION));

//get_template_part( 'template-parts/content/archive',"top" );
$map_shortcode = apply_filters( 'sd_archive_gd_map_shortcode', '[gd_map width="100%" height="100vh" maptype="ROADMAP" zoom="0" map_type="auto"]' );
?>


	<div class="container-fluid whoop-archive-content">

		<div class="row">
			<?php if ($dt_blog_sidebar_position == 'left') { ?>
				<div class="col col-12 col-md-4 px-0 ">
					<div class="sidebar page-sidebar geodir-sidebar sticky-top">
						<?php echo do_shortcode( $map_shortcode );?>
					</div>
				</div>
			<?php } ?>
			<div class="col col-12 col-md-8 mt-4">
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
			</div>
			<?php if ($dt_blog_sidebar_position == 'right') { ?>
				<div class="col col-12 col-md-4 px-0">
					<div class="sidebar page-sidebar geodir-sidebar sticky-top">
						<?php echo do_shortcode( $map_shortcode );?>
					</div>
				</div>
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
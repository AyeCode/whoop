<?php
/**
 * Template Name: GD Single New Style
 *
 * @package Whoop
 * @since 2.0.0.0
 */
get_header();

do_action('dt_page_before_main_content');

$dt_enable_gd_sidebar          = esc_attr( get_theme_mod( 'dt_enable_gd_sidebar', DT_ENABLE_GD_SIDEBAR ) );
$dt_gd_sidebar_position        = esc_attr( get_theme_mod( 'dt_gd_sidebar_position', DT_GD_SIDEBAR_POSITION ) );
$dt_gd_sidebar_position_mobile = esc_attr( get_theme_mod( 'dt_gd_sidebar_position_mobile', DT_GD_SIDEBAR_POSITION_MOBILE ) );

if ( $dt_enable_gd_sidebar ) {
	$content_class = 'col-lg-8 col-md-9';
	$content_class .= $dt_gd_sidebar_position == 'right' ? ' order-md-first' : ' order-md-last';
	$content_class .= $dt_gd_sidebar_position_mobile == 'bottom' ? ' order-first' : ' order-last';
} else {
	$content_class = 'col-lg-12';
}


?>
<div class="fullwidth-sidebar-container">
	<div class="sidebar top-sidebar">
		<?php dynamic_sidebar('sidebar-gd-top'); ?>
	</div>
</div>

<div class="fullwidth-sidebar-container">
	<div class="sidebar top-sidebar">
		<?php if(defined('GEODIRECTORY_VERSION') ){	echo do_shortcode( '[gd_post_images types="logo,comment_images,post_images" type="slider" ajax_load="1" slideshow="1" show_title="1" animation="slide" controlnav="0" limit_show="4"]' ); } ?>
	</div>
</div>

<div class="container whoop-single-main-content whoop-single-main-content-new">
	<div class="row">
		<section class="<?php echo $content_class;?>">
			<div class="content-box content-single">
				<?php if (!have_posts()) : ?>
					<div class="alert alert-warning">
						<?php _e('Sorry, no results were found.', 'whoop'); ?>
					</div>
					<?php get_search_form(); ?>
				<?php endif; ?>
				<?php
				while ( have_posts() ) : the_post();
	
					if(defined('GEODIRECTORY_VERSION') ){
						get_template_part( 'template-parts/content/single',"top-new" );
					}
	
	
				// Include the page content template.
					get_template_part( 'template-parts/content/single' );
	
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
	
					// End the loop.
				endwhile;
				?>
			</div>
		</section>
		<?php if ( $dt_enable_gd_sidebar ) { ?>
			<aside class="col-lg-4 col-md-3">
				<div class="sidebar page-sidebar geodir-sidebar geodir-sidebar-single">
					<?php dynamic_sidebar('sidebar-gd'); ?>
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
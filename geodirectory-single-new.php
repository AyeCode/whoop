<?php
/**
 * Template Name: GD Single New Style
 *
 * @package Whoop
 * @since 2.0.0.0
 */
get_header();

do_action('dt_page_before_main_content'); 

$dt_blog_sidebar_position = esc_attr(get_theme_mod('dt_blog_sidebar_position', DT_BLOG_SIDEBAR_POSITION));


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
	<?php if ($dt_blog_sidebar_position == 'left') { ?>
		<div class="col-lg-4 col-md-3">
			<div class="sidebar page-sidebar geodir-sidebar geodir-sidebar-single">
				<?php dynamic_sidebar('sidebar-gd'); ?>
			</div>
		</div>
	<?php } ?>
	<div class="col-lg-8 col-md-9">
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
	</div>
	<?php if ($dt_blog_sidebar_position == 'right') { ?>
		<div class="col-lg-4 col-md-3">
			<div class="sidebar page-sidebar geodir-sidebar geodir-sidebar-single">
				<?php dynamic_sidebar('sidebar-gd'); ?>
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
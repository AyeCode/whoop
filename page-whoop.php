<?php
/**
 * Template Name: Whoop Home
 *
 * @package Whoop
 * @since 2.0.0.0
 */

get_header('home'); 

do_action('dt_page_before_main_content'); ?>
<div class="container">
	<div class="row">
	<div class="col-lg-12">
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
				get_template_part( 'template-parts/content/home' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

				// End the loop.
			endwhile;
			?>
		</div>
	</div>
	</div>
</div>

<?php do_action('dt_page_after_main_content'); ?>

<?php get_footer(); ?>
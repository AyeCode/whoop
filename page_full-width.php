<?php
/**
 * Template Name: Full Width Page
 *
 * @package Directory_Starter_Child
 *
 * @since 1.0.0
 */

get_header(); ?>

<?php do_action( 'whoop_page_before_main_content' ); ?>

	<div class="container">

		<div class="row">

			<div class="col-lg-12">

				<div class="content-box content-page">

					<?php if (!have_posts()) : ?>

						<div class="alert alert-warning">

							<?php _e('Sorry, no results were found.', 'directory-starter'); ?>

						</div>

						<?php get_search_form(); ?>

					<?php endif; ?>

					<?php
					while ( have_posts() ) : the_post();

						get_template_part('content','page');

						if ( comments_open() || get_comments_number() ) :

							comments_template();

						endif;

					endwhile;
					?>

				</div>

			</div>

		</div>

	</div>

<?php do_action( 'whoop_page_after_main_content' ); ?>

<?php get_footer(); ?>
<?php get_header(); ?>

<?php do_action( 'whoop_page_before_main_content' ); ?>

	<div class="container">

		<?php $blog_position = esc_attr(get_theme_mod('dt_blog_sidebar_position', 'right' ) ); ?>

		<div class="row">

			<?php if( 'left' === $blog_position ) { ?>

				<div class="col-lg-4 col-md-3">

					<div class="sidebar blog-sidebar page-sidebar">

						<?php get_sidebar('pages'); ?>

					</div>

				</div>

			<?php } ?>

			<div class="col-lg-8 col-md-9">

				<div class="content-box content-page">

					<?php if (!have_posts()) { ?>

						<div class="alert alert-warning">

							<?php _e('Sorry, no results were found.', 'whoop'); ?>

						</div>

						<?php get_search_form(); ?>

					<?php } ?>

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

			<?php if( 'right' === $blog_position ) { ?>

				<div class="col-lg-4 col-md-3">

					<div class="sidebar blog-sidebar page-sidebar">

						<?php get_sidebar('pages'); ?>

					</div>
				</div>

			<?php } ?>

		</div>

	</div>

<?php do_action( 'whoop_page_after_main_content' ); ?>

<?php get_footer();
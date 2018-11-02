<?php get_header(); ?>

	<div class="container">

		<div class="content-box content-single">

			<?php if (!have_posts()) : ?>

				<div class="alert-error">
					<p><?php _e('Sorry, no results were found.', 'whoop'); ?></p>
				</div>

				<?php get_search_form(); ?>

			<?php endif; ?>

			<?php
			while (have_posts()) : the_post();

				get_template_part('content','single');

			endwhile;
			?>

		</div>

	</div>

<?php get_footer();
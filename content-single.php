<article <?php post_class(); ?>>
	<header>
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>
	<div class="entry-content entry-summary content-single">
		<?php

		if (is_singular() || (function_exists('is_bbpress') && is_bbpress())) {
			the_content();
		}
		?>
	</div>
	<footer class="entry-footer">
		<?php directory_theme_entry_meta(); ?>
		<?php edit_post_link( __( 'Edit', 'whoop' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
</article>
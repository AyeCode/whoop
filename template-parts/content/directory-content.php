<article <?php post_class('whoop-archive-listings'); ?>>
	<div class="entry-content entry-summary">
		<h1 class="entry-title h3"><?php the_title(); ?></h1>
		<?php
		if (is_singular() || (function_exists('is_bbpress') && is_bbpress())) {
			the_content();
		} else {
			directory_theme_post_thumbnail();
			the_excerpt();
		}
		?>
		<?php
		wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'whoop' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
		) );
		?>
	</div>
	<footer class="entry-footer">
		<?php directory_theme_entry_meta(); ?>
		<?php edit_post_link( __( 'Edit', 'whoop' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
</article>
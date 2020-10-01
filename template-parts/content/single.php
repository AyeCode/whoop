<article <?php post_class('content-box p-0 mb-3 '.dt_content_classes()); ?>>
	<header>
		<h1 class="entry-title pb-2 h1 text-dark font-weight-bold"><?php the_title(); ?></h1>
	</header>
	<div class="entry-content entry-summary">
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
			'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'directory-starter' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
		) );
		?>
	</div>
	<footer class="entry-footer mt-2 pt-2 text-muted">
		<?php directory_theme_entry_meta(); ?>
		<?php edit_post_link( __( 'Edit', 'directory-starter' ), '<span class="edit-link"><i class="fas fa-pencil-alt"></i> ', '</span>' ); ?>
	</footer>
</article>
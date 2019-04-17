<article <?php post_class('whoop-home-content'); ?>>
	<div class="entry-content entry-summary">
		<?php
		the_content();
		?>
	</div>
	<footer class="entry-footer">
		<?php directory_theme_entry_meta(); ?>
		<?php edit_post_link( __( 'Edit', 'whoop' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
</article>
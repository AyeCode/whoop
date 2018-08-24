<?php get_header(); ?>

	<div class="container">
		<div class="content-box content-404 whoop-404">
			<header class="page-header">
				<h1 class="page-title"><?php _e( '404 Not Found', 'directory-starter' ); ?></h1>
			</header>

			<div class="page-wrapper">
				<div class="page-content">
					<h2><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'directory-starter' ); ?></h2>
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'directory-starter' ); ?></p>
					<?php echo do_shortcode( '[gd_search]'); ?>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>
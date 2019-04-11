<div class="menu-wrapper">
	<div class="container menu-container">
		<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
			<nav id="primary-nav" class="primary-nav" role="navigation">
				<?php
				wp_nav_menu( array(
					'container'      => false,
					'theme_location' => 'primary-menu',
				) );
				?>
			</nav>
		<?php } ?>
	</div>
</div>
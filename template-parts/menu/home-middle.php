<div class="menu-wrapper">
	<div class=" menu-container">
		<?php if ( has_nav_menu( 'home_middle_menu' ) ) { ?>
			<nav class="primary-nav home_middle_menu" role="navigation">
				<?php
				wp_nav_menu( array(
					'container'      => false,
					'theme_location' => 'home_middle_menu',
				) );
				?>
			</nav>
		<?php }?>

	</div>
</div>
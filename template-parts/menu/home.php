<div class="menu-wrapper">
	<div class="container menu-container">
		<div class="header-top-item header-home-menu">

		<?php if ( has_nav_menu( 'home_menu' ) ) { ?>
			<nav id="primary-nav" class="primary-nav home_menu" role="navigation">
				<?php
				wp_nav_menu( array(
					'container'      => false,
					'theme_location' => 'home_menu',
				) );
				?>
			</nav>
		<?php }elseif ( has_nav_menu( 'primary-menu' ) ) { ?>
			<nav id="primary-nav" class="primary-nav home_menu" role="navigation">
				<?php
				wp_nav_menu( array(
					'container'      => false,
					'theme_location' => 'primary-menu',
				) );
				?>
			</nav>
		<?php }?>
		</div>
		<?php 			get_template_part( 'template-parts/menu/user'); ?>

	</div>

</div>
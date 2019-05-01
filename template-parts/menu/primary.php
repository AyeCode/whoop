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
		<?php }else{
			if(get_current_user_id()){
			?>
			<div class="alert-info">
				<p><?php _e('Add a main menu and it will show here', 'whoop'); ?></p>
			</div>
		<?php } }?>
	</div>
</div>
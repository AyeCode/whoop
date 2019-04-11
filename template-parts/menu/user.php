<?php if ( has_nav_menu( 'user_menu' ) ) { ?>
	<nav class="primary-nav user_menu" role="navigation">
		<?php
		wp_nav_menu( array(
			'container'      => false,
			'theme_location' => 'user_menu',
//			'container_class' => ' dt-btn button whoop-button whoop-login '
//			'items_wrap'      => '<ul id="%1$s" class="%2$s vvv">%3$s xxx</ul>',
		) );
		?>
	</nav>
<?php }else{
	?>
<div class="header-top-item header-user">
	<?php
	echo "<a href='".wp_login_url( get_permalink() )."' class='dt-btn button whoop-button whoop-login'>".__("Log in","whoop")."</a>";
	echo "<a href='".wp_registration_url()."' class='dt-btn button whoop-button whoop-register'>".__("Sign up","whoop")."</a>";
	?>
</div>
<?php
} ?>
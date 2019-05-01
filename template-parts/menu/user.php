<div class="header-top-item header-user">
<?php if ( has_nav_menu( 'user_menu' ) ) { ?>
	<nav id="user-account-nav" class="primary-nav user_menu" role="navigation">
		<?php
		wp_nav_menu( array(
			'container'      => false,
			'theme_location' => 'user_menu',
//			'container_class' => ' dt-btn button whoop-button whoop-login '
//			'items_wrap'      => '<ul id="%1$s" class="%2$s vvv">%3$s xxx</ul>',
		) );
		?>
	</nav>
<?php } else {

	if($user_id = get_current_user_id()){
		?>
		<nav id="user-account-nav" class="primary-nav user_menu logged-in" role="navigation">
			<ul id="menu-user" class="menu">
				<li  class="menu-item menu-item-has-children">
					<a class="dt-btn button whoop-button whoop-my-account" href="#">
						<?php
						echo get_avatar( $user_id, 32 );
						?>
						<span><?php _e( "My Account", "whoop" );?></span>
					</a>
					<ul class="sub-menu">
						<li class="gd-menu-item menu-item menu-item-logout">
							<a href="<?php echo wp_logout_url(); ?>"><?php _e( "Log out", "whoop" );?></a>
						</li>
					</ul>
				</li>
			</ul>
		</nav>
		<?php
	}else{
		?>
		<nav id="user-account-nav" class="primary-nav user_menu" role="navigation">
			<ul id="menu-user" class="menu">
				<li class="menu-item menu-item-type-custom menu-item-object-custom ">
					<a class="dt-btn button whoop-button" href="<?php echo wp_login_url( get_permalink() )  ;?>"><?php _e( "Log in", "whoop" );?></a>
				</li>
				<li class="whoop-register menu-item menu-item-type-custom menu-item-object-custom ">
					<a class="dt-btn button whoop-button" href="<?php echo wp_registration_url() ;?>"><?php _e( "Sign up", "whoop" );?></a>
				</li>
			</ul>
		</nav>
		<?php
	}

} ?>
	</div>

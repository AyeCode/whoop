<div class="header-top-item header-user">
<?php if ( has_nav_menu( 'user_menu' ) ) { ?>
	<nav id="user-account-nav" class="primary-nav user_menu  logged-in" role="navigation">
		<?php
		wp_nav_menu( array(
			'menu_id'   => 'menu-user' ,
			'container'      => false,
			'theme_location' => 'user_menu',
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
						<?php echo apply_filters("whoop_menu_account_items","");?>
						<li class="gd-menu-item menu-item menu-item-logout">
							<a href="<?php echo wp_logout_url(); ?>"><?php _e( "Log out", "whoop" );?></a>
						</li>
					</ul>
				</li>
			</ul>
		</nav>
		<?php
	}else{
		$login_class = function_exists('uwp_get_option') && uwp_get_option("login_modal",1) ? 'uwp-login-link' : '';
		$reg_class = function_exists('uwp_get_option') && uwp_get_option("register_modal",1) ? 'uwp-register-link' : '';
		?>
		<nav id="user-account-nav" class="primary-nav user_menu" role="navigation">
			<ul id="menu-user" class="menu">
				<li class="menu-item menu-item-type-custom menu-item-object-custom ">
					<a class="dt-btn button whoop-button <?php echo $login_class;?>" href="<?php echo wp_login_url( get_permalink() )  ;?>"><?php _e( "Log in", "whoop" );?></a>
				</li>
				<li class="whoop-register menu-item menu-item-type-custom menu-item-object-custom ">
					<a class="dt-btn button whoop-button <?php echo $reg_class;?>" href="<?php echo wp_registration_url() ;?>"><?php _e( "Sign up", "whoop" );?></a>
				</li>
			</ul>
		</nav>
		<?php
	}

} ?>
	</div>

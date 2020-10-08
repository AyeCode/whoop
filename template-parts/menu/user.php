<div class="header-top-item header-user ml-auto">
<?php if ( has_nav_menu( 'user_menu' ) ) { ?>
	<nav id="user-account-nav" class="primary-nav user_menu  logged-in font-weight-bold" role="navigation">
		<?php
		wp_nav_menu( array(
			'menu_id'   => 'menu-user' ,
			'container'      => false,
			'theme_location' => 'user_menu',
			'menu_class' => 'navbar-nav  text-nowrap flex-wrap'
		) );
		?>
	</nav>
<?php } else {

	if($user_id = get_current_user_id()){
		global $current_user; wp_get_current_user();
		?>
		<nav id="user-account-nav" class="primary-nav user_menu logged-in " role="navigation">
			<ul id="menu-user" class="menu nav">
				<?php echo apply_filters("whoop_menu_account_items_inline","");?>
				<li  class="menu-item menu-item-has-children nav-item">
					<a class="dt-btn button whoop-button whoop-my-account nav-link" href="#" role="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php
						echo get_avatar( $user_id, 40,'mm','', array('class'=>"comment_avatar rounded-circle border border-white border-width-2","extra_attr"=> ' data-toggle="tooltip" data-placement="bottom" title="'.esc_attr( $current_user->user_login ).'" ') );
						?>
						<span class="sr-only"><?php _e( "My Account", "whoop" );?></span>
					</a>
					<ul class="sub-menu dropdown-menu dropdown-menu-right dropdown-caret-0">
						<?php echo apply_filters("whoop_menu_account_items","");?>
						<li class="gd-menu-item menu-item menu-item-logout nav-item">
							<a href="<?php echo wp_logout_url(); ?>" class="nav-link"><?php _e( "Log out", "whoop" );?></a>
						</li>
					</ul>
				</li>
			</ul>
		</nav>
		<?php
	}else{
		$login_class = function_exists('uwp_get_option') && uwp_get_option("login_modal",1) ? 'uwp-login-link' : '';
		$reg_class = function_exists('uwp_get_option') && uwp_get_option("register_modal",1) ? 'uwp-register-link' : '';
		$reg_class = function_exists('uwp_get_option') && uwp_get_option("register_modal",1) ? 'uwp-register-link' : '';
		// to avoid login redirection issue with userWP.
		$redirect = !class_exists( 'UsersWP' ) ?  get_permalink() : '';
		?>
		<nav id="user-account-nav" class="primary-nav user_menu" role="navigation">
			<ul id="menu-user" class="menu nav">
				<li class="menu-item menu-item-type-custom menu-item-object-custom nav-item">
					<a class="dt-btn button whoop-button nav-link btn btn-outline-gray <?php echo $login_class;?>" href="<?php echo wp_login_url( $redirect )  ;?>"><?php _e( "Log in", "whoop" );?></a>
				</li>
				<li class="whoop-register menu-item menu-item-type-custom menu-item-object-custom nav-item">
					<a class="dt-btn button whoop-button nav-link btn btn-primary text-white ml-2 <?php echo $reg_class;?>" href="<?php echo wp_registration_url() ;?>"><?php _e( "Sign up", "whoop" );?></a>
				</li>
			</ul>
		</nav>
		<?php
	}

} ?>
	</div>

<?php
if( !is_user_logged_in() && !get_option( 'users_can_register' ) ){
	wp_safe_redirect( site_url());
	exit();
}
?>
<?php get_header(); ?>

<div class="container">
	<div class="whoop-author-content">

	<?php if( is_user_logged_in() ) {

		$current_user = wp_get_current_user();

		$user_data = get_userdata( $current_user->ID );
		$user_link = get_author_posts_url($current_user->ID);

		if (class_exists('BuddyPress')) {
			$user_link = bp_get_loggedin_user_link();
		}

		$profile_pic = get_avatar($current_user->ID,'250' );

		$author_name = !empty( $current_user->display_name ) ? $current_user->display_name :'';

		if( !empty( $user_data->first_name ) ) {
			$author_name = !empty( $user_data->first_name ) ? $user_data->first_name.' '.$user_data->last_name : '';
		}

		$get_gd_posttype = geodir_get_posttypes('array');
		$user_listing = geodir_user_post_listing_count( $current_user->ID );
		$reviews_count = get_user_review_count($current_user->ID);

		$fav_list_count = whoop_user_favourite($current_user->ID,'count');

		?>

		<?php do_action( 'whoop_before_author_content'); ?>
        <div class="profile-wrap">
            <div class="author-Profile-picture">
                <?php echo $profile_pic; ?>
            </div>
            <div class="author-Profile-info">
                <h4 class="author-title"><?php echo esc_attr($author_name); ?></h4>
                <p class="author-email"><?php echo !empty( $user_data->user_email ) ? esc_attr($user_data->user_email) :''; ?></p>
                <div class="gd-author-listing">
                    <ul>
                        <?php do_action( 'whoop_before_author_listing_links'); ?>
                        <?php if( !empty( $user_listing ) && is_array( $user_listing)) {

                            foreach ( $user_listing as $list_key => $list_values ) {

                                $temp_post_arr = !empty( $get_gd_posttype ) ? $get_gd_posttype[$list_key] :'';
                                $get_menu_icon = get_post_menu_icon( $list_key );

                                ?>
                                <li>
                                    <a href="<?php echo $user_link.'?gd_dashboard=true&style='.$list_key ?>"><p class="listing-count"><?php echo $list_values; ?></p><span class="list-icon"><i class="<?php echo $get_menu_icon; ?>"></i></span> <?php echo $temp_post_arr['labels']['name'] ; ?></a>
                                </li>
                                <?php
                            }

                        } ?>
                        <li><a href="<?php echo $user_link.'?gd_dashboard=true&style=reviews'; ?>"><p class="Review-count"><?php echo $reviews_count; ?></p><span class="list-icon"><i class="fa fa-star"></i></span> Reviews</a></li>
                        <li><a href="<?php echo $user_link.'?gd_dashboard=true&style=favourite'; ?>"><p class="favorites-count"><?php echo $fav_list_count; ?></p><span class="list-icon"><i class="fa fa-bookmark"></i></span> Favourites</a></li>
                        <?php do_action( 'whoop_after_author_listing_links'); ?>
                    </ul>
                </div>
                <p class="author-bio"><?php echo !empty( $user_data->description ) ? esc_attr($user_data->description) :''; ?></p>
            </div>
        </div>
		<?php
		if( !empty( $_GET['gd_dashboard'] ) && 'true' === $_GET['gd_dashboard'] ) {
			?>
			<div class="author-listing">
			<?php
			if( !empty( $_GET['style'] ) && 'reviews'=== $_GET['style'] ) {

				do_action( 'whoop_before_user_review_content');

				whoop_user_review( $current_user->ID );

				do_action( 'whoop_after_user_review_content');

			} elseif ( !empty( $_GET['style'] ) && 'favourite'=== $_GET['style'] ){

				do_action( 'whoop_before_user_favourite_content');

				whoop_user_favourite($current_user->ID ,'html');

				do_action( 'whoop_after_user_favourite_content');

			} else{

				do_action( 'whoop_before_user_listing_content');

				whoop_user_listing( $current_user->ID );

				do_action( 'whoop_after_user_listing_content');
			}
			?></div><?php
		}
		?>

		<?php do_action( 'whoop_after_author_content'); ?>

	<?php } else {

		if ( get_option( 'users_can_register' ) ) { ?>

			<div class="not-logged-in-author">
				<?php $site_title = get_bloginfo( '', 'display' ); ?>
				<h2><?php echo __('Currently user not login in '.$site_title,'whoop'); ?></h2>
				<p><?php echo __('Please login in '.$site_title.' and then access user page.','whoop'); ?></p>
				<ul class="menu">
					<li class="nav-login">
						<a href="<?php echo apply_filters('whoop_login_url', wp_login_url() ); ?>"><?php echo apply_filters('whoop_login_text', __('Log in','whoop'));  ?></a>
					</li>
					<li class="nav-signup">
						<a href="<?php echo apply_filters('whoop_register_url', wp_login_url().'?action=register' ); ?>"><?php echo apply_filters('whoop_register_text', __('Sign up','whoop'));  ?></a>
					</li>
				</ul>
			</div>

		<?php } ?>

	<?php } ?>
	</div>
</div>
<?php get_footer(); ?>

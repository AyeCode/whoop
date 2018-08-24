<?php get_header(); ?>

<?php
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
?>
<div class="container">
	<div class="whoop-author-content">
		<?php do_action( 'whoop_before_author_content'); ?>
		<div class="author-Profile-picture">
			<?php echo $profile_pic; ?>
		</div>
		<div class="author-Profile-info">
			<h4 class="author-title"><?php echo esc_attr($author_name); ?></h4>
			<p class="author-email"><?php echo !empty( $user_data->user_email ) ? esc_attr($user_data->user_email) :''; ?></p>
			<div class="gd-author-listing">
				<ul>
					<?php if( !empty( $user_listing ) && is_array( $user_listing)) {

						foreach ( $user_listing as $list_key => $list_values ) {

							$temp_post_arr = !empty( $get_gd_posttype ) ? $get_gd_posttype[$list_key] :'';
							?>
							<li>
								<p class="listing-count"><?php echo $list_values; ?></p>
								<a href="<?php echo $user_link.'?gd_dashboard=true&style='.$list_key ?>"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $temp_post_arr['labels']['name'] ; ?></a>
							</li>
							<?php

						}

					} ?>
					<li><p class="Review-count"><?php echo $reviews_count; ?></p><a href="<?php echo $user_link.'?gd_dashboard=true&style=reviews'; ?>"><i class="fa fa-star"></i> Reviews</a></li>
				</ul>
			</div>
			<p class="author-bio"><?php echo !empty( $user_data->description ) ? esc_attr($user_data->description) :''; ?></p>
		</div>
		<div class="author-listing">
			<?php
			if( !empty( $_GET['gd_dashboard'] ) && 'true' === $_GET['gd_dashboard'] ) {

				if( !empty( $_GET['style'] ) && 'reviews'=== $_GET['style'] ) {

					whoop_user_review( $current_user->ID );

				} else{

					whoop_user_listing( $current_user->ID );
				}

			}
			?>
		</div>
		<?php do_action( 'whoop_after_author_content'); ?>
	</div>
</div>
<?php get_footer(); ?>

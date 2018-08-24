<?php
function whoop_header_nav() {
	?>
	<div class="whoop-header-nav">
		<ul class="menu">
			<?php if( is_user_logged_in() ) {
				$avatar = get_avatar(get_current_user_id(), 40);
				?>
				<li class="nav-account">
					<a href="javascript:void(0);" class="whoop-account-link"><?php echo $avatar; ?><span><i class="fa fa-caret-down"></i></span></a>
					<?php whoop_current_user_account();?>
				</li>

			<?php } else { ?>

				<?php if( is_front_page()) { ?>
					<li class="nav-login">
						<a href="<?php echo apply_filters('whoop_login_url', wp_login_url() ); ?>"><?php echo apply_filters('whoop_login_text', __('Log in','whoop'));  ?></a>
					</li>
				<?php }  ?>
					<li class="nav-signup">
						<a href="<?php echo apply_filters('whoop_register_url', wp_login_url().'?action=register' ); ?>"><?php echo apply_filters('whoop_register_text', __('Sign up','whoop'));  ?></a>
					</li>
			<?php } ?>

		</ul>
	</div>
	<?php
}

function whoop_current_user_account() {

	$current_user = wp_get_current_user();

	$avatar = get_avatar($current_user->ID, 50);

	$user_link = get_author_posts_url($current_user->ID);

	if (class_exists('BuddyPress')) {

		$user_link = bp_get_loggedin_user_link();

	}

	$author_name = !empty( $current_user->display_name ) ? $current_user->display_name :'';

	$current_user_data = get_userdata( $current_user->ID );

	if( !empty( $current_user_data->first_name ) ) {

		$author_name = !empty( $current_user_data->first_name ) ? $current_user_data->first_name.' '.$current_user_data->last_name : '';

	}
	?>
	<div id="whoop_user_account_panel" class="account-panel">
		<div class="whoop-avatar-wrap">
			<a href="<?php echo esc_url($user_link); ?>" rel="nofollow"><?php echo $avatar; ?></a>
		</div>
		<h4><a href="<?php echo esc_url($user_link); ?>" rel="nofollow"><?php echo esc_attr($author_name); ?></a></h4>
		<p class="user-review-count"><i class="fa fa-star"></i> <?php echo get_user_review_count( $current_user->ID ); ?></p>
		<?php if (class_exists('BuddyPress')) { ?>
			<ul class="menu buddypress-menu">
				<li>
					<a href="<?php echo esc_url($user_link); ?>"><i class="fa fa-user"></i> <?php echo __('About Me', 'whoop'); ?></a>
				</li>
				<li>
					<a href="<?php echo esc_url($user_link.'settings/'); ?>"><i class="fa fa-cog"></i> <?php echo __('Account Settings', 'whoop'); ?></a>
				</li>
			</ul>
		<?php } ?>
		<ul class="menu">
			<li class="nav-logout">
				<a href="<?php echo apply_filters('gd_sd_child_logout_url',wp_logout_url(site_url())); ?>"><i class="fa fa-sign-out"></i> <?php echo apply_filters('gd_sd_child_logout_text', __('Log Out','whoop'));  ?></a>
			</li>
		</ul>

	</div>
	<?php

}

function get_user_review_count( $user_id ) {

	global $wpdb;

	$results = $wpdb->get_var(
		$wpdb->prepare(
			"SELECT COUNT(comment_id) FROM " . GEODIR_REVIEW_TABLE . " WHERE user_id = %d AND rating > 0",
			array($user_id)
		)
	);

	return !empty( $results ) ? $results : 0;

}

if( !function_exists( 'gd_popular_categories_fn' ) ) {

	function gd_popular_categories_fn() {

		ob_start();

		$gd_place_terms = get_terms( array(
			'taxonomy' => 'gd_placecategory',
			'hide_empty' => false,
		) );
		?>
		<div class="popular-category">
			<ul class="cat-menu">
				<?php
				if( !empty( $gd_place_terms ) && count( $gd_place_terms ) > 0 ) {

					foreach ( $gd_place_terms as $term_key => $term_value ) {

						if( $term_value->count > 0 ) {
							$cat_icon = geodir_get_term_icon( $term_value->term_id );

							?>
							<li>
								<a href="<?php echo esc_url( get_term_link( $term_value->term_id ) ); ?>"><img src="<?php echo $cat_icon; ?>" alt="<?php echo $term_value->slug; ?>"><?php echo __( $term_value->name, 'directory-starter-child' ) ?></a>
							</li>
							<?php
						}
					}
				}
				?>
			</ul>
		</div>
		<?php

		echo ob_get_clean();

	}

}
add_shortcode( 'gd_popular_categories', 'gd_popular_categories_fn');

function whoop_user_review( $user_id ) {

	global $wpdb;

	$review_results = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . GEODIR_REVIEW_TABLE . " WHERE user_id = %d AND rating > 0 ORDER BY `comment_id` DESC",array($user_id)));

	?>
	<div class="whoop-user-reviews">
		<ul>
			<?php
			if( !empty( $review_results ) && count( $review_results ) > 0 ) {

				foreach ( $review_results as $review_key => $review_value ) {

					$post_thumbnail = get_the_post_thumbnail($review_value->post_id,array(50,50));

					$post_class ='post-image';
					if( empty( $post_thumbnail ) ) {
						$post_thumbnail = '<img style="width:50px;height:50px;" src="'.WHOOP_PLACEHOLDER_IMAGE.'" >';
						$post_class ='post-placeholder-img';
					}

					$comment_id = $review_value->comment_id;
					$get_comment = get_comment( $comment_id );

					$comment_url = get_comment_link( $comment_id );

					$comment_date = mysql2date('U', $get_comment->comment_date, true);
					$comment_time = !empty( $comment_date ) ? human_time_diff( $comment_date) :'';

					$user_link = get_author_posts_url($user_id);

					$ratings_display = GeoDir_Comments::rating_html($review_value->rating, 'output');
					?>
					<li class="<?php echo ( $review_key % 2 == 0 ) ? 'even' : 'odd'; ?>">
						<div class="user-pic"><a class="<?php echo $post_class; ?>" href="<?php echo $user_link; ?>"><?php echo $post_thumbnail; ?></a></div>
						<div class="comment-stars"><?php echo $ratings_display; ?></div>
						<div class="review-post"><a  href="<?php echo get_the_permalink($review_value->post_id); ?>"><?php echo get_the_title($review_value->post_id); ?></a></div>
						<div class="review-comment"><p><?php echo $get_comment->comment_content; ?></p></div>
						<div class="review-time"><a href="<?php echo $comment_url; ?>"><?php echo !empty( $comment_time ) ? $comment_time.' ago' :''; ?></a></div>
					</li>
					<?php
				}

			} else{
				?>
				<li><p class="error">No reviews found...</p></li>
				<?php
			}
			?>
		</ul>
	</div>
	<?php

}

function whoop_user_listing( $user_id ) {

	global $wpdb;

	$posttyps = !empty( $_GET['style'] ) ? $_GET['style'] : 'gd_place';
	?>
	<div class="whoop-user-listing">
		<div class="whoopsearch-listing">
			<?php echo do_shortcode( '[gd_search]'); ?>
		</div>
		<div class="whoop-list-view-select">
			<select name="gd_list_view" id="gd_list_view" class="geodir-select" style="min-width: 130px;border-radius: 4px;">
				<option value="1">View: List</option>
				<option value="2">View: Grid 2</option>
				<option value="3">View: Grid 3</option>
				<option value="4">View: Grid 4</option>
				<option value="5">View: Grid 5</option>
			</select>
		</div>
		<div class="geodir-loop-container">

			<ul class="geodir-category-list-view list-view">
				<?php
				$listing_args = array(
					'posts_per_page'   => -1,
					'orderby'          => 'date',
					'order'            => 'DESC',
					'post_type'        => $posttyps,
					'author'	   => $user_id,
					'suppress_filters' => true,
				);

				$listing_array = get_posts( $listing_args );

				if( !empty( $listing_array ) && count( $listing_array ) > 0 ) {

					foreach ( $listing_array as $listing_key => $listing_value ) {

						$post_thumbnail = get_the_post_thumbnail($listing_value->ID,'medium');
						$post_thumbnail = !empty( $post_thumbnail ) ? $post_thumbnail : '<img src="'.WHOOP_PLACEHOLDER_IMAGE.'" alt="placeholder">' ;

						$review_results = $results = $wpdb->get_results($wpdb->prepare("SELECT COUNT(`comment_id`) AS `Total_review` ,SUM(`rating`) AS `Total_rating`  FROM `".GEODIR_REVIEW_TABLE."` WHERE `post_id` = %d AND `user_id` = %d AND `rating` > 0 ORDER BY `comment_id`  DESC",$listing_value->ID,$user_id));

						$get_review_count = !empty( $review_results[0]->Total_review ) ? $review_results[0]->Total_review: 0;
						$get_review_rating = !empty( $review_results[0]->Total_rating ) ? $review_results[0]->Total_rating : 0;

						$percentage_count = ( $get_review_rating > 0 ) ? $get_review_rating / $get_review_count : 0;

						$ratings_display = GeoDir_Comments::rating_html($percentage_count, 'output');

						$post_date = mysql2date('U', $listing_value->post_date, true);
						$post_date_time = !empty( $post_date ) ? human_time_diff( $post_date) :'';

						$taxonomy = geodir_get_taxonomies( $posttyps );
						$get_taxonomy = get_the_terms($listing_value->ID,$taxonomy[0]);

						$temp_arr = array();

						if( !empty( $get_taxonomy ) && is_array( $get_taxonomy ) ) {

							foreach ( $get_taxonomy as $taxonomy_key => $taxonomy_value ) {
								$term_url = get_term_link($taxonomy_value->term_id);
								$temp_arr[]= "<a href='$term_url'>$taxonomy_value->name</a>";
							}

						}
						$categories = !empty( $temp_arr ) ? implode( ' | ', $temp_arr) :'';

						$post_content = $listing_value->post_content;

						if( strlen ( $listing_value->post_content ) > 200 ) {

							$post_content = substr($listing_value->post_content, 0, 200).'...';

						}

						?>
						<li id="post-<?php echo $listing_value->ID; ?>" <?php post_class('',$listing_value->ID); ?> >
							<div class="whoop-post-left">
								<div class="whoop-post-img"><?php echo $post_thumbnail; ?></div>
							</div>
							<div class="whoop-post-right">
								<div class="post-title"><a href="<?php echo get_the_permalink($listing_value->ID); ?>"><?php echo $listing_value->post_title; ?></a></div>
								<div class="review-html"><?php echo $ratings_display; ?></div>
								<div class="review-count"><?php echo ( $get_review_count > 0 ) ? $get_review_count.' reviews' : 'No reviews'; ?></div>
								<div class="post-content"><?php echo $post_content; ?></div>
								<div class="post-date"><?php echo $post_date_time.' ago'; ?></div>
								<div class="post-status"><i class="fa fa-play"></i> <span>Status: </span> <?php echo $listing_value->post_status; ?></div>
								<div class="post-categories"><i class="fa fa-tags "></i>  <?php echo $categories; ?></div>
							</div>
						</li>
						<?php
					}
				}
				?>
			</ul>

		</div>
	</div>
	<?php

}
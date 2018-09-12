<?php

// Define Whoop theme placeholder image.
if( !defined('WHOOP_LISTING_PER_PAGE') ) {
	define( 'WHOOP_LISTING_PER_PAGE', 10);
}

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

			<?php } else {

				if ( get_option( 'users_can_register' ) ) {
					?>
					<li class="nav-login">
						<a href="<?php echo apply_filters( 'whoop_login_url', wp_login_url() ); ?>"><?php echo apply_filters( 'whoop_login_text', __( 'Log in', 'whoop' ) ); ?></a>
					</li>
					<li class="nav-signup">
						<a href="<?php echo apply_filters( 'whoop_register_url', wp_login_url() . '?action=register' ); ?>"><?php echo apply_filters( 'whoop_register_text', __( 'Sign up', 'whoop' ) ); ?></a>
					</li>
				<?php }

			}?>

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

    $user_role = !empty( $current_user_data->roles ) ? $current_user_data->roles :'';

	?>
	<div id="whoop_user_account_panel" class="account-panel">
		<div class="inner-account-panel">
			<div class="whoop-avatar-wrap">
				<a href="<?php echo esc_url($user_link); ?>" rel="nofollow"><?php echo $avatar; ?></a>
			</div>
			<h4><a href="<?php echo esc_url($user_link); ?>" rel="nofollow"><?php echo esc_attr($author_name); ?></a></h4>
            <h5 class="user-role">( <?php echo __( $user_role[0],'whoop' );?> )</h5>
			<div class="user-counts">
				<p class="user-review-count"><span class="list-icon"><i class="fa fa-star"></i></span> <?php echo get_user_review_count( $current_user->ID ); ?></p>
				<p class="user-fav-count"><span class="list-icon"><i class="fa fa-bookmark"></i></span> <?php echo whoop_user_favourite($current_user->ID,'count'); ?></p>
			</div>
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
			<ul class="menu nav-menu">
                <li class="user-dashboard">
                    <a href="<?php echo get_dashboard_url(); ?>"><span class="list-icon"><i class="fa fa-dashboard"></i></span><?php echo __( 'Dashboard','whoop' ); ?></a>
                </li>
				<li class="nav-logout">
					<a href="<?php echo apply_filters('gd_sd_child_logout_url',wp_logout_url(site_url())); ?>"><span class="list-icon"><i class="fa fa-sign-out"></i></span> <?php echo apply_filters('gd_sd_child_logout_text', __('Log Out','whoop'));  ?></a>
				</li>
			</ul>
		</div>
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
							$cat_icon = geodir_get_term_icon( $term_value->term_id ,true);

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

	$offset = !empty( $_GET['page'] ) ? $_GET['page'] - 1 : 0;

	$review_results = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . GEODIR_REVIEW_TABLE . " WHERE user_id = %d AND rating > 0 ORDER BY `comment_id` DESC LIMIT %d OFFSET %d",$user_id,WHOOP_LISTING_PER_PAGE,$offset));

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

					$ratings_display = GeoDir_Comments::rating_html($review_value->rating, 'output');

					$review_content = $get_comment->comment_content;

					if( strlen ( $get_comment->comment_content ) > 150 ) {

						$review_content = substr($get_comment->comment_content, 0, 150).'...';

					}

					?>
					<li class="<?php echo ( $review_key % 2 == 0 ) ? 'even' : 'odd'; ?>">
						<div class="user-pic"><a class="<?php echo $post_class; ?>" href="<?php echo get_the_permalink($review_value->post_id); ?>"><?php echo $post_thumbnail; ?></a></div>
						<div class="comment-stars"><?php echo $ratings_display; ?></div>
						<div class="review-post"><a  href="<?php echo get_the_permalink($review_value->post_id); ?>"><?php echo get_the_title($review_value->post_id); ?></a></div>
						<div class="review-comment"><p><?php echo $review_content; ?></p></div>
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
	$rating_counts = $wpdb->get_results($wpdb->prepare( "SELECT count(`comment_id`) AS COUNT FROM ".GEODIR_REVIEW_TABLE." WHERE `user_id` = %d AND rating > 0 ORDER BY `comment_id` DESC", $user_id));

	$total_counts = !empty( $rating_counts[0]->COUNT ) ? $rating_counts[0]->COUNT : 0;

	whoop_listing_pagination($total_counts); ?>
	<?php

}

function whoop_user_listing( $user_id ) {

	global $wpdb;

	$posttyps = !empty( $_GET['style'] ) ? $_GET['style'] : 'gd_place';
	$paged = !empty( $_GET['page'] ) ? $_GET['page'] : '1';

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
					'posts_per_page'   => WHOOP_LISTING_PER_PAGE,
					'orderby'          => 'date',
					'order'            => 'DESC',
					'post_type'        => $posttyps,
					'author'	   => $user_id,
					'suppress_filters' => true,
					'paged' =>$paged,
				);

				$listing_array = new WP_Query( $listing_args );

				if( !empty( $listing_array->posts ) && count( $listing_array->posts ) > 0 ) {

					foreach ( $listing_array->posts as $listing_key => $listing_value ) {

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

						$custom_fields = GeoDir_Settings_Cpt_Cf::get_cpt_custom_fields( $posttyps );

                        $business_hours ='';
                        $get_bz_cf = get_business_hours_cf($custom_fields);

						if( !empty( $get_bz_cf ) && '' != $get_bz_cf) {
                            $business_hours = geodir_cf_business_hours( '','',$get_bz_cf,$listing_value->ID,'' );
                        }

                        $event_date_time = get_event_date( $listing_value->ID );

						?>
						<li id="post-<?php echo $listing_value->ID; ?>" <?php post_class('',$listing_value->ID); ?> >
							<div class="whoop-post-left">
								<div class="whoop-post-img"><?php echo $post_thumbnail; ?></div>
							</div>
							<div class="whoop-post-right">
								<div class="post-title"><a href="<?php echo get_the_permalink($listing_value->ID); ?>"><?php echo $listing_value->post_title; ?></a></div>
								<div class="post-categories"><i class="fa fa-tags "></i>  <?php echo $categories; ?></div>
								<div class="review-html"><?php echo $ratings_display; ?></div>
								<div class="review-count"><?php echo ( $get_review_count > 0 ) ? $get_review_count.' reviews' : 'No reviews'; ?></div>
								<div class="post-favorite-list"><span class="gd-list-favorite"><?php geodir_favourite_html( '', $listing_value->ID ); ?></span></div>
								<div class="post-business-hour"><?php echo $business_hours; ?></div>
								<div class="event-date-time"><?php echo !empty( $event_date_time ) ? '<span class="event-cal-icon"><i class="fas fa-calendar-alt" aria-hidden="true"></i></span>'.$event_date_time :''; ?></div>
								<div class="post-date"><?php echo $post_date_time.' ago'; ?></div>
								<div class="post-status"><i class="fa fa-play"></i> <span>Status: </span> <?php echo $listing_value->post_status; ?></div>
								<div class="post-content"><?php echo strip_tags($post_content); ?></div>
							</div>
						</li>
						<?php
					}
				}
				?>
			</ul>
		</div>
		<?php
		$total_found_post = !empty( $listing_array->found_posts )  ? $listing_array->found_posts : 0;
		whoop_listing_pagination($total_found_post);
		?>

	</div>
	<?php
}

function get_business_hours_cf( $cf_array ) {

	if( empty( $cf_array ) ){
		return false;
	}

	$bz_hr_cf = '';
	foreach ( $cf_array as $cf_key => $cf_value ) {

		if( !empty( $cf_value->field_type ) && 'business_hours' === $cf_value->field_type ) {
			$bz_hr_cf = (array) $cf_value;
		}

	}

	return $bz_hr_cf;

}

function whoop_user_favourite($user_id, $response = 'html'){

	$site_id = '';
	if ( is_multisite() ) {
		$blog_id = get_current_blog_id();
		if ( $blog_id && $blog_id != '1' ) {
			$site_id = '_' . $blog_id;
		}
	}

	$get_fav_listing = get_user_meta( $user_id,'gd_user_favourite_post'.$site_id,true);
    $get_fav_listing = !empty( $get_fav_listing ) ? array_reverse($get_fav_listing) : array();

	$get_page = !empty( $_GET['page'] ) ? (int)$_GET['page'] : 0;

	$offset = 0;
	$length = WHOOP_LISTING_PER_PAGE;

	if( !empty( $get_page ) && $get_page > 1 ) {
		$offset = $length * ( $get_page-1 );
	}

	$fav_listing_arr = !empty( $get_fav_listing ) ? array_slice($get_fav_listing, $offset, $length, true) : array();

	if( 'html' === $response ) {

		?>
		<div class="whoop-user-favourite">
			<ul>
			<?php
			if( !empty( $fav_listing_arr ) && is_array( $fav_listing_arr ) ) {

				foreach ( $fav_listing_arr as $fav_key => $fav_list ) {

					$post_date = get_the_date('',$fav_list);
					$post_date = mysql2date('U', $post_date, true);
					$post_date_time = !empty( $post_date ) ? human_time_diff( $post_date) :'';

					$get_posttype = get_post_type($fav_list);

					$taxonomy = geodir_get_taxonomies( $get_posttype );
					$get_taxonomy = get_the_terms($fav_list,$taxonomy[0]);

					$temp_arr = array();

					if( !empty( $get_taxonomy ) && is_array( $get_taxonomy ) ) {

						foreach ( $get_taxonomy as $taxonomy_key => $taxonomy_value ) {
							$term_url = get_term_link($taxonomy_value->term_id);
							$temp_arr[]= "<a href='$term_url'>$taxonomy_value->name</a>";
						}

					}
					$categories = !empty( $temp_arr ) ? implode( ' | ', $temp_arr) :'';


                    $post_images = geodir_get_images($fav_list, 1,true);

                    $post_thumbnail ='';

                    foreach($post_images as $image) {
                        $post_thumbnail = geodir_get_image_tag($image);
                    }

                    $post_class ='post-image';
                    if( empty( $post_thumbnail ) ) {
                        $post_thumbnail = '<img style="width:50px;height:50px;" src="'.WHOOP_PLACEHOLDER_IMAGE.'" >';
                        $post_class ='post-placeholder-img';
                    }
                    ?>
					<li class="<?php echo ( $fav_key % 2 == 0 ) ? 'even' :'odd'; ?>">
						<div class="post-thumb"><?php ?><a class="<?php echo $post_class; ?>" href="<?php echo get_the_permalink($fav_list); ?>"><?php echo $post_thumbnail; ?></a></div>
						<div class="post-title"><a href="<?php echo get_the_permalink($fav_list); ?>"><?php echo get_the_title($fav_list); ?></a></div>
						<div class="post-category"><i class="fa fa-tags "></i> <?php echo $categories; ?></div>
						<div class="post-time"><?php echo $post_date_time.' ago';; ?></div>
						<div class="post-fav"><?php geodir_favourite_html( $user_id, $fav_list ); ?></div>
					</li>
					<?php
				}

			}
			?>
			</ul>
		</div>
		<?php

		$total_fav_count= !empty( $get_fav_listing ) ? count( $get_fav_listing ) : 0;

		whoop_listing_pagination($total_fav_count);
	} else{

		return !empty( $get_fav_listing ) ? count( $get_fav_listing ) : 0;

	}
}

function whoop_listing_pagination( $total_record ) {

	$list_page = !empty( $total_record ) ? ceil( $total_record / WHOOP_LISTING_PER_PAGE ) : 0;

	$user_link = get_author_posts_url(get_current_user_id());

	$current_style =!empty( $_GET['style'] ) ? $_GET['style'] :'gd_place';

	$current_page =!empty( $_GET['page'] ) ? $_GET['page'] : 1;

	$pagination_link = $user_link.'?gd_dashboard=true&style='.$current_style.'&page=';

	$prev_page = ( $current_page > 1 )  ? $current_page - 1 :'';
	$next_page = ( $current_page < $list_page )  ? $current_page + 1 :'';

	$prev_link = $user_link.'?gd_dashboard=true&style='.$current_style.'&page='.$prev_page;
	$next_link = $user_link.'?gd_dashboard=true&style='.$current_style.'&page='.$next_page;

	if( !empty( $list_page ) && $list_page > 1 ) {
		?>
		<div class="whoop-pagination">
			<ul class="author-paginate">
				<?php if( $current_page > 1 ) { ?>
				<li class="prev-page"><a href="<?php echo $prev_link; ?>"><i class="fa fa-long-arrow-left"></i></a></li>
				<?php } ?>

				<?php
				for ( $i=1; $i<=$list_page;$i++ ) {
					?>
					<li class="list-page <?php echo ( $current_page == $i ) ? 'active' :''; ?> "><a href="<?php echo $pagination_link.$i; ?>"><?php echo $i; ?></a></li>
					<?php
				}
				?>

				<?php if( $current_page < $list_page ) { ?>
				<li class="prev-page"><a href="<?php echo $next_link; ?>"><i class="fa fa-long-arrow-right"></i></a></li>
				<?php } ?>
			</ul>
		</div>
		<?php
	}

}

function get_post_menu_icon( $posttype ) {

    $menu_icon = '';

    $single_template = geodir_get_option('post_types');

    $post_arr = !empty( $single_template[$posttype] )? $single_template[$posttype] : array();

    $menu_icon = !empty( $post_arr['menu_icon'] ) ? $post_arr['menu_icon'] :'';

    $menu_icon = 'dashicons-before '.$menu_icon;

    return $menu_icon;
}

function get_event_date( $event_id ) {

    $schedule = array();

    if ( ( $schedules = GeoDir_Event_Schedules::get_schedules( $event_id, 'upcoming', 1 ) ) ) {
        $schedule		= $schedules[0];
    } elseif ( ( $schedules = GeoDir_Event_Schedules::get_schedules( $event_id, '', 1 ) ) ) {
        $schedule		= $schedules[0];
    }

    return GeoDir_Event_Schedules::get_schedules_html( array( (object)$schedule ), false );

}
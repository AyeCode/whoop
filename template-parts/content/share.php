<span class="whoop-top-share-wrap lity-show lity-hide">
	<div class="lity-title">
		<h3><?php _e("Share Business","whoop");?></h3>
	</div>
	<div class="whoop-shares">
		<?php
		global $gd_post;
		$title = esc_attr(get_the_title($gd_post->ID));
		$link = get_permalink($gd_post->ID);

		// facebook
		$params = array();
		$params['badge'] = __("Share on Facebook","whoop");
		$params['icon_class'] = "fab fa-facebook";
		$params['link'] = "https://www.facebook.com/sharer.php?u=$link&t=$title";
		$params['size'] = "large";
		$params['new_window'] = "true";
		echo  geodir_get_post_badge( $post->ID, $params );

		// twitter
		$params = array();
		$params['badge'] = __("Share on Twitter","whoop");
		$params['icon_class'] = "fab fa-twitter";
		$params['link'] = "https://twitter.com/share?text=$title&url=$link";
		$params['size'] = "large";
		$params['new_window'] = "true";
		$params['bg_color'] = "#50abf1";
		echo  geodir_get_post_badge( $post->ID, $params );

		// email
		$params = array();
		$email_subject = __("I thought you might like:","whoop");
		$params['badge'] = __("Share via Email","whoop");
		$params['icon_class'] = "far fa-envelope";
		$params['link'] = "mailto:?subject=$email_subject "."$title&body=$link";
		$params['size'] = "large";
		$params['new_window'] = "true";
		$params['bg_color'] = "#a7a7a7";
		echo  geodir_get_post_badge( $post->ID, $params );
		?>
	</div>
</span>
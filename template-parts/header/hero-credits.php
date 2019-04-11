<?php
//echo '################################################';
$post_id = 205;
$link = get_permalink($post_id);
$link = "http://citygourmetnyc.com/";
$post_name = "City Gourmet Cafe";
$user_name = "Dan Gold";
$user_link = "<a href='https://www.danielcgold.com/' target='_blank' rel=\"nofollow\">$user_name</a>";
?>
<div class="container header-credits">
	<p><a href="<?php echo $link; ?>" rel="nofollow"><?php echo esc_attr( $post_name );?></a></p>
	<p><?php echo sprintf(__("Photo by %s","whoop"),$user_link ) ?></p>
</div>

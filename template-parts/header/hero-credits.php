<?php
//echo '################################################';
global $whoop_default_image;
if($whoop_default_image){
$post_id = 205;
$link = get_permalink($post_id);
$link = "http://citygourmetnyc.com/";
$post_name = "City Gourmet Cafe";
$user_name = "Dan Gold";
$user_link = "<a href='https://www.danielcgold.com/' target='_blank' rel=\"nofollow\">$user_name</a>";
?>
<div class="container header-credits">
	<p><?php echo esc_attr( $post_name );?></p>
	<p><?php echo sprintf(__("Photo by %s","whoop"),$user_link ) ?></p>
</div>
<?php
}


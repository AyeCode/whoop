<?php
global $post;
$post_id = isset($post->ID) ? $post->ID : '';
$image =  get_the_post_thumbnail( $post_id, 'full', array( 'class' => 'whoop-hero-image ' ) );

if($image ){
	echo str_replace("<img","<img onload='jQuery(this).addClass(\"whoop-fade-in\")'",$image );
}
?>
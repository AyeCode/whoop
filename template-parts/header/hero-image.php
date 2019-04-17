<?php
global $post,$whoop_default_image;
$whoop_default_image = false;
$post_id = isset($post->ID) ? $post->ID : '';
$image =  get_the_post_thumbnail( $post_id, 'full', array( 'class' => 'whoop-hero-image ' ) );

if(!$image){
	$whoop_default_image = true;
	$image = '<img width="1600" height="1066" src="'.get_stylesheet_directory_uri().'/assets/images/whoop-splash.jpg" class="whoop-hero-image  wp-post-image " alt="" srcset="'.get_stylesheet_directory_uri().'/assets/images/whoop-splash.jpg 1600w, '.get_stylesheet_directory_uri().'/assets/images/whoop-splash-300x200.jpg 300w, '.get_stylesheet_directory_uri().'/assets/images/whoop-splash-768x512.jpg 768w, '.get_stylesheet_directory_uri().'/assets/images/whoop-splash-1024x682.jpg 1024w" sizes="(max-width: 1600px) 100vw, 1600px">';
}

if($image ){
	echo str_replace("<img","<img onload='jQuery(this).addClass(\"whoop-fade-in\")'",$image );
}
?>
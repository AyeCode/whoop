<?php
/**
 * This action is called before the site logo wrapper.
 *
 * @since 1.0.2
 */
do_action( 'dt_before_site_logo' ); ?>
<div class="container header-top my-auto">
	<?php if ( $query_id = get_queried_object() ) { ?>
		<h1 class="entry-title text-white"><?php echo get_the_title( $query_id ); ?></h1>
	<?php  } ?>
	<?php
//	get_template_part( 'template-parts/header/logo');
	get_template_part( 'template-parts/header/search');
	get_template_part( 'template-parts/menu/home','middle');
	?>
</div>
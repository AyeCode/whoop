<div class="whoop-top-content-single whoop-top-content-single-new">
	<div class="inner-container">
		<span class="whoop-archive-title-wrap">
			<span class="whoop-title-wrap">
				<h1 class="entry-title"><?php
					$query_id = get_queried_object();
					if ( $query_id ) {
						echo get_the_title( $query_id );
					}
					?></h1>
			</span>
			<span class="whoop-title-meta-wrap">
			<?php
			get_template_part( 'template-parts/content/single',"top-claim" );
			?>
			</span>

		</span>

		<?php
		echo do_shortcode( '[gd_notifications]' );
		?>

		<span class="whoop-single-meta-wrap">
			<span class="whoop-single-top-left-wrap">
			<?php
			echo do_shortcode( '[gd_post_rating]' );
			echo do_shortcode( '[gd_post_meta key="post_category" show="icon-value" alignment="block"]' );
			?>
			</span>
			<span class="whoop-single-top-right-wrap">
			<?php
			get_template_part( 'template-parts/content/single',"top-buttons" );
			?>
			</span>
		</span>
	</div>
</div>
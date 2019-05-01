<div class="fullwidth-sidebar-container whoop-top-content">
	<div class="container">
		<span class="whoop-archive-title-wrap">
			<span class="whoop-title-wrap">
				<h1 class="entry-title"><?php
					$query_id = get_queried_object();
					if($query_id){
						echo get_the_title($query_id);
					}

					//			the_title();
					?></h1>
			</span>

			<span class="whoop-title-meta-wrap">
			<?php
			echo do_shortcode( '[gd_loop_paging show_advanced="after"]' );
			?>
			</span>

		</span>
		<?php
		echo do_shortcode( '[gd_notifications]' );
		?>
		<span class="whoop-archive-filters">
			<?php if(defined('GEODIR_ADV_SEARCH_VERSION')) {
				ob_start();
				GeoDir_Adv_Search_Fields::advance_search_button();
				$has_filters = ob_get_clean();
				if($has_filters){
				?>
				<button class="whoop-show-filters "
				        onclick="geodir_search_show_filters('.whoop-archive-filters .geodir-show-filters '); return false;"><i
						class="fas fa-sliders-h"></i> <?php _e( "All Filters", "whoop" ) ?></button>
				<?php
			}}
			echo do_shortcode( '[gd_loop_actions]' );
			echo do_shortcode( '[gd_search]' );
			echo do_shortcode( '[gd_category_description]' );
			//
			?>
		</span>
	</div>
</div>
<span class="whoop-mapbox">
	<span class="whoop-mapbox-map">
		<?php
		echo do_shortcode( '[gd_map static="1" width="288px" height="138px" maptype="ROADMAP" zoom="0" map_type="auto" post_settings="1"]' );
		?>
	</span>

	<span class="whoop-mapbox-details">
		<?php
		echo do_shortcode( '[gd_post_meta key="address" show="icon-value"]' );
		echo do_shortcode( '[gd_post_directions]' );
		echo do_shortcode( '[gd_post_meta key="phone" show="icon-value"]' );
		?>
	</span>
</span>

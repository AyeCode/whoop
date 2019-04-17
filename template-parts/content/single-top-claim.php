<span class="whoop-top-claim-wrap">
	<?php
	echo do_shortcode( '[gd_claim_post text="Unclaimed" output="link"]' );
	echo do_shortcode( '[gd_post_badge key="claimed" condition="is_not_empty" icon_class="fas fa-check-circle" badge="Claimed" bg_color="#f5f5f5" txt_color="#0073bb"]' );
	?>
</span>
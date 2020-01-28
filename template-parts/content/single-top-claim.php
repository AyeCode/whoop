<span class="whoop-top-claim-wrap">
	<?php
	if ( defined( 'GEODIR_CLAIM_VERSION' ) ) {
		// Post claim link
		$claim_link_shortcode = '[gd_claim_post text="' . esc_attr__( 'Unclaimed', 'whoop' ) . '" output="link"]';
		$claim_link_shortcode = apply_filters( 'whoop_single_claim_post_link_shortcode', $claim_link_shortcode );
		if ( ! empty( $claim_link_shortcode ) ) {
			echo do_shortcode( $claim_link_shortcode );
		}

		// Post claimed badge
		$claim_badge_shortcode = '[gd_post_badge key="claimed" condition="is_not_empty" icon_class="fas fa-check-circle" badge="' . esc_attr__( 'Claimed', 'whoop' ) . '" bg_color="#f5f5f5" txt_color="#0073bb"]';
		$claim_badge_shortcode = apply_filters( 'whoop_single_claim_post_badge_shortcode', $claim_badge_shortcode );
		if ( ! empty( $claim_badge_shortcode ) ) {
			echo do_shortcode( $claim_badge_shortcode );
		}
	}
	?>
</span>
<div class="header-top-item site-logo-wrap">
	<?php if ( get_theme_mod( 'logo', false ) ) : ?>
		<div class='site-logo'>
			<a href='<?php echo esc_url( home_url( '/' ) ); ?>'
			   title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><img
					src='<?php echo esc_url( get_theme_mod( 'logo', false ) ); ?>'
					alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'></a>
		</div>
	<?php else : ?>
		<?php
		if ( display_header_text() ) {
			$style = ' style="color:#' . get_header_textcolor() . ';"';
		} else {
			$style = ' style="display:none;"';
		}

		if ( display_header_text() ) : ?>
			<?php
			$desc  = get_bloginfo( 'description', 'display' );
			$class = '';
			if ( ! $desc ) {
				$class = 'site-title-no-desc';
			}
			?>
			<hgroup>
				<h1 class='site-title <?php echo $class; ?>'>
					<a <?php echo $style; ?> href='<?php echo esc_url( home_url( '/' ) ); ?>'
					                         title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'
					                         rel='home'><?php bloginfo( 'name' ); ?></a>
				</h1>
				<?php
				if ( $enable_header_top != '1' ) { ?>
					<h2 class="site-description">
						<a <?php echo $style; ?> href='<?php echo esc_url( home_url( '/' ) ); ?>'
						                         title='<?php echo esc_attr( $desc ); ?>'
						                         rel='home'><?php echo $desc; ?></a>
					</h2>
				<?php } ?>
			</hgroup>
		<?php endif; ?>
	<?php endif; ?>
</div>
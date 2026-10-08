<?php
/**
 * Site footer.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<footer class="site-footer">
	<div class="container">
		<div class="site-footer__grid">
			<div class="site-footer__col">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-footer__logo">IQRA <span>Construction</span></a>
				<p class="site-footer__tagline"><?php echo esc_html( get_bloginfo( 'description' ) ?: 'General contracting and structural engineering for residential, commercial, and infrastructure projects.' ); ?></p>
				<?php
				$socials = array(
					'social_facebook'  => 'Fb',
					'social_instagram' => 'Ig',
					'social_linkedin'  => 'In',
					'social_whatsapp'  => 'Wa',
				);
				$social_html = '';
				foreach ( $socials as $key => $label ) {
					$url = iqra_mod( $key, '' );
					if ( ! empty( $url ) ) {
						$social_html .= sprintf(
							'<a href="%s" target="_blank" rel="noopener noreferrer" aria-label="%s">%s</a>',
							esc_url( $url ),
							esc_attr( str_replace( 'social_', '', $key ) ),
							esc_html( $label )
						);
					}
				}
				if ( $social_html ) :
					?>
					<div class="site-footer__social"><?php echo $social_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above ?></div>
				<?php endif; ?>
			</div>

			<div class="site-footer__col">
				<h4>Company</h4>
				<ul class="site-footer__links">
					<?php if ( has_nav_menu( 'footer' ) ) : ?>
						<?php
						wp_nav_menu( array(
							'theme_location' => 'footer',
							'container'      => false,
							'items_wrap'     => '%3$s',
							'fallback_cb'    => false,
							'depth'          => 1,
						) );
						?>
					<?php else : ?>
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
						<li><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>">About</a></li>
						<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Services</a></li>
						<li><a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>">Projects</a></li>
						<li><a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">Contact</a></li>
					<?php endif; ?>
				</ul>
			</div>

			<div class="site-footer__col">
				<h4>Services</h4>
				<ul class="site-footer__links">
					<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Residential Construction</a></li>
					<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Commercial Construction</a></li>
					<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Structural Engineering</a></li>
					<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Renovation &amp; Remodeling</a></li>
					<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Project Management</a></li>
				</ul>
			</div>

			<div class="site-footer__col">
				<h4>Contact</h4>
				<p class="site-footer__contact">
					<?php
					$address = iqra_mod( 'contact_address', "4820 Industrial Parkway\nSuite 210\nYour City, ST 00000" );
					$phone   = iqra_mod( 'contact_phone', '+1 (555) 214-0890' );
					$email   = iqra_mod( 'contact_email', 'info@iqraconstruction.com' );
					$hours   = iqra_mod( 'contact_hours', 'Mon–Fri 7:30 AM – 5:30 PM' );
					if ( $address ) {
						echo nl2br( esc_html( $address ) ) . '<br>';
					}
					if ( $phone ) {
						echo '<a href="tel:' . esc_attr( preg_replace( '/[^\d+]/', '', $phone ) ) . '">' . esc_html( $phone ) . '</a><br>';
					}
					if ( $email ) {
						echo '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a><br>';
					}
					if ( $hours ) {
						echo esc_html( $hours );
					}
					?>
				</p>
			</div>
		</div>

		<div class="site-footer__bottom">
			<span>&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</span>
			<span>Licensed general contractor &amp; engineering services</span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

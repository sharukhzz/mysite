<?php
/**
 * Contact Us — page slug "contact-us".
 */
get_header();
$status  = isset( $_GET['contact'] ) ? sanitize_text_field( wp_unslash( $_GET['contact'] ) ) : '';
$address = iqra_mod( 'contact_address', "4820 Industrial Parkway\nSuite 210\nYour City, ST 00000" );
$phone   = iqra_mod( 'contact_phone', '+1 (555) 214-0890' );
$email   = iqra_mod( 'contact_email', 'info@iqraconstruction.com' );
$hours   = iqra_mod( 'contact_hours', 'Mon–Fri 7:30 AM – 5:30 PM' );
$map_q   = $address ? rawurlencode( $address ) : '';
?>
<main>
	<section class="page-hero">
		<div class="container">
			<span class="section-label">Contact</span>
			<h1>Talk to the project team</h1>
			<p>Questions about a service, an active job, or whether we are the right fit — reach a real person, not a ticket queue.</p>
		</div>
	</section>

	<section class="section">
		<div class="container split">
			<div class="split__text">
				<span class="section-label">Office</span>
				<h2>How to reach us</h2>
				<p>Call or email during business hours. For new project inquiries, the quote form is usually faster — it routes to a project manager with the details they need.</p>

				<dl class="contact-details">
					<?php if ( $address ) : ?>
						<dt>Address</dt>
						<dd><?php echo nl2br( esc_html( $address ) ); ?></dd>
					<?php endif; ?>
					<?php if ( $phone ) : ?>
						<dt>Phone</dt>
						<dd><a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></dd>
					<?php endif; ?>
					<?php if ( $email ) : ?>
						<dt>Email</dt>
						<dd><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></dd>
					<?php endif; ?>
					<?php if ( $hours ) : ?>
						<dt>Business Hours</dt>
						<dd><?php echo esc_html( $hours ); ?></dd>
					<?php endif; ?>
				</dl>

				<?php $whatsapp = iqra_mod( 'social_whatsapp', '' ); ?>
				<?php if ( $whatsapp ) : ?>
					<a href="<?php echo esc_url( $whatsapp ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn--outline">WhatsApp</a>
				<?php endif; ?>
				<a href="<?php echo esc_url( home_url( '/request-a-quote/' ) ); ?>" class="btn btn--primary">Request a Quote</a>

				<?php if ( $map_q ) : ?>
					<div class="map-embed">
						<iframe
							title="Office location map"
							loading="lazy"
							referrerpolicy="no-referrer-when-downgrade"
							src="https://maps.google.com/maps?q=<?php echo esc_attr( $map_q ); ?>&amp;z=14&amp;output=embed">
						</iframe>
					</div>
				<?php endif; ?>
			</div>

			<div class="split__media" style="align-self:start;">
				<?php if ( 'success' === $status ) : ?>
					<div class="form-banner form-banner--success">Thanks — your message was sent. We will follow up shortly.</div>
				<?php elseif ( 'error' === $status ) : ?>
					<div class="form-banner form-banner--error">Please check the required fields and try again.</div>
				<?php endif; ?>

				<form class="form-card" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="iqra_contact_submit">
					<?php wp_nonce_field( 'iqra_contact_submit', 'iqra_contact_nonce' ); ?>

					<label for="contact_full_name">Full Name *</label>
					<input type="text" id="contact_full_name" name="full_name" required autocomplete="name">

					<label for="contact_email">Email *</label>
					<input type="email" id="contact_email" name="email" required autocomplete="email">

					<label for="contact_phone">Phone</label>
					<input type="tel" id="contact_phone" name="phone" autocomplete="tel">

					<label for="contact_subject">Subject</label>
					<input type="text" id="contact_subject" name="subject">

					<label for="contact_message">Message *</label>
					<textarea id="contact_message" name="message" rows="5" required></textarea>

					<button type="submit" class="btn btn--primary">Send Message</button>
				</form>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();

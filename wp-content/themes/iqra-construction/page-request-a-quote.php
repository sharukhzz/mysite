<?php
/**
 * Request a Quote — page slug "request-a-quote".
 */
get_header();
$status = isset( $_GET['quote'] ) ? sanitize_text_field( wp_unslash( $_GET['quote'] ) ) : '';
?>
<main>
	<section class="page-hero">
		<div class="container">
			<span class="section-label">New project</span>
			<h1>Request a quote</h1>
			<p>This is an inquiry form — not an automatic price. A project manager reviews your details and follows up with scope and next steps.</p>
		</div>
	</section>

	<section class="section">
		<div class="container" style="max-width:760px;">
			<?php if ( 'success' === $status ) : ?>
				<div class="form-banner form-banner--success">Thanks — we received your request and will follow up within 1–2 business days.</div>
			<?php elseif ( 'error' === $status ) : ?>
				<div class="form-banner form-banner--error">Please complete the required fields and try again.</div>
			<?php endif; ?>

			<form class="form-card form-card--wide" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data">
				<input type="hidden" name="action" value="iqra_quote_submit">
				<?php wp_nonce_field( 'iqra_quote_submit', 'iqra_quote_nonce' ); ?>

				<div class="form-grid">
					<div>
						<label for="quote_full_name">Full Name *</label>
						<input type="text" id="quote_full_name" name="full_name" required autocomplete="name">
					</div>
					<div>
						<label for="quote_email">Email *</label>
						<input type="email" id="quote_email" name="email" required autocomplete="email">
					</div>
					<div>
						<label for="quote_phone">Phone</label>
						<input type="tel" id="quote_phone" name="phone" autocomplete="tel">
					</div>
					<div>
						<label for="project_type">Project Type</label>
						<select id="project_type" name="project_type">
							<option value="Residential Construction">Residential Construction</option>
							<option value="Commercial Construction">Commercial Construction</option>
							<option value="Structural Engineering">Structural Engineering</option>
							<option value="Renovation & Remodeling">Renovation &amp; Remodeling</option>
							<option value="Project Management">Project Management</option>
							<option value="Architectural Design">Architectural Design</option>
							<option value="Interior Works">Interior Works</option>
						</select>
					</div>
					<div>
						<label for="project_location">Project Location</label>
						<input type="text" id="project_location" name="project_location" placeholder="City / site address">
					</div>
					<div>
						<label for="project_area">Approx. Area</label>
						<input type="text" id="project_area" name="project_area" placeholder="e.g. 2,400 sq ft">
					</div>
					<div>
						<label for="budget">Estimated Budget</label>
						<input type="text" id="budget" name="budget" placeholder="Optional range">
					</div>
					<div>
						<label for="start_date">Target Start</label>
						<input type="date" id="start_date" name="start_date">
					</div>
				</div>

				<label for="description">Project Description *</label>
				<textarea id="description" name="description" rows="5" required placeholder="Site conditions, goals, drawings available, constraints…"></textarea>

				<label for="reference_file">Reference file (image or PDF, optional)</label>
				<input type="file" id="reference_file" name="reference_file" accept=".jpg,.jpeg,.png,.pdf">

				<button type="submit" class="btn btn--primary">Submit Inquiry</button>
			</form>
		</div>
	</section>
</main>
<?php
get_footer();

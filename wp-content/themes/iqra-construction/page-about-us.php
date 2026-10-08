<?php
/**
 * About Us — page slug "about-us".
 */
get_header();
?>
<main>
	<section class="page-hero">
		<div class="container">
			<span class="section-label">About</span>
			<h1>A construction company that keeps engineers on the job</h1>
			<p>IQRA Construction was built to close the gap between design office and job site.</p>
		</div>
	</section>

	<section class="section">
		<div class="container split">
			<div class="split__text">
				<span class="section-label">Our story</span>
				<h2>Started on site — still run that way</h2>
				<p>Too many firms split the people who design a building from the people who build it. Problems show up late, change orders pile up, and nobody owns the full picture.</p>
				<p>We keep structural engineers involved through construction, not just at permit. Supervisors read drawings. Project managers own the schedule. That is how we take on residential, commercial, and infrastructure work without the usual disconnect.</p>
			</div>
			<div class="split__media">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/about-worker.jpg' ); ?>" alt="Construction professional on site with hard hat and drawings">
			</div>
		</div>
	</section>

	<section class="section section--muted">
		<div class="container">
			<div class="section__heading">
				<span class="section-label">Standards</span>
				<h2>How we run every job</h2>
			</div>
			<div class="feature-grid">
				<div class="feature">
					<h3>Engineering first</h3>
					<p>Structural decisions are documented and reviewable before they are built.</p>
				</div>
				<div class="feature">
					<h3>Honest timelines</h3>
					<p>We only commit to schedules we can staff — and flag slips early.</p>
				</div>
				<div class="feature">
					<h3>Site craft</h3>
					<p>Supervisors who understand drawings, not just punch lists.</p>
				</div>
				<div class="feature">
					<h3>After handover</h3>
					<p>We stand behind completed work with clear warranty terms.</p>
				</div>
			</div>
		</div>
	</section>

	<section class="section">
		<div class="container">
			<div class="section__heading">
				<span class="section-label">Who is on the job</span>
				<h2>Departments that stay connected</h2>
				<p>No staged headshots needed — these are the teams that actually move your project.</p>
			</div>
			<div class="dept-grid">
				<div class="dept">
					<span class="dept__tag">Engineering</span>
					<h3>Structural Engineering</h3>
					<p>Licensed engineers for load analysis, stamped drawings, and construction-phase review when field conditions change.</p>
				</div>
				<div class="dept">
					<span class="dept__tag">Operations</span>
					<h3>Project Management</h3>
					<p>Scheduling, procurement, subcontractor coordination, and client reporting from permit through close-out.</p>
				</div>
				<div class="dept">
					<span class="dept__tag">Field</span>
					<h3>Site Supervision</h3>
					<p>Daily quality, safety, and trade sequencing on active sites — with eyes on the drawings every morning.</p>
				</div>
			</div>
		</div>
	</section>

	<section class="cta-banner">
		<div class="container cta-banner__inner">
			<span class="section-label">Work with us</span>
			<h2>Have a site ready to discuss?</h2>
			<p>Share your location, scope, and target start. We will tell you if we are the right fit before anyone spends weeks on a dead-end bid.</p>
			<a href="<?php echo esc_url( home_url( '/request-a-quote/' ) ); ?>" class="btn btn--primary">Request a Quote</a>
		</div>
	</section>
</main>
<?php
get_footer();

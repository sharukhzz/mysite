<?php
/**
 * Services — page slug "services".
 */
get_header();

$services = array(
	array(
		'title' => 'Residential Construction',
		'short' => 'Ground-up homes and multi-unit residential builds.',
		'long'  => 'From single-family homes to multi-unit residential, we manage design coordination, permitting, foundations, structure, and finishes under one contract. You get a single schedule and a single point of contact — not a chain of separate trades arguing over who owns the next delay.',
		'imgs'  => array( 'residential-aerial.jpg', 'hero-construction.jpg', 'about-worker.jpg' ),
	),
	array(
		'title' => 'Commercial Construction',
		'short' => 'Retail, office, warehouse, and mixed-use projects.',
		'long'  => 'Commercial work needs MEP coordination, inspection sequencing, and tenants who care about handover dates. We run site prep, structure, systems coordination, and finishes with a project manager accountable for the whole build.',
		'imgs'  => array( 'commercial-tower.jpg', 'hero-construction.jpg', 'interior-office.jpg' ),
	),
	array(
		'title' => 'Structural Engineering',
		'short' => 'Calculations, stamped drawings, and field review.',
		'long'  => 'In-house structural engineers produce calculations and stamped drawings for new builds, additions, and renovations. They stay available during construction when field conditions do not match the drawings — which is when most problems get expensive.',
		'imgs'  => array( 'about-worker.jpg', 'commercial-tower.jpg', 'hero-construction.jpg' ),
	),
	array(
		'title' => 'Renovation & Remodeling',
		'short' => 'Additions and remodels that respect the existing structure.',
		'long'  => 'Renovation carries risk new builds do not. We assess the existing building first — foundations, framing, and load paths — then design and execute changes that do not compromise what is already there.',
		'imgs'  => array( 'interior-office.jpg', 'residential-aerial.jpg', 'about-worker.jpg' ),
	),
	array(
		'title' => 'Construction Project Management',
		'short' => 'One manager across every trade on site.',
		'long'  => 'Already have drawings and need it built? Our project management service coordinates subcontractors, scheduling, inspections, and quality control from permit to handover.',
		'imgs'  => array( 'hero-construction.jpg', 'about-worker.jpg', 'commercial-tower.jpg' ),
	),
	array(
		'title' => 'Architectural Design',
		'short' => 'Concept-to-permit drawings built for constructability.',
		'long'  => 'Our design process is grounded in what can actually be engineered and built — so architectural packages do not need a second expensive round of revisions once construction starts.',
		'imgs'  => array( 'commercial-tower.jpg', 'residential-aerial.jpg', 'interior-office.jpg' ),
	),
	array(
		'title' => 'Interior Works',
		'short' => 'Fit-outs and finishes for commercial and residential spaces.',
		'long'  => 'Office fit-outs, residential interiors, and finish packages that turn a completed structure into a usable space — coordinated with the same site team when we are already on the job.',
		'imgs'  => array( 'interior-office.jpg', 'residential-aerial.jpg', 'about-worker.jpg' ),
	),
);
?>
<main>
	<section class="page-hero">
		<div class="container">
			<span class="section-label">Services</span>
			<h1>Engineering and construction under one contract</h1>
			<p>Design-build, structural engineering, renovations, and project management — staffed by one accountable team.</p>
		</div>
	</section>

	<?php foreach ( $services as $i => $service ) : ?>
		<section class="section <?php echo ( 0 === $i % 2 ) ? '' : 'section--muted'; ?>">
			<div class="container split <?php echo ( 0 === $i % 2 ) ? '' : 'split--reverse'; ?>">
				<div class="split__text">
					<span class="section-label">0<?php echo esc_html( (string) ( $i + 1 ) ); ?></span>
					<h2><?php echo esc_html( $service['title'] ); ?></h2>
					<p><strong><?php echo esc_html( $service['short'] ); ?></strong></p>
					<p><?php echo esc_html( $service['long'] ); ?></p>
				</div>
				<div class="split__media">
					<div class="service-slider" data-interval="4000" aria-label="<?php echo esc_attr( $service['title'] . ' gallery' ); ?>">
						<div class="service-slider__track">
							<?php foreach ( $service['imgs'] as $img_i => $img ) : ?>
								<figure class="service-slider__slide<?php echo 0 === $img_i ? ' is-active' : ''; ?>">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/' . $img ); ?>" alt="<?php echo esc_attr( $service['title'] ); ?>" <?php echo 0 === $img_i ? '' : 'loading="lazy"'; ?>>
								</figure>
							<?php endforeach; ?>
						</div>
						<div class="service-slider__dots" role="tablist" aria-label="Slides">
							<?php foreach ( $service['imgs'] as $img_i => $img ) : ?>
								<button type="button" class="service-slider__dot<?php echo 0 === $img_i ? ' is-active' : ''; ?>" aria-label="<?php echo esc_attr( sprintf( 'Slide %d', $img_i + 1 ) ); ?>" data-index="<?php echo esc_attr( (string) $img_i ); ?>"></button>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endforeach; ?>
</main>
<?php
get_footer();

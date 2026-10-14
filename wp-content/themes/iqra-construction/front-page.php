<?php
/**
 * Homepage.
 */
get_header();
?>
<main>

	<section class="hero">
		<div class="hero__media" aria-hidden="true">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/hero-construction.jpg' ); ?>" alt="">
			<div class="hero__media-overlay"></div>
		</div>
		<div class="hero__content">
			<p class="hero__brand">IQRA <span>Construction</span></p>
			<h1>Residential, commercial, and infrastructure builds — managed from drawings to handover.</h1>
			<p class="hero__lede">A design-build contractor with in-house structural engineering. Clear schedules, on-site supervision, and one team accountable for the whole job.</p>
			<div class="hero__actions">
				<a href="<?php echo esc_url( home_url( '/request-a-quote/' ) ); ?>" class="btn btn--primary">Request a Quote</a>
				<a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>" class="btn btn--outline-light">View Projects</a>
			</div>
		</div>
	</section>

	<section class="capability-strip" aria-label="Service areas">
		<div class="container">
			<ul class="capability-strip__list">
				<li class="capability-strip__item">Residential Builds</li>
				<li class="capability-strip__item">Commercial Projects</li>
				<li class="capability-strip__item">Structural Engineering</li>
				<li class="capability-strip__item">Renovations</li>
				<li class="capability-strip__item">Project Management</li>
			</ul>
		</div>
	</section>

	<section class="section">
		<div class="container split">
			<div class="split__media">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/about-worker.jpg' ); ?>" alt="Site supervisor reviewing drawings on an active construction site">
			</div>
			<div class="split__text">
				<span class="section-label">About the company</span>
				<h2>Engineers on the drawings. Supervisors on the site.</h2>
				<p>IQRA Construction handles design coordination, structural work, and general contracting as one team. That means fewer handoffs between the people who calculate loads and the crew that pours concrete — and fewer surprises when the schedule gets tight.</p>
				<p>We take on ground-up homes, multi-story commercial work, renovations, and infrastructure support jobs. Same process every time: assess the site, lock the scope, staff the job, and keep the client updated.</p>
				<a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>" class="btn btn--outline">About Us</a>
				<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="btn btn--ghost-dark">Contact</a>
			</div>
		</div>
	</section>

	<section class="section section--muted">
		<div class="container">
			<div class="section__heading reveal">
				<span class="section-label">Services</span>
				<h2>What we build and manage</h2>
				<p>Full-scope contracting with structural engineering available in-house — so design intent survives construction.</p>
			</div>
			<div class="services-list stagger">
				<?php
				$services = array(
					array( '01', 'Residential Construction', 'Single-family and multi-unit builds from foundation through finish.' ),
					array( '02', 'Commercial Construction', 'Retail, office, warehouse, and mixed-use projects with MEP coordination.' ),
					array( '03', 'Structural Engineering', 'Load analysis, stamped drawings, and construction-phase review.' ),
					array( '04', 'Renovation & Remodeling', 'Additions and remodels assessed against the existing structure first.' ),
					array( '05', 'Project Management', 'Scheduling, subcontractor coordination, and site quality control.' ),
					array( '06', 'Architectural Design', 'Buildable drawings from concept through permit package.' ),
				);
				foreach ( $services as $service ) :
					?>
					<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="service-row">
						<span class="service-row__num"><?php echo esc_html( $service[0] ); ?></span>
						<div>
							<h3><?php echo esc_html( $service[1] ); ?></h3>
							<p><?php echo esc_html( $service[2] ); ?></p>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
			<div class="section__cta">
				<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="btn btn--outline">All Services</a>
			</div>
		</div>
	</section>

	<section class="section">
		<div class="container">
			<div class="section__heading reveal">
				<span class="section-label">Selected work</span>
				<h2>Recent projects</h2>
			</div>
			<?php
			$featured = new WP_Query( array(
				'post_type'      => 'project',
				'posts_per_page' => 3,
				'orderby'        => 'date',
				'order'          => 'DESC',
			) );
			?>
			<?php if ( $featured->have_posts() ) : ?>
				<div class="projects-grid stagger">
					<?php while ( $featured->have_posts() ) : $featured->the_post(); ?>
						<a href="<?php the_permalink(); ?>" class="project-card">
							<div class="project-card__media">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'medium_large' ); ?>
								<?php else : ?>
									<div class="media-fallback">Project</div>
								<?php endif; ?>
							</div>
							<div class="project-card__body">
								<?php
								$location = get_post_meta( get_the_ID(), '_iqra_location', true );
								?>
								<h3><?php the_title(); ?></h3>
								<?php if ( $location ) : ?><p><?php echo esc_html( $location ); ?></p><?php endif; ?>
								<?php if ( has_excerpt() ) : ?><p class="project-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>	
							</div>
						</a>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			<?php else : ?>
				<div class="empty-state">
					Project case studies will appear here once published from the WordPress dashboard.
				</div>
			<?php endif; ?>
			<div class="section__cta">
				<a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>" class="btn btn--outline">View All Projects</a>
			</div>
		</div>
	</section>

	<section class="section section--muted">
		<div class="container">
			<div class="section__heading reveal">
				<span class="section-label">How we work</span>
				<h2>From first call to keys</h2>
			</div>
			<div class="process-grid stagger">
				<div class="process-step">
					<span class="process-step__number">01</span>
					<h3>Site review</h3>
					<p>We walk the site, review constraints, and confirm budget and timeline before proposing scope.</p>
				</div>
				<div class="process-step">
					<span class="process-step__number">02</span>
					<h3>Design &amp; permits</h3>
					<p>Drawings and structural calculations are completed, then submitted for permit.</p>
				</div>
				<div class="process-step">
					<span class="process-step__number">03</span>
					<h3>Build</h3>
					<p>Crew and trades work to a locked schedule with daily site supervision.</p>
				</div>
				<div class="process-step">
					<span class="process-step__number">04</span>
					<h3>Handover</h3>
					<p>Final walkthrough, as-built docs, and warranty details before close-out.</p>
				</div>
			</div>
		</div>
	</section>

	<section class="section">
		<div class="container">
			<div class="section__heading reveal">
				<span class="section-label">Why clients hire us</span>
				<h2>What you can expect on the job</h2>
			</div>
			<div class="feature-grid stagger">
				<div class="feature">
					<h3>Licensed engineering</h3>
					<p>Structural decisions are reviewed by qualified engineers — not left to the site alone.</p>
				</div>
				<div class="feature">
					<h3>Real schedules</h3>
					<p>We publish a timeline we can staff, and notify you early when weather or trades shift it.</p>
				</div>
				<div class="feature">
					<h3>One project lead</h3>
					<p>A single manager owns your job across every trade until handover.</p>
				</div>
				<div class="feature">
					<h3>Documented changes</h3>
					<p>Material or scope substitutions are written down and approved before they hit the site.</p>
				</div>
			</div>
		</div>
	</section>

	<section class="cta-banner">
		<div class="container cta-banner__inner reveal">
			<span class="section-label">Start a project</span>
			<h2>Need a contractor who can also stamp the drawings?</h2>
			<p>Send the site address, rough scope, and target start date. A project manager will follow up with next steps — not an automated price.</p>
			<a href="<?php echo esc_url( home_url( '/request-a-quote/' ) ); ?>" class="btn btn--primary">Request a Quote</a>
		</div>
	</section>

</main>
<?php
get_footer();

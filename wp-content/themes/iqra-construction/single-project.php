<?php
/**
 * Single project detail page.
 */
get_header();
while ( have_posts() ) :
	the_post();
	$location = get_post_meta( get_the_ID(), '_iqra_location', true );
	$status   = get_post_meta( get_the_ID(), '_iqra_status', true );
	$year     = get_post_meta( get_the_ID(), '_iqra_year', true );
	$duration = get_post_meta( get_the_ID(), '_iqra_duration', true );
	$terms    = get_the_terms( get_the_ID(), 'project_category' );
	?>
	<main>
		<section class="page-hero">
			<div class="container">
				<?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
					<span class="section-label"><?php echo esc_html( $terms[0]->name ); ?></span>
				<?php endif; ?>
				<h1><?php the_title(); ?></h1>
				<?php if ( $location ) : ?>
					<p><?php echo esc_html( $location ); ?><?php echo $status ? ' · ' . esc_html( $status ) : ''; ?></p>
				<?php endif; ?>
			</div>
		</section>

		<section class="section">
			<div class="container project-detail">
				<div class="project-detail__media">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large' ); ?>
					<?php else : ?>
						<div class="media-fallback" style="min-height:360px;">Project photo</div>
					<?php endif; ?>
				</div>

				<aside class="project-detail__meta">
					<h4>Project overview</h4>
					<dl>
						<?php if ( $location ) : ?><dt>Location</dt><dd><?php echo esc_html( $location ); ?></dd><?php endif; ?>
						<?php if ( $terms && ! is_wp_error( $terms ) ) : ?><dt>Category</dt><dd><?php echo esc_html( $terms[0]->name ); ?></dd><?php endif; ?>
						<?php if ( $status ) : ?><dt>Status</dt><dd><?php echo esc_html( $status ); ?></dd><?php endif; ?>
						<?php if ( $year ) : ?><dt>Completion year</dt><dd><?php echo esc_html( $year ); ?></dd><?php endif; ?>
						<?php if ( $duration ) : ?><dt>Duration</dt><dd><?php echo esc_html( $duration ); ?></dd><?php endif; ?>
					</dl>
					<a href="<?php echo esc_url( home_url( '/request-a-quote/' ) ); ?>" class="btn btn--primary" style="width:100%;">Start a Similar Project</a>
				</aside>
			</div>

			<div class="container project-detail__body">
				<?php the_content(); ?>
			</div>
		</section>

		<?php
		$related_args = array(
			'post_type'      => 'project',
			'posts_per_page' => 3,
			'post__not_in'   => array( get_the_ID() ),
		);
		if ( $terms && ! is_wp_error( $terms ) ) {
			$related_args['tax_query'] = array(
				array(
					'taxonomy' => 'project_category',
					'field'    => 'slug',
					'terms'    => $terms[0]->slug,
				),
			);
		}
		$related = new WP_Query( $related_args );
		if ( $related->have_posts() ) :
			?>
			<section class="section section--muted">
				<div class="container">
					<div class="section__heading">
						<span class="section-label">Related</span>
						<h2>More projects</h2>
					</div>
					<div class="projects-grid">
						<?php while ( $related->have_posts() ) : $related->the_post(); ?>
							<a href="<?php the_permalink(); ?>" class="project-card">
								<div class="project-card__media">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'medium_large' ); ?>
									<?php else : ?>
										<div class="media-fallback">Project</div>
									<?php endif; ?>
								</div>
								<div class="project-card__body">
									<h3><?php the_title(); ?></h3>
								</div>
							</a>
						<?php endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
			</section>
			<?php
		endif;
		?>
	</main>
	<?php
endwhile;
get_footer();

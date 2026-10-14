<?php
/**
 * Projects listing — page slug "projects".
 */
get_header();

$categories      = get_terms( array( 'taxonomy' => 'project_category', 'hide_empty' => false ) );
$active_category = isset( $_GET['category'] ) ? sanitize_title( wp_unslash( $_GET['category'] ) ) : '';
$paged           = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
if ( isset( $_GET['pg'] ) ) {
	$paged = max( 1, absint( $_GET['pg'] ) );
}

$query_args = array(
	'post_type'      => 'project',
	'posts_per_page' => 9,
	'paged'          => $paged,
);
if ( $active_category ) {
	$query_args['tax_query'] = array(
		array(
			'taxonomy' => 'project_category',
			'field'    => 'slug',
			'terms'    => $active_category,
		),
	);
}
$projects = new WP_Query( $query_args );

$base_url = home_url( '/projects/' );
if ( $active_category ) {
	$base_url = add_query_arg( 'category', $active_category, $base_url );
}
?>
<main>
	<section class="page-hero">
		<div class="container">
			<span class="section-label">Portfolio</span>
			<h1>Projects</h1>
			<p>Completed and active work across residential, commercial, and infrastructure.</p>
		</div>
	</section>

	<section class="section">
		<div class="container">
			<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
				<div class="filter-bar" role="navigation" aria-label="Filter projects by category">
					<a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>" class="filter-pill <?php echo '' === $active_category ? 'is-active' : ''; ?>">All</a>
					<?php foreach ( $categories as $cat ) : ?>
						<a href="<?php echo esc_url( add_query_arg( 'category', $cat->slug, home_url( '/projects/' ) ) ); ?>" class="filter-pill <?php echo $active_category === $cat->slug ? 'is-active' : ''; ?>"><?php echo esc_html( $cat->name ); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( $projects->have_posts() ) : ?>
				<div class="projects-grid">
					<?php while ( $projects->have_posts() ) : $projects->the_post(); ?>
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
					<?php endwhile; ?>
				</div>
				<?php if ( $projects->max_num_pages > 1 ) : ?>
					<div class="pagination">
						<?php
						$pagination_args = array(
							'total'   => $projects->max_num_pages,
							'current' => $paged,
							'type'    => 'plain',
							'prev_text' => '&larr;',
							'next_text' => '&rarr;',
						);
						if ( $active_category ) {
							$pagination_args['add_args'] = array( 'category' => $active_category );
						}
						// Keep category filter when paging via ?pg=
						$pagination_args['format'] = '?pg=%#%';
						$pagination_args['base']   = esc_url_raw( remove_query_arg( 'pg', $base_url ) ) . '%_%';
						echo paginate_links( $pagination_args );
						?>
					</div>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<div class="empty-state">
					No projects in this category yet. Publish one from <strong>Projects → Add New</strong> in the dashboard.
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();

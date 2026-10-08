<?php
/**
 * Generic page template.
 */
get_header();
?>
<main>
	<section class="page-hero">
		<div class="container">
			<?php the_title( '<h1>', '</h1>' ); ?>
		</div>
	</section>

	<section class="page-content">
		<div class="container" style="max-width:760px;">
			<?php
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
			?>
		</div>
	</section>
</main>
<?php
get_footer();

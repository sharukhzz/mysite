<?php
/**
 * Fallback template.
 */
get_header();
?>
<main class="page-content">
	<div class="container">
		<?php
		while ( have_posts() ) :
			the_post();
			the_title( '<h1>', '</h1>' );
			the_content();
		endwhile;
		?>
	</div>
</main>
<?php
get_footer();

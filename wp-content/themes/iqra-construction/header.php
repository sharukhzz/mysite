<?php
/**
 * Site header.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
	<div class="site-header__inner">
		<?php if ( has_custom_logo() ) : ?>
			<div class="site-header__logo site-header__logo--image">
				<?php the_custom_logo(); ?>
			</div>
		<?php else : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__logo site-header__logo--image">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/iqra-construction-logo.png' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			</a>
		<?php endif; ?>

		<nav class="site-header__nav" aria-label="Primary navigation">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => '',
					'fallback_cb'    => false,
					'depth'          => 1,
				) );
			} else {
				iqra_fallback_primary_menu();
			}
			?>
		</nav>

		<div class="site-header__actions">
			<a href="<?php echo esc_url( home_url( '/request-a-quote/' ) ); ?>" class="btn btn--primary">Get a Quote</a>
			<button class="nav-toggle" id="navToggle" type="button" aria-expanded="false" aria-controls="mobileMenu" aria-label="Toggle menu">
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>

	<div class="mobile-menu" id="mobileMenu">
		<?php
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'mobile-menu__list',
				'fallback_cb'    => false,
				'depth'          => 1,
			) );
		} else {
			iqra_fallback_primary_menu( 'mobile-menu__list' );
		}
		?>
		<a href="<?php echo esc_url( home_url( '/request-a-quote/' ) ); ?>" class="btn btn--primary">Get a Quote</a>
	</div>
</header>

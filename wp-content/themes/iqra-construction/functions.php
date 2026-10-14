<?php
/**
 * IQRA Construction theme setup.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function iqra_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 320,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'iqra-construction' ),
		'footer'  => __( 'Footer Menu', 'iqra-construction' ),
	) );
}
add_action( 'after_setup_theme', 'iqra_theme_setup' );

/**
 * Fallback primary menu when none is assigned in Appearance → Menus.
 */
function iqra_fallback_primary_menu( $menu_class = '' ) {
	$items = array(
		'/'                 => 'Home',
		'/about-us/'        => 'About',
		'/services/'        => 'Services',
		'/projects/'        => 'Projects',
		'/contact-us/'      => 'Contact',
	);

	echo '<ul' . ( $menu_class ? ' class="' . esc_attr( $menu_class ) . '"' : '' ) . '>';
	foreach ( $items as $path => $label ) {
		$url = home_url( $path );
		printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
	}
	echo '</ul>';
}

/**
 * Keep the Customizer logo compact in the header (not full-resolution).
 */
add_filter( 'get_custom_logo_image_attributes', function ( $attr ) {
	$attr['width']  = null;
	$attr['height'] = 60;
	$attr['class']  = trim( ( $attr['class'] ?? '' ) . ' custom-logo' );
	return $attr;
} );

function iqra_theme_assets() {
	wp_enqueue_style(
		'iqra-google-fonts',
		'https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600;700&family=Source+Sans+3:wght@400;500;600;700&display=swap',
		array(),
		null
	);
	wp_enqueue_style(
		'iqra-style',
		get_stylesheet_uri(),
		array( 'iqra-google-fonts' ),
		wp_get_theme()->get( 'Version' )
	);
	wp_enqueue_script(
		'iqra-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'iqra_theme_assets' );

/**
 * Theme mod helper — treats empty saved values as unset so Customizer defaults show.
 */
function iqra_mod( $key, $default = '' ) {
	$value = get_theme_mod( $key, $default );
	if ( null === $value || '' === $value ) {
		return $default;
	}
	return $value;
}

/**
 * Stop Elementor from loading the old cream/serif Google Fonts sitewide.
 * This theme ships its own type stack.
 */
add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );
add_action( 'wp_enqueue_scripts', function () {
	foreach ( array( 'elementor-gf-fraunces', 'elementor-gf-manrope' ) as $handle ) {
		wp_dequeue_style( $handle );
		wp_deregister_style( $handle );
	}
}, 100 );

/**
 * This theme renders pages with PHP templates, not Elementor canvases.
 * Dequeue Elementor kit CSS so the old cream/terracotta system cannot leak in.
 */
add_action( 'wp_enqueue_scripts', function () {
	if ( is_admin() ) {
		return;
	}
	wp_dequeue_style( 'elementor-frontend' );
	wp_dequeue_style( 'elementor-post-7' );
	wp_dequeue_style( 'base-desktop' );
	wp_dequeue_style( 'base-mobile' );
	wp_dequeue_style( 'elementor-icons' );
	wp_dequeue_style( 'elementor-common' );
}, 120 );

/**
 * Contact & social details — Appearance → Customize → Contact Info.
 */
function iqra_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'iqra_contact_info', array(
		'title'    => __( 'Contact Info', 'iqra-construction' ),
		'priority' => 30,
	) );

	$fields = array(
		'contact_phone'    => array( 'label' => 'Phone Number', 'default' => '+1 (555) 214-0890', 'sanitize' => 'sanitize_text_field' ),
		'contact_email'    => array( 'label' => 'Email Address', 'default' => 'info@iqraconstruction.com', 'sanitize' => 'sanitize_email' ),
		'contact_address'  => array( 'label' => 'Office Address', 'default' => "4820 Industrial Parkway\nSuite 210\nYour City, ST 00000", 'sanitize' => 'sanitize_textarea_field', 'type' => 'textarea' ),
		'contact_hours'    => array( 'label' => 'Business Hours', 'default' => 'Mon–Fri 7:30 AM – 5:30 PM', 'sanitize' => 'sanitize_text_field' ),
		'social_facebook'  => array( 'label' => 'Facebook URL', 'default' => '', 'sanitize' => 'esc_url_raw' ),
		'social_instagram' => array( 'label' => 'Instagram URL', 'default' => '', 'sanitize' => 'esc_url_raw' ),
		'social_linkedin'  => array( 'label' => 'LinkedIn URL', 'default' => '', 'sanitize' => 'esc_url_raw' ),
		'social_whatsapp'  => array( 'label' => 'WhatsApp Link (e.g. https://wa.me/15552140890)', 'default' => '', 'sanitize' => 'esc_url_raw' ),
	);

	foreach ( $fields as $id => $field ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $field['default'],
			'sanitize_callback' => $field['sanitize'],
		) );
		$wp_customize->add_control( $id, array(
			'section' => 'iqra_contact_info',
			'label'   => $field['label'],
			'type'    => isset( $field['type'] ) ? $field['type'] : 'text',
		) );
	}
}
add_action( 'customize_register', 'iqra_customize_register' );

require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/forms.php';

/**
 * Create the pages this theme has templates for, if they don't exist yet.
 */
function iqra_create_default_pages() {
	$pages = array(
		'projects'        => 'Projects',
		'about-us'        => 'About Us',
		'services'        => 'Services',
		'contact-us'      => 'Contact Us',
		'request-a-quote' => 'Request a Quote',
	);

	foreach ( $pages as $slug => $title ) {
		if ( get_page_by_path( $slug ) ) {
			continue;
		}
		wp_insert_post( array(
			'post_type'   => 'page',
			'post_status' => 'publish',
			'post_title'  => $title,
			'post_name'   => $slug,
		) );
	}
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'iqra_create_default_pages' );

/**
 /**
 * Simplified dashboard for the client (Editor role).
 */

/**
 * Check whether the current user is a client Editor.
 *
 * Editor = role is exactly "editor"
 * Admin   = users with manage_options are excluded
 */
function iqra_is_client_editor( $user = null ) {

	$user = $user ? $user : wp_get_current_user();

	if ( ! $user instanceof WP_User ) {
		return false;
	}

	return (
		in_array( 'editor', (array) $user->roles, true ) &&
		! user_can( $user, 'manage_options' )
	);
}

/**
 * Show only:
 *
 * Projects
 * Media
 * Pages
 * Profile
 */
function iqra_simplify_client_menu() {

	if ( ! iqra_is_client_editor() ) {
		return;
	}

	global $menu, $submenu;

	/*
	 * These are the ONLY top-level menus the client should see.
	 *
	 * project = Custom Post Type registered in inc/post-types.php
	 */
	$allowed_menus = array(
		'edit.php?post_type=project',
		'upload.php',
		'edit.php?post_type=page',
		'profile.php',
	);

	/*
	 * Remove every top-level menu except the four above.
	 */
	foreach ( $menu as $key => $item ) {

		if ( empty( $item[2] ) ) {
			continue;
		}

		$slug = $item[2];

		if ( ! in_array( $slug, $allowed_menus, true ) ) {
			unset( $menu[ $key ] );
		}
	}

	/*
	 * Remove separators left behind by the removed menus.
	 */
	foreach ( $menu as $key => $item ) {

		if (
			isset( $item[2] ) &&
			(
				'separator1' === $item[2] ||
				'separator2' === $item[2] ||
				'separator3' === $item[2]
			)
		) {
			unset( $menu[ $key ] );
		}
	}

	/*
	 * Remove unwanted submenus.
	 */
	$submenu = array(
		'edit.php?post_type=project' => isset( $submenu['edit.php?post_type=project'] )
			? $submenu['edit.php?post_type=project']
			: array(),

		'upload.php' => isset( $submenu['upload.php'] )
			? $submenu['upload.php']
			: array(),

		'edit.php?post_type=page' => isset( $submenu['edit.php?post_type=page'] )
			? $submenu['edit.php?post_type=page']
			: array(),

		'profile.php' => isset( $submenu['profile.php'] )
			? $submenu['profile.php']
			: array(),
	);
}
add_action( 'admin_menu', 'iqra_simplify_client_menu', 9999 );

/**
 * Redirect client Editor to Projects after login.
 */
function iqra_client_login_redirect( $redirect_to, $request, $user ) {

	if ( $user instanceof WP_User && iqra_is_client_editor( $user ) ) {
		return admin_url( 'edit.php?post_type=project' );
	}

	return $redirect_to;
}
add_filter( 'login_redirect', 'iqra_client_login_redirect', 10, 3 );
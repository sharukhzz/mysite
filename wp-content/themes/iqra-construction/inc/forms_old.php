<?php
/**
 * Contact + Request-a-Quote form handling.
 *
 * Submissions are (1) emailed via wp_mail() to the site admin email, and
 * (2) always saved as a private "Form Submission" post so nothing is lost
 * even if local mail delivery isn't configured (MAMP has no SMTP server by
 * default — this gets revisited at Phase 10 when the site goes live).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function iqra_register_submission_post_type() {
	register_post_type( 'iqra_submission', array(
		'labels' => array(
			'name'          => 'Form Submissions',
			'singular_name' => 'Submission',
		),
		'public'       => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-email-alt',
		'supports'     => array( 'title' ),
		'capabilities' => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap' => true,
	) );
}
add_action( 'init', 'iqra_register_submission_post_type' );

function iqra_submission_meta_box() {
	add_meta_box( 'iqra_submission_details', 'Submission Details', function ( $post ) {
		$meta = get_post_meta( $post->ID );
		echo '<table class="widefat"><tbody>';
		foreach ( $meta as $key => $value ) {
			if ( 0 === strpos( $key, '_' ) ) {
				continue;
			}
			printf( '<tr><th style="text-align:left;width:160px;">%s</th><td>%s</td></tr>', esc_html( $key ), esc_html( is_array( $value ) ? implode( ', ', $value ) : $value[0] ) );
		}
		echo '</tbody></table>';
	}, 'iqra_submission', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'iqra_submission_meta_box' );

/**
 * Contact form
 */
function iqra_form_redirect( $arg, $value ) {
	$target = wp_get_referer();
	if ( ! $target ) {
		$target = home_url( '/' );
	}
	wp_safe_redirect( add_query_arg( $arg, $value, $target ) );
	exit;
}

function iqra_handle_contact_submit() {
	if ( ! isset( $_POST['iqra_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['iqra_contact_nonce'] ) ), 'iqra_contact_submit' ) ) {
		iqra_form_redirect( 'contact', 'error' );
	}

	$name    = sanitize_text_field( wp_unslash( $_POST['full_name'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	$phone   = sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) );
	$subject = sanitize_text_field( wp_unslash( $_POST['subject'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );

	if ( empty( $name ) || ! is_email( $email ) || empty( $message ) ) {
		iqra_form_redirect( 'contact', 'error' );
	}

	$post_id = wp_insert_post( array(
		'post_type'   => 'iqra_submission',
		'post_status' => 'private',
		'post_title'  => sprintf( 'Contact: %s — %s', $name, $subject ),
	) );
	update_post_meta( $post_id, 'Name', $name );
	update_post_meta( $post_id, 'Email', $email );
	update_post_meta( $post_id, 'Phone', $phone );
	update_post_meta( $post_id, 'Subject', $subject );
	update_post_meta( $post_id, 'Message', $message );

	wp_mail(
		get_option( 'admin_email' ),
		'New Contact Enquiry: ' . $subject,
		"Name: $name\nEmail: $email\nPhone: $phone\n\n$message"
	);

	iqra_form_redirect( 'contact', 'success' );
}
add_action( 'admin_post_iqra_contact_submit', 'iqra_handle_contact_submit' );
add_action( 'admin_post_nopriv_iqra_contact_submit', 'iqra_handle_contact_submit' );

/**
 * Request a Quote form
 */
function iqra_handle_quote_submit() {
	if ( ! isset( $_POST['iqra_quote_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['iqra_quote_nonce'] ) ), 'iqra_quote_submit' ) ) {
		iqra_form_redirect( 'quote', 'error' );
	}

	$name        = sanitize_text_field( wp_unslash( $_POST['full_name'] ?? '' ) );
	$email       = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	$phone       = sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) );
	$type        = sanitize_text_field( wp_unslash( $_POST['project_type'] ?? '' ) );
	$location    = sanitize_text_field( wp_unslash( $_POST['project_location'] ?? '' ) );
	$area        = sanitize_text_field( wp_unslash( $_POST['project_area'] ?? '' ) );
	$budget      = sanitize_text_field( wp_unslash( $_POST['budget'] ?? '' ) );
	$start_date  = sanitize_text_field( wp_unslash( $_POST['start_date'] ?? '' ) );
	$description = sanitize_textarea_field( wp_unslash( $_POST['description'] ?? '' ) );

	if ( empty( $name ) || ! is_email( $email ) || empty( $description ) ) {
		iqra_form_redirect( 'quote', 'error' );
	}

	$file_url = '';
	if ( ! empty( $_FILES['reference_file']['name'] ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		$uploaded = wp_handle_upload( $_FILES['reference_file'], array(
			'test_form' => false,
			'mimes'     => array(
				'jpg|jpeg' => 'image/jpeg',
				'png'      => 'image/png',
				'pdf'      => 'application/pdf',
			),
		) );
		if ( isset( $uploaded['url'] ) ) {
			$file_url = $uploaded['url'];
		}
	}

	$post_id = wp_insert_post( array(
		'post_type'   => 'iqra_submission',
		'post_status' => 'private',
		'post_title'  => sprintf( 'Quote: %s — %s', $name, $type ),
	) );
	update_post_meta( $post_id, 'Name', $name );
	update_post_meta( $post_id, 'Email', $email );
	update_post_meta( $post_id, 'Phone', $phone );
	update_post_meta( $post_id, 'Project Type', $type );
	update_post_meta( $post_id, 'Location', $location );
	update_post_meta( $post_id, 'Approx Area', $area );
	update_post_meta( $post_id, 'Budget', $budget );
	update_post_meta( $post_id, 'Start Date', $start_date );
	update_post_meta( $post_id, 'Description', $description );
	if ( $file_url ) {
		update_post_meta( $post_id, 'Reference File', $file_url );
	}

	wp_mail(
		get_option( 'admin_email' ),
		'New Quote Request: ' . $type,
		"Name: $name\nEmail: $email\nPhone: $phone\nLocation: $location\nArea: $area\nBudget: $budget\nStart date: $start_date\n\n$description" . ( $file_url ? "\n\nReference file: $file_url" : '' )
	);

	iqra_form_redirect( 'quote', 'success' );
}
add_action( 'admin_post_iqra_quote_submit', 'iqra_handle_quote_submit' );
add_action( 'admin_post_nopriv_iqra_quote_submit', 'iqra_handle_quote_submit' );

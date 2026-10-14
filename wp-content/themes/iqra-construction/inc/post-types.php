<?php
/**
 * "Projects" custom post type — how the client adds new project case studies
 * without ever touching a page layout.
 *
 * Rewrite slug is deliberately "project" (singular) so a single project lives
 * at /project/downtown-tower/, while the "Projects" Page created earlier
 * keeps /projects/ for the filterable listing. This avoids the two colliding.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function iqra_register_project_post_type() {
	register_post_type( 'project', array(
		'labels' => array(
			'name'          => 'Projects',
			'singular_name' => 'Project',
			'add_new_item'  => 'Add New Project',
			'edit_item'     => 'Edit Project',
			'all_items'     => 'All Projects',
		),
		'public'       => true,
		'has_archive'  => false,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-hammer',
		'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),		'rewrite'      => array( 'slug' => 'project', 'with_front' => false ),
	) );

	register_taxonomy( 'project_category', 'project', array(
		'labels' => array(
			'name'          => 'Project Categories',
			'singular_name' => 'Project Category',
		),
		'hierarchical'      => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'project-category' ),
	) );
}
add_action( 'init', 'iqra_register_project_post_type' );

function iqra_seed_project_categories() {
	$term_exists = get_terms( array( 'taxonomy' => 'project_category', 'hide_empty' => false ) );
	if ( ! empty( $term_exists ) ) {
		return;
	}
	foreach ( array( 'Residential', 'Commercial', 'Industrial', 'Infrastructure', 'Renovation' ) as $term ) {
		wp_insert_term( $term, 'project_category' );
	}
}
add_action( 'after_switch_theme', 'iqra_seed_project_categories' );

/**
 * Project details meta box: Location, Duration.
 * Hand-coded instead of ACF — keeps the plugin count down since these are
 * only two simple fields.
 */
function iqra_add_project_meta_box() {
	add_meta_box(
		'iqra_project_details',
		'Project Details',
		'iqra_render_project_meta_box',
		'project',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'iqra_add_project_meta_box' );

function iqra_render_project_meta_box( $post ) {
	wp_nonce_field( 'iqra_save_project_meta', 'iqra_project_meta_nonce' );

	$location = get_post_meta( $post->ID, '_iqra_location', true );
	$duration = get_post_meta( $post->ID, '_iqra_duration', true );
	?>
	<p>
		<label for="iqra_location"><strong>Location</strong></label><br>
		<input type="text" id="iqra_location" name="iqra_location" value="<?php echo esc_attr( $location ); ?>" class="widefat" placeholder="e.g. Riverside, City">
	</p>
	<p>
		<label for="iqra_duration"><strong>Duration</strong></label><br>
		<input type="text" id="iqra_duration" name="iqra_duration" value="<?php echo esc_attr( $duration ); ?>" class="widefat" placeholder="e.g. 8 months">
	</p>
	<?php
}

function iqra_save_project_meta( $post_id ) {
	if ( ! isset( $_POST['iqra_project_meta_nonce'] ) || ! wp_verify_nonce( $_POST['iqra_project_meta_nonce'], 'iqra_save_project_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = array( 'iqra_location' => '_iqra_location', 'iqra_duration' => '_iqra_duration' );
	foreach ( $fields as $input_name => $meta_key ) {
		if ( isset( $_POST[ $input_name ] ) ) {
			update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $input_name ] ) ) );
		}
	}
}
add_action( 'save_post_project', 'iqra_save_project_meta' );

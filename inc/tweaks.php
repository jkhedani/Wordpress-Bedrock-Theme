<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package _s
 * @since _s 1.0
 */

//		 HELPER UTILITY FUNCTIONS 		//

function get_current_user_role() {
    global $current_user;
    get_currentuserinfo();
    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);
    return $user_role;
};

//		 END HELPER UTILITY FUNCTIONS 		//

// Load resources and hook in bootstrap
function custom_scripts() {
	$stylesheetDir = get_stylesheet_directory_uri();
	// Bootstrap scripts
	wp_enqueue_style( 'bootstrap-custom-style', "$stylesheetDir/inc/css/style.css" );

	wp_enqueue_script('bootstrap-dropdown', "$stylesheetDir/inc/bootstrap/js/bootstrap-dropdown.js", array(), false, true);
	wp_enqueue_script('bootstrap-popover', "$stylesheetDir/inc/add-ons/js/bootstrap-collapse.js", array(), false, true);
	wp_enqueue_script('bootstrap-tooltip', "$stylesheetDir/inc/bootstrap/js/bootstrap-tooltip.js", array(), false, true);
	wp_enqueue_script('bootstrap-popover', "$stylesheetDir/inc/bootstrap/js/bootstrap-popover.js", array(), false, true);
	wp_enqueue_script('bootstrap-custom-script', "$stylesheetDir/inc/js/scripts.js", array(), false, true);
}
add_action( 'wp_enqueue_scripts', 'custom_scripts' );

// Add additional contact fields
// http://wpquicktips.wordpress.com/2010/06/21/add-or-change-user-contact-fields/
function extend_user_contactmethods() {
	return array(
		'office_hours' => __( 'Office Hours' ),
		'voffice_link' => __( 'V-Office Link')
	);
}
add_filter( 'user_contactmethods', 'extend_user_contactmethods' );

// http://justintadlock.com/archives/2009/09/10/adding-and-using-custom-user-profile-fields
function my_save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	update_usermeta( $user_id, 'office_hours', $_POST['office_hours'] );
	update_usermeta( $user_id, 'voffice_link', $_POST['voffice_link'] );
}
add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );


// Remove unncessary admin menu items
function my_remove_menu_pages() {
	global $userdata;
	remove_menu_page('edit.php'); // "Posts"
	remove_menu_page('link-manager.php'); // "Links"
	
	// Start removing menu items conditionally
	if (get_option('default_comment_status') == 'closed')
		remove_menu_page('edit-comments.php'); // "Comments"

	// Based on user
	// http://codex.wordpress.org/Roles_and_Capabilities
	get_currentuserinfo();
	if ( $userdata->user_level < 2 ) {
		remove_menu_page('plugins.php'); // "Plugins"
		remove_menu_page('users.php'); // "Users"
		remove_menu_page('tools.php'); // "Tools"
		remove_menu_page('options-general.php'); // "Settings"
	}
}
add_action( 'admin_menu', 'my_remove_menu_pages' );

// Theme activated functions
// http://www.krishnakantsharma.com/2011/01/activationdeactivation-hook-for-wordpress-theme/
// On theme activation, do the following...
function myactivationfunction($oldname, $oldtheme=false) {
	
	// Add Instructor User Role
	// http://codex.wordpress.org/Function_Reference/add_role
	add_role('course_instructor', 'Course Instructor', array(
    'read' => true,
    'edit_posts' => true,
    'edit_published_posts' => true,
    'delete_posts' => true,
		'delete_published_posts' => true,
		'publish_posts' => true,
		'read' => true,
		'upload_files' => true
	));

}
add_action("after_switch_theme", "myactivationfunction", 10 ,  2);

// On theme deactivation, do the following...
//function mydeactivationfunction($newname, $newtheme) {
//
//}
//add_action("switch_theme", "mydeactivationfunction", 10 , 2);

// Create custom post types for courses
function course_page_types() {
	$supportedMetaboxes = array('title', 'editor', 'page-attributes');
	
	// "Units"
	$labels = array(
		'name' => __( 'Units' ),
		'singular_name' => __( 'Unit' ),
		'add_new' => __( 'Add New Unit' ),
		'add_new_item' => __( 'Add New Unit' ),
		'edit_name' => __( 'Edit This Unit' ),
		'view_item' => __( 'View This Unit' ),
		'search_items' => __('Search Units'),
		'not_found' => __('No Units found.'),
	);
	register_post_type( 'units',
		array(
		'menu_position' => 5,
		'public' => true,	
		'hierarchical' => true,
		'supports' => $supportedMetaboxes,
		'labels' => $labels,
		)
	);

	// "Modules"
	$labels = array(
		'name' => __( 'Modules' ),
		'singular_name' => __( 'Module' ),
		'add_new' => __( 'Add New Module' ),
		'add_new_item' => __( 'Add New Module' ),
		'edit_name' => __( 'Edit This Module' ),
		'view_item' => __( 'View This Module' ),
		'search_items' => __('Search Modules'),
		'not_found' => __('No Modules found.'),
	);
	register_post_type( 'modules',
		array(
		'menu_position' => 6,
		'public' => true,	
		'hierarchical' => true,
		'supports' => $supportedMetaboxes,
		'labels' => $labels,
		)
	);
	
	// "Lessons"
	$labels = array(
		'name' => __( 'Lessons' ),
		'singular_name' => __( 'Lesson' ),
		'add_new' => __( 'Add New Lesson' ),
		'add_new_item' => __( 'Add New Lesson' ),
		'edit_name' => __( 'Edit This Lesson' ),
		'view_item' => __( 'View This Lesson' ),
		'search_items' => __('Search Lessons'),
		'not_found' => __('No Lessons found.'),
	);
	register_post_type( 'lessons',
		array(
		'menu_position' => 7,
		'public' => true,	
		'hierarchical' => true,
		'supports' => $supportedMetaboxes,
		'labels' => $labels,
		)
	);
}
add_action( 'init', 'course_page_types' );

// Create connection types for course structure
function course_connection_types() {
	// Connect Modules to Units
	p2p_register_connection_type(array(
		'name' => 'units_to_modules',
		'from' => 'units',
		'to' => 'modules',
		'sortable' => 'any',
		'admin_box' => 'any',
		'admin_column' => 'any',
		'cardinality' => 'many-to-many',
		'title' => array( 'from' => __( 'Units', 'my-textdomain' ), 'to' => __( 'Connected Units', 'my-textdomain' ) ),
		'from_labels' => array(
      'singular_name' => __( 'Unit', 'my-textdomain' ),
      'search_items' => __( 'Search Units', 'my-textdomain' ),
      'not_found' => __( 'No Units found.', 'my-textdomain' ),
      'create' => __( 'Connect to a Unit', 'my-textdomain' ),
  	),
		'to_labels' => array(
      'singular_name' => __( 'Module', 'my-textdomain' ),
      'search_items' => __( 'Search Modules', 'my-textdomain' ),
      'not_found' => __( 'No Modules found.', 'my-textdomain' ),
      'create' => __( 'Connect a Module', 'my-textdomain' ),
  	),
	));

	// Connect Lessons to Modules
	p2p_register_connection_type(array(
		'name' => 'modules_to_lessons',
		'from' => 'modules',
		'to' => 'lessons',
		'sortable' => 'any',
		'admin_box' => 'any',
		'admin_column' => 'any',
		'cardinality' => 'many-to-many',
		'title' => array( 'from' => __( 'Connected Lessons', 'my-textdomain' ), 'to' => __( 'Connected Lessons', 'my-textdomain' ) ),
		'from_labels' => array(
      'singular_name' => __( 'Module', 'my-textdomain' ),
      'search_items' => __( 'Search Modules', 'my-textdomain' ),
      'not_found' => __( 'No Modules found.', 'my-textdomain' ),
      'create' => __( 'Connect to a Module', 'my-textdomain' ),
  	),
		'to_labels' => array(
      'singular_name' => __( 'Lesson', 'my-textdomain' ),
      'search_items' => __( 'Search Lessons', 'my-textdomain' ),
      'not_found' => __( 'No Lessons found.', 'my-textdomain' ),
      'create' => __( 'Connect a Lesson', 'my-textdomain' ),
  	),
	));
}
add_action( 'p2p_init', 'course_connection_types' );

// Footer Credits
function addFooterCredits() {
	// Display specific fields for course instructors
	$users = get_users('role=course_instructor');
	if (isset($users)) {
		foreach ($users as $user) {
			$userID = $user->ID;
			echo '<div class="instructor-contact">';
			echo 	get_the_author_meta('first_name',$userID) . ' ';
			echo 	get_the_author_meta('last_name',$userID);
			echo '<span class="sep"> | </span>';
			echo 	get_the_author_meta('user_email',$userID);
			echo '<span class="sep"> | </span>';
			echo 	get_the_author_meta('office_hours',$userID);
			echo '<span class="sep"> | </span>';
			echo '<a href="' .get_the_author_meta('voffice_link',$userID). '">V-Office Link</a>';
			echo '</div>';
		}
	} else {
		
	}
}
add_action('footerCredits','addFooterCredits');

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since _s 1.0
 */
function _s_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', '_s_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since _s 1.0
 */
function _s_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', '_s_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since _s 1.0
 */
function _s_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', '_s_enhanced_image_navigation', 10, 2 );
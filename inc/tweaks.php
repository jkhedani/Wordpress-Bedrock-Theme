<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package _s
 * @since _s 1.0
 */

// Require Course Options
require( get_template_directory() . '/inc/theme-options/course-options.php' );

//		 HELPER UTILITY FUNCTIONS 		//

function get_current_user_role() {
    global $current_user;
    get_currentuserinfo();
    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);
    return $user_role;
};

//		 END HELPER UTILITY FUNCTIONS 		//

// Login page scripts
function login_scripts() {
	$stylesheetDir = get_stylesheet_directory_uri();

	wp_enqueue_style( 'login-custom-style', "$stylesheetDir/inc/css/login-style.css" );
}
add_action('login_head','login_scripts');

// Admin theme scripts
function admin_scripts() {
	$stylesheetDir = get_stylesheet_directory_uri();
	wp_enqueue_style( 'admin-custom-style', "$stylesheetDir/inc/css/admin-style.css" );
	wp_enqueue_script('admin-custom-scripts', "$stylesheetDir/inc/js/admin-scripts.js", array(), false, true); ////// HACK! (just for now)
}
add_action('admin_enqueue_scripts','admin_scripts');

// Dashboard widgets
// http://codex.wordpress.org/Dashboard_Widgets_API
function DCDC_remove_dashboard_widgets() {
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
} 
add_action('wp_dashboard_setup', 'DCDC_remove_dashboard_widgets' );

// Load resources and hook in bootstrap
function custom_scripts() {
	$stylesheetDir = get_stylesheet_directory_uri();
	// Bootstrap scripts
	wp_enqueue_style( 'bootstrap-custom-style', "$stylesheetDir/inc/css/style.css" );
	wp_enqueue_style('open-sans-google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700', array(), false, 'all');

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
		remove_menu_page('tools.php'); // "Tools"
		remove_menu_page('users.php'); // "Users"
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
		'upload_files' => true,
	));

	// Add Instructor User Role
	// http://codex.wordpress.org/Function_Reference/add_role
	add_role('instructional_designer', 'Instructional Designer', array(
    'delete_others_pages' => true,
		'delete_others_posts' => true,
		'delete_pages' => true,
		'delete_posts' => true,
		'delete_private_pages' => true,
		'delete_private_posts' => true,
		'delete_published_pages' => true,
		'delete_published_posts' => true,
		'edit_others_pages' => true,
		'edit_others_posts' => true,
		'edit_pages' => true,
		'edit_posts' => true,
		'edit_private_pages' => true,
		'edit_private_posts' => true,
		'edit_published_pages' => true,
		'edit_published_posts' => true,
		'manage_categories' => true,
		'manage_links' => true,
		'moderate_comments' => true,
		'publish_pages' => true,
		'publish_posts' => true,
		'read' => true,
		'read_private_pages' => true,
		'read_private_posts' => true,
		'upload_files' => true,
		'edit_users' => true,
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
	if (!(get_theme_mod('courses_layout_ia') == 'unitsModulesLessons')) {
		$supportedMetaboxes = array('title', 'editor', 'page-attributes', 'thumbnail');
	} else {
		$supportedMetaboxes = array('title', 'editor', 'thumbnail');
	}
	
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
		'capability_type' => 'page',
		'hierarchical' => true,
		'supports' => array('title', 'editor', 'page-attributes', 'thumbnail'),
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
		'capability_type' => 'page',
		'map_meta_cap' => true, // Needed to be true to make 'capability_type' work
		'hierarchical' => true,
		'supports' => array('title', 'editor', 'thumbnail'),
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
		'capability_type' => 'page',
		'map_meta_cap' => true, // Needed to be true to make 'capability_type' work
		'hierarchical' => true,
		'supports' => array('title', 'editor', 'thumbnail'),
		'labels' => $labels,
		)
	);
}
add_action( 'init', 'course_page_types' );

// Create connection types for course structure
// https://github.com/scribu/wp-posts-to-posts/wiki
function course_connection_types() {

	// Connect Modules to Units
	p2p_register_connection_type(array(
		// Connnection Attributes
		'name' => 'units_to_modules',
		'from' => 'units',
		'to' => 'modules',
		'sortable' => 'any',
		'cardinality' => 'one-to-many', // Module can be connected to only one Unit
		// Display Attributes
		'admin_box' => 'any',
		'admin_column' => 'any',
		'title' => array( 'from' => __( 'Connected Modules', 'my-textdomain' ), 'to' => __( 'Connected Unit', 'my-textdomain' ) ),
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
		// Connnection Attributes
		'name' => 'modules_to_lessons',
		'from' => 'modules',
		'to' => 'lessons',
		'sortable' => 'any',
		'cardinality' => 'one-to-many', // Lesson can be connected to only one Module
		// Display Attributes
		'admin_box' => 'any',
		'admin_column' => 'any',
		'title' => array( 'from' => __( 'Connected Lessons', 'my-textdomain' ), 'to' => __( 'Connected Module', 'my-textdomain' ) ),
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
	$courseAffil = get_theme_mod('courses_branding_college_affil', 'default_value');
	if (get_users('role=course_instructor')) {
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
		echo '<span>We need an instructor for our course! </span><a href="'.site_url().'/wp-admin/users.php">Assign an instructor here.</a>';
	}
	echo '<div class="course-footer-credits">&copy; '.date('Y');
	echo '<span> '; // Yes, there is a space here.
	if ($courseAffil == 'default') {
		echo 'University of Hawai&#699;i';
	} elseif($courseAffil == 'system') {
		echo 'University of Hawai&#699;i System';
	} elseif($courseAffil == 'manoa') {
		echo 'University of Hawai&#699;i at Manoa';
	} elseif($courseAffil == 'hcc') {
		echo 'University of Hawai&#699;i at HCC';
	} elseif($courseAffil == 'kcc') {
		echo 'University of Hawai&#699;i at KCC';
	}
	echo '</span>';

	// course secondary brand

	echo ' | Made by <a href="http://www.hawaii.edu/coe/dcdc/" title="Visit the makers of this course">DCDC</a>';
	echo ' | <a href="#" title="Help us improve the quality of our courses">Rate This Course</a>';
	echo '</div>';
}
add_action('footerCredits','addFooterCredits');

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since _s 1.0
 */
// function _s_page_menu_args( $args ) {
// 	$args['show_home'] = true;
// 	return $args;
// }
// add_filter( 'wp_page_menu_args', '_s_page_menu_args' );

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
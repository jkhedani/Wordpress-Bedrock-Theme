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
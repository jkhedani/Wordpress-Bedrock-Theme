<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package _s
 * @since _s 1.0
 */

// Admin theme scripts
// function admin_scripts() {
// 	$stylesheetDir = get_template_directory_uri();
// 	wp_enqueue_style( 'admin-custom-style', "$stylesheetDir/inc/css/admin-style.css" );
// 	wp_enqueue_script('admin-custom-scripts', "$stylesheetDir/inc/js/admin-scripts.js", array(), false, true); ////// HACK! (just for now)
// }
// add_action('admin_enqueue_scripts','admin_scripts');

// // Dashboard widgets
// // http://codex.wordpress.org/Dashboard_Widgets_API
// function DCDC_remove_dashboard_widgets() {
// 	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
// 	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
// 	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
// 	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
// 	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
// 	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
// 	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
// } 
// add_action('wp_dashboard_setup', 'DCDC_remove_dashboard_widgets' );

// Load resources and hook in bootstrap
function custom_scripts() {
	$stylesheetDir = get_template_directory_uri();
	// Bootstrap scripts
	wp_enqueue_style(	'bootstrap-base-styles', "$stylesheetDir/inc/css/bedrock-bootstrap.css");
	wp_enqueue_style(	'bootstrap-responsive-styles', "$stylesheetDir/inc/css/bedrock-bootstrap-responsive.css");
	wp_enqueue_style( 'bootstrap-parent-style', "$stylesheetDir/inc/css/style.css" );
	wp_enqueue_style( 'open-sans-google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700', array(), false, 'all');

	wp_enqueue_script('bootstrap-dropdown', "$stylesheetDir/inc/bootstrap/js/bootstrap-dropdown.js", array(), false, true);
	wp_enqueue_script('bootstrap-popover', "$stylesheetDir/inc/bootstrap/js/bootstrap-collapse.js", array(), false, true);
	wp_enqueue_script('bootstrap-tooltip', "$stylesheetDir/inc/bootstrap/js/bootstrap-tooltip.js", array(), false, true);
	wp_enqueue_script('bootstrap-popover', "$stylesheetDir/inc/bootstrap/js/bootstrap-popover.js", array(), false, true);
	wp_enqueue_script('bootstrap-alert', "$stylesheetDir/inc/bootstrap/js/bootstrap-alert.js", array(), false, true);
	wp_enqueue_script('bootstrap-custom-script', "$stylesheetDir/inc/js/scripts.js", array(), false, true);
}
add_action( 'wp_enqueue_scripts', 'custom_scripts' );

// Removes automatic <code><html></code> spacing compensating for navbar 
function my_filter_head() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'my_filter_head');

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

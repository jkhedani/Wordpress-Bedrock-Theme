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
	wp_enqueue_script('bootstrap-alert', "$stylesheetDir/inc/add-ons/js/bootstrap-alert.js", array(), false, true);
	wp_enqueue_script('bootstrap-custom-script', "$stylesheetDir/inc/js/scripts.js", array(), false, true);
}
add_action( 'wp_enqueue_scripts', 'custom_scripts' );

// Removes automatic <code><html></code> spacing compensating for navbar 
function my_filter_head() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'my_filter_head');

// Limit excerpt length to prevent overflow on the module list page.
function new_excerpt_length($length) {
	return 20;
}
add_filter('excerpt_length', 'new_excerpt_length');

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
function course_theme_activate_enable_roles($old_name, $old_theme = false) {
	// Declare user roles
	// See: http://codex.wordpress.org/Roles_and_Capabilities
	// See: http://codex.wordpress.org/Function_Reference/add_role

	// Role: Super Admin (default)

	// Role: Admin (default)

	// Role: Editor (default)
	remove_role("editor");

	// Role: Author (default)
	remove_role("author");

	// Role: Contributor (default)
	remove_role("contributor");

	// Role: Subscriber (default)
	remove_role("subscriber");

	// Role: Instructional Designer (based on Editor)
	add_role('instructional_designer', 'Instructional Designer', array(
		// Administrator permissions:
		'create_users' => true,
		'delete_users' => true,
		'edit_users' => true,
		'list_users' => true,
		'remove_users' => true,
		//'promote_users' => true,
		'edit_dashboard' => true,
		'manage_options' => true,
		'edit_theme_options' => true,

		// Editor permissions:
		'moderate_comments' => true,
		'manage_categories' => true,
		'manage_links' => true,
		'edit_others_posts' => true,
		'edit_pages' => true,
		'edit_others_pages' => true,
		'edit_published_pages' => true,
		'publish_pages' => true,
		'delete_pages' => true,
		'delete_others_pages' => true,
		'delete_published_pages' => true,
		'delete_others_posts' => true,
		'delete_private_posts' => true,
		'edit_private_posts' => true,
		'read_private_posts' => true,
		'delete_private_pages' => true,
		'edit_private_pages' => true,
		'read_private_pages' => true,

		// Author permissions:
		'edit_published_posts' => true,
		'upload_files' => true,
		'publish_posts' => true,
		'delete_published_posts' => true,

		// Contributor permissions:
		'edit_posts' => true,
		'delete_posts' => true,

		// Subscriber permissions:
		'read' => true,
	));

	// Role: Instructor (based on Editor)
	add_role('course_instructor', 'Course Instructor', array(
		// Editor permissions:
		'moderate_comments' => true,
		'manage_categories' => true,
		'manage_links' => true,
		'edit_others_posts' => true,
		'edit_pages' => true,
		'edit_others_pages' => true,
		'edit_published_pages' => true,
		'publish_pages' => true,
		'delete_pages' => true,
		'delete_others_pages' => true,
		'delete_published_pages' => true,
		'delete_others_posts' => true,
		'delete_private_posts' => true,
		'edit_private_posts' => true,
		'read_private_posts' => true,
		'delete_private_pages' => true,
		'edit_private_pages' => true,
		'read_private_pages' => true,

		// Author permissions:
		'edit_published_posts' => true,
		'upload_files' => true,
		'publish_posts' => true,
		'delete_published_posts' => true,

		// Contributor permissions:
		'edit_posts' => true,
		'delete_posts' => true,

		// Subscriber permissions:
		'read' => true,
	));

	// Role: Teaching Assistant (based on Subscriber)
	add_role('teaching_assistant', 'Teaching Assistant', array(
		// Subscriber permissions:
		'read' => true,
	));

	// Role: Student (based on Subscriber)
	add_role('student', 'Student', array(
		// Subscriber permissions:
		'read' => true,
	));
}
add_action("after_switch_theme", "course_theme_activate_enable_roles", 10, 2);

// On theme deactivation, do the following...
function course_theme_deactivate_disable_roles($newname, $newtheme) {
	// Role: Editor (default)
	add_role('editor', 'Editor', array(
		// Editor permissions:
		'moderate_comments' => true,
		'manage_categories' => true,
		'manage_links' => true,
		'edit_others_posts' => true,
		'edit_pages' => true,
		'edit_others_pages' => true,
		'edit_published_pages' => true,
		'publish_pages' => true,
		'delete_pages' => true,
		'delete_others_pages' => true,
		'delete_published_pages' => true,
		'delete_others_posts' => true,
		'delete_private_posts' => true,
		'edit_private_posts' => true,
		'read_private_posts' => true,
		'delete_private_pages' => true,
		'edit_private_pages' => true,
		'read_private_pages' => true,

		// Author permissions:
		'edit_published_posts' => true,
		'upload_files' => true,
		'publish_posts' => true,
		'delete_published_posts' => true,

		// Contributor permissions:
		'edit_posts' => true,
		'delete_posts' => true,

		// Subscriber permissions:
		'read' => true,
	));

	// Role: Author (default)
	add_role('author', 'Author', array(
		// Author permissions:
		'edit_published_posts' => true,
		'upload_files' => true,
		'publish_posts' => true,
		'delete_published_posts' => true,

		// Contributor permissions:
		'edit_posts' => true,
		'delete_posts' => true,

		// Subscriber permissions:
		'read' => true,
	));

	// Role: Contributor (default)
	add_role('contributor', 'Contributor', array(
		// Contributor permissions:
		'edit_posts' => true,
		'delete_posts' => true,

		// Subscriber permissions:
		'read' => true,
	));

	// Role: Subscriber (default)
	add_role('subscriber', 'Subscriber', array(
		// Subscriber permissions:
		'read' => true,
	));

	// Role: Instructional Designer (based on Editor)
	remove_role('instructional_designer');

	// Role: Instructor (based on Editor)
	remove_role('course_instructor');

	// Role: Teaching Assistant (based on Subscriber)
	remove_role('teaching_assistant');

	// Role: Student (based on Subscriber)
	remove_role('student');
}
add_action("switch_theme", "course_theme_deactivate_disable_roles", 10 , 2);


// On theme activation, create some default content if it doesn't exist
function course_theme_activate_create_default_content($old_name, $old_theme = false) {
	// List of default pages to create
	$default_pages = array(
		array(
			'name' => "Contact",
			'content' => "<h1>Contact Information</h1><p>Pat Q. Instructor</p><ul><li>Office Hours: MWF 11-12pm</li><li><a href=''>V-Office Link</a></li><li>Email: <a href='mailto:'>pat_q_instructor@hawaii.edu</a></li></ul>",
		),
		array(
			'name' => "Roster",
			'content' => "<h1>Roster</h1><ul><li>Student 1</li><li>Student 2</li><li>Student 3</li></ul>",
		),
	);

	// Create default pages if they don't already exist
	$all_pages = get_pages(array(
		'post_type' => 'page',
		'post_status' => 'publish,private',
	));
	foreach($default_pages as $new_page) {
		$page_exists = false;
		foreach ($all_pages as $page) {
			if ($page->post_title == $new_page['name']) {
				$page_exists = true;
				break;
			}
		}
		if (!$page_exists) {
			wp_insert_post(array(
				'post_title' => $new_page['name'],
				'post_name' => sanitize_title($new_page['name']),
				'post_status' => 'publish',
				'post_type' => 'page',
				'post_content' => $new_page['content'],
			));
		}
	}
}
add_action("after_switch_theme", "course_theme_activate_create_default_content", 10, 2);


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
		'supports' => array('title', 'page-attributes', 'thumbnail', 'revisions'),
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
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
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
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt','revisions'),
		'labels' => $labels,
		)
	);
}
add_action( 'init', 'course_page_types' );




// Create pages to sort the custom post types above via drag-and-drop.
// http://soulsizzle.com/jquery/create-an-ajax-sorter-for-wordpress-custom-post-types/
function course_enable_sort() {
	$sortable_post_types = array(
		'modules',
	);
	foreach ($sortable_post_types as $type) {
		add_submenu_page("edit.php?post_type=$type", "Sort ".ucwords($type), "Sort", "edit_posts", basename(__FILE__), "course_sort_$type");
	}
}
add_action('admin_menu', 'course_enable_sort');

// Display function for each sortable custom post type
// @see $sortable_post_types (one function for each item in array above)
function course_sort_modules() {
	$posts = new WP_Query(array(
		'post_type' => 'modules',
		'posts_per_page' => '-1',
		'orderby' => 'menu_order',
		'order' => 'ASC',
	));
?>
	<div class="wrap">
		<h3>Sort Modules <img src="<?php bloginfo('url'); ?>/wp-admin/images/loading.gif" id="loading-animation" /></h3>
		<ul id="module-list">
		<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
			<li id="<?php the_id(); ?>"><?php the_title(); ?></li>
		<?php endwhile; ?>
	</div><!-- End div#wrap //-->
<?php
}

// Queue admin javascript for sorting custom post types
function course_sortable_scripts() {
	global $pagenow;
	$pages = array("edit.php");
	if (in_array($pagenow, $pages)) {
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('course_sortable', get_bloginfo('template_url').'/inc/js/course_sortable.js');
	}
}
add_action('admin_print_scripts', 'course_sortable_scripts');

// Queue admin css for sorting custom post types
function course_sortable_styles() {
	global $pagenow;
	$pages = array("edit.php");
	if (in_array($pagenow, $pages)) {
		wp_enqueue_style('course_sortable', get_bloginfo('template_url').'/inc/css/course_sortable.css');
	}
}
add_action('admin_print_styles', 'course_sortable_styles');

// Event handler: save new sort order for sortable custom post type
// @todo: use wp_update_post instead of wpdb->update: 
// http://wordpress.stackexchange.com/questions/23012/control-attachments-menu-order-with-jquery-sortable
function course_save_sort_order() {
	global $wpdb;
	$order = explode(',', $_POST['order']);
	$counter = 0;
	foreach ($order as $post_id) {
		$wpdb->update(
			$wpdb->posts, 
			array('menu_order' => $counter),
			array('ID' => $post_id)
		);
		$counter++;
	}
	die(1);
}
add_action('wp_ajax_course_sortable', 'course_save_sort_order');




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

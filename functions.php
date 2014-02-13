<?php
/**
 * _s functions and definitions
 *
 * @package _s
 * @since _s 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since _s 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( '_s_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since _s 1.0
 */
function _s_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	// Admin theme scripts
	function admin_scripts() {
		$stylesheetDir = get_template_directory_uri();
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
		wp_enqueue_style( 'normalize', get_template_directory_uri() . '/inc/css/normalize.css' );
		wp_enqueue_style( 'bedrock-style', get_template_directory_uri() . '/inc/css/style.css', 'normalize' );
	}
	add_action( 'wp_enqueue_scripts', 'custom_scripts' );

	// Removes automatic <code><html></code> spacing compensating for toolbar 
	// NOTE: Leaving this uncommented just in case we rip out the toolbar bar.
	// function my_filter_head() {
	// 	remove_action('wp_head', '_admin_bar_bump_cb');
	// }
	// add_action('get_header', 'my_filter_head');


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
	 * Custom Theme Options
	 */
	//require( get_template_directory() . '/inc/theme-options/theme-options.php' );
	//require( get_template_directory() . '/inc/theme-options/dcdc-theme-options.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on _s, use a find and replace
	 * to change '_s' to the name of your theme in all the template files
	 */
	load_theme_textdomain( '_s', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', ) );

	// NAV MENUS
	// =====================

	// This theme uses one location for nav menus
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', '_s' ),
	) );

	// Needed for class control
	// See http://codex.wordpress.org/Function_Reference/wp_nav_menu#Using_a_Custom_Walker_Function
	// Extends Walker_Nav_Menu from \wp-includes\nav-menu-template.php
	class dcdc_walker_nav_menu extends Walker_Nav_Menu {

		// add classes to ul sub-menus
		function start_lvl( &$output, $depth ) {
			// depth dependent classes
			$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
			$display_depth = ( $depth + 1); // because it counts the first submenu as 0
			$classes = array(
				'sub-menu',
				( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
				( $display_depth >=2 ? 'sub-sub-menu' : '' ),
				'menu-depth-' . $display_depth,
				'dropdown-menu'
			);
			$class_names = implode( ' ', $classes );

			// build html
			$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
		}
  
		// add main/sub classes to li's and links
		function start_el( &$output, $item, $depth, $args ) {
			global $wp_query;
			$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

			// depth dependent classes
			$depth_classes = array(
			  ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
			  ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
			  ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
			  'menu-item-depth-' . $depth
			);
			$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

			// passed classes
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

			// build html
			$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

			// link attributes
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
			$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';
			$attributes .= ' data-toggle="' . ( $depth == 0 ? 'dropdown' : '') . '"'; // Bootstrap: Add data-toggle attribute

			//Bootstrap caret
			$caret = ($depth == 0 ? '<b class="caret"></b>' : '');

			$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
			  $args->before,
			  $attributes,
			  $args->link_before,
			  apply_filters( 'the_title', $item->title, $item->ID ),
			  $caret, // Bootstrap caret
			  $args->link_after,
			  $args->after
			);

			// build html
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	} // class dcdc_walker_nav_menu
} // _s_setup()
endif; // _s_setup
add_action( 'after_setup_theme', '_s_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since _s 1.0
 */
function _s_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', '_s' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', '_s_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function _s_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/inc/js/small-menu.js', array( 'jquery' ), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/inc/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', '_s_scripts' );

/**
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );
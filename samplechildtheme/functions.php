<?php

/**
 * Place any hand-crafted Wordpress
 * Please read the documentation on how to use this file within child theme (README.md)
 */

/**
 * Properly add new script files using this function.
 * http://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts
 */
function diamond_scripts() {
	wp_enqueue_style( 'diamond-style', get_stylesheet_directory_uri().'/css/diamond-style.css', array( 'bootstrap-base-styles' ) );
	// Activate line below for responsive layout
	// Requires: Child theme style, resets, parent theme base style and bootstrap base style
	// to load prior to responsive. Responsive styles should typically be loaded last.
	//wp_enqueue_style( 'diamond-style-responsive', get_stylesheet_directory_uri().'/css/diamond-style-responsive.css', array( 'diamond-style','bootstrap-base-styles' ) );
	wp_enqueue_script('diamond-custom-script', get_stylesheet_directory_uri().'/inc/js/scripts.js', array(), false, true);
}
add_action( 'wp_enqueue_scripts', 'diamond_scripts' );




?>
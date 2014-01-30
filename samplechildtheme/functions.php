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
	$stylesheetDir = get_stylesheet_directory_uri();
	wp_enqueue_style( 'diamond-style', $stylesheetDir . '/inc/css/diamond-style.css', array( 'bedrock-style' ) );
	wp_enqueue_script('diamond-custom-script', $stylesheetDir . '/inc/js/scripts.js', array(), false, true);
}
add_action( 'wp_enqueue_scripts', 'diamond_scripts' );


?>
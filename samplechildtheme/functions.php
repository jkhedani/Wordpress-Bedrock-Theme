<?php

/**
 * Place any hand-crafted Wordpress
 * Please read the documentation on how to use this file within child theme (README.md)
 */

/**
 * Properly add new script files using this function.
 * http://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts
 */
function course_scripts() {
	wp_enqueue_style( 'course-style', get_stylesheet_directory_uri().'/css/course-style.css' );

	wp_enqueue_script('bootstrap-custom-script', get_stylesheet_directory_uri().'/inc/js/scripts.js', array(), false, true);
}
add_action( 'wp_enqueue_scripts', 'course_scripts' );

/**
 * Custom Hook Functions
 *
 * Use these hooks to add/insert functions/content at specific load points within the Wordpress loading process.
 * Inspired by Thematic
 * A list of all hook functions and what templates they are used in:

		dcdc_before()
				dcdc_aboveheader()
				dcdc_belowheader()
				dcdc_mainfirst() 
						dcdc_contentfirst()
						dcdc_abovepostcontent()
								dcdc_postcontentfirst()
								dcdc_postcontentlast()
						dcdc_belowpostcontent()
						dcdc_contentlast()
						dcdc_sidebarfirst()
						dcdc_sidebarlast()
				dcdc_mainlast()
		dcdc_after()

	* Here is an example of how to properly hook into a function:
		
		function nameOfMyNewFunction() {
			// content to output
		}
		add_action('theNameOfTheHookTheContentAboveWillGetLoaded','nameOfMyNewFunction');

*/




?>
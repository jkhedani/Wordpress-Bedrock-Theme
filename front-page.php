<?php
/**
 * The template for displaying the home page of your site
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package _s
 * @since _s 1.0
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<h1><?php echo bloginfo('name'); ?></h1>
			<h2><?php echo bloginfo('description'); ?></h2>
			<p>Welcome to the Bedrock theme!</p>
		
		</div><!-- #content .site-content -->
	</div><!-- #primary .content-area -->

	<?php // get_sidebar(); ?>

<?php get_footer(); ?>
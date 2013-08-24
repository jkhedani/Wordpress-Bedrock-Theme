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
		<div id="primary" class="content-area row">
			<div id="content" class="site-content span8" role="main">
			<h1>Welcome back, Justin!</h1>
			<p>Grab a starter template from <a href="http://getbootstrap.com/2.3.2/getting-started.html#examples" title="Bootstrap 2.3.2 HTML template examples">Bootstrap</a> or start your own!</p>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php //get_template_part( 'templates/content', 'page' ); ?>

				<?php //comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>
			
			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

		<?php // get_sidebar(); ?>

<?php get_footer(); ?>
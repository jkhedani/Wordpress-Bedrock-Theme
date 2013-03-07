<?php
/**
 * The template for displaying all pages.
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

	<div class="row-fluid"><!-- Bootstrap: REQUIRED! -->
		<div id="primary" class="content-area span10">
			<div id="content" class="site-content" role="main">

			<?php bedrock_contentstart(); ?>

			<?php dcdc_get_breadcrumbs(); ?>

			<?php bedrock_abovepostcontent(); ?>
				
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

			<?php bedrock_belowpostcontent(); ?>

			<?php bedrock_contentend(); ?>
			
			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->
		<?php get_sidebar(); ?>
	</div><!-- .row-fluid -->

<?php get_footer(); ?>
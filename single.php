<?php
/**
 * The Template for displaying all single posts.
 *
 * @package _s
 * @since _s 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area row">
		<div id="content" class="site-content span8" role="main">
		
		<?php bedrock_contentstart(); ?>

		<?php bedrock_get_breadcrumbs(); ?>

		<?php bedrock_abovepostcontent(); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'templates/content', 'single' ); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template( '', true );
			?>

		<?php endwhile; // end of the loop. ?>

		<?php
			// "Back To Top" Link
			if(!$post->post_content == "")
				echo '<a id="backToTop" href="" title="Scroll to the top of this page.">Back To Top</a>';
		?>

		<?php bedrock_belowpostcontent(); ?>

		<?php bedrock_contentend(); ?>

		</div><!-- #content .site-content -->
	</div><!-- #primary .content-area -->
	
	<?php get_sidebar(); ?>

<?php get_footer(); ?>
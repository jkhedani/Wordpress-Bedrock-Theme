<?php
/**
 * The Template for displaying all single posts.
 *
 * @package _s
 * @since _s 1.0
 */

get_header(); ?>

	<div class="row-fluid"><!-- Bootstrap: REQUIRED! -->
		<div id="primary" class="content-area span10">
			<div id="content" class="site-content" role="main">
			
			<?php dcdc_contentfirst(); ?>

			<?php dcdc_get_breadcrumbs(); ?>

			<?php dcdc_abovepostcontent(); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?>

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

			<?php dcdc_belowpostcontent(); ?>

			<?php dcdc_contentlast(); ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->
		<?php get_sidebar(); ?>
	</div><!-- .row-fluid -->
	<footer class="entry-meta span10">
		<?php dcdc_get_pager(); ?>
	</footer>

<?php get_footer(); ?>
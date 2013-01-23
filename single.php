<?php
/**
 * The Template for displaying all single posts.
 *
 * @package _s
 * @since _s 1.0
 */

get_header(); ?>
	<!-- <div class="row-fluid"></div> -->
	<div class="row-fluid"><!-- Bootstrap: REQUIRED! -->
		<div id="primary" class="content-area span10">
			<div id="content" class="site-content" role="main">

			<?php dcdc_get_breadcrumbs(); ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template( '', true );
				?>

			<?php endwhile; // end of the loop. ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->
		<?php get_sidebar(); ?>
	</div><!-- .row-fluid -->
	<footer class="entry-meta span10">
		<?php dcdc_get_pager(); ?>
	</footer>

<?php get_footer(); ?>
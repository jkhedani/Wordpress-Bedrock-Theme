<?php
/**
 * The main template file. (also will serve as default 'home')
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 * @since _s 1.0
 */

get_header(); ?>

	<div class="row-fluid"><!-- Bootstrap: REQUIRED! -->
		<?php get_sidebar(); ?>
		<div id="primary" class="content-area span8">
			<div id="content" class="site-content" role="main">

				<?php // DCDC Module List
				$moduleListContent = new WP_Query ( array(
					'post_type' => 'units',
					'order' => 'ASC',
					'orderby' => 'menu_order'
				));
				

				?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->
	</div><!-- .row -->
	
<?php get_footer(); ?>
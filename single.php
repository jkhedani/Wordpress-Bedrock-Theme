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

			<?php while ( have_posts() ) : the_post(); ?>

				<?php dcdc_get_breadcrumbs(); ?>

				<?php

					if(!(get_theme_mod('courses_layout_ia') == 'unitsModulesLessons')) {
						$currentPostType = get_post_type();
						$currentPostID = $post->ID;
						// Count Modules or Lessons
						if ($currentPostType == 'modules') {
							$getUnitConnection = new WP_Query ( array(
								'connected_type' => 'units_to_modules',
								'connected_items' => get_queried_object(),
							));

							while($getUnitConnection->have_posts()) : $getUnitConnection->the_post();
								$i = 0;
								$moduleCount = new WP_Query ( array(
									'connected_type' => 'units_to_modules',
									'connected_items' => $post->ID,
								));

								while($moduleCount->have_posts()) : $moduleCount->the_post();
									$postID = $post->ID;
									if($currentPostID == $postID) {
										echo '<span class="moduleCount">Module ' .$i. '</span>';
									}
									$i++;
								endwhile;
								wp_reset_postdata();

							endwhile;
							wp_reset_postdata();

						} else if ($currentPostType == 'lessons') {
							// if lessons
						}
					} else {
						// If unitsModulesLessons
						$currentPostType = get_post_type();
						$currentPostID = $post->ID;
						// Count Modules or Lessons
						if ($currentPostType == 'modules') {
							$getUnitConnection = new WP_Query ( array(
								'connected_type' => 'units_to_modules',
								'connected_items' => get_queried_object(),
							));

							while($getUnitConnection->have_posts()) : $getUnitConnection->the_post();
								$i = 0;
								$moduleCount = new WP_Query ( array(
									'connected_type' => 'units_to_modules',
									'connected_items' => $post->ID,
								));

								while($moduleCount->have_posts()) : $moduleCount->the_post();
									$postID = $post->ID;
									if($currentPostID == $postID) {
										echo 'Module' . $i;
									}
									$i++;
								endwhile;
								wp_reset_postdata();

							endwhile;
							wp_reset_postdata();

						} else if ($currentPostType == 'lessons') {
							// if lessons
						}
					}

				?>

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
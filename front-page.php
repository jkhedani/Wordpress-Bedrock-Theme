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
		<div id="primary" class="content-area span11">
			<div id="content" class="site-content" role="main">
				<?php // DCDC Module List
				if (get_theme_mod('courses_layout') == 'singular') { // Home Page with Singular Layout (FSHN)
					$moduleListContent = new WP_Query ( array(
						'post_type' => 'modules',
						'order' => 'ASC',
						'orderby' => 'menu_order'
					));
					if ($moduleListContent->have_posts()) {
						echo '<ol class="modules">';
						while ($moduleListContent->have_posts()) : $moduleListContent->the_post();
							echo 	'<li>'.get_the_title().'</li>';
						endwhile;
						echo '</ol>'; // .unitmodule
						wp_reset_postdata();
					} else { // If no required posts for this template exists...
						echo '<div class="span5" id="no-content">';
						echo '<p>It seems you don&#39;t have any Modules published.</p><a href="';
						echo 	admin_url( 'post-new.php?post_type=modules' );
						echo '" title="Go to admin and create a module." class="create-new"><span class="large-icon">+</span><span>Create a new Module</span></a>';
						echo '</div>';
					}

				} elseif (get_theme_mod('courses_layout') == 'nested') { // Home Page with Nested Layout (PEPS)
					echo "Nested Module Option";
					$moduleListContent = new WP_Query ( array(
						'post_type' => 'units',
						'order' => 'ASC',
						'orderby' => 'menu_order'
					));
					p2p_type( 'units_to_modules' )->each_connected( $moduleListContent, array(), 'modules' );
					if ($moduleListContent->have_posts()) {
						while ($moduleListContent->have_posts()) : $moduleListContent->the_post();
							
							p2p_type( 'modules_to_lessons' )->each_connected( $post->modules, array(), 'lessons' );
							$unitTitle = get_the_title();
							echo '<ol class="units"><li>' . $unitTitle;
							echo '<ol class="modules">';
							foreach ( $post->modules as $post ) : setup_postdata( $post );
							$moduleTitle = get_the_title();
							echo		'<li>' . $moduleTitle;
							echo 			'<ol class="lessons">';
							foreach ( $post->lessons as $post ) : setup_postdata( $post );
							$lessonTitle = get_the_title();
							echo 				'<li>' . $lessonTitle . '</li>';
							endforeach; // end Lessons
							echo 			'</ol>'; // .lesson
							endforeach; // end Modules
							echo '</li></ol>'; // .module
							echo '</li></ol>'; // .unit
							wp_reset_postdata();

						endwhile;
						wp_reset_postdata();
					} else { // If no required posts for this template exists...

					} // endif

				} else { // Home Page with Custom Layout
					echo "Custom Option";
				} // endif
				

				?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->
	</div><!-- .row -->
	
<?php get_footer(); ?>
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
				
				p2p_type( 'units_to_modules' )->each_connected( $moduleListContent, array(), 'modules' );
				//$unitName = p2p_type( 'units' )->set_direction( 'to' )->get_connected( $post_id );

				while ($moduleListContent->have_posts()) : $moduleListContent->the_post();
					
					p2p_type( 'modules_to_lessons' )->each_connected( $post->modules, array(), 'lessons' );
					$unitTitle = get_the_title();
					echo '<ol class="unit"><li>' . $unitTitle;
					echo '<ol class="module">';
					foreach ( $post->modules as $post ) : setup_postdata( $post );
					$moduleTitle = get_the_title();
					echo		'<li>' . $moduleTitle;
					echo 			'<ol class="lesson">';
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

				?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->
	</div><!-- .row -->
	
<?php get_footer(); ?>
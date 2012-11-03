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
		<div id="primary" class="content-area span8">
			<div id="content" class="site-content" role="main">

			<?php if ( have_posts() ) : ?>

				<?php _s_content_nav( 'nav-above' );

				// DCDC Module List
				$moduleListContent = new WP_Query ( array(
					'post_type' => 'units',
				));
				
				p2p_type( 'units_to_modules' )->each_connected( $moduleListContent, array(), 'modules' );
				//$unitName = p2p_type( 'units' )->set_direction( 'to' )->get_connected( $post_id );

				while ($moduleListContent->have_posts()) : $moduleListContent->the_post();
					
					p2p_type( 'modules_to_lessons' )->each_connected( $post->modules, array(), 'lessons' );
					$unitTitle = get_the_title();
					echo '<p>Parent Unit:</p>';
						echo $unitTitle;
					echo '<ul>';
					foreach ( $post->modules as $post ) : setup_postdata( $post );
					$moduleTitle = get_the_title();
					echo		'<li>' . $moduleTitle;
					echo 			'<ul>';
					foreach ( $post->lessons as $post ) : setup_postdata( $post );
					$lessonTitle = get_the_title();
					echo 				'<li>' . $lessonTitle . '</li>';
					endforeach; // end Lessons
					echo 			'</ul>';
					endforeach; // end Modules
					echo '</li></ul>';
					wp_reset_postdata();

				endwhile;
				wp_reset_postdata();

				/* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php _s_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php endif; ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->
		<?php get_sidebar(); ?>
	</div><!-- .row -->
	
<?php get_footer(); ?>
<?php
/**
 * The main template file. (also will serve as default 'home')
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 * @since _s 1.0
 */

global $wp_customize;
get_header(); ?>

	<div class="row-fluid"><!-- Bootstrap: REQUIRED! -->
		<?php get_sidebar(); ?>
		<div id="primary" class="content-area span11">
			<div id="content" class="site-content" role="main">
				<?php // DCDC Module List

				// Modules & Lessons with Singular Layout (FSHN)
				if (($isCurrentLayout = (
					get_theme_mod('courses_layout_template') == 'singular' &&
					get_theme_mod('courses_layout_ia') == 'modulesLessons'
					)) || isset($wp_customize)) {

					$moduleListContent = new WP_Query ( array(
						'post_type' => 'modules',
						'order' => 'ASC',
						'orderby' => 'menu_order'
					));
					if ($moduleListContent->have_posts()) {
						$i = 1;
						$isHidden = (!$isCurrentLayout && isset($wp_customize)) ? "hidden" : ""; // For Customize Preview Only: Show/Hide correct layout
						echo "<ol id='singularModulesLessons' class='modules row-fluid $isHidden'>";
						while ($moduleListContent->have_posts()) : $moduleListContent->the_post();
							echo '<li class="module span5"><a href="#" title="Go to this module.">';
							echo 		'<div class="module-count">Module '.$i.'</div>';
							echo 		'<h2 class="module-title">'.get_the_title().'</h2>';
							echo 		'<div class="module-image">';
							if (get_the_post_thumbnail()) {
							echo 			get_the_post_thumbnail();
							} else {
							echo 			'<img src="http://placehold.it/257x128" alt="placeholder" />';
							}
							echo 		'</div>';
							echo 		'<div class="module-content">';
							if (get_the_content()) {
							echo 		'<p>'.get_the_content().'</p>';
							} else {
							echo 		'<p>You don&#39;t have a module blurb yet.</p>';
							} // endif
							echo 		'</div>';
							echo '</a></li>'; //.unit
							$i++;
						endwhile;
						// Add more content item if logged in
						if (is_user_logged_in()) {
						echo 	 '<li class="module span5 last">';
						echo 	 	 '<div id="no-content">';
						echo 	 	 '<p>It seems you don&#39;t have any Modules published.</p><a href="';
						echo 	 	 admin_url( 'post-new.php?post_type=modules' );
						echo 	 	 '" title="Go to admin and create a module." class="create-new"><span class="large-icon">+</span><span>Create a new Module</span></a>';
						echo 	 	 '</div>';
						echo 	 '</li>';
						}
						echo '</ol>'; // .modules
						wp_reset_postdata();
					} else { // If no required posts for this template exists...
						echo '<div class="span5" id="no-content">';
						echo '<p>It seems you don&#39;t have any Modules published.</p><a href="';
						echo 	admin_url( 'post-new.php?post_type=modules' );
						echo '" title="Go to admin and create a module." class="create-new"><span class="large-icon">+</span><span>Create a new Module</span></a>';
						echo '</div>';
					}
				}

				// Modules & Lessons with Nested Layout (PEPS)
				if (($isCurrentLayout = (
					get_theme_mod('courses_layout_template') == 'nested' && 
					get_theme_mod('courses_layout_ia') == 'modulesLessons'
					)) || isset($wp_customize)) {

					$moduleListContent = new WP_Query ( array(
						'post_type' => 'modules',
						'order' => 'ASC',
						'orderby' => 'menu_order'
					));
					p2p_type( 'modules_to_lessons' )->each_connected( $moduleListContent, array(), 'lessons' );
					
					if ($moduleListContent->have_posts()) {
						$i = 1;
						$isHidden = (!$isCurrentLayout && isset($wp_customize)) ? "hidden" : ""; // For Customize Preview Only: Show/Hide correct layout
						echo "<ol id='nestedModulesLessons' class='modules row-fluid $isHidden'>";
						while ($moduleListContent->have_posts()) : $moduleListContent->the_post();
							echo '<li class="module span10">';
							echo 	'<div class="module-count">Module '.$i.'</div>';
							echo 	'<h2 class="module-title">'.get_the_title().'</h2>';
							echo 	'<div class="module-image">'.get_the_post_thumbnail().'</div>';
							echo 	'<div class="module-content">' . get_the_content() . '<hr />';
								if ($post->lessons) {
									foreach ( $post->lessons as $post ) : setup_postdata( $post );
										the_title();
									endforeach;
								} else { // If there are no lessons
									echo '<p><a href="'.admin_url( 'post-new.php?post_type=lessons' ).'" title="Create a lesson in this module.">Create</a> or ';
									echo '<a href="'.admin_url('edit.php?post_type=lessons').'" title="Attach a lesson to this module.">attach</a> a lesson.</p>';
								}
							echo '</div>'; // .module-content 
							echo '</li>'; // .module
							$i++;
						endwhile;
						echo '</ol>'; // .modules
						wp_reset_postdata();
					} else { // If no required posts for this template exists...
						echo '<div class="span10" id="no-content">';
						echo '<p>It seems you don&#39;t have any Modules published.</p><a href="';
						echo 	admin_url( 'post-new.php?post_type=modules' );
						echo '" title="Go to admin and create a module." class="create-new"><span class="large-icon">+</span><span>Create a new Module</span></a>';
						echo '</div>';
					}
				}
				
				// Units, Modules & Lessons (ART)
				if (($isCurrentLayout = (
					get_theme_mod('courses_layout_ia') == 'unitsModulesLessons'
					)) || isset($wp_customize)) {

					$moduleListContent = new WP_Query ( array(
						'post_type' => 'units',
						'order' => 'ASC',
						'orderby' => 'menu_order'
					));

					p2p_type( 'units_to_modules' )->each_connected( $moduleListContent, array(), 'modules' );
					if ($moduleListContent->have_posts()) {
						$i = 1;
						$isHidden = (!$isCurrentLayout && isset($wp_customize)) ? "hidden" : ""; // For Customize Preview Only: Show/Hide correct layout
						echo "<ol id='unitsModulesLessons' class='units row-fluid $isHidden'>";
						while ($moduleListContent->have_posts()) : $moduleListContent->the_post();
							//p2p_type( 'modules_to_lessons' )->each_connected( $post->modules, array(), 'lessons' );
							$unitTitle = get_the_title();
							echo '<li class="unit span15">';
							echo 	'<div class="unit-count">Unit '.$i.'</div>';
							echo 	'<h2 class="unit-title">'.get_the_title().'</h2>';
								if ($post->modules) {
									echo '<ol class="modules">';
									foreach ( $post->modules as $post ) : setup_postdata( $post );
										echo '<li class="module span5"><a href="'.get_permalink().'" title="Go to this module.">';
										echo 	'<div class="module-count">Module '.$i.'</div>';
										echo 	'<h2 class="module-title">'.get_the_title().'</h2>';
										echo 	'<div class="module-image">'.get_the_post_thumbnail().'</div>';
										echo '</a></li>';
										$i++;
									endforeach; // end Modules
									
									// Add more content item
									echo '<li class="module span5">';
									echo 	'<div class="" id="no-content">';
									echo 	'<a href="';
									echo 		admin_url( 'post-new.php?post_type=modules' );
									echo 	'" title="Go to admin and create a module." class="create-new"><span class="large-icon">+</span><span>Create a new Module</span></a>';
									echo 	'</div>';
									echo '</li>';
									echo '</ol>'; // .module
								} else { // If no modules exist...
									echo '<div class="span5" id="no-content">';
									echo '<p>It seems you don&#39;t have any Modules published.</p><a href="';
									echo 	admin_url( 'post-new.php?post_type=modules' );
									echo '" title="Go to admin and create a module." class="create-new"><span class="large-icon">+</span><span>Create a new Module</span></a>';
									echo '</div>';
								}
							echo '</li>'; // .unit
							wp_reset_postdata();
						endwhile;
						echo '</ol>'; // .units
						wp_reset_postdata();
					
					} else { // If no required posts for this template exists...
						echo '<div class="span15" id="no-content">';
						echo 	'<p>It seems you don&#39;t have any Units published.</p><a href="';
						echo 	admin_url( 'post-new.php?post_type=units' );
						echo 	'" title="Go to admin and create a module." class="create-new"><span class="large-icon">+</span><span>Create a new Unit</span></a>';
						echo '</div>';
					} // endif

				}

				// elseif (get_theme_mod('courses_layout_template') == 'custom') { // Home Page with Custom Layout
				// 	echo "Custom Option";

				// 	$moduleListContent = new WP_Query ( array(
				// 		'post_type' => 'units',
				// 		'order' => 'ASC',
				// 		'orderby' => 'menu_order'
				// 	));
				// 	p2p_type( 'units_to_modules' )->each_connected( $moduleListContent, array(), 'modules' );
				// 	if ($moduleListContent->have_posts()) {
				// 		while ($moduleListContent->have_posts()) : $moduleListContent->the_post();
							
				// 			p2p_type( 'modules_to_lessons' )->each_connected( $post->modules, array(), 'lessons' );
				// 			$unitTitle = get_the_title();
				// 			echo '<ol class="units"><li>' . $unitTitle;
				// 			echo '<ol class="modules">';
				// 				foreach ( $post->modules as $post ) : setup_postdata( $post );
				// 				$moduleTitle = get_the_title();
				// 				echo '<li>' . $moduleTitle;
				// 				echo '<ol class="lessons">';
				// 				foreach ( $post->lessons as $post ) : setup_postdata( $post );
				// 				$lessonTitle = get_the_title();
				// 				echo 				'<li>' . $lessonTitle . '</li>';
				// 			endforeach; // end Lessons
				// 			echo 			'</ol>'; // .lesson
				// 			endforeach; // end Modules
				// 			echo '</li></ol>'; // .module
				// 			echo '</li></ol>'; // .unit
				// 			wp_reset_postdata();

				// 		endwhile;
				// 		wp_reset_postdata();
				// 	}
				// } // endif
				
				// Hidden form element for Customizer
				if (isset($wp_customize)) {
					echo '<input type="hidden" id="hiddenLayoutSettings" value="'.get_theme_mod('courses_layout_ia').','.get_theme_mod('courses_layout_template').'"/>';
				}
				?>
			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->
	</div><!-- .row -->
	
<?php get_footer(); ?>
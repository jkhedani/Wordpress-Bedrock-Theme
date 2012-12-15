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
						$moduleCounter = 1;
						$isHidden = (!$isCurrentLayout && isset($wp_customize)) ? "hide" : ""; // For Customize Preview Only: Show/Hide correct layout
						echo "<ol id='singularModulesLessons' class='modules row-fluid $isHidden'>";

						// Banner Module
						echo '<li class="module span5 first">';
						echo  '<div id="inline-intro-banner" class="intro-banner span4" role="complementary">';
						$collegeAffilOption = get_theme_mod('courses_branding_college_affil', 'default_value');
						echo '<div class="college-branding" data-affil="'.$collegeAffilOption.'">';
						switch ($collegeAffilOption) {
							case 'default':
								echo '<img src="'.get_stylesheet_directory_uri().'/inc/images/college-logos.png" alt="University of Hawaii System logo" />';
							break;
							case 'system':
								echo '<img src="'.get_stylesheet_directory_uri().'/inc/images/college-logos.png" alt="University of Hawaii System logo" />';
							break;
							case 'manoa':
								echo '<img src="'.get_stylesheet_directory_uri().'/inc/images/college-logos.png" alt="University of Hawaii Manoa logo" />';
							break;
							case 'hcc':
								echo '<img src="'.get_stylesheet_directory_uri().'/inc/images/college-logos.png" alt="University of Hawaii Honolulu Community College logo" />';
							break;
							case 'kcc':
								echo '<img src="'.get_stylesheet_directory_uri().'/inc/images/college-logos.png" alt="University of Hawaii Kapiolani Community College logo" />';
							break;
						}
						echo '</div>'; // .college-branding
						echo '<div id="intro-banner-content">';
						echo '<span class="welcome">Welcome To</span>';
						echo '<h1>'.get_bloginfo('name').'</h1>';
						//echo '<p>'.get_theme_mod( 'courses_short_desc', 'default_value' ).'</p>';
						//echo '<img src="http://placehold.it/250x275" alt="placeholder" />';
						echo '</div>';
						echo '<div id="alternate-brand"></div>';
						if (is_user_logged_in())
							echo '<a class="edit-post-link" href="'.site_url().'/wp-admin/customize.php" title="Edit the '.get_the_title().' module">Edit this module</a>';
						echo '</div>';
						echo '</li>';


						while ($moduleListContent->have_posts()) : $moduleListContent->the_post();
							echo '<li class="module span5"><a href="'.get_permalink().'" title="Go to this module.">';
							echo 		'<div class="module-count">Module '.$moduleCounter.'</div>';
							echo 		'<h2 class="module-title">'.get_the_title().'</h2>';
							echo 		'<div class="module-image">';
							if (get_the_post_thumbnail()) {
							echo 			get_the_post_thumbnail();
							} else {
							echo 			'<img src="http://placehold.it/300x171" alt="placeholder" />';
							}
							echo 		'</div>';
							echo 		'<div class="module-content">';
							if (get_the_content()) {
							echo 		'<p>'.get_the_content('', true).'</p>';
							} else {
							echo 		'<p>You don&#39;t have a module blurb yet.</p>';
							} // endif
							echo 		'</div>';
							if (is_user_logged_in()) {
								echo '<a class="edit-post-link" href="'.get_edit_post_link().'" title="Edit the '.get_the_title().' module">Edit this module</a>';
							}
							echo '</a></li>'; //.module
							$moduleCounter++;
						endwhile;
						// Add more content item if logged in
						if (is_user_logged_in()) {
						echo 	 '<li class="module span5 last">';
						echo 	 	 '<div class="no-content">';
						echo 	 	 '<p>It seems you don&#39;t have any Modules published.</p><span class="plus">+</span><a class="btn btn-primary" href="';
						echo 	 	 admin_url( 'post-new.php?post_type=modules' );
						echo 	 	 '" title="Go to admin and create a module." class="create-new">Create a new Module</a>';
						echo 	 	 '</div>';
						echo 	 '</li>';
						}
						echo '</ol>'; // .modules
						wp_reset_postdata();
					} else { // If no required posts for this template exists...
						$isHidden = (!$isCurrentLayout && isset($wp_customize)) ? "hide" : ""; // For Customize Preview Only: Show/Hide correct layout
						echo "<div id='singularModulesLessons' class='span5 no-content $isHidden'>";
						echo 	 	 '<p>It seems you don&#39;t have any Modules published.</p><span class="plus">+</span><a class="btn btn-primary" href="';
						echo 	 	 admin_url( 'post-new.php?post_type=modules' );
						echo 	 	 '" title="Go to admin and create a module." class="create-new">Create a new Module</a>';
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
						$moduleCounter = 1;
						$isHidden = (!$isCurrentLayout && isset($wp_customize)) ? "hide" : ""; // For Customize Preview Only: Show/Hide correct layout
						echo "<ol id='nestedModulesLessons' class='modules row-fluid $isHidden'>";
						while ($moduleListContent->have_posts()) : $moduleListContent->the_post();
							echo '<li class="module span10">';
							echo 		'<div class="module-image">';
							if (get_the_post_thumbnail()) {
							echo 			get_the_post_thumbnail();
							} else {
							echo 			'<div class="module-image-placeholder">This image will be a full background image. Minimum dimensions: 568x288</div>';
							}
							echo 		'</div>';
							echo 	'<div class="module-count">Module '.$moduleCounter.'</div>';
							echo 	'<div class="module-content-wrapper">';
							echo 	'<h2 class="module-title">'.get_the_title().'</h2>';
							echo 	'<div class="module-content">';
							if (get_the_content()) {
								echo 		'<p>'.get_the_content('', true).'</p>';
							} else {
								echo 		'<p>You don&#39;t have a module blurb yet.</p>';
							}
							echo 	'<hr />';
								if ($post->lessons) {
									echo '<ol class="lessons">';
									foreach ( $post->lessons as $post ) : setup_postdata( $post );
									echo 	'<li class="lesson">';
									echo 		'<a href="'.get_permalink().'" title="Go to the '.get_the_title().' lesson">' . get_the_title() . '</a>';
									echo 		'<a class="edit-post-link" href="'.get_edit_post_link().'" title="Edit the '.get_the_title().' module">Edit this lesson</a>';
									echo 	'</li>';
									endforeach;
									echo '</ol>'; // end lessons
								} else { // If there are no lessons
									echo '<p><a href="'.admin_url( 'post-new.php?post_type=lessons' ).'" title="Create a lesson in this module.">Create</a> or ';
									echo '<a href="'.admin_url('edit.php?post_type=lessons').'" title="Attach a lesson to this module.">attach</a> a lesson.</p>';
								}
							echo '</div>'; // .module-content 
							echo '</div>'; // .module-content-wrapper
							if (is_user_logged_in()) {
								echo '<a class="edit-post-link" href="'.get_edit_post_link().'" title="Edit the '.get_the_title().' module">Edit this module</a>';
							}
							echo '</li>'; // .module
							$moduleCounter++;
						endwhile;
						if (is_user_logged_in()) {
						echo 	 '<li class="module span10 last">';
						echo 	 	 '<div class="no-content">';
						echo 	 	 '<p>It seems you don&#39;t have any Modules published.</p><span class="plus">+</span><a class="btn btn-primary" href="';
						echo 	 	 admin_url( 'post-new.php?post_type=modules' );
						echo 	 	 '" title="Go to admin and create a module." class="create-new">Create a new Module</a>';
						echo 	 	 '</div>';
						echo 	 '</li>';
						}
						echo '</ol>'; // .modules
						wp_reset_postdata();
					} else { // If no required posts for this template exists...
						$isHidden = (!$isCurrentLayout && isset($wp_customize)) ? "hide" : ""; // For Customize Preview Only: Show/Hide correct layout
						echo "<div id='nestedModulesLessons' class='span10 no-content $isHidden'>";
						echo 	 	 '<p>It seems you don&#39;t have any Modules published.</p><span class="plus">+</span><a class="btn btn-primary" href="';
						echo 	 	 admin_url( 'post-new.php?post_type=modules' );
						echo 	 	 '" title="Go to admin and create a module." class="create-new">Create a new Module</a>';
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
						$unitCounter = 1;
						$moduleCounter = 1;
						$isHidden = (!$isCurrentLayout && isset($wp_customize)) ? "hide" : ""; // For Customize Preview Only: Show/Hide correct layout
						echo "<ol id='unitsModulesLessons' class='units row-fluid $isHidden'>";
						while ($moduleListContent->have_posts()) : $moduleListContent->the_post();
							//p2p_type( 'modules_to_lessons' )->each_connected( $post->modules, array(), 'lessons' );
							$unitTitle = get_the_title();
							echo '<li class="unit span15">';
							echo 	'<div class="unit-title-wrapper">';
							echo 		'<div class="unit-count">Unit '.$unitCounter.'</div>';
							echo 		'<h2 class="unit-title">'.get_the_title().'</h2>';
							echo 	'</div>';
								if ($post->modules) {
									echo '<ol class="modules">';
									foreach ( $post->modules as $post ) : setup_postdata( $post );
										echo '<li class="module span5"><a href="'.get_permalink().'" title="Go to this module.">';
										echo 		'<div class="module-title-wrapper">';
										echo 			'<div class="module-count">Module '.$moduleCounter.'</div>';
										echo 			'<h2 class="module-title">'.get_the_title().'</h2>';
										echo 		'</div>';
										echo 		'<div class="module-image">';
										if (get_the_post_thumbnail()) {
										echo 			get_the_post_thumbnail();
										} else {
										echo 			'<div class="module-image-placeholder">This image will be a full background image. Minimum dimensions: 568x288</div>';
										}
										echo 		'</div>';
										if (is_user_logged_in()) {
											echo '<a class="edit-post-link" href="'.get_edit_post_link().'" title="Edit the '.get_the_title().' module">Edit this module</a>';
										}
										echo '</a></li>';
										$moduleCounter++;
									endforeach; // end Modules
									
									// Add more content item
									if (is_user_logged_in()) {
									echo 	 '<li class="module span5 last">';
									echo 	 	 '<div class="no-content">';
									echo 	 	 '<p>It seems you don&#39;t have any Modules published.</p><span class="plus">+</span><a class="btn btn-primary" href="';
									echo 	 	 admin_url( 'post-new.php?post_type=modules' );
									echo 	 	 '" title="Go to admin and create a module." class="create-new">Create a new Module</a>';
									echo 	 	 '</div>';
									echo 	 '</li>';
									}
									echo '</ol>'; // .module
								} else { // If no modules exist...
									echo '<div class="span5 no-content">';
									echo 	 	 '<p>It seems you don&#39;t have any Modules published.</p><span class="plus">+</span><a class="btn btn-primary" href="';
									echo 	 	 admin_url( 'post-new.php?post_type=modules' );
									echo 	 	 '" title="Go to admin and create a module." class="create-new">Create a new Module</a>';
									echo '</div>';
								}
							echo '</li>'; // .unit
							wp_reset_postdata();
							$unitCounter++;
						endwhile;
						if (is_user_logged_in()) {
							echo '<li class="unit span15 last">';
							echo "<div id='unitsModulesLessons' class='no-content span15 $isHidden'>";
							echo 	 	 '<p>It seems you don&#39;t have any Modules published.</p><span class="plus">+</span><a class="btn btn-primary" href="';
							echo 	 	 admin_url( 'post-new.php?post_type=modules' );
							echo 	 	 '" title="Go to admin and create a module." class="create-new">Create a new Module</a>';
							echo '</div>';
							echo '</li>';
						}
						echo '</ol>'; // .units
						wp_reset_postdata();
					
					} else { // If no required posts for this template exists...
						$isHidden = (!$isCurrentLayout && isset($wp_customize)) ? "hidden" : ""; // For Customize Preview Only: Show/Hide correct layout
						echo "<div id='unitsModulesLessons' class='no-content span15 $isHidden'>";
						echo 	 	 '<p>It seems you don&#39;t have any Modules published.</p><span class="plus">+</span><a class="btn btn-primary" href="';
						echo 	 	 admin_url( 'post-new.php?post_type=modules' );
						echo 	 	 '" title="Go to admin and create a module." class="create-new">Create a new Module</a>';
						echo '</div>';
					} // endif

				}

				// Hidden form element for Customizer
				if (isset($wp_customize)) {
					echo '<input type="hidden" id="hiddenLayoutSettings" value="'.get_theme_mod('courses_layout_ia').','.get_theme_mod('courses_layout_template').'"/>';
				}
				?>
			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->
	</div><!-- .row -->
	
<?php get_footer(); ?>
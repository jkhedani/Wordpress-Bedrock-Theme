<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package _s
 * @since _s 1.0
 */
// Set customize global to check if we are in customize.php
global $wp_customize;
// Home Image URL
$homeImage = get_theme_mod('courses_home_representative_image', 'normal');
// Home Image Options
$homeImageOptions = get_theme_mod('courses_home_representative_image_options','normal');
// College Affiliation Options
$collegeAffilOption = get_theme_mod('courses_branding_college_affil', 'default_value');

?>
	<?php if( is_home() ) {
		echo '<div id="intro-banner" class="intro-banner span4 ';
		if($homeImageOptions == 'fullSidebar'){
			echo 'full-background';
		}
		echo '" role="complementary">';
			echo '<div class="college-branding" data-affil="'.$collegeAffilOption.'">';
			 
  		if(is_user_logged_in() && ! isset( $wp_customize )) {
  			switch ($collegeAffilOption) {
					case 'default':
						echo '<img src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-system-light.png" alt="University of Hawaii System logo" />';
					break;
					case 'system':
						echo '<img src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-system-light.png" alt="University of Hawaii System logo" />';
					break;
					case 'manoa':
						echo '<img src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-manoa-light.png" alt="University of Hawaii Manoa logo" />';
					break;
					case 'hcc':
						echo '<img src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-honolulu-cc-light.png" alt="University of Hawaii Honolulu Community College logo" />';
					break;
					case 'kcc':
						echo '<img src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-kapiolani-cc-light.png" alt="University of Hawaii Kapiolani Community College logo" />';
					break;
				}
  		} else {
  			// For display in course previewer only!
  			if($collegeAffilOption == 'default') {
  				echo '<img data-affil="system" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-system-light.png" alt="University of Hawaii System logo" />';	
  				echo '<img class="hide" data-affil="manoa" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-manoa-light.png" alt="University of Hawaii Manoa logo" />';
  				echo '<img class="hide" data-affil="hcc" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-honolulu-cc-light.png" alt="University of Hawaii Honolulu Community College logo" />';
  				echo '<img class="hide" data-affil="kcc" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-kapiolani-cc-light.png" alt="University of Hawaii Kapiolani Community College logo" />';
  			} elseif ($collegeAffilOption == 'system') {
  				echo '<img data-affil="system" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-system-light.png" alt="University of Hawaii System logo" />';	
  				echo '<img class="hide" data-affil="manoa" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-manoa-light.png" alt="University of Hawaii Manoa logo" />';
  				echo '<img class="hide" data-affil="hcc" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-honolulu-cc-light.png" alt="University of Hawaii Honolulu Community College logo" />';
  				echo '<img class="hide" data-affil="kcc" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-kapiolani-cc-light.png" alt="University of Hawaii Kapiolani Community College logo" />';
  			} elseif ($collegeAffilOption == 'manoa') {
  				echo '<img class="hide" data-affil="system" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-system-light.png" alt="University of Hawaii System logo" />';	
  				echo '<img data-affil="manoa" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-manoa-light.png" alt="University of Hawaii Manoa logo" />';
  				echo '<img class="hide" data-affil="hcc" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-honolulu-cc-light.png" alt="University of Hawaii Honolulu Community College logo" />';
  				echo '<img class="hide" data-affil="kcc" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-kapiolani-cc-light.png" alt="University of Hawaii Kapiolani Community College logo" />';
  			} elseif ($collegeAffilOption == 'hcc') {
  				echo '<img class="hide" data-affil="system" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-system-light.png" alt="University of Hawaii System logo" />';	
  				echo '<img class="hide"data-affil="manoa" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-manoa-light.png" alt="University of Hawaii Manoa logo" />';
  				echo '<img data-affil="hcc" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-honolulu-cc-light.png" alt="University of Hawaii Honolulu Community College logo" />';
  				echo '<img class="hide" data-affil="kcc" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-kapiolani-cc-light.png" alt="University of Hawaii Kapiolani Community College logo" />';
  			} elseif ($collegeAffilOption == 'kcc') {
  				echo '<img class="hide" data-affil="system" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-system-light.png" alt="University of Hawaii System logo" />';	
  				echo '<img class="hide" data-affil="manoa" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-manoa-light.png" alt="University of Hawaii Manoa logo" />';
  				echo '<img class="hide" data-affil="hcc" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-honolulu-cc-light.png" alt="University of Hawaii Honolulu Community College logo" />';
  				echo '<img data-affil="kcc" src="'.get_stylesheet_directory_uri().'/inc/images/logos/uh-kapiolani-cc-light.png" alt="University of Hawaii Kapiolani Community College logo" />';
  			}
  		}

			echo '</div>'; // .college-branding ?>

			<div class="intro-banner-content">
				<span class="welcome">Welcome to</span>
				<h1><?php bloginfo('name'); ?></h1>
				<?php echo '<p>'.get_theme_mod( 'courses_short_desc', 'default_value' ).'</p>'; ?>
				<?php
					if ($homeImageOptions == 'normal') {
						if ($homeImage):
						echo '<img src="'.$homeImage.'" alt="Representative Image for the Home Page" />';
						else:
						echo '<img src="http://placehold.it/260x275" alt="placeholder" />';
						endif;
					}
				?>
			</div>

			<?php // If Full Sidebar Background, load appropriate image
			if($homeImageOptions == 'fullSidebar'){
				if ($homeImage):
				echo '<img class="full-background-image" src="'.$homeImage.'" alt="Representative Image for the Home Page" />';
				else:
				echo '<img class="full-background-image" src="http://placehold.it/300x543" alt="placeholder" />';
				endif;
			} ?>

			<div class="alternate-brand"></div>
			
			<?php if (is_user_logged_in()) { echo '<a class="edit-post-link" href="'.site_url().'/wp-admin/customize.php" title="Edit the '.get_the_title().' module">Edit this module</a>'; } ?>
		</div>
	<?php } else { // End Sidebar for Home Page ?>
		<div id="secondary" class="widget-area span4 offset1" role="complementary">
			<?php do_action( 'before_sidebar' ); ?>
			
			<?php // Module/Lesson Sidebar

			// Module/Lesson Image
			if((get_post_type() == 'modules') || (get_post_type() == 'lessons')) { // Prevent filler image from showing up on basic content pages (e.g. Contact, About, etc.)
				if (get_the_post_thumbnail()) {
					echo get_the_post_thumbnail();
				} else {
					echo '<img src="http://placehold.it/300x171" alt="placeholder" />';
				}
			}

			// Sidebar Menu
			if(get_post_type() == 'modules') {
				echo '<h3 class="sidebar-nav-title">'.get_the_title().'</h3>';
				$sidebarNavContent = new WP_Query ( array(
					'connected_type' => 'modules_to_lessons',
					'connected_items' => get_queried_object(),
				));

				echo '<ol class="lessons">';
				if ($sidebarNavContent->have_posts()) {
					while($sidebarNavContent->have_posts()) : $sidebarNavContent->the_post();
						echo '<li class="lesson"><a class="lesson-link" href="'.get_permalink().'">'.get_the_title().'</a></li>';
					endwhile;
					wp_reset_postdata();
					
				}
				if (is_user_logged_in()) {
					echo '<li class="lesson no-content"><a class="btn btn-primary" href="'.admin_url( 'post-new.php?post_type=lessons' ).'" title="Create a lesson in this module.">Create</a> or ';
					echo '<a class="btn btn-primary" href="'.admin_url('edit.php?post_type=lessons').'" title="Attach a lesson to this module.">attach</a> a lesson.</li>';
				}
				echo '</ol>'; // end lessons

			} elseif (get_post_type() == 'lessons') {

				$currentPostID = $post->ID;
				$sidebarNavContent = new WP_Query ( array(
					'connected_type' => 'modules_to_lessons',
					'connected_items' => get_queried_object(),
					'nopaging' => true,
				));
				if ($sidebarNavContent->have_posts()) {

					while($sidebarNavContent->have_posts()) : $sidebarNavContent->the_post();
						echo '<h3 class="sidebar-nav-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
						$parentID = $post->ID;
						$getConnectedToParent = new WP_Query( array(
							'connected_type' => 'modules_to_lessons',
							'connected_items' => $parentID,
							'nopaging' => true
						));
						if($getConnectedToParent->have_posts()) {
							echo '<ol class="lessons">';
							while($getConnectedToParent->have_posts()) : $getConnectedToParent->the_post();
								$postID = $post->ID;
								echo '<li class="lesson"><a class="lesson-link ';
								if ($currentPostID == $postID) {
									$postType = get_post_type($postID);
									$postTypeObject = get_post_type_object($postType);
									echo 'current'.$postTypeObject->labels->singular_name;
								}
								echo '" href="'.get_permalink().'">'.get_the_title().'</a></li>';
							endwhile;
							wp_reset_postdata();
							echo '</ol>';
						}
					endwhile;
					wp_reset_postdata();
				 // end lessons
				}
			}


			//if ( ! dynamic_sidebar( 'sidebar-1' ) ) :

			// 	echo '<aside id="search" class="widget widget_search">';
			// 	get_search_form();
			// 	echo '</aside>';

			// 	echo '<aside id="archives" class="widget">';
			// 		echo '<h1 class="widget-title">'. _e( 'Archives', '_s' ).'</h1>';
			// 		echo '<ul>';
			// 			wp_get_archives( array( 'type' => 'monthly' ) );
			// 		echo '</ul>';
			// 	echo '</aside>';

			// 	echo '<aside id="meta" class="widget">';
			// 		echo '<h1 class="widget-title">'. _e( 'Meta', '_s' ) .'</h1>';
			// 		echo '<ul>';
			// 			wp_register();
			// 			echo '<li>'. wp_loginout() .'</li>';
			// 			wp_meta();
			// 		echo '</ul>';
			// 	echo '</aside>';

			// endif; // end sidebar widget area
			?>
		</div><!-- #secondary .widget-area -->
	<?php } // end is_home() ?>
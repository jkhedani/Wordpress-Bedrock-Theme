<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package _s
 * @since _s 1.0
 */
?>
	<?php if( is_home() ) { ?>
		<div id="intro-banner" class="intro-banner span4" role="complementary">
			<?php
				echo '<div class="college-branding ';
				echo get_theme_mod('courses_branding_college_affil', 'default_value') . ' ';
				echo '"></div>';
			?>
			<div class="intro-banner-content">
				<span class="welcome">Welcome To</span>
				<h1><?php bloginfo('name'); ?></h1>
				<?php echo '<p>'.get_theme_mod( 'courses_short_desc', 'default_value' ).'</p>'; ?>
				<?php echo '<img src="http://placehold.it/250x275" alt="placeholder" />'; ?>
			</div>
			<div class="alternate-brand"></div>
			<?php if (is_user_logged_in()) { echo '<a class="edit-post-link" href="'.site_url().'/wp-admin/customize.php" title="Edit the '.get_the_title().' module">Edit this module</a>'; } ?>
		</div>
	<?php } else { ?>
		<div id="secondary" class="widget-area span5" role="complementary">
			<?php do_action( 'before_sidebar' ); ?>
			
			<?php // Module/Lesson Sidebar
			
			// Breadcrumbs
			echo '<div class="breadcrumbs">';
			echo 	'<ol>';
			echo 	'<li><a href="'.get_home_url().'"></a>';
			echo 	'</ol>';
			echo '</div>';

			// Module/Lesson Image
			if (get_the_post_thumbnail()) {
				echo get_the_post_thumbnail();
			} else {
				echo '<img src="http://placehold.it/257x128" alt="placeholder" />';
			}
			
			echo '<hr />';

			if(!(get_theme_mod('courses_layout_ia') == 'unitsModulesLessons')) {

				if(get_post_type() == 'modules') {
					echo '<h3>'.get_the_title().'</h3>';
					$sidebarNavContent = new WP_Query ( array(
						'connected_type' => 'modules_to_lessons',
						'connected_items' => get_queried_object_id(),
					));

					if ($sidebarNavContent->have_posts()) {
						echo '<ol class="lessons">';
						while($sidebarNavContent->have_posts()) : $sidebarNavContent->the_post();
							echo '<li class="lesson"><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
						endwhile;
						echo '</ol>'; // end lessons
					} else { // If there are no lessons
						echo '<p><a href="'.admin_url( 'post-new.php?post_type=lessons' ).'" title="Create a lesson in this module.">Create</a> or ';
						echo '<a href="'.admin_url('edit.php?post_type=lessons').'" title="Attach a lesson to this module.">attach</a> a lesson.</p>';
					}
				} elseif (get_post_type() == 'lessons') {
					$currentPostID = $post->ID;
					$sidebarNavContent = new WP_Query ( array(
						'connected_type' => 'modules_to_lessons',
						'connected_items' => get_queried_object(),
						'nopaging' => true,
					));
					if ($sidebarNavContent->have_posts()) {

						while($sidebarNavContent->have_posts()) : $sidebarNavContent->the_post();
							echo '<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
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
									echo '<li class="lesson"><a ';
									if ($currentPostID == $postID) {
										$postType = get_post_type($postID);
										$postTypeObject = get_post_type_object($postType);
										echo 'class="current'.$postTypeObject->labels->singular_name.'"';
									}
									echo ' href="'.get_permalink().'">'.get_the_title().'</a></li>';
								endwhile;
								wp_reset_postdata();
								echo '</ol>';
							}
						endwhile;
						wp_reset_postdata();
					 // end lessons
					}
				}
			} else {
				// Units, Modules & Lessons call
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
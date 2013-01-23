<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package _s
 * @since _s 1.0
 */

if ( ! function_exists( '_s_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since _s 1.0
 */
function _s_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';

	?>
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', '_s' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', '_s' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', '_s' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', '_s' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', '_s' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // _s_content_nav

if ( ! function_exists( '_s_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since _s 1.0
 */
function _s_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', '_s' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', '_s' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', '_s' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', '_s' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', '_s' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( '(Edit)', '_s' ), ' ' );
					?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for _s_comment()

if ( ! function_exists( '_s_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since _s 1.0
 */
function _s_posted_on() {
	printf( __( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> by <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', '_s' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', '_s' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category
 *
 * @since _s 1.0
 */
function _s_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so _s_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so _s_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in _s_categorized_blog
 *
 * @since _s 1.0
 */
function _s_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', '_s_category_transient_flusher' );
add_action( 'save_post', '_s_category_transient_flusher' );


if ( ! function_exists( 'dcdc_get_pager') ) :
/**
 * Prints an HTML pager based on p2p connections.
 */
function dcdc_get_pager() {
	global $wp_query, $post;
	$currentPageID = $post->ID;
	if((get_post_type() == 'lessons')) {
		$p2pConnectedParent = new WP_Query ( array(
			'connected_type' => 'modules_to_lessons',
			'connected_items' => get_queried_object(),
			'nopaging' => true,
		));
		if ($p2pConnectedParent->have_posts()) {
			while($p2pConnectedParent->have_posts()) : $p2pConnectedParent->the_post();
			echo '<ol class="pager">';
				echo '<li class="previous"><a href="' . get_permalink() . '">&larr; Module: ' . get_the_title() . '</a></li>';
				$p2pConnectedParentsChildren = new WP_Query( array(
					'connected_type' => 'modules_to_lessons',
					'connected_items' => $post->ID,
					'nopaging' => true,
				));
				if($p2pConnectedParentsChildren->have_posts()) {
					
					
					$lastChildPageID = -1;
					$thisChildPageID = -1;
					while($p2pConnectedParentsChildren->have_posts()) : $p2pConnectedParentsChildren->the_post();
						$thisChildPageID = $post->ID;
						if ($thisChildPageID == $currentPageID && $lastChildPageID >= 0) {
							echo '<li class="previous"><a href="' . get_permalink($lastChildPageID) . '">&larr; ' . get_the_title($lastChildPageID) . '</a></li>';
						} else if ($lastChildPageID == $currentPageID) {
							echo '<li class="next"><a href="' . get_permalink($thisChildPageID) . '">' . get_the_title($thisChildPageID) . ' &rarr;</a></li>';
						}
						$lastChildPageID = $post->ID;
					endwhile;
					wp_reset_postdata();
					
					echo '</ol>';
				}
			endwhile;
			wp_reset_postdata();
		}
	} elseif((get_post_type() == 'modules')) {
		$i = 0;
		$p2pConnectedParent = new WP_Query ( array(
			'connected_type' => 'modules_to_lessons',
			'connected_items' => get_queried_object_id(),
			'nopaging' => true,
		));
		echo 	'<ol class="pager">';
		while($p2pConnectedParent->have_posts()) : $p2pConnectedParent->the_post();
			// Only spit out the first 'child' connection
			if ($i == 0) {
				echo '<li class="next"><a href="'.get_permalink().'">Start '.get_the_title().' &rarr;</a></li>';
			}
			$i++;
		endwhile;
		echo 	'</ol>';
		wp_reset_postdata();
	}
}
endif;

/**
 * Prints breadcrumbs based on p2p connections.
 */
if ( ! function_exists( 'dcdc_get_breadcrumbs') ) :
function dcdc_get_breadcrumbs() {
	global $wp_query, $post;
	$currentPostType = get_post_type();
	echo '<ul class="breadcrumb">';
	echo 	'<li><a href="'.get_home_url().'">Home</a> <span class="divider">/</span></li>';
	if ($currentPostType == 'units') {
		echo '<li class="active">'.get_the_title().'</li>';														// Unit Page Breadcrumb
	} else if ($currentPostType == 'modules') {
		
		if(get_theme_mod('courses_layout_ia') == 'unitsModulesLessons') {							// Only Show Unit Page in Breadcrumb if unitsModulesLessons are selected
			$getUnitConnection = new WP_Query ( array(
				'connected_type' => 'units_to_modules',
				'connected_items' => get_queried_object(),
			));
			while ($getUnitConnection->have_posts()) : $getUnitConnection->the_post();
				echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a> <span class="divider">/</span></li>'; 	// Module Page Breadcrumb
			endwhile;
			wp_reset_postdata();
		}
		echo '<li class="active">'.get_the_title().'</li>';

	// Lesson Page Breadcrumb
	} else if ($currentPostType == 'lessons') {
		$getModuleConnection = new WP_Query ( array(
			'connected_type' => 'modules_to_lessons',
			'connected_items' => $post->ID,
		));
		while ($getModuleConnection->have_posts()) : $getModuleConnection->the_post();
			$currentModuleTitle = get_the_title();
			$currentModulePermalink = get_permalink();
			// Only Show Unit Page in Breadcrumb if unitsModulesLessons are selected
			if(get_theme_mod('courses_layout_ia') == 'unitsModulesLessons') {
				$getNewUnitConnection = new WP_Query ( array(
					'connected_type' => 'units_to_modules',
					'connected_items' => $post->ID,
					'nopaging' => true
				));			
				while ($getNewUnitConnection->have_posts()) : $getNewUnitConnection->the_post();
					echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a> <span class="divider">/</span></li>';
				endwhile;
				wp_reset_postdata();
			}
			echo '<li><a href="'.$currentModulePermalink.'">'.$currentModuleTitle .'</a> <span class="divider">/</span></li>';
		endwhile;
		wp_reset_postdata();
		
		// Lesson module
		echo '<li class="active">'.get_the_title().'</li>';

	}
	echo '</ul>'; // .breadcrumbs
}
endif;

if ( ! function_exists( 'dcdc_footer_credits') ) :
/**
 * Footer Credits
 */
function dcdc_footer_credits() {
	// Display specific fields for course instructors
	$users = get_users('role=course_instructor');
	$courseAffil = get_theme_mod('courses_branding_college_affil', 'default_value');
	if (get_users('role=course_instructor')) {
		foreach ($users as $user) {
			$userID = $user->ID;
			echo '<div class="instructor-contact">';
			echo 	get_the_author_meta('first_name',$userID) . ' ';
			echo 	get_the_author_meta('last_name',$userID);
			echo '<span class="sep"> | </span>';
			echo '<a href="mailto:'.get_the_author_meta('user_email',$userID).'?Subject=Hello%20Professor" title="Send an email to your instructor">'.get_the_author_meta('user_email',$userID).'</a>';
			echo '<span class="sep"> | </span>';
			echo 	get_the_author_meta('office_hours',$userID);
			echo '<span class="sep"> | </span>';
			echo '<a href="' .get_the_author_meta('voffice_link',$userID). '">V-Office Link</a>';
			echo '</div>';
		}
	} else {
		echo '<span>We need an instructor for our course! </span><a href="'.site_url().'/wp-admin/users.php">Assign an instructor here.</a>';
	}
	echo '<div class="course-footer-credits">&copy; '.date('Y');
	echo '<span> '; // Yes, there is a space here.
	if ($courseAffil == 'default') {
		echo 'University of Hawai&#699;i';
	} elseif($courseAffil == 'system') {
		echo 'University of Hawai&#699;i System';
	} elseif($courseAffil == 'manoa') {
		echo 'University of Hawai&#699;i at Manoa';
	} elseif($courseAffil == 'hcc') {
		echo 'University of Hawai&#699;i at HCC';
	} elseif($courseAffil == 'kcc') {
		echo 'University of Hawai&#699;i at KCC';
	}
	echo '</span>';

	// course secondary brand
	echo ' | Made by <a href="http://www.hawaii.edu/coe/dcdc/" title="Visit the makers of this course">DCDC</a>';
	echo ' | <a href="#" title="Help us improve the quality of our courses">Rate This Course</a>';
	echo '</div>';
}
endif;

if ( ! function_exists( 'dcdc_get_module_count') ) :
	/**
	 * Module Count
	 */
	function dcdc_get_module_count() {
		if(!(get_theme_mod('courses_layout_ia') == 'unitsModulesLessons')) {
			global $post;
			$menuOrder = $post->menu_order;
			echo '<span class="moduleCount">Module ' .++$menuOrder. '</span>'; // Increment needed as menu_order starts at 0

		} elseif (get_theme_mod('courses_layout_ia') == 'unitsModulesLessons') { 					// If unitsModulesLessons
			global $post;
			$currentPostType = get_post_type();

			if ($currentPostType == 'modules'):
				$currentPostID = $post->ID;
				$getUnits = new WP_Query ( array(																							// Query all the units from first to last
					'post_type' => 'units',
					'order' => 'ASC',
					'orderby' => 'menu_order'
				));
				p2p_type( 'units_to_modules' )->each_connected( $getUnits, array(), 'modules' );
				$moduleCount = 1;
				while ($getUnits->have_posts()) : $getUnits->the_post();																	
					foreach ( $post->modules as $post ) : setup_postdata( $post );							// Get all Modules connected to said units
					if ($currentPostID == $post->ID):
						echo '<span class="moduleCount">Module ' .$moduleCount. '</span>';				// When iteration lands on current module, print $i
					endif;
					$moduleCount++;
					endforeach;
					endwhile;
				wp_reset_postdata();
			elseif ($currentPostType == 'lessons'):	
				$currentPostID = $post->ID;
				$getCurrentLesson = new WP_Query ( array( 																		// Query connected module (there can be only one!)
					'post_type' => 'lessons',
					'connected_type' => 'modules_to_lessons',
	  			'connected_items' => get_queried_object(),
				));
				while ($getCurrentLesson->have_posts()) : $getCurrentLesson->the_post();
					$parentModuleID = $post->ID;																								// Set connected module's ID as the "parent" ID
				endwhile;
				wp_reset_postdata();

				$getUnits = new WP_Query ( array(																							// Query all the units from first to last
					'post_type' => 'units',
					'order' => 'ASC',
					'orderby' => 'menu_order'
				));
				p2p_type( 'units_to_modules' )->each_connected( $getUnits, array(), 'modules' );
				$moduleCount = 1;																															// Start our module count at one
				while ($getUnits->have_posts()) : $getUnits->the_post();
					if ($post->modules):																												// Get all Modules connected to said units
						foreach ( $post->modules as $post ) : setup_postdata( $post );								
							if ($parentModuleID == $post->ID):																			// If module is current parent Module
							echo '<span class="moduleCount">Module ' .$moduleCount. '</span>';			// GET MODULE COUNT
							$lessonCount = 1;																												// Now that the query is on the "parent" post
							$getLessons = new WP_Query ( array( 																		// Query all lessons associated with this (the parent Module)
								'post_type' => 'modules',
								'page_id' => $post->ID, 
							));
							p2p_type( 'modules_to_lessons' )->each_connected( $getLessons, array(), 'lessons' );
							while ($getLessons->have_posts()) : $getLessons->the_post();
								foreach ( $post->lessons as $post ) : setup_postdata( $post );				// Iterate through all lessons of the parent Module
								if($currentPostID == $post->ID):
								echo '<span class="lessonCount">Lesson ' .$lessonCount. '</span>';		// GET LESSON COUNT
								endif;
								$lessonCount++;
								endforeach;
							endwhile;
							wp_reset_postdata();
							endif; // current post module
							$moduleCount++;
						endforeach;
					endif; // $post->modules
				endwhile;
				wp_reset_postdata();
			endif; // currentPostType lessons/modules
		} // If unitsModulesLessons
	} // dcdc_get_module_count());
endif; // Function exists
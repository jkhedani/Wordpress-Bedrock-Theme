<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package _s
 * @since _s 1.0
 */
?>
	<?php if( is_home() ) { ?>
		<div id="intro-banner" class="<?php echo get_theme_mod('courses_branding_tint', 'default_value'); ?> span4" role="complementary">
			<?php
				echo '<div id="college-branding" class="';
				echo get_theme_mod('courses_branding_college_affil', 'default_value') . ' ';
				echo get_theme_mod('courses_branding_tint', 'default_value');
				echo '"></div>';
			?>
			<div id="intro-banner-content">
				<span class="welcome">Welcome To</span>
				<h1><?php bloginfo('name'); ?></h1>
				<?php echo '<p>'.get_theme_mod( 'courses_short_desc', 'default_value' ).'</p>'; ?>
			</div>
			<div id="alternate-brand"></div>
		</div>
	<?php } else { ?>
		<div id="secondary" class="widget-area span4" role="complementary">
			<?php do_action( 'before_sidebar' ); ?>
			<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

				<aside id="search" class="widget widget_search">
					<?php get_search_form(); ?>
				</aside>

				<aside id="archives" class="widget">
					<h1 class="widget-title"><?php _e( 'Archives', '_s' ); ?></h1>
					<ul>
						<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
					</ul>
				</aside>

				<aside id="meta" class="widget">
					<h1 class="widget-title"><?php _e( 'Meta', '_s' ); ?></h1>
					<ul>
						<?php wp_register(); ?>
						<li><?php wp_loginout(); ?></li>
						<?php wp_meta(); ?>
					</ul>
				</aside>

			<?php endif; // end sidebar widget area ?>
		</div><!-- #secondary .widget-area -->
	<?php } // end is_home() ?>
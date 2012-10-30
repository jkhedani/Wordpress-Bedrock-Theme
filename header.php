<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package _s
 * @since _s 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', '_s' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/inc/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>

	<header id="navbar" class="navbar navbar-inverse navbar-fixed-top">
  	<div class="navbar-inner">
    	<div class="container">
    		<!-- Bootstrap: Collapses to form mobile toggle menu -->
      	<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        	<span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <h1 class="site-title brand"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
        <h2 class="site-description description"><?php bloginfo( 'description' ); ?></h2>
        <nav class="nav-collapse collapse pull-left">
        	<h1 class="assistive-text"><?php _e( 'Menu', '_s' ); ?></h1>
					<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', '_s' ); ?>"><?php _e( 'Skip to content', '_s' ); ?></a></div>
        	<?php wp_nav_menu( array(
        		'theme_location' => 'primary', // Uses menu called 'Primary Menu'. If not defaults to use function 'wp_page_menu'
        		'container' => false,
        		'items_wrap' => '<ul role="navigation" id="%1$s" class="%2$s nav">%3$s</ul>',
        		'fallback_cb' => false
        	));?>
      	</nav><!--/.nav-collapse -->
    	</div><!-- .container -->
  	</div><!-- .navbar-inner -->
  </header>

	<div id="main" role="main" class="site-main container">
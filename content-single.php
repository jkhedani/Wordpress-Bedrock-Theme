<?php
/**
 * @package _s
 * @since _s 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php dcdc_postcontentstart(); ?>

	<header class="entry-header">
		<?php dcdc_get_module_count(); ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<hr />
		<div class="entry-meta">
			<?php //_s_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		if($post->post_content=="") {
			echo '<p class="muted helper-text">You currently have no content. Add some <a href="'.get_edit_post_link().'" title="Edit this piece of content">here.</a></p>';
		} else {
			the_content();
		}
		?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', '_s' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<?php
	//echo '<footer class="entry-meta">';
		
			/* translators: used between list items, there is a space after the comma */
			// $category_list = get_the_category_list( __( ', ', '_s' ) );

			// /* translators: used between list items, there is a space after the comma */
			// $tag_list = get_the_tag_list( '', ', ' );

			// if ( ! _s_categorized_blog() ) {
			// 	// This blog only has 1 category so we just need to worry about tags in the meta text
			// 	if ( '' != $tag_list ) {
			// 		$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', '_s' );
			// 	} else {
			// 		$meta_text = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', '_s' );
			// 	}

			// } else {
			// 	// But this blog has loads of categories so we should probably display them here
			// 	if ( '' != $tag_list ) {
			// 		$meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', '_s' );
			// 	} else {
			// 		$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', '_s' );
			// 	}

			// } // end check for categories on this blog

			// printf(
			// 	$meta_text,
			// 	$category_list,
			// 	$tag_list,
			// 	get_permalink(),
			// 	the_title_attribute( 'echo=0' )
			// );
			
			//edit_post_link( __( 'Edit', '_s' ), '<span class="edit-link">', '</span>' );
	//echo '</footer>';// .entry-meta ?>

	<?php dcdc_postcontentend(); ?>

</article><!-- #post-<?php the_ID(); ?> -->
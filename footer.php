<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package _s
 * @since _s 1.0
 */
?>

		</div><!-- #main .site-main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
			<div class="site-info">
				<p>&copy; <?php echo get_the_date('Y'); ?></p>
			</div><!-- .site-info -->
		</div><!-- .container -->
	</footer><!-- #colophon .site-footer -->

	</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

</body>
</html>
<?php
/**
 * Theme Footer
 *
 * Contains the closing of the container tags, copyright message, and
 * footer JavaScripts.
 *
 * @package   gwen
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

?>

</div><!-- #primary -->

<?php get_sidebar(); ?>

</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
	<?php do_action( 'gwen/footer' ); ?>

	<div class="site-info">
		<?php
		/*
		 * Display the copyright message.
		 */
		?>
		<span id="gwen-copyright"><?php echo gwen_get_copyright_message(); ?></span>

		<span id="gwen-credits">
			<?php
			printf(
				'<a href="' . esc_url( gwen_theme_credit_url() ) . '" target="_blank" rel="nofollow">%1$s</a>',
				__( 'Gwen Theme', 'gwen' )
			);

			do_action( 'gwen/footer/attribution' ); ?>
		</span>
	</div>
</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>
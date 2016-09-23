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

<?php
if ( get_page_template_slug() != 'page-layouts/full-width.php' ) {
	get_sidebar();
}
?>

</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
	<?php do_action( 'gwen/footer/before-site-info' ); ?>

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
				'<a href="' . esc_url( 'https://github.com/nosegraze/gwen' ) . '" target="_blank" rel="nofollow">%1$s</a> | <a href="http://thelovelydesign.co/" target="_blank" rel="nofollow">%2$s</a>',
				__( 'Gwen Theme', 'gwen' ),
				__( 'Design by The Lovely Design Co,', 'sylvia' )
			);

			do_action( 'gwen/footer/attribution' ); ?>
		</span>
	</div>
</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>
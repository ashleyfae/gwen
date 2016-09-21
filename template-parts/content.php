<?php
/**
 * Template part for displaying post content.
 *
 * @package   gwen
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php gwen_posted_on(); ?>
			</div>
			<?php
		endif; ?>
	</header>

	<div class="entry-content">
		<?php
		if ( is_singular() || get_theme_mod( 'excerpt_type', 'automatic' ) == 'manual' ) {
			gwen_featured_image();

			the_content( false );
		} else {
			the_excerpt();
		}

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'gwen' ),
			'after'  => '</div>',
		) );
		?>
	</div>

	<?php gwen_entry_footer(); ?>

</article>

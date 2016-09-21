<?php
/**
 * Template Tags
 *
 * Functions used within the various template files to display parts
 * of the theme.
 *
 * @package   gwen
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

/**
 * Display the Primary Menu
 *
 * @since 1.0
 * @return void
 */
function gwen_navigation() {
	wp_nav_menu( array(
		'container'      => false,
		'theme_location' => 'primary',
		'menu_id'        => 'primary-menu'
	) );
}

/**
 * Post Meta
 *
 * Prints the date of the blog post.
 *
 * @since 1.0
 * @return void
 */
function gwen_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$categories = get_the_category_list( ', ' );
	?>
	<span class="posted-on"><a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php echo $time_string; ?></a></span>

	<?php if ( $categories ) : ?>
		<span class="posted-in"><?php _e( 'in', 'gwen' ); ?></span>
		<span class="entry-categories"><?php echo $categories; ?></span>
	<?php endif;
}

/**
 * Maybe Display Featured Image
 *
 * @since 1.0
 * @return void
 */
function gwen_featured_image() {
	if ( ( get_theme_mod( 'auto_add_featured', true ) || is_customize_preview() ) && has_post_thumbnail() ) {
		?>
		<div class="featured-image"<?php echo ( ! get_theme_mod( 'auto_add_featured', true ) ) ? ' style="display: none;"' : ''; ?>>
			<?php the_post_thumbnail( 'large' ); ?>
		</div>
		<?php
	}
}

/**
 * Post Footer
 *
 * Displays share icons (if Naked Social Share is activated) and
 * either "Continue Reading" button (archives) or post tags (single
 * post pages).
 *
 * @since 1.0
 * @return void
 */
function gwen_entry_footer() {
	if ( get_post_type() != 'post' ) {
		return;
	}

	?>
	<footer class="entry-footer<?php echo function_exists( 'naked_social_share_buttons' ) ? ' nss-enabled' : ''; ?>">
		<?php
		if ( function_exists( 'naked_social_share_buttons' ) ) {
			naked_social_share_buttons();
		}

		if ( is_singular() ) {
			the_tags( '<span class="entry-tags">', ', ', '</span>' );
		} else {
			?>
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="more-link"><?php _e( 'Continue Reading &raquo;', 'elizabeth' ); ?></a>
			<?php
		}
		?>
	</footer>
	<?php
}

/**
 * Get Copyright Message
 *
 * Replaces a few shortcodes with dynamic values. The template is taken from
 * the Customizer.
 *
 * @since 1.0
 * @return string
 */
function gwen_get_copyright_message() {
	$find    = array(
		'[site-url]',
		'[site-title]',
		'[current-year]',
	);
	$replace = array(
		get_bloginfo( 'url' ),
		get_bloginfo( 'name' ),
		date( 'Y' ),
	);

	return str_replace( $find, $replace, get_theme_mod( 'footer_text', sprintf( __( '&copy; %s %s. All Rights Reserved.', 'gwen' ), '[current-year]', '[site-title]' ) ) );
}

/**
 * Post Navigation
 *
 * Navigate to next and previous pages.
 *
 * @since 1.0
 * @return void
 */
function gwen_posts_navigation() {
	?>
	<nav id="pagination">
		<div id="pagination-previous">
			<?php previous_posts_link( __( '<span>&laquo;</span> Newer Posts', 'gwen' ) ); ?>
		</div>
		<div id="pagination-next">
			<?php next_posts_link( __( 'Older Posts <span>&raquo;</span>', 'gwen' ) ); ?>
		</div>
	</nav>
	<?php
}
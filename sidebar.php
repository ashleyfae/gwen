<?php
/**
 * Sidebar
 *
 * @package   gwen
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

if ( ! is_active_sidebar( 'sidebar' ) && ! is_customize_preview() ) {
	return;
}
?>

<button class="sidebar-toggle" aria-controls="sidebar" aria-expanded="false"><?php esc_html_e( 'Show Sidebar', 'gwen' ); ?></button>

<aside id="sidebar" class="widget-area" role="complementary">
	<?php
	if ( is_active_sidebar( 'sidebar' ) ) {
		dynamic_sidebar( 'sidebar' );
	} elseif ( is_customize_preview() ) {
		?>
		<p><?php _e( 'Add some widgets to the \'Sidebar\' widget area.', 'gwen' ); ?></p>
		<?php
	}
	?>
</aside>
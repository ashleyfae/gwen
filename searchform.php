<?php
/**
 * Custom Search Form
 *
 * @package   gwen
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

?>
<form class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="GET">
	<label class="screen-reader-text" for="s"><?php _e( 'Search for:', 'gwen' ); ?></label>
	<input type="search" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" id="s" placeholder="<?php esc_attr_e( 'whatcha lookin for?', 'gwen' ); ?>">
	<input type="submit" value="<?php esc_attr_e( 'Go &raquo;', 'gwen' ); ?>">
</form>
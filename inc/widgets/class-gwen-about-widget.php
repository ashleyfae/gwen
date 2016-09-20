<?php

/**
 * About Widget
 *
 * @package   gwen
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */
class Gwen_About_Widget extends WP_Widget {

	/**
	 * Gwen_About_Widget constructor.
	 *
	 * @access public
	 * @since  1.0
	 */
	public function __construct() {
		add_filter( 'gwen/about-widget/description', 'wpautop' );

		parent::__construct(
			'gwen_about_widget',
			__( 'Gwen - About', 'gwen' ),
			array(
				'description' => __( 'A small piece about you and/or your site.', 'gwen' )
			)
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see    WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function widget( $args, $instance ) {

		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		if ( $instance['attach_id'] ) {
			echo wp_get_attachment_image( absint( $instance['attach_id'] ), apply_filters( 'gwen/about-widget/image-size', 'medium' ), false, array( 'class' => 'gwen-about-image' ) );
		}

		if ( array_key_exists( 'profiles', $instance ) && is_array( $instance['profiles'] ) && count( $instance['profiles'] ) ) {
			?>
			<ul class="gwen-social">
				<?php foreach ( $instance['profiles'] as $id => $url ) : ?>
					<li>
						<a href="<?php echo esc_url( $url ); ?>" target="_blank"><i class="fa fa-<?php echo esc_attr( $id ); ?>"></i></a>
					</li>
				<?php endforeach; ?>
			</ul>
			<?php
		}

		if ( $instance['text'] ) {
			?>
			<div class="gwen-about-description">
				<?php echo apply_filters( 'gwen/about-widget/description', $instance['text'] ); ?>
			</div>
			<?php
		}

		if ( $instance['about_page_id'] ) {
			?>
			<a href="<?php echo esc_url( get_permalink( $instance['about_page_id'] ) ); ?>" class="button"><?php echo $instance['more_text']; ?></a>
			<?php
		}

		echo $args['after_widget'];

	}

	/**
	 * Back-end widget form.
	 *
	 * @see    WP_Widget::form()
	 *
	 * @param array $instance
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'         => '',
			'attach_id'     => false,
			'text'          => '',
			'profiles'      => array(),
			'about_page_id' => 0,
			'more_text'     => __( 'Find Out More &raquo;', 'gwen' )
		) );

		$page_args = array(
			'selected'          => $instance['about_page_id'],
			'name'              => $this->get_field_name( 'about_page_id' ),
			'id'                => $this->get_field_id( 'about_page_id' ),
			'class'             => 'widefat',
			'show_option_none'  => __( '- Select -', 'gwen' ),
			'option_none_value' => 0
		);
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'gwen' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>

		<label for="<?php echo $this->get_field_id( 'attach_id' ); ?>"><?php _e( 'Photo:', 'gwen' ); ?></label>
		<br>
		<input id="<?php echo $this->get_field_id( 'attach_id' ); ?>" name="<?php echo $this->get_field_name( 'attach_id' ); ?>" type="hidden" value="<?php echo esc_attr( $instance['attach_id'] ); ?>">

		<?php
		if ( $instance['attach_id'] ) {
			$attach_args = array(
				'id' => $this->get_field_id( 'attach_id' ) . '_image'
			);

			echo wp_get_attachment_image( absint( $instance['attach_id'] ), 'medium', false, $attach_args );
		} else {
			echo '<img src="" id="' . $this->get_field_id( 'attach_id' ) . '_image" style="display: none;">';
		}
		?>

		<div class="gwen-button-upload-wrap">
			<button class="button gwen-upload-image-button" id="<?php echo $this->get_field_id( 'attach_id' ); ?>_upload" onclick="return gwen_open_uploader('<?php echo $this->get_field_id( 'attach_id' ); ?>');"><?php _e( 'Upload', 'gwen' ); ?></button>
			<button class="button gwen-remove-image-button" id="<?php echo $this->get_field_id( 'attach_id' ); ?>_remove" onclick="return gwen_clear_uploader('<?php echo $this->get_field_id( 'attach_id' ); ?>');"<?php echo empty( $instance['attach_id'] ) ? ' style="display: none;"' : ''; ?>><?php _e( 'Remove', 'gwen' ); ?></button>
		</div>

		<p>
			<?php foreach ( gwen_get_social_sites() as $id => $name ) : ?>
				<label for="<?php echo $this->get_field_id( 'profiles' ); ?>[<?php echo esc_attr( $id ); ?>]"><?php printf( __( '%s Profile URL', 'gwen' ), esc_html( $name ) ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'profiles' ); ?>[<?php echo esc_attr( $id ); ?>]" name="<?php echo $this->get_field_name( 'profiles' ); ?>[<?php echo esc_attr( $id ); ?>]" type="url" value="<?php echo array_key_exists( $id, $instance['profiles'] ) ? esc_attr( $instance['profiles'][ $id ] ) : ''; ?>" placeholder="<?php esc_attr_e( 'http://', 'gwen' ); ?>">
			<?php endforeach; ?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text:', 'gwen' ); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" rows="10"><?php echo esc_textarea( $instance['text'] ); ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'about_page_id' ); ?>"><?php _e( 'About Page:', 'gwen' ); ?></label>
			<?php wp_dropdown_pages( $page_args ); ?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'more_text' ); ?>"><?php _e( 'Button Text:', 'gwen' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'more_text' ); ?>" name="<?php echo $this->get_field_name( 'more_text' ); ?>" type="text" value="<?php echo esc_attr( $instance['more_text'] ); ?>">
		</p>

		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see    WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @access public
	 * @since  1.0
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                  = $old_instance;
		$instance['title']         = sanitize_text_field( $new_instance['title'] );
		$instance['attach_id']     = $new_instance['attach_id'] ? absint( $new_instance['attach_id'] ) : false;
		$instance['text']          = wp_kses_post( $new_instance['text'] );
		$instance['about_page_id'] = absint( $new_instance['about_page_id'] );
		$instance['more_text']     = sanitize_text_field( $new_instance['more_text'] );


		// Sanitize profiles.
		$instance['profiles'] = array();
		if ( array_key_exists( 'profiles', $new_instance ) ) {
			$instance['profiles'] = array_map( 'esc_url_raw', $new_instance['profiles'] );
		}

		return $instance;
	}

}

add_action( 'widgets_init', function () {
	register_widget( 'Gwen_About_Widget' );
} );
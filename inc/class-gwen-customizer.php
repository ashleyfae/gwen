<?php

/**
 * Implements Customizer functionality.
 *
 * @package   gwen
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */
class Gwen_Customizer {

	/**
	 * Theme Object
	 *
	 * @var WP_Theme
	 * @access private
	 * @since  1.0
	 */
	private $theme;

	/**
	 * Gwen_Customizer constructor.
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function __construct() {

		$theme       = wp_get_theme();
		$this->theme = $theme;

		add_action( 'customize_register', array( $this, 'register_customize_sections' ) );
		add_action( 'customize_preview_init', array( $this, 'live_preview' ) );

	}

	/**
	 * Add all panels to the Customizer
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function register_customize_sections( $wp_customize ) {

		// Blog
		$wp_customize->add_section( 'blog_posts', array(
			'title'    => esc_html__( 'Blog Posts', 'gwen' ),
			'priority' => 105
		) );

		// Footer
		$wp_customize->add_section( 'footer', array(
			'title'    => esc_html__( 'Footer', 'gwen' ),
			'priority' => 210
		) );

		do_action( 'gwen/customizer/register-sections', $wp_customize );

		/*
		 * Populate Sections
		 */

		$this->colours_section( $wp_customize );
		$this->blog_posts_section( $wp_customize );
		$this->footer_section( $wp_customize );

		/*
		 * Change existing settings.
		 */

		$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_image' )->transport      = 'postMessage';
		$wp_customize->get_setting( 'header_image_data' )->transport = 'postMessage';

	}

	/**
	 * Section: Colours
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function colours_section( $wp_customize ) {

		/* Primary Colour */
		$wp_customize->add_setting( 'primary_colour', array(
			'default'           => '#2a3876',
			'sanitize_callback' => 'sanitize_hex_color'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_colour', array(
			'label'       => esc_html__( 'Primary Colour', 'gwen' ),
			'description' => __( 'Used in post titles and link colours.', 'gwen' ),
			'section'     => 'colors',
			'settings'    => 'primary_colour',
			'priority'    => 15
		) ) );

		/* Secondary Colour */
		$wp_customize->add_setting( 'secondary_colour', array(
			'default'           => '#f0eee4',
			'sanitize_callback' => 'sanitize_hex_color'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_colour', array(
			'label'       => esc_html__( 'Secondary Colour', 'gwen' ),
			'description' => __( 'Top border colour, footer background, and button backgrounds.', 'gwen' ),
			'section'     => 'colors',
			'settings'    => 'secondary_colour',
			'priority'    => 17
		) ) );

	}

	/**
	 * Section: Blog Posts
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function blog_posts_section( $wp_customize ) {

		/* Excerpt Type */
		$wp_customize->add_setting( 'excerpt_type', array(
			'default'           => 'automatic',
			'sanitize_callback' => array( $this, 'sanitize_excerpt_type' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'excerpt_type', array(
			'label'    => esc_html__( 'Excerpt Type', 'gwen' ),
			'type'     => 'radio',
			'choices'  => array(
				'automatic' => esc_html__( 'Automatic', 'gwen' ),
				'manual'    => esc_html__( 'Manual', 'gwen' )
			),
			'section'  => 'blog_posts',
			'settings' => 'excerpt_type',
			'priority' => 10
		) ) );

		/* Auto Add Featured Images */
		$wp_customize->add_setting( 'auto_add_featured', array(
			'default'           => true,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			'transport'        => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'auto_add_featured', array(
			'label'    => esc_html__( 'Auto add featured images above post content', 'gwen' ),
			'type'     => 'checkbox',
			'section'  => 'blog_posts',
			'settings' => 'auto_add_featured',
			'priority' => 20
		) ) );

	}

	/**
	 * Section: Footer
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function footer_section( $wp_customize ) {

		/* Copyright Message */
		$wp_customize->add_setting( 'copyright_message', array(
			'default'           => sprintf( __( '&copy; %s %s. All Rights Reserved.', 'gwen' ), '[current-year]', get_bloginfo( 'name' ) ),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'copyright_message', array(
			'label'       => esc_html__( 'Copyright Message', 'gwen' ),
			'description' => sprintf(
				__( 'Customize the copyright message. You can use %s as a placeholder for the current year.', 'gwen' ),
				'<code>[current-year]</code>'
			),
			'type'        => 'textarea',
			'default'     => '',
			'section'     => 'footer',
			'settings'    => 'copyright_message',
			'priority'    => 20
		) ) );

	}

	/**
	 * Sanitize: Checkbox
	 *
	 * @param bool $input
	 *
	 * @access public
	 * @since  1.0
	 * @return bool
	 */
	public function sanitize_checkbox( $input ) {
		return $input ? true : false;
	}

	/**
	 * Sanitize: Excerpt Type
	 *
	 * @param string $input
	 *
	 * @access public
	 * @since  1.0
	 * @return string
	 */
	public function sanitize_excerpt_type( $input ) {

		$allowed_types = array( 'automatic', 'manual' );

		if ( in_array( $input, $allowed_types ) ) {
			return $input;
		}

		return 'automatic';

	}

	/**
	 * Add JavaScript
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function live_preview() {

		// Use minified libraries if SCRIPT_DEBUG is turned off
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		wp_enqueue_script(
			'bookstagram-customizer',
			get_template_directory_uri() . '/assets/js/customizer-preview' . $suffix . '.js',
			array( 'jquery', 'customize-preview' ),
			$this->theme->get( 'Version' ),
			true
		);

	}

}

new Gwen_Customizer;
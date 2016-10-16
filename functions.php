<?php
/**
 * Theme Functions
 *
 * Also pulls in any other required files.
 *
 * @package   gwen
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

if ( ! function_exists( 'gwen_setup' ) ) :
	/**
	 * Setup
	 *
	 * Sets up theme definitions and registers support
	 * for WordPress features.
	 *
	 * @since 1.0
	 * @return void
	 */
	function gwen_setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain( 'gwen', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Register navigation menu.
		register_nav_menus( array(
			'primary' => esc_html__( 'Top Menu', 'gwen' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'gwen/custom-background-args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

	}
endif;

add_action( 'after_setup_theme', 'gwen_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since 1.0
 * @return void
 */
function gwen_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'gwen/content-width', 642 );
}

add_action( 'after_setup_theme', 'gwen_content_width', 0 );


/**
 * Register widget areas.
 *
 * @link  https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @since 1.0
 * @return void
 */
function gwen_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'gwen' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Sidebar on the right-hand side.', 'gwen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

add_action( 'widgets_init', 'gwen_widgets_init' );

/**
 * Enqueue scripts and styles.
 *
 * @uses  wp_get_theme()
 *
 * @since 1.0
 * @return void
 */
function gwen_scripts() {
	$gwen    = wp_get_theme();
	$version = $gwen->get( 'Version' );

	wp_enqueue_style( 'gwen-google-fonts', 'https://fonts.googleapis.com/css?family=Balthazar|Roboto:100,300,700,700i', array(), $version );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '4.6.1' );
	wp_enqueue_style( 'gwen', get_stylesheet_uri(), array(), $version );
	wp_add_inline_style( 'gwen', gwen_get_custom_css() );

	wp_enqueue_script( 'gwen', get_template_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), $version, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'gwen_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/class-gwen-customizer.php';

/**
 * Custom widgets.
 */
require get_template_directory() . '/inc/widgets/class-gwen-about-widget.php';
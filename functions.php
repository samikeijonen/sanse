<?php
/**
 * Sanse functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Sanse
 */
 
/**
 * The suffix to use for scripts.
 */
if ( ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ) {
	define( 'SANSE_SUFFIX', '' );
} else {
	define( 'SANSE_SUFFIX', '.min' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for sanse features, such
 * as indicating support for post thumbnails.
 */
function sanse_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Sanse, use a find and replace
	 * to change 'sanse' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'sanse', get_template_directory() . '/languages' );

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

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'sanse' ),
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
	add_theme_support( 'custom-background', apply_filters( 'sanse_custom_background_args', array(
		'default-color' => 'f0f0f0',
		'default-image' => '',
	) ) );
}
add_action( 'after_setup_theme', 'sanse_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function sanse_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'sanse_content_width', 640 );
}
add_action( 'after_setup_theme', 'sanse_content_width', 0 );

/**
 * Register Google fonts.
 *
 * @since 1.0.0
 *
 * @return string Google fonts URL for the theme.
 */
function sanse_fonts_url() {

	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Droid Serif, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== esc_attr_x( 'on', 'Droid Serif font: on or off', 'sanse' ) ) {
		$fonts[] = 'Droid Serif:400,700,400italic,700italic';
	}
	
	/* translators: If there are characters in your language that are not supported by Archivo Narrow, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== esc_attr_x( 'on', 'Archivo Narrow font: on or off', 'sanse' ) ) {
		$fonts[] = 'Archivo Narrow:400,700,400italic,700italic';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function sanse_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'sanse' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'sanse' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'sanse_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function sanse_scripts() {
	
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'sanse-fonts', sanse_fonts_url(), array(), null );
	
	// Add parent theme styles if using child theme.
	if ( is_child_theme() ) {
		wp_enqueue_style( 'sanse-parent-style', trailingslashit( get_template_directory_uri() ) . 'style' . SANSE_SUFFIX . '.css', array(), null );
	}
	
	// Add theme styles.
	wp_enqueue_style( 'sanse-style', get_stylesheet_uri() );
	
	// Add theme scripts.
	wp_enqueue_script( 'sanse-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );
	
	// Add skip link script.
	wp_enqueue_script( 'sanse-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );
	
	// Add comments script.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'sanse_scripts' );

/**
 * Change [...] to just "Read more".
 *
 * @since  1.0.0
 * @return string $more
 */
function sanse_excerpt_more() {

	/* Translators: The %s is the post title shown to screen readers. */
	$text = sprintf( esc_attr__( 'Read more %s', 'some' ), '<span class="screen-reader-text">' . get_the_title() ) .  '</span>';
	$more = sprintf( '&hellip; <span class="icon-wrapper icon-wrapper-round"></span><a href="%s" class="more-link">%s %s</a>', esc_url( get_permalink() ), $text, sanse_get_svg( array( 'icon' => 'next' ) ) );

	return $more;

}
add_filter( 'excerpt_more', 'sanse_excerpt_more' );

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
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

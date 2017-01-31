<?php
/**
 * Sanse functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Sanse
 */

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

	// This theme uses wp_nav_menu() in two location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'sanse' ),
		'social'  => esc_html__( 'Social Links', 'sanse' ),
	) );

	// Add support for logo.
	add_theme_support( 'custom-logo', apply_filters( 'sanse_custom_logo_arguments', array(
		'height'      => 90,
		'width'       => 90,
		'flex-height' => true,
		'flex-width'  => true,
	) ) );

	/*
	 * Add support for selective refresh.
	 *
	 * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#widgets-opting-in-to-selective-refresh
	 */
	add_theme_support( 'customize-selective-refresh-widgets' );

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

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'assets/css/editor-style.css' ) );

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
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function sanse_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Footer widget area 1', 'sanse' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here for footer widget area 1.', 'sanse' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer widget area 2', 'sanse' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add widgets here for footer widget area 2.', 'sanse' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer widget area 3', 'sanse' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add widgets here for footer widget area 3.', 'sanse' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Front Page template widget area', 'sanse' ),
		'id'            => 'front-page',
		'description'   => esc_html__( 'Add widgets here for Front Page template.', 'sanse' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner-wrapper">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'sanse_widgets_init' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 */
function sanse_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'sanse_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 */
function sanse_scripts() {

	// Get '.min' suffix.
	$suffix = sanse_get_min_suffix();

	// Add parent theme styles if using child theme.
	if ( is_child_theme() ) {
		wp_enqueue_style( 'sanse-parent-style', trailingslashit( get_template_directory_uri() ) . 'style' . $suffix . '.css', array(), null );
	}

	// Add theme styles.
	wp_enqueue_style( 'sanse-style', get_stylesheet_uri() );

	// Add theme scripts.
	wp_enqueue_script( 'sanse-navigation', get_template_directory_uri() . '/assets/js/navigation' . $suffix . '.js', array(), '20170131', true );

	// Add comments script.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'sanse_scripts' );

/**
 * Filters the 'stylesheet_uri' to allow theme developers to offer a minimized version of their main
 * 'style.css' file. It will detect if a 'style.min.css' file is available and use it if SCRIPT_DEBUG
 * is disabled.
 *
 * @since     1.1.0
 * @author    Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2008 - 2015, Justin Tadlock
 * @link      http://themehybrid.com/hybrid-core
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @param     string  $stylesheet_uri      The URI of the active theme's stylesheet.
 * @param     string  $stylesheet_dir_uri  The directory URI of the active theme's stylesheet.
 * @return    string  $stylesheet_uri
 */
function sanse_min_stylesheet_uri( $stylesheet_uri, $stylesheet_dir_uri ) {

	// Get the minified suffix.
	$suffix = sanse_get_min_suffix();

	// Use the .min stylesheet if available.
	if ( $suffix ) {

		// Remove the stylesheet directory URI from the file name.
		$stylesheet = str_replace( trailingslashit( $stylesheet_dir_uri ), '', $stylesheet_uri );

		// Change the stylesheet name to 'style.min.css'.
		$stylesheet = str_replace( '.css', "{$suffix}.css", $stylesheet );

		// If the stylesheet exists in the stylesheet directory, set the stylesheet URI to the dev stylesheet.
		if ( file_exists( trailingslashit( get_stylesheet_directory() ) . $stylesheet ) ) {
			$stylesheet_uri = esc_url( trailingslashit( $stylesheet_dir_uri ) . $stylesheet );
		}

	}

	// Return the theme stylesheet.
	return $stylesheet_uri;

}
add_filter( 'stylesheet_uri', 'sanse_min_stylesheet_uri', 5, 2 );

/**
 * Helper function for getting the script/style `.min` suffix for minified files.
 *
 * @since  1.1.0
 * @return string
 */
function sanse_get_min_suffix() {
	return defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ? '' : '.min';
}

/**
 * Add SVG definitions to the footer.
 *
 * @since 1.1.0
 */
function sanse_include_svg_icons() {

	// Define SVG sprite file.
	$svg_icons = get_template_directory() . '/assets/images/svg-icons.svg';

	// If it exists, include it.
	if ( file_exists( $svg_icons ) ) {
		require_once( $svg_icons );
	}

}
add_action( 'wp_footer', 'sanse_include_svg_icons', 9999 );

/**
 * Change [...] to just "Read more".
 *
 * @since  1.0.0
 * @return string $more
 */
function sanse_excerpt_more() {

	/* Translators: The %s is the post title shown to screen readers. */
	$text = sprintf( esc_html__( 'Read more %s', 'sanse' ), '<span class="screen-reader-text">' . esc_html( get_the_title() ) .  '</span>' );
	$more = sprintf( '&hellip; <a href="%s" class="more-link">%s %s</a>', esc_url( get_permalink() ), $text, sanse_get_svg( array( 'icon' => 'next' ) ) );

	return $more;

}
add_filter( 'excerpt_more', 'sanse_excerpt_more' );

/**
 * Display SVG icons in social navigation.
 *
 * @since 1.0.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function sanse_nav_social_icons( $item_output, $item, $depth, $args ) {

	// Supported social icons.
	$social_icons = apply_filters( 'sanse_nav_social_icons', array(
		'codepen.io'      => 'codepen',
		'digg.com'        => 'digg',
		'dribbble.com'    => 'dribbble',
		'dropbox.com'     => 'dropbox',
		'facebook.com'    => 'facebook',
		'flickr.com'      => 'flickr',
		'foursquare.com'  => 'foursquare',
		'plus.google.com' => 'googleplus',
		'github.com'      => 'github',
		'instagram.com'   => 'instagram',
		'linkedin.com'    => 'linkedin-alt',
		'mailto:'         => 'mail',
		'pinterest.com'   => 'pinterest-alt',
		'getpocket.com'   => 'pocket',
		'polldaddy.com'   => 'polldaddy',
		'reddit.com'      => 'reddit',
		'skype.com'       => 'skype',
		'skype:'          => 'skype',
		'soundcloud.com'  => 'cloud',
		'spotify.com'     => 'spotify',
		'stumbleupon.com' => 'stumbleupon',
		'tumblr.com'      => 'tumblr',
		'twitch.tv'       => 'twitch',
		'twitter.com'     => 'twitter',
		'vimeo.com'       => 'vimeo',
		'wordpress.org'   => 'wordpress',
		'wordpress.com'   => 'wordpress',
		'youtube.com'     => 'youtube',
	) );

	// Change SVG icon inside social links menu if there is supported URL.
	if ( 'social' == $args->theme_location ) {
		foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item_output, $attr ) ) {
				$item_output = str_replace( $args->link_after, '</span>' . sanse_get_svg( array( 'icon' => esc_attr( $value ) ) ), $item_output );
			}
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'sanse_nav_social_icons', 10, 4 );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function sanse_body_classes( $classes ) {

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add the '.custom-header-image' class if the user is using a custom header image.
	if ( get_header_image() ) {
		$classes[] = 'custom-header-image';
	}

	// Add the '.no-header-text' class if there is no Site Title and Tagline.
	if ( ! display_header_text() ) {
		$classes[] = 'no-header-text';
	}

	// Footer widget area count.
	$footer_widget_count = 0;
	if( is_active_sidebar( 'footer-1' ) ) {
		$footer_widget_count++;
	}
	if( is_active_sidebar( 'footer-2' ) ) {
		$footer_widget_count++;
	}
	if( is_active_sidebar( 'footer-3' ) ) {
		$footer_widget_count++;
	}

	$classes[] = 'footer-widgets-' . $footer_widget_count;

	return $classes;
}
add_filter( 'body_class', 'sanse_body_classes' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Implement the Custom Background feature.
 */
require get_template_directory() . '/inc/custom-background.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

<?php
/**
 * Implementation of the Custom Header feature.
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Sanse
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses sanse_header_style()
 */
function sanse_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'sanse_custom_header_args', array(
		'default-image'      => '',
		'default-text-color' => '000000',
		'width'              => 1920,
		'height'             => 400,
		'flex-height'        => true,
		'wp-head-callback'   => 'sanse_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'sanse_custom_header_setup', 15 );

/**
 * Styles the header image and text displayed on the blog.
 *
 * @see sanse_custom_header_setup().
 */
function sanse_header_style() {

	// Header text color.
	$header_color = esc_attr( get_header_textcolor() );

	// Header image.
	$header_image = esc_url( get_header_image() );

	// Start header styles.
	$style = '';

	// Header image height.
	$header_height = get_custom_header()->height;

	// Header image width.
	$header_width = get_custom_header()->width;

	// When to show header image.
	$min_width = absint( apply_filters( 'sanse_header_bg_show', 1260 ) );

	if ( ! empty( $header_image ) ) {
		$style .= "@media screen and (min-width: {$min_width}px) { body.custom-header-image .hero { background-image: url({$header_image}) } }";
	}

	/* Site title styles. */
	if ( display_header_text() ) {
		$style .= ".site-title a, .site-description { color: #{$header_color} }";
	}

	if ( ! display_header_text() ) {
		$style .= ".site-title, .site-description { clip: rect(1px, 1px, 1px, 1px); position: absolute; }";
	}

	/* Echo styles if it's not empty. */
	if ( ! empty( $style ) ) {
		echo "\n" . '<style type="text/css" id="custom-header-css">' . trim( $style ) . '</style>' . "\n";
	}

}

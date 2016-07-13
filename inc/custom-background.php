<?php
/**
 * Custom background feature
 *
 * @package Sanse
 */

/**
 * Adds support for the WordPress 'custom-background' theme feature.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function sanse_custom_background_setup() {

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'sanse_custom_background_args', array(
		'default-color' => 'f0f0f0',
		'default-image' => '',
	) ) );
	
}
add_action( 'after_setup_theme', 'sanse_custom_background_setup', 15 );

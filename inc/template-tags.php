<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, sanse of the functionality here could be replaced by core features.
 *
 * @package Sanse
 */

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function sanse_posted_on() {
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

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'sanse' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'sanse' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}

/**
 * This template tag is meant to replace template tags like `the_category()`, `the_terms()`, etc.  These core
 * WordPress template tags don't offer proper translation and RTL support without having to write a lot of
 * messy code within the theme's templates.  This is why theme developers often have to resort to custom
 * functions to handle this (even the default WordPress themes do this). Particularly, the core functions
 * don't allow for theme developers to add the terms as placeholders in the accompanying text (ex: "Posted in %s").
 * This funcion is a wrapper for the WordPress `get_the_terms_list()` function.  It uses that to build a
 * better post terms list.
 *
 * @author  Justin Tadlock
 * @link    https://github.com/justintadlock/hybrid-core/blob/2.0/functions/template-post.php
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * @since   1.0.0
 * @param   array   $args
 * @return  string
 */
function sanse_get_post_terms( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id'    => get_the_ID(),
		'taxonomy'   => 'category',
		'text'       => '%s',
		'before'     => '',
		'after'      => '',
		'items_wrap' => '<span %s>%s</span>',
		/* Translators: Separates tags, categories, etc. when displaying a post. */
		'sep'        => '<span class="screen-reader-text">' . esc_html_x( ', ', 'taxonomy terms separator', 'sanse' ) . '</span>'
	);

	$args = wp_parse_args( $args, $defaults );

	$terms = get_the_term_list( $args['post_id'], $args['taxonomy'], '', $args['sep'], '' );

	if ( !empty( $terms ) ) {
		$html .= $args['before'];
		$html .= sprintf( $args['items_wrap'], 'class="entry-terms ' . $args['taxonomy'] . '"', sprintf( $args['text'], $terms ) );
		$html .= $args['after'];
	}

	return $html;
}

/**
 * Outputs a post's taxonomy terms.
 *
 * @since  1.0.0
 * @access public
 * @param  array   $args
 * @return void
 */
function sanse_post_terms( $args = array() ) {
	echo sanse_get_post_terms( $args );
}

/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 */
function sanse_the_custom_logo() {

	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}

}

/**
 * Return SVG markup.
 *
 * @param  array  $args {
 *     Parameters needed to display an SVG.
 *
 *     @param string $icon Required. Use the icon filename, e.g. "facebook-square".
 *     @param string $title Optional. SVG title, e.g. "Facebook".
 *     @param string $desc Optional. SVG description, e.g. "Share this post on Facebook".
 * }
 * @return string SVG markup.
 */
function sanse_get_svg( $args = array() ) {

	// Make sure $args are an array.
	if ( empty( $args ) ) {
		return esc_html__( 'Please define default parameters in the form of an array.', 'sanse' );
	}

	// Define an icon.
	if ( false === array_key_exists( 'icon', $args ) ) {
		return esc_html__( 'Please define an SVG icon filename.', 'sanse' );
	}

	// Set defaults.
	$defaults = array(
		'icon'        => '',
		'title'       => '',
		'desc'        => '',
		'aria_hidden' => true, // Hide from screen readers.
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Set aria hidden.
	if ( true === $args['aria_hidden'] ) {
		$aria_hidden = ' aria-hidden="true"';
	} else {
		$aria_hidden = '';
	}

	// Set ARIA.
	if ( $args['title'] && $args['desc'] ) {
		$aria_labelledby = ' aria-labelledby="title desc"';
	} else {
		$aria_labelledby = '';
	}

	// Begin SVG markup
	$svg = '<svg class="icon icon-' . esc_attr( $args['icon'] ) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';
		// If there is a title, display it.
		if ( $args['title'] ) {
			$svg .= '<title>' . esc_html( $args['title'] ) . '</title>';
		}
		// If there is a description, display it.
		if ( $args['desc'] ) {
			$svg .= '<desc>' . esc_html( $args['desc'] ) . '</desc>';
		}
	$svg .= '<use xlink:href="#icon-' . esc_attr( $args['icon'] ) . '"></use>';
	$svg .= '</svg>';
	return $svg;
}

/**
 * Display an SVG.
 *
 * @param  array  $args  Parameters needed to display an SVG.
 */
function sanse_do_svg( $args = array() ) {
	echo sanse_get_svg( $args );
}

/**
 * Display post pagination.
 *
 * Use WordPress native the_posts_pagination function.
 */
function sanse_posts_pagination() {

	the_posts_pagination( array(
		'prev_text'          => '<span class="screen-reader-text">' . esc_html__( 'Previous page', 'sanse' ) . '</span>' . sanse_get_svg( array( 'icon' => 'arrow-circle-left' ) ),
		'next_text'          => '<span class="screen-reader-text">' . esc_html__( 'Next page', 'sanse' ). '</span>' . sanse_get_svg( array( 'icon' => 'arrow-circle-right' ) ),
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'sanse' ) . ' </span>',
	) );

}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function sanse_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'sanse_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'sanse_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so sanse_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so sanse_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in sanse_categorized_blog.
 */
function sanse_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'sanse_categories' );
}
add_action( 'edit_category', 'sanse_category_transient_flusher' );
add_action( 'save_post',     'sanse_category_transient_flusher' );

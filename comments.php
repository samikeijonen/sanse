<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SanseSanse
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( // WPCS: XSS OK.
					esc_html( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'sanse' ) ),
					number_format_i18n( get_comments_number() ),
					'<span>' . get_the_title() . '</span>'
				);
			?>
		</h2>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 60,
					'reply_text'  => esc_html__( 'Reply', 'sanse' ). sanse_get_svg( $args = array( 'icon' => 'reply' ) ),
				) );
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation( array (
			'prev_text' => sprintf( esc_html__( '%s Older comments', 'sanse' ), sanse_get_svg( $args = array( 'icon' => 'chevron-circle-left' ) ) ),
			'next_text' => sprintf( esc_html__( 'Newer comments %s', 'sanse' ), sanse_get_svg( $args = array( 'icon' => 'chevron-circle-right' ) )  ),
		) );

	endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'sanse' ); ?></p>
	<?php
	endif;

	comment_form();
	?>

</div><!-- #comments -->

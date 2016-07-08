<?php
/**
 * Entry footer.
 *
 * @package Some
 */
?>

<?php if ( 'post' == get_post_type() ) : ?>
	
	<footer class="entry-footer">
		<?php
			//sanse_post_terms( array( 'taxonomy' => 'category', 'before' => '<div class="entry-terms-wrapper entry-categories-wrapper"><span class="screen-reader-text">' . esc_html__( 'Categories:', 'some' ) . ' </span><span class="icon-wrapper icon-wrapper-round">' . some_get_svg( array( 'icon' => 'category' ) ) . '</span>', 'after' => '</div>' ) );
			//sanse_post_terms( array( 'taxonomy' => 'post_tag', 'before' => '<div class="entry-terms-wrapper entry-tags-wrapper"><span class="screen-reader-text">' . esc_html__( 'Tags:', 'some' ) . ' </span><span class="icon-wrapper icon-wrapper-round">' . some_get_svg( array( 'icon' => 'tag' ) ) . '</span>', 'after' => '</div>' ) );
		?>
	</footer><!-- .entry-footer -->
	
<?php endif;
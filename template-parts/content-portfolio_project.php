<?php
/**
 * Template part for displaying portfolios.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Some
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( is_singular() ) : // If single. ?>
	
		<?php some_post_thumbnail(); ?>
	
		<header class="entry-header">
			<?php
				the_title( '<h1 class="entry-title">', '</h1>' );
			?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
				the_content();

				wp_link_pages( array(
					'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'some' ),
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'some' ) . ' </span>%',
					'separator'   => '<span class="screen-reader-text">,</span> ',
				) );
			?>
		</div><!-- .entry-content -->
		
		<footer class="entry-footer">
			<?php
				some_post_terms( array( 'taxonomy' => 'portfolio_category', 'before' => '<div class="entry-terms-wrapper entry-categories-wrapper"><span class="screen-reader-text">' . esc_html__( 'Categories:', 'some' ) . ' </span><span class="icon-wrapper icon-wrapper-round">' . some_get_svg( array( 'icon' => 'category' ) ) . '</span>', 'after' => '</div>' ) );
				some_post_terms( array( 'taxonomy' => 'portfolio_tag', 'before' => '<div class="entry-terms-wrapper entry-tags-wrapper"><span class="screen-reader-text">' . esc_html__( 'Tags:', 'some' ) . ' </span><span class="icon-wrapper icon-wrapper-round">' . some_get_svg( array( 'icon' => 'tag' ) ) . '</span>', 'after' => '</div>' ) );
			?>
		</footer><!-- .entry-footer -->
	
	<?php else : ?>
		
		<div class="entry-inner">
		
			<?php some_post_thumbnail(); ?>
		
			<header class="entry-header">
				<?php
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				?>
			</header><!-- .entry-header -->
			
		</div><!-- .entry-inner -->

	<?php endif; // End check single. ?>
	
</article><!-- #post-## -->

<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Sanse
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="entry-inner">
		
		<header class="entry-header">
			<?php
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			?>
		</header><!-- .entry-header -->
		
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
			
		<?php
			get_template_part( 'entry-meta' );
		?>
			
	</div><!-- .entry-inner -->

</article><!-- #post-## -->

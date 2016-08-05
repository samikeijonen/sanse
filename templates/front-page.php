<?php
/**
 * Template Name: Front Page
 *
 * This is the template displaying custom front page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Sanse
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			
			<div class="front-page-content front-page-section" id="front-page-content">
			<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', 'page' );

				endwhile; // End of the loop.
			?>
			</div><!-- .front-page-content -->
			
			<?php get_sidebar( 'front-page' ); // Loads the sidebar-front-page.php template. ?>
			
			<?php
			// Blog Posts Query. 
			$blog_content = new WP_Query( apply_filters( 'sanse_blog_posts_arguments', array(
				'post_type'              => 'post',
				'posts_per_page'         => 4,
				'no_found_rows'          => true,
				'update_post_meta_cache' => false,
			) ) );
			
			if ( $blog_content->have_posts() ) : ?>
			
			<div class="front-page-blog front-page-section" id="front-page-blog">
			
				<header class="page-header">
				<?php
					// Get blog title from the options.
					$blog_title_option = get_option( 'page_for_posts' );
					$blog_title        = ( 'page' == get_option( 'show_on_front' ) && 0 !== $blog_title_option ) ? get_the_title( absint( $blog_title_option ) ) : esc_html__( 'Blog', 'sanse' );
					
					echo '<h2 class="page-title">' . esc_html( $blog_title ) . '</h2>';
				?>
				</header><!-- .page-header -->
			
				<div class="grid-wrapper">
				
				<?php while ( $blog_content->have_posts() ) : $blog_content->the_post(); ?>
				
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
						<div class="entry-inner">
		
							<header class="entry-header">
							<?php
								do_action( 'sanse_front_page_blog_header' );
								the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
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
				
				<?php endwhile; ?>
				
				</div><!-- .grid-wrapper -->
				
			</div><!-- .front-page-blog -->
				
			<?php	
			endif; // End loop.
			wp_reset_postdata(); // Reset post data.
			?>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();

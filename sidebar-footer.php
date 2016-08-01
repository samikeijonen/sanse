<?php
/**
 * The area containing the footer widget areas.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Sanse
 */

if ( ! is_active_sidebar( 'footer-1' ) && ! is_active_sidebar( 'footer-2' ) && ! is_active_sidebar( 'footer-3' ) ) {
	return;
}
?>

<div class="footer-widgets-wrapper">
	<div class="wrapper">
		<div class="grid-wrapper">

		<?php if( is_active_sidebar( 'footer-1' ) ) : ?>
			<aside id="footer-area-1" class="footer-area-1 widget-area" role="complementary">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</aside><!-- .widget-area -->
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
			<aside id="footer-area-2" class="footer-area-2 widget-area" role="complementary">
				<?php dynamic_sidebar( 'footer-2' ); ?>
			</aside><!-- .widget-area -->
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
			<aside id="footer-area-3" class="footer-area-3 widget-area" role="complementary">
				<?php dynamic_sidebar( 'footer-3' ); ?>
			</aside><!-- .widget-area -->
		<?php endif; ?>
		
		</div><!-- .grid-wrapper -->
	</div><!-- .wrapper -->
</div><!-- .footer-widgets-wrapper -->

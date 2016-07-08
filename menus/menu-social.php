<?php
/**
 * Social links menu.
 *
 * @package Sanse
 */
?>

<?php if ( has_nav_menu( 'social' ) ) : // Check if there's a menu assigned to the 'social' location. ?>
	
	<nav class="menu-social social-navigation menu" role="navigation" aria-label="<?php esc_attr_e( 'Social Menu', 'sanse' ); ?>">
		
		<?php wp_nav_menu(
			array(
				'theme_location'  => 'social',
				'container_class' => 'social-menu-wrapper',
				'menu_id'         => 'menu-social-items',
				'menu_class'      => 'menu-social-items',
				'depth'           => 1,
				'link_before'     => '<span class="screen-reader-text">',
				'link_after'      => '</span>' . sanse_get_svg( array( 'icon' => 'rating-full' ) ),
				'fallback_cb'     => '',
			)
		); ?>
	</nav><!-- .menu-social -->

<?php endif; // End check for menu.
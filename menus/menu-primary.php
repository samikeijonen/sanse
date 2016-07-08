<?php
/**
 * Primary menu.
 *
 * @package Sanse
 */
?>

<?php if ( has_nav_menu( 'primary' ) ) : // Check do we have primary menu. ?>

	<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'sanse' ); ?>">
		<button id="menu-toggle" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'sanse' ); ?></button>
			<?php
				wp_nav_menu( array(
					'container_class' => 'primary-menu-wrapper',
					'theme_location'  => 'primary',
					'menu_id'         => 'primary-menu',
					'menu_class'      => 'primary-menu',
				) );
			?>
	</nav><!-- #site-navigation -->

<?php endif; // End check for primary menu.
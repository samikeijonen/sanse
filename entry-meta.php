<?php 
/**
 * Entry meta content for displaying post date and author.
 *
 * @package Sanse
 */
 
if ( 'post' === get_post_type() ) : ?>
	<div class="entry-meta">
		<?php sanse_posted_on(); ?>
	</div><!-- .entry-meta -->
<?php endif; ?>
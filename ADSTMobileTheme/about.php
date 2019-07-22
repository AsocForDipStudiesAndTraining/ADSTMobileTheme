<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.3
 */

// About visibility
$visible = Website::getInheritOption('options/about', get_post_type().'/about');

// About
if ($visible === true || $visible === 'on') {

	?>
	<section class="about clear">
		<?php echo get_avatar(get_the_author_meta('ID'), 60); ?>
		<div class="info">
			<h1><?php the_author(); ?></h1>
			<p><?php the_author_meta('description'); ?></p>
		</div>
	</section>
	<?php

}
<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */
?>

<section class="main">
	<?php get_template_part('title', 'portfolio-item'); ?>
	<?php if (has_post_thumbnail()): ?>
		<div class="featured">
			<?php Website::responsiveThumbnail(); ?>
		</div>
	<?php endif; ?>
	<?php get_template_part('content', 'portfolio-item'); ?>
</section>
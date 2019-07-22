<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */
?>

<section class="main">
	<?php get_template_part('title', 'post'); ?>
	<?php if (!post_password_required() && Website::getThemeOption('format_post/audio/player/visible', true)->value(is_singular() ? 'single' : 'list')): ?>
		<div class="featured">
			<audio id="audio-<?php the_ID(); ?>">
				<source src="<?php Website::postOption('audio/url'); ?>" type="audio/mp3" />
			</audio>
		</div>
	<?php endif; ?>
	<?php get_template_part('content', 'post'); ?>
</section>
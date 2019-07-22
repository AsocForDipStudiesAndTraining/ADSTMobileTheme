<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */
?>

<section class="main">
	<?php get_template_part('title', 'post'); ?>
	<?php if (!post_password_required() && Website::getThemeOption('format_post/video/player/visible', true)->value(is_singular() ? 'single' : 'list')): ?>
		<div class="featured">
			<?php if (Website::getPostOption('video/method') == 'self'): ?>
				<?php list($post_thumbnail_src) = wp_get_attachment_image_src(get_post_thumbnail_id(), ''); ?>
				<video id="video-<?php the_ID(); ?>" poster="<?php echo $post_thumbnail_src; ?>" data-ratio="<?php Website::postOption('video/ratio'); ?>">
					<source src="<?php Website::postOption('video/url'); ?>" type="video/mp4" />
				</video>
			<?php else: ?>
				<?php Website::postOption('video/code'); ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<?php get_template_part('content', 'post'); ?>
</section>
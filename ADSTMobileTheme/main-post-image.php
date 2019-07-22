<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */
?>

<section class="main">
	<?php get_template_part('title', 'post'); ?>
	<?php if (!post_password_required() && has_post_thumbnail() && Website::getThemeOption('format_post/image/featured/visible', true)->value(is_singular() ? 'single' : 'list')): ?>
		<div class="featured">
			<?php list($post_thumbnail_src) = wp_get_attachment_image_src(get_post_thumbnail_id(), ''); ?>
			<?php if (is_singular() || Website::getThemeOption('format_post/image/featured/link') == 'fancybox'): ?>
				<a href="<?php echo $post_thumbnail_src; ?>" class="fancybox">
			<?php else: ?>
				<a href="<?php the_permalink(); ?>">
			<?php endif; ?>
				<?php Website::responsiveImage($post_thumbnail_src); ?>
			</a>
		</div>
	<?php endif; ?>
	<?php get_template_part('content', 'post'); ?>
</section>
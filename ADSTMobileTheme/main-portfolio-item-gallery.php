<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */
?>

<section class="main">
	<?php get_template_part('title', 'portfolio-item'); ?>
	<?php
		$gallery_query = new WP_Query(array(
			'post_parent'    => get_the_ID(),
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC'
		));
	?>
	<?php if ($gallery_query->have_posts()): ?>
		<div class="featured flexslider">
			<ul class="slides">
				<?php while ($gallery_query->have_posts()): ?>
					<?php $gallery_query->the_post(); ?>
					<li>
						<?php Website::responsiveThumbnail(get_the_ID()); ?>
						<?php if (has_excerpt()): ?>
							<p class="flex-caption"><?php echo get_the_excerpt(); ?></p>
						<?php endif; ?>
					</li>
				<?php endwhile; ?>
			</ul>
		</div>
	<?php endif; ?>
	<?php wp_reset_query(); ?>
	<?php get_template_part('content', 'portfolio-item'); ?>
</section>
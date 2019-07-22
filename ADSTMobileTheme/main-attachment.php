<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */
?>

<section class="main">
	<?php get_template_part('title', 'attachment'); ?>
	<div class="content">
		<figure class="full-width-mobile <?php Website::themeOption('appearance/image/border'); ?>">
			<?php Website::responsiveThumbnail(get_the_ID()); ?>
			<figcaption><?php echo get_the_excerpt(); ?></figcaption>
		</figure>
	</div>
</section>
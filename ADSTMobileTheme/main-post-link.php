<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */
?>

<section class="main">
	<h1 class="title">
		<a href="<?php Website::getThemeOption('format_post/link/title/link') == 'url' || is_singular() ? (Website::postOption('link/url') || the_permalink()) : the_permalink(); ?>" title="<?php the_title_attribute(); ?>"<?php if (Website::getThemeOption('format_post/link/title/target_blank')) echo ' target="_blank"'; ?>><?php the_title(); ?></a>
	</h1>
	<?php get_template_part('content', 'post'); ?>
</section>
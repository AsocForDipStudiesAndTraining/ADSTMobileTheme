<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.3
 */
?>

<h1 class="title">
	<?php if (is_singular()): ?>
		<?php the_title(); ?>
	<?php else: ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
	<?php endif; ?>
</h1>
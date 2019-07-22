<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */
?>

<!-- Interior Content Pages -->

<section class="main">
	<?php
		$hide = Website::getInheritOption('options/title', 'page/hide_title');
		if ($hide === false || $hide === 'show') {
			get_template_part('title', 'page');
		}
	?>
	<?php get_template_part('content', 'page'); ?>
</section>
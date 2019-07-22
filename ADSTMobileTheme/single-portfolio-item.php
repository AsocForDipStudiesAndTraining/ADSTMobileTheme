<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */
?>

<?php
	get_header();
	get_template_part('breadcrumbs', 'portfolio-item');
?>

<section id="content">
	<?php get_template_part('loop', 'portfolio-item'); ?>
</section>

<?php get_footer(); ?>
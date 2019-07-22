<?php
	get_header();
?>

<div id="newsletterArchive">

<section id="content" class="<?php Website::contentClass(); ?>">
	<?php get_template_part('loop', 'newsletter'); ?>
</section>

</div>

<?php
	get_sidebar();
	get_footer();
?>
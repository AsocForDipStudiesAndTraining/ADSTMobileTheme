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

	<?php if (have_posts()): ?>

		<?php
			the_post();
			extract(Website::getPostOption('options', true)->toArray(), EXTR_PREFIX_ALL, 'gallery');
			$paged = get_query_var('page') ? get_query_var('page') : 1;
			$gallery_query = new WP_Query(array(
				'post_parent'    => get_the_ID(),
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'posts_per_page' => $gallery_pagination ? $gallery_per_page : -1,
				'paged'          => $paged,
				'orderby'        => $gallery_orderby,
				'order'          => strtoupper($gallery_order)
			));
		?>

		<section class="items <?php echo $gallery_size; ?> clear">

			<?php while ($gallery_query->have_posts()): ?>

				<?php
					$gallery_query->the_post();
					list($src) = wp_get_attachment_image_src(get_the_ID(), '');
				?>
				<article id="item-<?php the_ID(); ?>" class="item-<?php the_ID(); ?> item">
					<div class="image">
						<a href="<?php echo $src; ?>" class="fancybox" rel="gallery" title="<?php echo esc_attr(get_the_excerpt()); ?>">
							<?php Website::responsiveImage($src); ?>
							<span class="hover"></span>
						</a>
					</div>
				</article>

			<?php endwhile; ?>

			<?php wp_reset_query(); ?>

		</section>

		<?php
			if ($gallery_pagination) {
				if (get_option('permalink_structure')) {
					$base = trailingslashit(get_permalink()).user_trailingslashit('%#%', 'single_paged');
				} else {
					$base = add_query_arg('page', '%#%', get_permalink());
				}
				$pagination = paginate_links(array(
					'base'      => $base,
					'format'    => '',
					'current'   => $paged,
					'total'     => $gallery_query->max_num_pages,
					'prev_next' => Website::getThemeOption('gallery/pagination') == 'numbers_navigation',
					'prev_text' => __('previous', 'website'),
					'next_text' => __('next', 'website')
				));
				if ($pagination) {
					printf('<div class="pagination">%s</div>', $pagination);
				}
			}
		?>

	<?php endif; ?>

</section>

<?php get_footer(); ?>
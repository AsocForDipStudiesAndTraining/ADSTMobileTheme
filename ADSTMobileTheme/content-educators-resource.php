<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */
?>

<?php $post_format = get_post_format() or $post_format = 'default'; ?>

							testsetsete		test	

<?php if (get_post_type() != 'post' || is_single() || !Website::getThemeOption("format_post/{$post_format}/content/hide")): ?>
	<div class="content clear wysiwyg"><?php
			if (is_search()) {
				$sq = preg_quote(get_search_query(), '/');
				printf('<p>%s</p>', preg_replace("/\b{$sq}\b/i", '<mark class="search">\0</mark>', get_the_excerpt()));
			} else {
				if (has_excerpt() && !is_singular()) {
					the_excerpt();
				} else {
					the_content(Website::getThemeOption('post/readmore'));
				}
				if (is_singular()) {
					$pages = wp_link_pages(array(
						'before' => '',
						'after'  => '',
						'echo'   => false
					));
					if ($pages) {
						printf('<div class="pagination">%s</div>', preg_replace('/ ([0-9]+)/', ' <span class="current">\1</span>', $pages));
					}
				}
			}
		?></div>
		
		<div id="newsletterReturnBTN">View All <?php the_category( ' '); ?> Articles</div>
		
		
<?php endif; ?>
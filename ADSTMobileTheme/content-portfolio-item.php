<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */
?>

<div class="content clear"><?php
		if (is_search()) {
			$sq = preg_quote(get_search_query(), '/');
			printf('<p>%s</p>', preg_replace("/\b{$sq}\b/i", '<mark class="search">\0</mark>', get_the_excerpt()));
		} else {
			if (!post_password_required()) {
				$tags = array();
				$terms = get_the_terms(get_the_ID(), 'portfolio-item-tag');
				if ($terms !== false) {
					foreach ($terms as $term) {
						$tags[] = sprintf('<span>%s</span>', $term->name);
					}
					printf('<p class="tags">%s</p>', implode(' ', $tags));
				}
			}
			the_content(Website::getThemeOption('post/readmore'));
			if (is_singular()) {
				$pagination = wp_link_pages(array(
					'before' => '',
					'after'  => '',
					'echo'   => false
				));
				if ($pagination) {
					printf('<div class="pagination">%s</div>', preg_replace('/ ([0-9]+)/', ' <span class="current">\1</span>', $pagination));
				}
			}
		}
	?></div>
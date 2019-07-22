<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */

// Option path
$option_path = 'meta'.(get_post_type() == 'post' ? (is_singular() ? '/single' : '/list') : '');
$theme_option_path = get_post_type().'/'.$option_path;
$post_option_path  = 'options/'.str_replace('/', '_', $option_path);

// Meta visibility
$visible = Website::getInheritOption($post_option_path, $theme_option_path.'/visible');

// Meta
if ($visible === true || $visible === 'on') {

	$meta_items = Website::getThemeOption($theme_option_path.'/items');

	if (!empty($meta_items)) {

		echo '<ul class="meta">';

		foreach ($meta_items as $meta_item) {

			switch ($meta_item) {
				case 'comments':
					if (Website::getThemeOption(get_post_type().'/comments') && (comments_open() || have_comments())) {
						Website::postMetaFormat('<li class="comments"><a href="%comments_link%" title="%comments_number_esc%">%comments_number%</a></li>');
					}
					break;
				case 'author':
					Website::postMetaFormat('<li class="author"><a href="%author_link%" title="%author_name_esc%">%author_name%</a></li>');
					break;
				case 'date':
					Website::postMetaFormat('<li class="date"><a href="%date_month_link%" title="%s">%date%</a></li>', sprintf(__('View all posts from %s', 'website'), get_the_date('F')));
					break;
				case 'category':
					if ($category_list = Website::getPostMeta('category_list')) {
						printf('<li class="category">%s</li>', $category_list);
					}
					break;
				case 'tags':
					if ($tags_list = Website::getPostMeta('tags_list')) {
						printf('<li class="tags">%s</li>', $tags_list);
					}
					break;
				case 'link':
					Website::postMetaFormat('<li class="link"><a href="%link%" title="%title_esc%">%s</a></li>', __('Permalink', 'website'));
					break;
				case 'edit':
					if ($link_edit = Website::getPostMeta('link_edit')) {
						printf('<li class="edit"><a href="%1$s" title="%2$s">%2$s</a></li>', $link_edit, __('Edit', 'website'));
					}
					break;
			}

		}

		echo '</ul>';

	}

}
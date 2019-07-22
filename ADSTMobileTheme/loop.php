<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */

if (have_posts()) {

	// Posts loop
	while (have_posts()) {

		// Post
		the_post();
		$post_type = get_post_type();
		switch ($post_type) {
			case 'post':
				$post_format = get_post_format();
				$post_class  = $post_format or $post_class = 'default';
				break;
			case 'portfolio-item':
				$post_format = Website::getPostOption('format/format');
				$post_class  = 'page';
				break;
			case 'attachment':
				$post_format = null;
				$post_class  = 'page';
				break;
			default:
				$post_type   = 'page';
				$post_format = null;
				$post_class  = 'page';
		}

		// Post article
		printf('<article id="post-%s" class="%s">', get_the_ID(), implode(' ', get_post_class(array('post', $post_class))));
		get_template_part('main-'.$post_type, $post_format);
		//locate_template(array("main-{$post_type}-{$post_format}.php", "main-{$post_type}.php", 'main-page.php'), true, false);
		if (is_singular()) {
			get_template_part('about', 'index');
		}
		if (!is_search() && !is_attachment()) {
			get_template_part('social', 'index');
			get_template_part('meta', 'index');
		}
		echo '</article>';

		// Navigation
		if (is_single() && Website::getThemeOption(get_post_type().'/navigation')) { // todo: custom post type? dodac or === null?
			echo '<div class="pagination">';
			previous_post_link('%link');
			next_post_link('%link');
			echo '</div>';
		}

		// Comments
		if (Website::getThemeOption(get_post_type().'/comments')) { // todo: custom post type? dodac or === null?
			comments_template(); 
		}

	}

	// Pagination
	if (is_home() || is_archive() || is_search()) {
		$pagination = paginate_links(array(
			'base'      => str_replace('99999999', '%#%', get_pagenum_link(99999999)),
			'current'   => max(1, get_query_var('paged')),
			'total'     => $wp_query->max_num_pages,
			'prev_next' => Website::getThemeOption('post/pagination') == 'numbers_navigation',
			'prev_text' => __('next posts', 'website'),
			'next_text' => __('previous posts', 'website')
		));
		if ($pagination) {
			printf('<div class="pagination">%s</div>', $pagination);
		}
	}

} else {

	// No posts
	if (is_search()) {
		$title = __('Sorry, but nothing matched your search criteria.', 'website');
	} else if (is_404()) {
		$title = __('Sorry, but the page you requested could not be found.', 'website');
	} else {
		$title = __('Sorry, but no posts were found.', 'website');
	}
	?>
	<article class="post page">
		<section class="main">
			<h1 class="title"><?php echo $title; ?></h1>
		</section>
	</article>
	<?php

}

wp_reset_query();
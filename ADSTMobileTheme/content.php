<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */
?>

<?php $post_format = get_post_format() or $post_format = 'default'; ?>

										

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
		
		<div id="newsletterReturnBTN">View All <?php
$cats=get_the_category();
$cid=array();
foreach($cats as $cat)  { $cid[]=$cat->cat_ID; }
    $cid=implode(',', $cid);
    foreach((get_categories('orderby=id&include='.$cid)) as $category) { // notice orderby
        echo '<a href="'.get_category_link($category->cat_ID).'">'.$category->cat_name.'</a> '; // keep a space after </a> as seperator 
    }
	
?>	 Articles.</div>


		
<?php endif; ?>
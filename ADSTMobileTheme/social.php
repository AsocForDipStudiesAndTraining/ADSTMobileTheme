<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */

// Option path
$option_path = 'social'.(get_post_type() == 'post' ? (is_singular() ? '/single' : '/list') : '');
$theme_option_path = get_post_type().'/'.$option_path;
$post_option_path  = 'options/'.str_replace('/', '_', $option_path);

// Social visibility
$visible = Website::getInheritOption($post_option_path, $theme_option_path.'/visible');

// Social
if ($visible === true || $visible === 'on') {

	$social_items = Website::getThemeOption($theme_option_path.'/items');

	if (!empty($social_items)) {

		echo '<ul class="social clear">';

		$permalink = get_permalink();

		foreach ($social_items as $social_item) {

			switch ($social_item) {
				case 'twitter':
					printf('<li><a href="https://twitter.com/share" class="twitter-share-button" data-url="%s" data-text="%s" data-count="horizontal">Tweet</a></li>', $permalink, esc_attr(get_the_title()));
					break;
				case 'facebook':
					printf('<li><div class="fb-like" data-href="%s" data-send="false" data-layout="button_count"></div></li>', $permalink);
					break;
				case 'googleplus':
					printf('<li><div class="g-plusone" data-size="medium" data-href="%s"></div></li>', $permalink);
					break;
				case 'pinterest':
					if (has_post_thumbnail()) {
						list($thumbnail_src) = wp_get_attachment_image_src(get_post_thumbnail_id(), '');
					} else {
						$thumbnail_src = '';
					}
					printf('<li><a href="http://pinterest.com/pin/create/button/?url=%s&amp;media=%s&amp;description=%s" class="pin-it-button" count-layout="horizontal"><img border="0" src="http://assets.pinterest.com/images/PinExt.png" title="Pin It" /></a></li>', urlencode($permalink), urlencode($thumbnail_src), urlencode(get_the_title()));
					break;
			}

		}

		echo '</ul>';

	}

}
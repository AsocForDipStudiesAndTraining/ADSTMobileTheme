<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */

if ($slider = Website::getSliderName()) {

	// Slider query
	$slider_query = new WP_Query(array(
		'post_type'   => 'slider',
		'post_status' => 'publish',
		'p'           => $slider
	));

	if ($slider_query->have_posts()) {

		// Slider options
		$slider_query->the_post();
		$slider_items    = Website::getPostOption('content/items');
		$slider_type     = Website::getPostOption('options/type');

		// Slider items query
		$slider_items_query = new WP_Query(array(
			'post_type'      => 'slider-item',
			'post_status'    => 'publish',
			'post__in'       => empty($slider_items) ? array(0) : $slider_items,
			'posts_per_page' => -1,
			'orderby'        => Website::getPostOption('options/orderby'),
			'order'          => strtoupper(Website::getPostOption('options/order')),
		));

		$banners      = array();
		$slides       = array();
		$descriptions = array();

		// Additional banners

		for ($i = 1; $i <= 2; $i++) {

			// Banner
			$banner = Website::getResponsiveImage(Website::getPostOption("banner_{$i}/image"))->attr('data-side', 'both')->html();

			// Banner caption
			if ($caption = Website::getPostOption("banner_{$i}/caption")) {
				$banner .= sprintf(
					'<span class="caption %s">%s</span>',
					Website::getPostOption("banner_{$i}/color"),
					$caption
				);
			}

			// Banner link
			if ($link = Website::getPostOption("banner_{$i}/link")) {
				$banner = sprintf('<a href="%s">%s</a>', $link, $banner);
			}

			// Banner
			$banner = sprintf('<div class="banner small image %s">%s</div>', $i == 1 ? 'second' : 'third', $banner);
			$banners[] = $banner;

		}
		
		?>
		
		
		
		<?php


		// Slider items
		while ($slider_items_query->have_posts()) {

			// Slider item options
			$slider_items_query->the_post();

			// Slide
			if ($video = Website::getPostOption('video/code')) {

				// YouTube
				$video = preg_replace_callback(
					'|src="(http://www.youtube.com/embed/[-_a-z0-9]+)\??(.*?)"|i',
					create_function('$m', 'return sprintf("src=\"%s?wmode=opaque%s\"", $m[1], isset($m[2]) && $m[2] ? "&amp;".$m[2] : "");'),
					$video
				);

				// Slide video
				$slide = $video;

			} else {

				// Slide image
				if (!has_post_thumbnail()) {
					continue;
				}
				$slide = Website::getResponsiveThumbnail()->attr('data-side', 'both')->html();

				// Slide text
				if ($text = Website::getPostOption('content/text')) {
					$slide .= sprintf(
						'<span class="caption %s %s"><span>%s</span></span>',
						Website::getPostOption('content/color'),
						Website::getPostOption('content/align'),
						nl2br($text)
					);
				}

				// Slide link
				if ($link = Website::getPostOption('content/link')) {
					$slide = sprintf('<a href="%s" target="%s">%s</a>', $link, Website::getPostOption('content/target_blank') ? '_blank' : '_self', $slide);
				}

				// Slide caption
				if ($caption = Website::getPostOption('content/caption')) {
					$slide .= sprintf('<p class="flex-caption">%s</p>', $caption);
				}

			}

			// Slide
			$slide = sprintf('<li>%s</li>', $slide);
			$slides[] = $slide;

			// Description
			$description = '';

			// Description title
			if ($title = Website::getPostOption('description/title')) {
				$description .= sprintf('<h1>%s</h1>', $title);
			}

			// Description text
			if ($text = Website::getPostOption('description/text')) {
				if ($tablet_text = Website::getPostOption('description/tablet_text')) {
					$description .= sprintf(
						'<div class="hide-tablet">%s</div>'.
						'<div class="tablet">%s</div>',
						DroneFunc::stringToHTML($text),
						DroneFunc::stringToHTML($tablet_text)
					);
				} else {
					$description .= DroneFunc::stringToHTML($text);
				}
			}

			// Description link
			if ($link = Website::getPostOption('description/link')) {
				$description .= sprintf('<p><a href="%s" class="more">%s</a></p>', $link, Website::getPostOption('description/more'));
			}

			// Description
			$description = sprintf('<article>%s</article>', $description);
			$descriptions[] = $description;

		}

		// Output
		echo '<div id="banners" class="clear">';

		switch ($slider_type) {
			case 'full':
				?>
				<div class="banner full flexslider fixed">
					<ul class="slides">
						<?php echo implode('', $slides); ?>
					</ul>
				</div>
				<?php
				break;
			case 'one_two':
				?>
				<div class="banner big flexslider fixed alpha">
					<ul class="slides">
						<?php echo implode('', $slides); ?>
					</ul>
				</div>
				<div class="beta hpButtons">
					<!-- <?php echo implode('', $banners); ?> -->					
					
					
				<div class="buttonRow row1">
						
						
				<?php
 
				// check if the repeater field has rows of data
				if( have_rows('homepage_banner', 2389) ):
				 
				 	// loop through the rows of data
				    while ( have_rows('homepage_banner', 2389) ) : the_row(); ?>
									
					<a href="<?php the_sub_field('banner_link'); ?>" <?php if( get_sub_field('open_new_window') ): ?>target="_blank"<?php endif; ?> >
						
						<?php 
							// pull in the product image
							$image = get_sub_field('banner_image');
							if( !empty($image) ):
						 ?>
							 
							<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
							
							<?php endif; ?>
					
					</a>
				 
				 <?php
				 
				endwhile;
				 
				else :
				 
				    // no rows found
				 
				endif;
				 
				?>
						
				</div>  <!--.row1 -->
					
					
				</div>
				<?php
				break;
				case 'one_text':
				?>
				<div class="banner">
					<div class="alpha big flexslider fixed">
						<ul class="slides">
							<?php echo implode('', $slides); ?>
						</ul>
					</div>
					<div class="descriptions beta">
						<?php echo implode('', $descriptions); ?>
					</div>
				</div>
				<?php
				break;
		}

		echo '</div>';

		// Reset query
		wp_reset_query();

	}

}
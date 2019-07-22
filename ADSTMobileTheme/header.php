<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */
?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>

	<!-- Head section -->
	<head>

		<?php $template_uri = get_template_directory_uri(); ?>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
		<meta name="description" content="<?php echo esc_attr(get_bloginfo('description')); // todo: do Drone'a przeniesc jak OGP ?>" />

		<title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>

		<?php if (defined('WEBSITE_DEBUG') && WEBSITE_DEBUG): ?>
			<link rel="stylesheet" href="<?php echo $template_uri; ?>/data/css/fancybox.css" />
			<link rel="stylesheet" href="<?php echo $template_uri; ?>/data/css/flexslider.css" />
			<link rel="stylesheet" href="<?php echo $template_uri; ?>/data/css/tipsy.css" />
			<link rel="stylesheet" href="<?php echo $template_uri; ?>/data/css/base.css" />
			<link rel="stylesheet" href="<?php echo $template_uri; ?>/data/css/structure.css" />
			<link rel="stylesheet" href="<?php echo $template_uri; ?>/data/css/parts.css" />
			<link rel="stylesheet" href="<?php echo $template_uri; ?>/data/css/widgets.css" />
			<link rel="stylesheet" href="<?php echo $template_uri; ?>/data/css/plugins.css" />
			<link rel="stylesheet" href="<?php echo $template_uri; ?>/data/css/<?php Website::themeOption('appearance/scheme'); ?>.css" />
		<?php else: ?>
			<link rel="stylesheet" href="<?php echo $template_uri; ?>/data/php/attach.php?f=fancybox.css,flexslider.css,tipsy.css,base.css,structure.css,parts.css,widgets.css,plugins.css,<?php Website::themeOption('appearance/scheme'); ?>.css" />
		<?php endif; ?>
		
		<link rel="stylesheet" href="<?php echo $template_uri; ?>/css/screen.css?v=1.7" />
		
<!--
/**
 * @license
 * MyFonts Webfont Build ID 2975222, 2015-02-18T18:57:57-0500
 * 
 * The fonts listed in this notice are subject to the End User License
 * Agreement(s) entered into by the website owner. All other parties are 
 * explicitly restricted from using the Licensed Webfonts(s).
 * 
 * You may obtain a valid license at the URLs below.
 * 
 * Webfont: GillSansMTStd-Bold by Monotype 
 * URL: http://www.myfonts.com/fonts/mti/gill-sans/std-bold/
 * Copyright: Font software Copyright 2001 Adobe Systems Incorporated. Typeface designs
 * Copyright The Monotype Corporation. All Rights Reserved.
 * 
 * Webfont: GillSansMTStd-BoldItalic by Monotype 
 * URL: http://www.myfonts.com/fonts/mti/gill-sans/std-bold-italic/
 * Copyright: Font software Copyright 2001 Adobe Systems Incorporated. Typeface designs
 * Copyright The Monotype Corporation. All Rights Reserved.
 * 
 * Webfont: GillSansMTStd-Book by Monotype 
 * URL: http://www.myfonts.com/fonts/mti/gill-sans/std-book/
 * Copyright: Font software Copyright 1990, 1991, 1998 Adobe Systems Incorporated.
 * Typeface designs Copyright The Monotype Corporation. All rights reserved.
 * 
 * Webfont: GillSansMTStd-BookItalic by Monotype 
 * URL: http://www.myfonts.com/fonts/mti/gill-sans/std-book-italic/
 * Copyright: Font software Copyright 1990, 1991, 1998 Adobe Systems Incorporated.
 * Typeface designs Copyright The Monotype Corporation. All rights reserved.
 * 
 * 
 * License: http://www.myfonts.com/viewlicense?type=web&buildid=2975222
 * Licensed pageviews: 250,000
 * 
 * © 2015 MyFonts Inc
*/

-->
<link rel="stylesheet" type="text/css" href="/MyFontsWebfontsKit.css">
				

		<?php if (Website::getNotEmptyThemeOption('appearance/font/enabled') && $font = Website::getNotEmptyThemeOption('appearance/font/name', 'appearance/font/custom_name')): ?>
			<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=<?php echo urlencode($font); ?>&amp;subset=<?php echo implode(',', Website::getThemeOption('appearance/font/subset')); ?>" data-noprefix />
		<?php endif; ?>

		<!--[if lte IE 9]>
		<link rel="stylesheet" href="<?php echo $template_uri; ?>/data/css/ie9.css" />
		<![endif]-->
		<!--[if lte IE 8]>
		<link rel="stylesheet" href="<?php echo $template_uri; ?>/data/css/ie8.css" />
		<script src="<?php echo $template_uri; ?>/data/js/html5.js"></script>
		<script src="<?php echo $template_uri; ?>/data/js/respond.min.js"></script>
		<![endif]-->

		<script>
			websiteConfig = {
				timThumbPath:      '<?php echo $template_uri; ?>/data/php/timthumb.php',
				timThumbQuality:   {
					desktop: <?php Website::themeOption('advanced/timthumb/quality/desktop'); ?>,
					tablet:  <?php Website::themeOption('advanced/timthumb/quality/desktop'); ?>,
					mobile:  <?php Website::themeOption('advanced/timthumb/quality/mobile'); ?>,
					mini:    <?php Website::themeOption('advanced/timthumb/quality/mobile'); ?>
				},
				jwplayerPath:      '<?php Website::jwplayerPath(); ?>',
				jwplayerSkinFile:  '<?php Website::jwplayerSkinFile(); ?>',
				jwplayerSkinHeight: <?php Website::themeOption('advanced/jwplayer/skin/height'); ?>,
				flexsliderOptions:  <?php echo json_encode(DroneFunc::arrayKeysToCamelCase(Website::getThemeOption('slider/prop', true)->toArray())); ?>
			};
		</script>

<style>

@media only screen and (min-width: 700px) {

	
}

@media only screen and (min-width: 820px) {

	

}

@media only screen and (min-width: 940px) {

	
#nav-main-desktop li {
	/* margin-right: 24px; */
}

}



@media only screen and (min-width: 1050px) {

	

}

</style>


		<?php

			//wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-cookie');

			if (defined('WEBSITE_DEBUG') && WEBSITE_DEBUG) {
				wp_enqueue_script('website-fancybox',   $template_uri.'/data/js/jquery.fancybox.min.js');
				wp_enqueue_script('website-flexslider', $template_uri.'/data/js/jquery.flexslider.min.js');
				wp_enqueue_script('website-flickr',     $template_uri.'/data/js/jquery.jflickrfeed.min.js');
				wp_enqueue_script('website-masonry',    $template_uri.'/data/js/jquery.masonry.min.js');
				wp_enqueue_script('website-tipsy',      $template_uri.'/data/js/jquery.tipsy.min.js');
				wp_enqueue_script('website-twitter',    $template_uri.'/data/js/jquery.tweet.min.js');
				wp_enqueue_script('website-yaselect',   $template_uri.'/data/js/jquery.yaselect.min.js');
				wp_enqueue_script('website-prefixfree', $template_uri.'/data/js/prefixfree.min.js');
				wp_enqueue_script('website',            $template_uri.'/data/js/website.js');
			} else {
				wp_enqueue_script('website',            $template_uri.'/data/php/attach.php?f=jquery.fancybox.min.js,jquery.flexslider.min.js,jquery.jflickrfeed.min.js,jquery.masonry.min.js,jquery.tipsy.min.js,jquery.tweet.min.js,jquery.yaselect.min.js,prefixfree.min.js,website.min.js');
			}

		wp_head();

		?>



	</head>
	<!-- // Head section -->

	<body <?php body_class(); ?>>

		<div class="outerContainer">

		<!-- Browser notification -->
		<!--googleoff: all-->
		<div class="browser-notification ie6">
			<p><?php printf(__('Your browser (Internet Explorer 7 or lower) is <strong>out of date</strong>. It has known <strong>security flaws</strong> and may <strong>not display all features</strong> of this and other websites. <a href="%s">Learn how to update your browser</a>.', 'website'), 'http://www.browser-update.org/update.html'); ?></p>
			<div class="close">X</div>
		</div>
		<!--googleon: all-->
		<!-- // Browser notification -->

		<?php if (count($nav_top_visible = Website::getThemeOption('nav/top/visible')) > 0): ?>
			<!-- Top section -->
			<?php
				$top_class = '';
				if (Website::getThemeOption('nav/top/fixed')) {
					$top_class .= 'fixed ';
				}
				if (count($nav_top_visible) == 1) {
					$top_class .= sprintf('%slte-mobile ', $nav_top_visible[0] == 'desktop' ? 'hide-' : '');
				}
			?>			
			<header id="top" class="<?php echo trim($top_class); ?>">
				<div class="container">

					<h1><?php _e('Navigate / search', 'website'); ?></h1>

					<div class="frame">

						<div class="inner">

							<!-- Search form -->
							<form action="<?php echo esc_url(home_url('/')); ?>" method="get">
								<section id="search">
									<input type="submit" value="" />
									<div class="input">
										<input name="s" type="text" placeholder="<?php esc_attr_e('search', 'website'); ?>" value="<?php echo get_search_query(); ?>" />
									</div>
								</section>
							</form>
							<!-- // Search form -->

						</div><!-- // .inner -->

						<!-- Top navigation -->
						<?php Website::navMenu('top'); ?>
						<!-- // Top navigation -->

					</div><!-- // .frame -->

				</div>
			</header>
			<!-- // Top section -->
		<?php endif; ?>
		
		<!-- Main section -->

		<div id="main" class="clear">
			<div class="container">
				
				<!-- Header -->	
					<header id="header" class="clear">
					<?php
						extract(Website::getThemeOption('header', true)->toArray());
						$ad['enabled'] = $ad['enabled'] && ($ad['image'] || $ad['code']);
						if (defined('WEBSITE_SCHEME_SWITCHER') && WEBSITE_SCHEME_SWITCHER) {
							$scheme        = Website::getThemeOption('appearance/scheme');
							$ad['image']   = str_replace('%scheme%', $scheme, $ad['image']);
							$logo['image'] = str_replace('%scheme%', $scheme, $logo['image']);
						}
					?>
					<hgroup class="alpha<?php if (!$ad['enabled'] || $logo['center']) echo ' noad'; ?>">
						<h1 class="alpha vertical<?php if ($logo['center']) echo ' center'; ?>">
							<span>
								<a class="headerLogo" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr($logo['text']); ?>">
									<?php echo $logo['image'] ? sprintf('<img src="%s" alt="%s" />', $logo['image'], esc_attr($logo['text'])) : $logo['text']; ?>
								</a>
							</span>				
						</h1>
						
<!-- UNCOMMENT TO ADD TAGLINE BACK TO WEBSITE
						<?php if ($tagline && !$logo['center']): ?>
						<h2 class="vertical">
							<span><?php echo preg_replace('/\s*_\s*/', '&nbsp;', $tagline); ?></span>
						</h2>
					<?php endif; ?>
-->
						</hgroup>
					<?php if ($ad['enabled'] && !$logo['center']): ?>
						<div class="ad beta vertical<?php if ($ad['hide_mobile']) echo ' hide-lte-mobile'; ?>">
							<div>
								<?php
									if ($ad['code']) {
										echo do_shortcode($ad['code']);
									} else if ($ad['url']) {
										printf('<a href="%s"><img src="%s" alt="" /></a>', $ad['url'], $ad['image']);
									} else {
										printf('<img src="%s" alt="" />', $ad['image']);
									}
								?>	
							</div>
							</div>
					<?php endif; ?>
				</header>
				<!-- // Header -->

				<!-- Main navigation -->
				<?php Website::navMenu('main'); ?>
				<!-- // Main navigation -->
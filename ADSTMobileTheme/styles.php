<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */

// Leading color
$styles['leading_color'] = <<<EOT
	mark, .post .content .tags a:hover, .items .item .tags a:hover, .filter a:hover, .filter a.active {
		background-color: %1\$s;
	}
	a, .post .content button:hover, .comments .comment cite a:hover, .widget a:hover {
		border-color: %1\$s;
	}
	input[type="submit"]:hover {
		border-color: %1\$s !important;
	}
	a, #nav-top a:hover, #nav-main a:hover, #nav-main li.sub > a:hover:after, #bottom input[type="submit"]:hover, #footer a:hover, .breadcrumbs a:hover, .post .title a:hover, .comments .comment .meta a:hover, .comments .comment .meta cite a, .pagination a:hover {
		color: %1\$s;
	}
	.widget a:hover {
		color: %1\$s !important;
	}
EOT;

// Header height
$styles['header_height'] = <<<EOT
	#header h1,
	#header h2,
	#header .ad {
		height: %1\$dpx;
	}
	#header h1 img {
		max-height: %1\$dpx;
	}
EOT;

// Custom background
$styles['custom_background'] = <<<EOT
	#main {
		%s
	}
	#nav-main li ul li {
		background: %s;
	}
EOT;

// Custom font
$styles['custom_font'] = <<<EOT
	input[type="submit"],
	#nav-main,
	#header h1, #header h2,
	#banners article h1, #banners .small .caption,
	section.box h1,
	section.columns .column h1,
	.post .title, .post .content h1, .post .content h2, .post .content h3, .post .content h4, .post .content h5, .post .content h6, .post .content button, .post .content .dropcap, .post .about h1,
	.flexslider .slides .caption, .flexslider .flex-caption,
	#aside .widget h1,
	.widget-social li, .widget-info h1 {
		font-family: %s, Roboto;
	}
EOT;

// Slider height
$styles['slider_height']['full'] = <<<EOT
	#banners .banner.full {
		height: %dpx;
	}
	@media only screen and (max-width: 979px) { /* <= Tablet */
		#banners .banner.full {
			height: %dpx;
		}
	}
	@media only screen and (max-width: 739px) { /* <= Mobile */
		#banners .banner.full {
			height: %dpx;
		}
	}
	@media only screen and (max-width: 319px) { /* <= Mini */
		#banners .banner.full {
			height: %dpx;
		}
	}
EOT;

$styles['slider_height']['one_text'] = <<<EOT
	#banners .banner > .big {
		height: %dpx;
	}
	@media only screen and (max-width: 979px) { /* <= Tablet */
		#banners .banner > .big {
			height: %dpx;
		}
	}
	@media only screen and (max-width: 739px) { /* <= Mobile */
		#banners .banner > .big {
			height: %dpx;
		}
	}
	@media only screen and (max-width: 319px) { /* <= Mini */
		#banners .banner > .big {
			height: %dpx;
		}
	}
EOT;

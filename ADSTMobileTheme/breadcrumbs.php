<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */

if (($breadcrumbs = Website::getThemeOption('nav/breadcrumbs', true)) !== null) {

	if (DroneFunc::wpContitionTagSwitch($breadcrumbs->values())) {

		echo '<section class="breadcrumbs">';

		// http://wordpress.org/extend/plugins/breadcrumb-navxt/changelog/
		if (function_exists('bcn_display')) {
			bcn_display();
		}

		// http://wordpress.org/extend/plugins/breadcrumbs/
		else if (function_exists('yoast_breadcrumb')) {
			yoast_breadcrumb();
		}

		// http://wordpress.org/extend/plugins/breadcrumb-trail/
		else if (function_exists('breadcrumb_trail')) {
			breadcrumb_trail(array(
				'separator' => '&rsaquo;',
				'before'    => false,
				'after'     => false
			));
		}

		echo '</section>';

	}

}
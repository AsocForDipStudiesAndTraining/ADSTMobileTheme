<?php
/**
 * @template name: Contact form
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */

$contact_form_after = sprintf(
	'<p class="frame message"></p>'.
	'<p><input type="submit" value="%s" /><img class="load" src="%s/data/img/%s/load.gif" alt="" width="16" height="16" /></p>',
	__('Send', 'website'),
	Website::get('template_uri'),
	Website::getThemeOption('appearance/scheme')
);

add_filter('the_content', create_function(
	'$content',
	"return \$content.Website::contactForm('Website::contactFormField', '', '{$contact_form_after}', true);"
));

get_template_part('index', 'contact-form');
<?php
/**
 * @package Website_Theme
 * @since Website 1.0
 */

// -----------------------------------------------------------------------------

// Input validation
if (!isset($_GET['f']) || !preg_match('/\.(css|js)$/', $_GET['f'], $type_match)) {
	exit;
}

// Data
$type = $type_match[1];
$path = "./../{$type}/";

// Merging
$output = '';
foreach (explode(',', $_GET['f']) as $file) {
	if (preg_match("/^[-_a-z0-9\.]+\.{$type}$/i", $file) && file_exists($path.$file)) {
		$output .= trim(file_get_contents($path.$file));
	}
}

// Minimization
if ($type == 'css') {
	$regexpr = array(
		'|/\*.*\*/|sU' => '',
		'|\s*([:;,\{\}])\s*|' => '\1',
		'|[\r\n\t]+|' => ''
	);
	$output = preg_replace(array_keys($regexpr), array_values($regexpr), $output);
}
$output = trim($output);

// -----------------------------------------------------------------------------

// Content types
$content_types = array(
	'css' => 'text/css',
	'js'  => 'text/javascript'
);

// Output
header("Content-Type: {$content_types[$type]}; charset=utf-8");
echo $output;
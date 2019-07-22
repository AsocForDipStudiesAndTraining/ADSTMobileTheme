<?php
/**
 * @package Website_Theme
 * @since Website 1.0
 */

// -----------------------------------------------------------------------------

define('FILE_CACHE_TIME_BETWEEN_CLEANS', 7*86400);
define('FILE_CACHE_MAX_FILE_AGE', 30*86400);
define('FILE_CACHE_DIRECTORY', './../../../../../wp-content/uploads/timthumbcache/');

if (isset($_SERVER['SCRIPT_FILENAME']) && strpos($_SERVER['SCRIPT_FILENAME'], '/wp-content/') !== false) {
	$script_filename_parts = explode('/wp-content/', $_SERVER['SCRIPT_FILENAME']);
	define('LOCAL_FILE_BASE_DIRECTORY', $script_filename_parts[0]);
}

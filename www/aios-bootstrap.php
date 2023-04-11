<?php
/**	
 * @version 1.0.1
 * WARNING: Please do not delete this file.
 * 
 * This will cause PHP to throw a fatal error and render your site unusable.
 * 
 * To safely delete this file, please check both your .user.ini file and your php.ini file and ensure this file is not set in the auto_prepend_file directive.
 * 
 * Please ask your web hosting provider if you need guidance with executing the aforementioned steps.
 */
// Previously set auto_prepend_file
if (file_exists('/usr/share/php/prepend.php')) {
	include_once('/usr/share/php/prepend.php');
}
$GLOBALS['aiowps_firewall_rules_path'] = __DIR__.'/wp-content/uploads/aios/firewall-rules/';



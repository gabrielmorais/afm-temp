<?php
// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');


if ( !defined('ABSPATH') ) define('ABSPATH', dirname(__FILE__) );
if ( !defined('WP_ENV') ) define('WP_ENV', (($_ENV['ENV'] ?: getenv('ENV')) ?: 'production'));

require_once(ABSPATH . '/environments/' . WP_ENV . '.php');
require_once(ABSPATH . 'wp-settings.php');
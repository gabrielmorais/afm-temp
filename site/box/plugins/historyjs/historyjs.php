<?
/*
Plugin Name: History.js for WordPress
Plugin URI: http://www.ramoonus.nl/wordpress/historyjs/
Description: History.js gracefully supports the HTML5 History/State APIs (pushState, replaceState, onPopState) in all browsers.
Version: 1.8.0
Author: Ramoonus
Author URI: http://www.ramoonus.nl/
License: GPL2
*/

/* Javascript declarations for init */
function rw_historyjs_init() {
		wp_deregister_script('historyjs');
		wp_enqueue_script('historyjs', plugins_url('/js/jquery.history.js',__FILE__), array("jquery"), '1.8.0');

}    
add_action('wp_enqueue_scripts', 'rw_historyjs_init');
?>
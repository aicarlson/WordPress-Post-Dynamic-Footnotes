<?php
/*
 * Plugin Name: I need a hero...image
 * Description: A WordPress plugin that makes it easy to upload a hero image for each post.
 * Version: 0.1
 * Author: Andrew Carlson
 * Author URI: http://ivanthevariable.com
 * License: GPL2
 */

// Include our options page and its required functions, but only in the admin panel.

if (is_admin()) {
	require( plugin_dir_path( __FILE__ ) . "/options.php");
	require( plugin_dir_path( __FILE__ ) . "/post.php");
} else {
	require( plugin_dir_path( __FILE__ ) . "/front.php");
};
?>
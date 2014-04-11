<?php
/*
 * Plugin Name: Integrated Footnotes
 * Description: A WordPress plugin that integrates footnotes into the post content
 * Version: 0.1
 * Author: Andrew Carlson
 * Author URI: http://ivanthevariable.com
 * License: GPL2
 */

// Include our post meta functions for the post page...
if (is_admin()) {
	require( plugin_dir_path( __FILE__ ) . "/post.php");
};

// Include our shortcode and front facing stuffs...
require( plugin_dir_path( __FILE__ ) . "/shortcode.php" );
require( plugin_dir_path( __FILE__ ) . "/front.php" );
?>
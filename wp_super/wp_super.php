<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Plugin Name:       WP Super Plugin
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       This plugin will display Super at the footer section
 * Version:           1.0.0
 * Author:            Halogenius
 * License:           GPL v2 or later
*/

// Register all Hooks
// Plugin is activated
if (function_exists('register_activation_hook')) {
	register_activation_hook(__FILE__,  'activationHook');
}
//Plugin is deactivated
if (function_exists('register_deactivation_hook')) {
	register_deactivation_hook(__FILE__,  'deactivationHook');
}
//Plugin is uninstalled
if (function_exists('register_uninstall_hook')) {
	register_uninstall_hook(__FILE__,  'uninstallHook');
}

// Define all hooks
// Plugin is activated
function activationHook()
{
	//Input word "Super!" to the database
	if (! get_option('wp_Super')) {
  	add_option('wp_Super', 'Super!');
	}
}

// Plugin is deactivated
function deactivationHook()
{
	delete_option('wp_Super');
}

// Plugin is uninstalled
function uninstallHook()
{
	delete_option('wp_Super');
}

// To Add a filter to the footer on the site
// Step 1: Create the filter
function filter_footer(){

  // Get the value of super
  $wp_super = get_option('wp_Super');
  ?>
    <!-- Now output the value of the super -->
    <div class="super"><?php echo $wp_super; ?></div>
  <?php

}
// Step 2: Register the custom filter in wordpress as one of the wp footer
add_filter('wp_footer','filter_footer');

// Every HTML elemento which is the web page has the css styles linked to the header section. Now let's define custom css file and link it to the header
// Create the filter
function filter_head(){
  wp_enqueue_style('super-link-css',plugins_url('css/super_style.css',__FILE__),array());
}

// Register the css in the head
add_filter('wp_head','filter_head');
?>

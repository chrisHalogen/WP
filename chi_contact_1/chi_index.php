<?php
// To deny anyone access to this file directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Plugin Header Information
/*
Plugin Name: HID Contact Forminator
Plugin URI: https://github.com/chrishalogen
Version: 1.0
Description: This plugin is designed to create a contact form
Author: Christian Chi Nwikpo
Author URI: https://github.com/chrishalogen
License: GPU
Text Domain: chi
*/

// The default plugin class Class
// class Chi_WP_Contact{
//
//   public function __construct(){
//
//     // Register Activation Hook
//     if ( function_exists( 'register_activation_hook' ) ) {
//     	register_activation_hook( __FILE__ ,  array( $this ,'activationHook' ) );
//     }
//
//     // Adds the PHP file carrying all the scripts to the head section of WordPress
//     add_filter('wp_head',array($this,'head_filter'));
//
//     // Register Deactivation Hook
//     if ( function_exists( 'register_deactivation_hook' ) ) {
//     	register_deactivation_hook( __FILE__ , array( $this , 'deactivationHook' ) );
//     }
//   }
// }
//
// $main_instance = new Chi_WP_Contact();

require_once plugin_dir_path(__FILE__) . 'functions.php';

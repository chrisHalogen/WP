<?php
// To deny anyone access to this file directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Plugin Header Information
/*
Plugin Name: HID CRUD Plugin
Plugin URI: https://github.com/chrishalogen
Version: 1.0
Description: This plugin is designed to perform CRUD operations in the admin dashboard
Author: Christian Chi Nwikpo
Author URI: https://github.com/chrishalogen
License: GPU
Text Domain: chi
*/

// The default plugin class Class
class Chi_WP_CRUD{

  public function __construct(){

    // Register Activation Hook
    if ( function_exists( 'register_activation_hook' ) ) {
    	register_activation_hook( __FILE__ ,  array( $this ,'activationHook' ) );
    }

    // Register Deactivation Hook
    if ( function_exists( 'register_deactivation_hook' ) ) {
    	register_deactivation_hook( __FILE__ , array( $this , 'deactivationHook' ) );
    }
  }

  public function activationHook(){
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'crud_users_table';
    $sql = "CREATE TABLE `$table_name` (
    `user_id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(220) DEFAULT NULL,
    `email` varchar(220) DEFAULT NULL,
    PRIMARY KEY(user_id)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
    ";
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
    }
  }

  public function deactivationHook(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'crud_users_table';
    $wpdb->query("DROP TABLE IF EXISTS " . $table_name);
  }
}





$main_instance = new Chi_WP_CRUD();

require_once plugin_dir_path(__FILE__) . 'crud_functions.php';

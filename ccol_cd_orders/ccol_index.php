<?php

// To deny anyone access to this file directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Plugin Header Information
/*
Plugin Name: CCOL CD Bookings
Plugin URI: https://github.com/chrishalogen
Version: 1.0
Description: This plugin is designed to handle all CD booking operations of Chapel of Christ our Light University of Lagos.
Author: Christian Chi Nwikpo
Author URI: https://github.com/chrishalogen
License: GPU
Text Domain: ccol
*/


// The default plugin class Class
class CCOL_Bookings{

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

  public function ccol_create_preachers_table(){
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'ccol_preachers';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
  		id mediumint(9) NOT NULL AUTO_INCREMENT,
  		name tinytext NOT NULL,
  		PRIMARY KEY  (id)
  	  ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'jal_db_version', $jal_db_version );
  }

  public function ccol_create_sermons_table(){
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'ccol_sermons';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
  		id mediumint(9) NOT NULL AUTO_INCREMENT,
  		title text NOT NULL,
      preacher_id tinyint NOT NULL,
      sermonDate date NOT NULL,
  		PRIMARY KEY  (id)
  	  ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'jal_db_version', $jal_db_version );
  }

  public function ccol_create_sermons_bookings_table(){
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'ccol_sermons_booking';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
  		id mediumint(9) NOT NULL AUTO_INCREMENT,
  		firstName tinytext NOT NULL,
      lastName tinytext NOT NULL,
      sermon_id tinyint NOT NULL,
      number_of_copies tinyint NOT NULL,
      order_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
      paid boolean NOT NULL,
      delivered boolean NOT NULL,
  		PRIMARY KEY  (id)
  	  ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'jal_db_version', $jal_db_version );
  }

  public function activationHook(){
    $this->ccol_create_preachers_table();
    $this->ccol_create_sermons_table();
    $this->ccol_create_sermons_bookings_table();

  }

  public function deactivationHook(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'ccol_sermons_booking';
    $wpdb->query("DROP TABLE IF EXISTS " . $table_name);

    $table_name = $wpdb->prefix . 'ccol_sermons';
    $wpdb->query("DROP TABLE IF EXISTS " . $table_name);

    $table_name = $wpdb->prefix . 'ccol_preachers';
    $wpdb->query("DROP TABLE IF EXISTS " . $table_name);

  }

}

$main_instance = new CCOL_Bookings();


// returns the root directory path of particular plugin
define('CCOL_ROOTDIR', plugin_dir_path(__FILE__));
require_once(CCOL_ROOTDIR . 'ccol_functions.php');

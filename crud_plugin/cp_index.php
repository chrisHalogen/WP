<?php

// Plugin Header Information
/*
Plugin Name: HID Crud Operations
Plugin URI: https://github.com/chrishalogen
Version: 1.0
Description: This plugin is designed to perform CRUD operations with the Vendors Database table
Author: Christian Chi Nwikpo
Author URI: https://github.com/chrishalogen
License: GPU
Text Domain: chi_crud
*/

//--------------Activation Hook-----------------
global $jal_db_version;

$jal_db_version = '1.0';

function jal_install() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'vendors';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		name tinytext NOT NULL,
		officeAddress text NOT NULL,
		niche text NOT NULL,
		contact bigint(12),
		PRIMARY KEY  (id)
	) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'jal_db_version', $jal_db_version );
}

register_activation_hook( __FILE__, 'jal_install' );


//--------------Deactivation Hook----------------------
// plugin deactivation hook
register_deactivation_hook(__FILE__, 'deactivation_function');

// callback function to drop table
function deactivation_function()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'vendors';
    $wpdb->query("DROP TABLE IF EXISTS " . $table_name);
}

//----------adding in menu------------------------
add_action('admin_menu', 'crud_plugin_menu');

function crud_plugin_menu() {
    //adding plugin in menu
    add_menu_page('All Vendors', //page title
        'Vendor Listing', //menu title
        'manage_options', //capabilities
        'Vendors_Listing', //menu slug
        'vendor_list', //function
        'dashicons-move'
    );
    //adding submenu to a menu
    add_submenu_page('Vendors_Listing',//parent page slug
        'vendor_insert',//page title
        'Vendors Insert',//menu titel
        'manage_options',//manage optios
        'Vendor_Insert',//slug
        'vendor_insert'//function
    );
    add_submenu_page( 'Vendors_Listing',//parent page slug
        'vendor_update',//$page_title
        'Vendors Update',// $menu_title
        'manage_options',// $capability
        'Vendor_Update',// $menu_slug,
        'vendor_update'// $function
    );
    add_submenu_page( 'Vendors_Listing',//parent page slug
        'vendor_delete',//$page_title
        'Vendor Delete',// $menu_title
        'manage_options',// $capability
        'Vendor_Delete',// $menu_slug,
        'vendor_delete'// $function
    );
}


// returns the root directory path of particular plugin
define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'vendors_list.php');
require_once (ROOTDIR.'vendors_insert.php');
require_once (ROOTDIR.'vendors_update.php');
require_once (ROOTDIR.'vendors_delete.php');

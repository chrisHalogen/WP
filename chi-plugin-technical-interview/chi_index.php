<?php
// To deny anyone access to this file directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Plugin Header Information
/*
Plugin Name: CODJA Test Interview
Plugin URI: https://github.com/chrishalogen
Version: 1.0
Description: This plugin solves the Technical Interview test given to me by Mr. Michal Via LinkedIn. This plugin is supposed to list a table of users via Shortcode or Gutemberg block. I'll be using a Shortcode.
Author: Christian Chi Nwikpo
Author URI: https://github.com/chrishalogen
License: GPU
Text Domain: chi
*/


// The default plugin class Class
class Chi_WP_List_Users{

  public function __construct(){

    // Register Activation Hook
    if ( function_exists( 'register_activation_hook' ) ) {
    	register_activation_hook( __FILE__ ,  array( $this ,'activationHook' ) );
    }

    // Adds the PHP file carrying all the scripts to the head section of WordPress
    add_filter('wp_head',array($this,'head_filter'));

    // Register Deactivation Hook
    if ( function_exists( 'register_deactivation_hook' ) ) {
    	register_deactivation_hook( __FILE__ , array( $this , 'deactivationHook' ) );
    }
  }

  // Plugin is activated -> Runs this method on function activation
  public function activationHook(){

    // This function runs on activation and it's going to create all the users contained in the CSV file sent which is one less work for the user
    $all_users = [
      // Name, Email, Role
      ['Rebeka','rmacadam0@photobucket.com','subscriber'],
      ['Rayna','rdragon1@geocities.jp','author'],
      ['Reine','rshimmin2@example.com','author'],
      ['Lorenza','lhalleybone3@ibm.com','author'],
      ['Pammie','ppippard4@businessweek.com','author'],
      ['Adham','amcmakin5@hatena.ne.jp','subscriber'],
      ['Cirillo','crimell6@google.com.br','editor'],
      ['Essie','egalland7@ucla.edu','subscriber'],
      ['Charmane','csliman8@bloglines.com','subscriber'],
      ['Sidonia','smaxsted9@chron.com','subscriber'],
      ['Artemus','apilsburya@de.vu','author'],
      ['Ivar','iovershottb@symantec.com','editor'],
      ['Franklyn','fclackersc@is.gd','author'],
      ['Tilly','tmacklind@twitter.com','author'],
      ['Anissa','aeichmanne@huffingtonpost.com','subscriber'],
      ['Marinna','mdysertf@1688.com','subscriber'],
      ['Tressa','tumang@cbslocal.com','subscriber'],
      ['Allard','abrushneenh@wikimedia.org','author'],
      ['Kyle','kjelleyi@csmonitor.com','author'],
      ['Gretchen','gtoynej@adobe.com','author'],
      ['Winna','wharkinsk@elpais.com','subscriber'],
      ['Nelia','nsorleyl@github.io','subscriber'],
      ['Collin','cmckimmm@myspace.com','author'],
      ['Dirk','dkeedwelln@harvard.edu','editor'],
      ['Dara','dbritteno@lulu.com','subscriber'],
      ['Moise','mwhiterodp@xrea.com','subscriber'],
      ['Charley','ctoffoloq@elegantthemes.com','editor'],
      ['Hunt','hcokayner@alibaba.com','editor'],
      ['Faulkner','fbortols@google.cn','editor'],
      ['Maridel','mmoylanet@constantcontact.com','editor'],
      ['Quinton','qchatten0@simplemachines.org','editor'],
      ['Janek','jpardey1@istockphoto.com','editor'],
      ['Kalie','kmccorkell2@addtoany.com','editor'],

    ];

    // For every user contained in the list, if no one is registered with the user's eMail address, create a new user for the person
    foreach( $all_users as $user_instance ) {
      if ( ! get_user_by( 'email', $user_instance[1] ) ) {

        $user_id = wp_insert_user( array(
            'user_login' => $user_instance[1],
            'user_pass' => $user_instance[1] . $user_instance[0],
            'user_email' => $user_instance[1],
            'first_name' => $user_instance[0],
            'display_name' => $user_instance[0],
            'role' => $user_instance[2]
          )
        );
      }
    }

  }

  // Plugin is deactivated -> Runs this method on function deactivation
  public function deactivationHook(){

    // This function runs on deactivation and it's going to create all the users created upon activation of this plugin.
    $all_users = [
      // Name, Email, Role
      ['Rebeka','rmacadam0@photobucket.com','subscriber'],
      ['Rayna','rdragon1@geocities.jp','author'],
      ['Reine','rshimmin2@example.com','author'],
      ['Lorenza','lhalleybone3@ibm.com','author'],
      ['Pammie','ppippard4@businessweek.com','author'],
      ['Adham','amcmakin5@hatena.ne.jp','subscriber'],
      ['Cirillo','crimell6@google.com.br','editor'],
      ['Essie','egalland7@ucla.edu','subscriber'],
      ['Charmane','csliman8@bloglines.com','subscriber'],
      ['Sidonia','smaxsted9@chron.com','subscriber'],
      ['Artemus','apilsburya@de.vu','author'],
      ['Ivar','iovershottb@symantec.com','editor'],
      ['Franklyn','fclackersc@is.gd','author'],
      ['Tilly','tmacklind@twitter.com','author'],
      ['Anissa','aeichmanne@huffingtonpost.com','subscriber'],
      ['Marinna','mdysertf@1688.com','subscriber'],
      ['Tressa','tumang@cbslocal.com','subscriber'],
      ['Allard','abrushneenh@wikimedia.org','author'],
      ['Kyle','kjelleyi@csmonitor.com','author'],
      ['Gretchen','gtoynej@adobe.com','author'],
      ['Winna','wharkinsk@elpais.com','subscriber'],
      ['Nelia','nsorleyl@github.io','subscriber'],
      ['Collin','cmckimmm@myspace.com','author'],
      ['Dirk','dkeedwelln@harvard.edu','editor'],
      ['Dara','dbritteno@lulu.com','subscriber'],
      ['Moise','mwhiterodp@xrea.com','subscriber'],
      ['Charley','ctoffoloq@elegantthemes.com','editor'],
      ['Hunt','hcokayner@alibaba.com','editor'],
      ['Faulkner','fbortols@google.cn','editor'],
      ['Maridel','mmoylanet@constantcontact.com','editor'],
      ['Quinton','qchatten0@simplemachines.org','editor'],
      ['Janek','jpardey1@istockphoto.com','editor'],
      ['Kalie','kmccorkell2@addtoany.com','editor'],
    ];

    // For every user contained in the list, if the user exists, delete the user
    foreach( $all_users as $user_instance ) {

      $user = get_user_by( 'email', $user_instance[1] );
      if ( $user ) { // get_user_by can return false, if no such user exists
        wp_delete_user( $user->ID );
      }
    }

  }

  // The function used to add the main Javascript file
  public function head_filter(){
    include(sprintf('%s/assets/js/chi_main.php',dirname(__FILE__)));
  }
}

$list_all_users = new Chi_WP_List_Users();

// Require the Shortcode and Functions file to run the plugin
require_once plugin_dir_path(__FILE__) . 'shortcodes/chi_table_shortcode.php';
require_once plugin_dir_path(__FILE__) . 'functions.php';

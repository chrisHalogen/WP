<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Plugin Name:       WP to top
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       This plugin will scroll all the way to the top
 * Version:           1.0.0
 * Author:            Halogenius CHris
 * License:           GPL v2 or later
*/

class WP_TO_TOP{

  public $plugins_url = '';

  public function __construct(){
    // All Hooks and Filters will be here
    if (function_exists('register_activation_hook')) {
    	register_activation_hook(__FILE__,  array($this,'activationHook'));
    }

    if (function_exists('register_deactivation_hook')) {
    	register_deactivation_hook(__FILE__,  array($this,'deactivationHook'));
    }

    if (function_exists('register_uninstall_hook')) {
    	register_uninstall_hook(__FILE__, $this , 'uninstallHook');
    }

    add_filter('wp_head',array($this,'head_filter'));
    add_filter('wp_footer',array($this,'filter_footer'));

    add_action( 'init', array($this,'init') );

    // Add admin menu action
    add_action('admin_menu', array($this ,'Wp_to_top_admin_menu' ));
  }

  public function Wp_to_top_admin_menu(){
    add_options_page(
      'Wp to top', // Page title
      'Wp to top Settings', // Menu Title
      'manage_options', // Capability for display
      'Wp_To_Top_admin_menu', // menu slug
      array($this,'to_top_edit_settings') // Callback FUnction (Optional)
    );
  }

  // Link to the admin page
  public function to_top_edit_settings(){
    include(sprintf('%s/manage/admin.php',dirname(__FILE__)));
  }

  public function init(){
    $this->plugins_url = untrailingslashit(plugins_url('',__FILE__ ));
    // echo $this->plugins_url;

  }

  public function activationHook(){
    if (! get_option('Wp_to_top_color')){
      update_option('Wp_to_top_color','red');
    }
    if (! get_option('Wp_to_top_speed')){
      update_option('Wp_to_top_speed','slow');
    }
  }

  public function deactivationHook(){
    delete_option('Wp_to_top_color');
    delete_option('Wp_to_top_speed');
  }

  public function uninstallHook(){
    delete_option('Wp_to_top_color');
    delete_option('Wp_to_top_speed');
  }

  public function head_filter(){
    // Anoter form of enqueue style
    // We can't use enqueue here because we want to inject data from the database into our CSS file so we inject it as a php script
    include(sprintf('%s/css/to_top_style.php',dirname(__FILE__)));

    // Put Jquery in the head section
    wp_enqueue_script('jquery');
    wp_enqueue_script('to-top-link-js',$this->plugins_url.'/js/to_top.php', array());
    // include(sprintf('%s/js/to_top.php',dirname(__FILE__)));
  }

  public function filter_footer(){
    ?>
      <div class="To_top_btn" id="To_top_animate">
        <a href="#">↑</a>
      </div>
    <?php
  }
}

$wp_to_top_btn = new WP_TO_TOP();

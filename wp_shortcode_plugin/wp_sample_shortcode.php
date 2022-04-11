<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Plugin Name:       WP Sample Shortcode
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       This plugin will demonstrate how shortcodes are being used in WordPress
 * Version:           1.0.0
 * Author:            Halogenius CHris
 * License:           GPL v2 or later
*/

class WP_Shortcode_Plugin{
  public function __construct(){
    if (function_exists('register_deactivation_hook')) {
    	register_deactivation_hook(__FILE__,  array($this,'deactivationHook'));
    }

    if (function_exists('register_uninstall_hook')) {
    	register_uninstall_hook(__FILE__, $this , 'uninstallHook');
    }

    if (function_exists('register_activation_hook')) {
    	register_uninstall_hook(__FILE__, $this , 'activationHook');
    }

    //Color Picker
    add_action( 'admin_enqueue_scripts', array($this, 'admin_scripts'));

    //Admin page
    add_action('admin_menu', array($this, 'WP_short_code_admin_menu'));

    //Shortcode
    add_shortcode('WP_Sample_ShortCode', array($this, 'wp_shortcode_plugin_shortcode_hook'));

    //header hook (style/jQuery link)
    add_action('wp_head', array($this, 'filter_header'));

  }

  // Plugin is deactivated
  public function deactivationHook(){
    delete_option('wp_shortcode_plugin_btntitle');
    delete_option('wp_shortcode_plugin_shortcode');
    delete_option('wp_short_code_sample_backcolor');
    delete_option('wp_short_code_sample_namecolor');
    delete_option('wp_shortcode_plugin_btn_url');
  }
  // Plugin is deleted
  public function uninstallHook(){
    delete_option('wp_shortcode_plugin_btntitle');
    delete_option('wp_shortcode_plugin_shortcode');
    delete_option('wp_short_code_sample_backcolor');
    delete_option('wp_short_code_sample_namecolor');
    delete_option('wp_shortcode_plugin_btn_url');
  }

  public function activationHook(){
    //Value of the button
    if (! get_option('wp_shortcode_plugin_btntitle')) {
        update_option('wp_shortcode_plugin_btntitle', 'Facebook');
    }
    if (! get_option('wp_shortcode_plugin_shortcode')) {
        update_option('wp_shortcode_plugin_shortcode', '[WP_Sample_ShortCode]');
    }
    if (! get_option('wp_short_code_sample_backcolor')) {
        update_option('wp_short_code_sample_backcolor', 'white');
    }
    if (! get_option('wp_short_code_sample_namecolor')) {
        update_option('wp_short_code_sample_namecolor', 'black');
    }
  }

  //Include the admin page
  public function WP_short_code_admin_menu(){
    add_options_page('WP Short Code Plugin', 'WP Short Code setting' , 'manage_options' , 'WP_Short_Code_setting',array($this, 'wp_short_code_setting'));
    }

  //Link the admin page
  public function wp_short_code_setting(){
    include(sprintf("%s/manage/admin.php", dirname(__FILE__) ));
  }

  //Color Picker
  // $hook will make it assign on a specific page
  public function admin_scripts( $hook ) {

    //Assign color picker
    wp_enqueue_style( 'wp-color-picker' );

    //External javascript file
    wp_enqueue_script( 'colorpicker_script', plugins_url( '/js/shortcode_colorpicker.js', __FILE__ ),array( 'wp-color-picker' ), false, true );
	}

  // header
    public function filter_header(){
    wp_enqueue_style( 'sample_shortcode-link-css', plugins_url('/css/sample_style.css', __FILE__), array());
	}

  public function wp_shortcode_plugin_shortcode_hook() {

        $wp_shortcode_plugin_btntitle = get_option('wp_shortcode_plugin_btntitle');
        $wp_shortcode_plugin_btn_url = get_option('wp_shortcode_plugin_btn_url');
        $wp_short_code_sample_backcolor = get_option('wp_short_code_sample_backcolor');
    	$wp_short_code_sample_namecolor = get_option('wp_short_code_sample_namecolor');

        $html = '';
        $html .= '<div class="div_link";
                  style="border: solid #a4a4a4 1px; padding:10px; width:170px; text-align:center;
                  background-color:'.$wp_short_code_sample_backcolor.'">';
        $html .= '<a href="'.$wp_shortcode_plugin_btn_url.'"style="width:170px;text-decoration:none; font-size:15px !important;color:'.$wp_short_code_sample_namecolor.'" class="link">';
	    $html .= '<span>'.$wp_shortcode_plugin_btntitle.'</span>';
        $html .= '</a>';
        $html .= '</div>';

        // Don not use echo here. Make sure to use replace

	    return $html;

    }
}

$wp_Shortcode_Plugin = new WP_Shortcode_Plugin()




?>

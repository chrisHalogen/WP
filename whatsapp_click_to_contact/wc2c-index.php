<?php
/*
Plugin Name: Whatsapp Click to Chat
Description: This is a demo portfolio plugin created by Christian Chi.
Author: Christian Chi
*/

function Whatsapp_btn() {
  $info = '<a href="https://api.whatsapp.com/send?phone=+2348109580733&amp;text=I am interested in your service" target="_blank" class="whatsapp">
  <img src="'.plugins_url( "whatsapp_click_to_contact/assets/img/img.png" ).'" alt="whatsapp logo" width="50" height="50">
</a>';
echo $info;
}

add_action( 'wp_footer', 'Whatsapp_btn' );


// Register style sheet.
add_action( 'wp_enqueue_scripts', 'register_plugin_styles' );

/**
 * Register style sheet.
 */
function register_plugin_styles() {
  wp_register_style( 'whatsapp_click_to_contact_style', plugins_url( 'whatsapp_click_to_contact/assets/css/plugin.css' ) );
  wp_enqueue_style( 'whatsapp_click_to_contact_style' );
}

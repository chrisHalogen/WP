<?php
/*
Plugin Name: HID Augment WooCommerce
Plugin URI: https://github.com/chrishalogen
Description: Plugin to Augment Woocommerce
Version: 1.0
Author: Christian Chi
Author URI: https://github.com/chrishalogen
License: GPLv2 or later
Text Domain: wp_hid_aug_woo
*/

add_action('woocommerce_before_main_content','woocamp_open_div',5);

function woocamp_open_div(){
  if (is_product()){
    return;
  }

  echo '<div class="woocamp-wrap" style:="background-color:red;">';
}


add_action('woocommerce_after_main_content','woocamp_close_div',50);

function woocamp_close_div(){
  if (is_product()){
    return;
  }

  echo "Product Page";

  echo '</div>';
}

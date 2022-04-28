<?php
/*
Plugin Name:  WP Social CTA
Plugin URI:   https://github.com/chrishalogen
Description:  A plugin to display a social follow CTA after every single post in WordPress.
Version:      1.0
Author:       Chris Halogen
Author URI:   https://github.com/chrishalogen
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  hid_social_cta

*/

function hid_post_CTA($content) {

  // Only do this when a single post is displayed
  if ( is_single() ) {

    $content .= '<p class="follow-us">If you liked this article, kindly follow me on <a href="http://twitter.com/chrishalogen_" title="Chris Halogen on Twitter" target="_blank" rel="nofollow">Twitter</a> and <a href="https://www.facebook.com/christackoms" title="Christackoms on Facebook" target="_blank" rel="nofollow">Facebook</a>.</p>';
     
  }
  // Return the content
  return $content;

}

add_filter('the_content', 'hid_post_CTA');

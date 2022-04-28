<?php
/*
Plugin Name:  HID Post View Shortcode
Plugin URI:   https://github.com/chrishalogen
Description:  A plugin to display recent posts with excerpt and picture in form of a widget
Author:       Chris Halogen
Author URI:   https://github.com/chrishalogen
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  hid_social_cta

*/

defined( 'ABSPATH' ) || exit;

function add_css_to_head(){
  wp_enqueue_style('main-css',plugins_url('css/hpvs_index.css',__FILE__),array());
}

// Register the css in the head
add_filter('wp_head','add_css_to_head');

function hpvs_postsbycategory() {

  $the_query = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 4 ) );
  if ( $the_query->have_posts() ) {

    $string .= '<ul class="postsbycategory widget_recent_entries">';
    $outputHTML .= '<div class="hpvs_container">';

    while ( $the_query->have_posts() ) {
      $the_query->the_post();

      $outputHTML .= '<div><a href="' . get_the_permalink() .'">
                        <h4 class="hpvs-title">'. get_the_title() .'</h4>
                        <div class="hpvs-img-ex-container">
                            '. get_the_post_thumbnail($post_id, array( 50, 50) ) .'
                            <p class="hpvs-excerpt">'. get_the_excerpt() .'</p>
                        </div>
                        <p class="hpvs-read-more">Read More...</p></a>
                    </div>';

      if ( has_post_thumbnail() ) {
        $string .= '<li>';
        $string .= '<a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_post_thumbnail($post_id, array( 50, 50) ) . get_the_title() .'</a></li>';
        } else {

          $string .= '<li><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() .'</a></li>';
            }  }
          } else {
    // no posts found
          }
  $string .= '</ul>';
  $outputHTML .= '</div>';

  return $outputHTML;
  /* Restore original Post Data */
  wp_reset_postdata();

}
// Add a shortcode
add_shortcode('categoryposts', 'hpvs_postsbycategory');

// Enable shortcodes in text widgets

add_filter('widget_text', 'do_shortcode');

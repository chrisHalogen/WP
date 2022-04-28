<?php
/*
  Plugin Name: Post Views
  Plugin URI: https://github.com/chrishalogen
  description: A plugin that records post views and also contains functions to list posts by their popularity
  Version: 1.0
  Author: Christian Chi
  Author URI: https://github.com/chrishalogen
*/

function pvh_add_view() {
  if(is_single()) {
     global $post;
     $current_views = get_post_meta($post->ID, "pvh_views", true);
     if(!isset($current_views) OR empty($current_views) OR !is_numeric($current_views) ) {
        $current_views = 0;
     }
     $new_views = $current_views + 1;
     update_post_meta($post->ID, "pvh_views", $new_views);
     return $new_views;
  }
}

add_action("wp_head", "pvh_add_view");

function pvh_get_view_count() {
   global $post;
   $current_views = get_post_meta($post->ID, "pvh_views", true);
   if(!isset($current_views) OR empty($current_views) OR !is_numeric($current_views) ) {
      $current_views = 0;
   }

   return $current_views;
}


function pvh_show_views($singular = "view", $plural = "views", $before = "This post has: ") {
   global $post;
   $current_views = pvh_get_view_count();

   $views_text = $before . $current_views . " ";

   if ($current_views == 1) {
      $views_text .= $singular;
   }
   else {
      $views_text .= $plural;
   }

   echo $views_text;

}


function pvh_popularity_list($post_count = 10) {
  $args = array(
    "posts_per_page" => $post_count,
    "post_type" => "post",
    "post_status" => "publish",
    "meta_key" => "pvh_views",
    "orderby" => "meta_value_num",
    "order" => "DESC"
  );

  $pvh_list = new WP_Query($args);

  if($pvh_list->have_posts()) { echo "<ul>"; }

  while ( $pvh_list->have_posts() ) : $pvh_list->the_post();
    echo '<li><a href="'.get_permalink($post->ID).'">'.the_title(’, ’, false).'</a></li>';
  endwhile;

  if($pvh_list->have_posts()) { echo "</ul>";}
}

 // Place this code anywhere in the theme to trigger the posts by popularity
if (function_exists("pvh_popularity_list")) {
 pvh_popularity_list();
}

function pvh_popularity_list_shortcode() {
  $args = array(
    "posts_per_page" => 10,
    "post_type" => "post",
    "post_status" => "publish",
    "meta_key" => "pvh_views",
    "orderby" => "meta_value_num",
    "order" => "DESC"
  );

  $pvh_list = new WP_Query($args);

  $html_output = "";

  if($pvh_list->have_posts()) {
    $html_output .= "<ul>";
  }

  while ( $pvh_list->have_posts() ) : $pvh_list->the_post();
    $html_output = $html_output . '<li><a href="'.get_permalink($post->ID).'">'.the_title(’, ’, false).'</a></li>';
  endwhile;

  if($pvh_list->have_posts()) {
    $html_output .= "</ul>";
  }

  return $html_output;
}

add_shortcode('pvh_post_by_popularity', 'pvh_popularity_list_shortcode');

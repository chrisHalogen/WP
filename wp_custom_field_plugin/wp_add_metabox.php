<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Plugin Name:       WP Add Metabox
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       This plugin will add a metabox to blog posts
 * Version:           1.0.0
 * Author:            Halogenius Chris
 * License:           GPL v2 or later
*/

class WP_Add_MetaBox{
  public function __construct(){
    if (function_exists('register_deactivation_hook')) {
    	register_deactivation_hook(__FILE__,  array($this,'deactivationHook'));
    }

    if (function_exists('register_uninstall_hook')) {
    	register_uninstall_hook(__FILE__, $this , 'uninstallHook');
    }

    //header hook
    add_action('wp_head', array($this, 'filter_header'));

    // Registering the metabox
    add_action('add_meta_boxes', array($this,'add_metabox'))

  }

  public function deactivationHook(){
    delete_post_meta_by_key('WP_customfield_css');
  }

  public function uninstallHook(){

  }

  // Put stylesheet on to the head section
  	 public function filter_header(){
      global $post;
     	$WP_customfield_css = get_post_meta($post->ID, 'WP_customfield_css', true);

      if($WP_customfield_css == true){ ?>
      	<style type="text/css">
      		.entry-title{
      			color:<?php echo $WP_customfield_css; ?>;
              }
      	</style>
    <?php 	}
	 }

  public function add_metabox() {
		$post_types = array('post', 'page'); //Array for both posts and pages
	   add_meta_box(
       'custom-word_css', // id of metabox - required
       'Title Color', // Title of the metabox - required
       array( $this, 'create_word_css'), // Function that fills the metabox with it's content. Output should be echod - required
       $post_types, // The screens on which this metabox should be visible
       'normal' // Context within the screen where the post should be displayed
     );

     //metabox for the checkbox
      add_meta_box( 'custom_checkbox_css', 'Title Media CSS', array( $this, 'create_checkbox_css'), $post_types, 'normal' );
	 }

   // Adding HTML
 	 public function create_word_css() {
 	    $keyname = 'WP_customfield_css';
 	    global $post;
 	    // Get the value of the custom field
 	    $get_value = get_post_meta( $post->ID, $keyname, true );
      // Add nonce
	    wp_nonce_field( 'action-' . $keyname, 'nonce-' . $keyname );

	    // Output HTML
	    echo _e( 'Input color name to decorate the title.', 'page-title-customizer-for-twenty-series' )."<br>";
	    echo '<textarea name="' . $keyname . '" style="width:85%;height:200px;" placeholder="ex. red">' . $get_value . '</textarea>';
    }

}

$metabox = WP_Add_MetaBox()

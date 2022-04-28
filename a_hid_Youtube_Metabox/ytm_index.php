<?php
/*

Plugin Name: Youtube Under Blog
Plugin URI: https://github.com/chrishalogen
Version: 1.0
Description: This plugin will be used to add a URL field to WordPress 'post' post type.
Author: Christian Chi
Author URI: https://github.com/chrishalogen
License: GPU

*/

// Meta Box Class: YoutubeVideoURLFieldMetaBox
// Get the field value: $metavalue = get_post_meta( $post_id, $field_id, true );
class YoutubeVideoURLFieldMetaBox{

	private $screen = array(
		'post',

	);

	private $meta_fields = array(
                array(
                    'label' => 'Youtube Video URL',
                    'id' => 'youtube_video_url',
                    'type' => 'url',
                )

	);

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_fields' ) );
	}

	public function add_meta_boxes() {
		foreach ( $this->screen as $single_screen ) {
			add_meta_box(
				'YoutubeVideoURLField',
				__( 'YoutubeVideoURLField', '' ),
				array( $this, 'meta_box_callback' ),
				$single_screen,
				'normal',
				'default'
			);
		}
	}

	public function meta_box_callback( $post ) {
		wp_nonce_field( 'YoutubeVideoURLField_data', 'YoutubeVideoURLField_nonce' );
    echo 'This field will be added beneath all '. "'post'". ' post types. This will be the Youtube reference of individual lectures posted on the site';
		$this->field_generator( $post );
	}
	public function field_generator( $post ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			$meta_value = get_post_meta( $post->ID, $meta_field['id'], true );
			if ( empty( $meta_value ) ) {
				if ( isset( $meta_field['default'] ) ) {
					$meta_value = $meta_field['default'];
				}
			}
			switch ( $meta_field['type'] ) {
				default:
                $input = sprintf(
                            '<input %s id="%s" name="%s" type="%s" value="%s">',
                            $meta_field['type'] !== 'color' ? 'style="width: 100%"' : '',
                            $meta_field['id'],
                            $meta_field['id'],
                            $meta_field['type'],
                            $meta_value
                        );
			}
			$output .= $this->format_rows( $label, $input );
		}
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}

	public function format_rows( $label, $input ) {
		return '<tr><th>'.$label.'</th><td>'.$input.'</td></tr>';
	}

	public function save_fields( $post_id ) {
		if ( ! isset( $_POST['YoutubeVideoURLField_nonce'] ) )
			return $post_id;
		$nonce = $_POST['YoutubeVideoURLField_nonce'];
		if ( !wp_verify_nonce( $nonce, 'YoutubeVideoURLField_data' ) )
			return $post_id;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;
		foreach ( $this->meta_fields as $meta_field ) {
			if ( isset( $_POST[ $meta_field['id'] ] ) ) {
				switch ( $meta_field['type'] ) {
					case 'email':
						$_POST[ $meta_field['id'] ] = sanitize_email( $_POST[ $meta_field['id'] ] );
						break;
					case 'text':
						$_POST[ $meta_field['id'] ] = sanitize_text_field( $_POST[ $meta_field['id'] ] );
						break;
				}
				update_post_meta( $post_id, $meta_field['id'], $_POST[ $meta_field['id'] ] );
			} else if ( $meta_field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, $meta_field['id'], '0' );
			}
		}
	}
}

if (class_exists('YoutubeVideoURLFieldMetabox')) {
	new YoutubeVideoURLFieldMetabox;
};

function ytm_youtube_widget_single_post(){
  if (is_single() and 'post' == get_post_type()){
    the_post();
    $link = get_post_meta( get_the_ID(), $key = 'youtube_video_url', $single = true );

    if (strpos($link, '?v=') != false){
      $pos = strpos($link, '?v=');
      $start = $pos + 3;
      $ext = substr($link, $start, 11);

    } elseif (strpos($link, 'u.be/') != false) {
      $pos = strpos($link, 'u.be/');
      $start = $pos + 5;
      $ext = substr($link, $start, 11);

    } else {

        return '<p style:"color:red;font-weight:bold;font-size:16px">No Valid Video Found</p>';
    }

    $embbed_url = "https:/\/\www.youtube.com/embed/". $ext;
    $embbed_url_no_slash = stripslashes($embbed_url);

    $html_output = '<iframe width="560" height="315" src="'. $embbed_url_no_slash .'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

    return $html_output;

  }
}


add_shortcode( 'ytm_display_yt', 'ytm_youtube_widget_single_post' );

function ytm_youtube_widget_single_post_filter($content){
  if (is_single() and 'post' == get_post_type()){
    the_post();
    $link = get_post_meta( get_the_ID(), $key = 'youtube_video_url', $single = true );
		echo "this is ".$link;

    if (strpos($link, '?v=') != false){
      $pos = strpos($link, '?v=');
      $start = $pos + 3;
      $ext = substr($link, $start, 11);

    } elseif (strpos($link, 'u.be/') != false) {
      $pos = strpos($link, 'u.be/');
      $start = $pos + 5;
      $ext = substr($link, $start, 11);

    } else {

        $content .= '<br><br><p style:"color:red;font-weight:bold;font-size:16px">No Valid Video Found</p>'. $link . '<p>Done</p>';
				return $content;
    }

    $embbed_url = "https:/\/\www.youtube.com/embed/". $ext;
    $embbed_url_no_slash = stripslashes($embbed_url);

    $html_output = '<iframe width="560" height="315" src="'. $embbed_url_no_slash .'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

    $fullcontent = $content . $html_output;

		return $fullcontent;
  }
}

add_filter('the_content', 'ytm_youtube_widget_single_post_filter');

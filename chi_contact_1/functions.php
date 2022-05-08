<?php
// Error Log
if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}


// Request Handler for the form
function deliver_mail() {

  // if the submit button is clicked, send the email
  if ( isset( $_POST['cf-submitted'] ) ) {

    // sanitize form values
    $name    = sanitize_text_field( $_POST["cf-name"] );
    $email   = sanitize_email( $_POST["cf-email"] );
    $subject = sanitize_text_field( $_POST["cf-subject"] );
    $message = esc_textarea( $_POST["cf-message"] );

    // get the blog administrator's email address
    $to = get_option( 'admin_email' );

    $headers = "From: $name <$email>" . "\r\n";

    // If email has been process for sending, display a success message
    $error_log_output = "Name: $name\nEmail: $email\nSubject: $subject\nMessage: $message";

    write_log($error_log_output);
    $output = "";
    // if ( wp_mail( $to, $subject, $message, $headers ) ) {
    $output .= '<div>';
    $output .= '<p>Thanks for contacting me, expect a response soon.</p>';
    $output .= '</div>';
    // } else {
    //     $output .= 'An unexpected error occurred';
    // }
    echo $output;
  }
}


// Create Shortcode Content
function output_form(){
  $html_output = '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
  $html_output .= '<p>';
  $html_output .= 'Your Name (required) <br />';
  $html_output .= '<input type="text" name="cf-name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf-name"] ) ? esc_attr( $_POST["cf-name"] ) : '' ) . '" size="40" />';
  $html_output .= '</p>';
  $html_output .= '<p>';
  $html_output .= 'Your Email (required) <br />';
  $html_output .= '<input type="email" name="cf-email" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" size="40" />';
  $html_output .= '</p>';
  $html_output .= '<p>';
  $html_output .= 'Subject (required) <br />';
  $html_output .= '<input type="text" name="cf-subject" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["cf-subject"] ) ? esc_attr( $_POST["cf-subject"] ) : '' ) . '" size="40" />';
  $html_output .= '</p>';
  $html_output .= '<p>';
  $html_output .= 'Your Message (required) <br />';
  $html_output .= '<textarea rows="10" cols="35" name="cf-message">' . ( isset( $_POST["cf-message"] ) ? esc_attr( $_POST["cf-message"] ) : '' ) . '</textarea>';
  $html_output .= '</p>';
  $html_output .= '<p><input type="submit" name="cf-submitted" value="Send"/></p>';
  $html_output .= '</form>';

  echo $html_output;
}

// Run the shortcode
function cf_shortcode() {
  ob_start();
  deliver_mail();
  output_form();

  return ob_get_clean();
}

add_shortcode( 'HID_contact_form', 'cf_shortcode' );

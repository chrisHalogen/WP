<?php

// Enqueueing the main Css and Jquery
add_action( 'wp_enqueue_scripts', function() {
  wp_enqueue_style('font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css');
  wp_enqueue_style( 'main-css' , plugins_url( 'assets/css/chi_main.css', __FILE__ ), array() );
  wp_enqueue_script( 'jquery' );
});

// The function that handles ajax request from the frontend
function users_list_ajax_request() {

  // _REQUEST is the PHP superglobal bringing in all the data sent via ajax
  if ( isset($_REQUEST) ) {

    // Setting the query arguments to get the list of users
    $query_args = [
      'role'      => $_REQUEST['role_selected'],
      'order_by'  => $_REQUEST['order_by_selected'],
      'order'     => $_REQUEST['order_selected'],
    ];

    // A list of all Users on the site including Admin
    $all_wp_users = new WP_User_Query($query_args);

    // Getting the Results of the query
    $users_temp = $all_wp_users -> get_results();

    // Initializing output data to an empty array
    $output_data = [];

    // We don't need all the data retrieved by the query, most of the data retrieved are quite sensitive
    // Filter out only the name, email and role then append a new array for each user to the output data array
    foreach ($users_temp as $user_instance) {
      array_push( $output_data,[
          'name' => $user_instance -> data -> display_name,
          'email' => $user_instance -> data -> user_email,
          'role' => $user_instance -> roles[0],
        ]);
    }

    // Return the output data as a Json Success
    wp_send_json_success( $data = $output_data );
  }

  // Killing the Ajax function
  die();
}


// Hooking the ajax function into wordpress
add_action( 'wp_ajax_users_list_ajax_request', 'users_list_ajax_request' );
add_action( 'wp_ajax_nopriv_users_list_ajax_request', 'users_list_ajax_request' );

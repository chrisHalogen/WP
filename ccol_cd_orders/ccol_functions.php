<?php

// To deny anyone access to this file directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Enqueueing the main Css and Jquery
add_action( 'wp_enqueue_scripts', function() {
  wp_enqueue_style( 'main-css' , plugins_url( 'assets/ccol-main.css', __FILE__ ), array() );
  wp_enqueue_script( 'jquery' );
});

// Include PHP - JS File
add_filter('wp_head',function(){
  include(sprintf('%s/assets/ccol-main-js.php',dirname(__FILE__)));
});


add_action('admin_menu', 'ccol_plugin_menu');

function ccol_plugin_menu() {
    //adding plugin in menu
    add_menu_page('CCOL Sermons', //page title
        'CCOL Sermons', //menu title
        'manage_options', //capabilities
        'all-bookings', //menu slug
        'view_all_bookings', //function
        'dashicons-superhero'
    );

    //adding plugin in menu
    add_submenu_page( 'all-bookings',//parent page slug
        'View All Sermons',//$page_title
        'View All Sermons',// $menu_title
        'manage_options',// $capability
        'view-all-sermons',// $menu_slug,
        'view_all_sermons'// $function
    );

    //adding plugin in menu
    add_submenu_page( 'all-bookings',//parent page slug
        'Create CD Booking',//$page_title
        'Create CD Booking',// $menu_title
        'manage_options',// $capability
        'create-cd-booking',// $menu_slug,
        'create_cd_booking'// $function
    );

    //adding submenu to a menu
    add_submenu_page('all-bookings',//parent page slug
        'Add new Sermon',//page title
        'Add new Sermon',//menu titel
        'manage_options',//manage optios
        'add-new-sermon',//slug
        'insert_sermon'//function
    );

    //adding plugin in menu
    add_submenu_page( 'all-bookings',//parent page slug
        'Add new Preacher',//$page_title
        'Add new Preacher',// $menu_title
        'manage_options',// $capability
        'add-new-preacher',// $menu_slug,
        'insert_preacher'// $function
    );
}

function insert_preacher(){
  ?>
  <div class="wrap">
    <h2>Add Preacher</h2>
    <br>
    <form class="post" method="post" action="#">
      <label><b>Preacher's Name</b>&emsp;</label>
      <input type="text" placeholder="Enter Preacher's Name" name="name" size="50" required />
      <br>
      <br>
      <input type="submit" name="insert-preacher" value="Add Preacher">
    </form>
  </div>
  <?php
    if(isset($_POST['insert-preacher'])){

      global $wpdb;
      $preachers_name = $_POST['name'];
      $table_name = $wpdb->prefix . 'ccol_preachers';
        $wpdb->insert(
          $table_name,
          array(
            'name' => $preachers_name,
          )
        );

        echo '<p><strong>Inserted Successfully</strong><br><br>Feel free to add another</p>';

        exit;
    }
}

function insert_sermon(){
  ?>
  <div class="wrap">
    <h2>Add A Sermon</h2>
    <br>
    <form class="post" method="post" action="#">
      <label><b>Title</b>&emsp;</label>
      <input type="text" placeholder="Enter Sermon's title" name="title" size="50" required />
      <br>
      <br>
      <label><b>Select Preacher</b>&emsp;</label>
      <select name="preacher_id">

        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . 'ccol_preachers';
        $all_preachers = $wpdb->get_results("SELECT id,name from $table_name");

        foreach ($all_preachers as $current_preacher) {
            ?>
            <option value="<?= $current_preacher->id; ?>"><?= $current_preacher->name; ?></option>
        <?php } ?>

      </select>

      <br>
      <br>
      <label><b>Sermon's Date</b>&emsp;</label>
      <input type="date" placeholder="" name="sermon-date" size="50" required />
      <br>
      <br>
      <input type="submit" name="insert-sermon" value="Add Sermon">
    </form>
  </div>
  <?php

  if(isset($_POST['insert-sermon'])){
    $title = $_POST['title'];
    $preacher_id = $_POST['preacher_id'];
    $initial_date = strtotime($_POST['sermon-date']);
    $actual_date = date('Y-m-d H:i:s', $initial_date);


    $table_name = $wpdb->prefix . 'ccol_sermons';
      $wpdb->insert(
        $table_name,
        array(
          'title' => $title,
          'preacher_id' => $preacher_id,
          'sermonDate' => $actual_date
        )
      );

      echo '<p><strong>Inserted Successfully</strong><br><br>Feel free to add another</p>';

      exit;
  }
}

function create_cd_booking(){
  ?>
  <div class="wrap">
    <h2>Create a CD Booking</h2>
    <br>
    <form class="post" method="post" action="#">
      <label><b>First Name</b>&emsp;</label>
      <input type="text" placeholder="Enter First Name" name="fname" size="50" required />
      <br>
      <br>
      <label><b>Last Name</b>&emsp;</label>
      <input type="text" placeholder="Enter Last Name" name="lname" size="50" required />
      <br>
      <br>
      <label><b>Select Sermon</b>&emsp;</label>
      <select name="sermon_id">
        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . 'ccol_sermons';
        $all_sermons = $wpdb->get_results("SELECT id,title,preacher_id from $table_name");

        foreach ($all_sermons as $current_sermon) {
          $preacher_id = $current_sermon->preacher_id;
          $preachers_table = $wpdb->prefix . 'ccol_preachers';
          $preacher = $wpdb->get_results("SELECT name from $preachers_table where id=$preacher_id");
            ?>
            <option value="<?= $current_sermon->id; ?>"><?= $current_sermon->title; ?> by <?= $preacher[0]->name; ?></option>
        <?php } ?>

      </select>

      <br>
      <br>
      <label><b>Number of Copies</b>&emsp;</label>
      <input type="number" name="copies-number" min="1" value="1" required/>
      <br>
      <br>
      <input type="submit" name="create-booking" value="Create Booking">
    </form>
  </div>

  <?php
  if(isset($_POST['create-booking'])){
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $sermon_id = $_POST['sermon_id'];
    $copies_number = $_POST['copies-number'];
    $paid = 0;
    $delivered = 0;

    $table_name = $wpdb->prefix . 'ccol_sermons_booking';
      $wpdb->insert(
        $table_name,
        array(
          'firstName' => $first_name,
          'lastName' => $last_name,
          'sermon_id' => $sermon_id,
          'number_of_copies' => $copies_number,
          'paid' => $paid,
          'delivered' => $delivered
        )
      );

      echo '<p><strong>Inserted Successfully</strong><br><br>Feel free to add another</p>';

      exit;
  }
}

function view_all_sermons(){
  ?>
  <div class="wrap">
    <h2>All Sermons Available</h2>
    <table class="wp-list-table widefat striped">
      <thead>
        <tr>
          <th width="25%">Title</th>
          <th width="25%">Preacher</th>
          <th width="25%">Date</th>
          <th width="25%">Actions</th>
        </tr>
      </thead>
      <tbody>

          <?php
          global $wpdb;
          $table_name = $wpdb->prefix . 'ccol_sermons';
          $all_sermons = $wpdb->get_results("SELECT id,title,preacher_id,sermonDate from $table_name");

          foreach ($all_sermons as $current_sermon) {
            $preacher_id = $current_sermon->preacher_id;
            $preachers_table = $wpdb->prefix . 'ccol_preachers';
            $preacher = $wpdb->get_results("SELECT name from $preachers_table where id=$preacher_id");
              ?>
              <tr>
              <td><?= $current_sermon->title; ?></td>
              <td><?= $preacher[0]->name; ?></td>
              <td><?= $current_sermon->sermonDate; ?></td>
              <td><button>Update</button>&emsp;<button>Delete</button></td>
              </tr>
          <?php } ?>

      </tbody>
    </table>
  </div>

  <?php
}

function view_all_bookings(){
  ?>
  <div class="wrap">
    <h2>All Bookings Made</h2>
    <table class="wp-list-table widefat striped">
      <thead>
        <tr>
          <th width="10%">First Name</th>
          <th width="10%">Last Name</th>
          <th width="25%">Sermon</th>
          <th width="5%">Copies</th>
          <th width="15%">Booking Time</th>
          <th width="5%">Paid</th>
          <th width="5%">Delivered</th>
          <th width="25%">Actions</th>
        </tr>
      </thead>
      <tbody>

          <?php
          global $wpdb;
          $table_name = $wpdb->prefix . 'ccol_sermons_booking';
          $sermon_table = $wpdb->prefix . 'ccol_sermons';
          $preachers_table = $wpdb->prefix . 'ccol_preachers';

          $all_bookings = $wpdb->get_results("SELECT id,firstName,lastName,sermon_id,number_of_copies,order_time,paid,delivered from $table_name");

          foreach ($all_bookings as $current_booking) {
            $sermon_id = $current_booking->sermon_id;

            $sermon = $wpdb->get_results("SELECT title,preacher_id from $sermon_table where id=$sermon_id");

            $sermon_title = $sermon[0]->title;
            $preacher_id = $sermon[0]->preacher_id;

            $preacher = $wpdb->get_results("SELECT name from $preachers_table where id=$preacher_id");

            $preacher_name = $preacher[0]->name;

            //------------------------------
            $paid_bg = ($current_booking->paid == 0)?"red":"green";
            $delivered_bg = ($current_booking->delivered == 0)?"red":"green";

            $paid_text = ($current_booking->paid == 0)?"No":"Yes";
            $delivered_text = ($current_booking->delivered == 0)?"No":"Yes";

              ?>
              <tr>
              <td><?= $current_booking->firstName; ?></td>
              <td><?= $current_booking->lastName; ?></td>
              <td><?= $sermon_title; ?> by <?= $preacher_name; ?></td>
              <td><?= $current_booking->number_of_copies; ?></td>
              <td><?= $current_booking->order_time; ?></td>
              <td style="background-color:<?= $paid_bg; ?>;color:white;"><?= $paid_text; ?></td>
              <td style="background-color:<?= $delivered_bg; ?>;color:white;"><?= $delivered_text; ?></td>
              <td><button>Mark As Paid</button>&emsp;<button>Mark As Delivered</button></td>
              </tr>
          <?php } ?>

      </tbody>
    </table>
  </div>

  <?php
}


// The function that handles ajax request from the frontend
function output_sermons_ajax_request() {

  // _REQUEST is the PHP superglobal bringing in all the data sent via ajax
  if ( isset($_REQUEST) ) {

    global $wpdb;
    $table_name = $wpdb->prefix . 'ccol_sermons';
    $all_sermons = $wpdb->get_results("SELECT id,title,preacher_id,sermonDate from $table_name");

    $output_data = [];

    foreach ($all_sermons as $current_sermon) {
      $preacher_id = $current_sermon->preacher_id;
      $preachers_table = $wpdb->prefix . 'ccol_preachers';
      $preacher = $wpdb->get_results("SELECT name from $preachers_table where id=$preacher_id");

      array_push($output_data,[
        'id' => $current_sermon->id,
        'title' => $current_sermon->title,
        'preacher' => $preacher[0]->name,

      ]);

  }
  // Return the output data as a Json Success
  wp_send_json_success( $data = $output_data );

  // Killing the Ajax function
  die();
  }
}


// Hooking the ajax function into wordpress
add_action( 'wp_ajax_output_sermons_ajax_request', 'output_sermons_ajax_request' );
add_action( 'wp_ajax_nopriv_output_sermons_ajax_request', 'output_sermons_ajax_request' );

// The function that handles ajax request from the frontend
function create_new_booking_ajax_request() {

  // _REQUEST is the PHP superglobal bringing in all the data sent via ajax
  if ( isset($_REQUEST) ) {

    $first_name = $_REQUEST['fname'];
    $last_name = $_REQUEST['lname'];
    $sermon_id = $_REQUEST['sermon_id'];
    $copies = $_REQUEST['no_of_copies'];
    $paid = 0;
    $delivered = 0;

    global $wpdb;
    $table_name = $wpdb->prefix . 'ccol_sermons_booking';
      $wpdb->insert(
        $table_name,
        array(
          'firstName' => $first_name,
          'lastName' => $last_name,
          'sermon_id' => $sermon_id,
          'number_of_copies' => $copies,
          'paid' => $paid,
          'delivered' => $delivered
        )
      );

    // Return the output data as a Json Success
    wp_send_json_success( $data = "New Booking Successfully Created" );
  }

  // Killing the Ajax function
  die();
}


// Hooking the ajax function into wordpress
add_action( 'wp_ajax_create_new_booking_ajax_request', 'create_new_booking_ajax_request' );
add_action( 'wp_ajax_nopriv_create_new_booking_ajax_request', 'create_new_booking_ajax_request' );


//----------Shortcode-----------------
function shortcode_output(){
  $html_output = '<div class="ccol-cta-button-wrapper" id="ccol-cta-wrapper">
      <button id="ccol-cta-button">Click Here to Get Started</button>
    </div>
    <div id="ccol-id01" class="ccol-modal">
  <span class="ccol-close" id="ccol-close-x" title="Close Modal">&#10005;</span>
  <form id="booking-form" class="ccol-modal-content ccol-animate" action="#">
    <div class="ccol-container">
      <div class="ccol-grid-container">
        <div class="ccol-half-line">
          <label><b>First Name</b></label>
          <input id="input-first-name"
            type="text"
            placeholder="Enter First Name"
            name="first-name"
            required
          />
        </div>
        <div class="ccol-half-line">
          <label><b>Last Name</b></label>
          <input id="input-last-name"
            type="text"
            placeholder="Enter Last Name"
            name="last-name"
            required
          />
        </div>
        <div class="ccol-half-line ccol-wide">
          <label><b>Select Sermon</b></label>
          <select id="select_sermon_wrapper" name="sermon_id">
            <option value="0">Select Sermon</option>
            <option value="1">Rev. Azuka Ogbolumani</option>
            <option value="2">Rev. Prof. Yemisi Obashoro John</option>
            <option value="3">Rev. Prof. Wale Okunuga</option>
            <option value="4">Rev. Fajemirokun</option>
            <option value="5">Rev. Bolaji Owasanye</option>
            <option value="6">Rev. Bayo Awala</option>
          </select>
        </div>

        <div class="ccol-half-line ccol-wide">
          <label><b>Nummber of Copies</b></label>
          <input id="input-copies"
            type="number"
            name="copies-number"
            min="1"
            value="1"
          />
        </div>
        <div class="ccol-half-line-btn">
          <button type="button" class="ccol-cancelbtn" id="ccol-cancel-btn">Cancel</button>
        </div>
        <div class="ccol-half-line-btn">
          <button type="submit" class="ccol-signupbtn" id="ccol-booking-btn">Place Booking</button>
        </div>
      </div>
    </div>
  </form>
</div>
    ';
  return $html_output;
}

add_shortcode( 'ccol-cd-booking', 'shortcode_output' );

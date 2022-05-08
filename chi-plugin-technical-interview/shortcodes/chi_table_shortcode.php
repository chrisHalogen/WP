<?php

// To deny anyone access to this file directly
if ( ! defined( 'ABSPATH' ) ) exit;

// The function creating the output of the Shortcode
function output_table(){

  // The default HTML Output showing that the content is restricted to admins alone
  $html_output = '<span style="color:red;font-size:20px;">This content is restricted to admin users only</span>';

  // Verifying that the current user trying to view the contents of the current page is a site administrator
  if ( is_user_logged_in() ) {
    $user = wp_get_current_user();
    $roles = ( array ) $user->roles;

    if ( in_array("administrator", $roles) ){

      // If the current user is an administrator, set the HTML output to the desired content html
      $html_output = '<div id="chi-full-widget-container">
          <div class="chi-filter-container">
            <h4>Table Filters</h4>
            <p>Select options and apply filter to view users</p>
            <form id="users-list-form">
              <table>
                <tbody>
                  <tr>
                    <td><label for="role">Filter by Role</label></td>
                    <td>
                      <select class="select" name="Roles" id="select-user-role">
                        <option value="">Select</option>
                        <option value="author">Author</option>
                        <option value="subscriber">Subscriber</option>
                        <option value="editor">Editor</option>
                      </select>
                    </td>
                    <td rowspan="3">
                      <input id="submit-btn" type="submit" value="Apply Filters" />
                    </td>
                  </tr>
                  <tr>
                    <td><label for="order_by">Order By</label></td>
                    <td>
                      <select class="select" name="Order_by" id="select-order_by">
                        <option value="">Select</option>
                        <option value="name">Name</option>
                        <option value="email">Email</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td><label for="order">Order</label></td>
                    <td>
                    <div class="radio ASC" id="wrapper-ASC" style="cursor: pointer">
                      <input
                        type="radio"
                        name="list-order"
                        id="select-user-role"
                        value="ASC"
                        checked
                      />
                      <label for="radio"></label>
                      <span>Asc</span>
                    </div>
                    <div class="radio DESC" id="wrapper-DESC" style="cursor: pointer">
                      <input
                        type="radio"
                        name="list-order"
                        id="select-user-role"
                        value="DESC"
                      />
                      <label for="radio"></label>
                      <span>Desc</span>
                    </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </form>
          </div>

          <div class="chi-table-container">
            <table>
              <thead>
                <tr>
                  <td>Name</td>
                  <td>Email</td>
                  <td>Role</td>
                </tr>
              </thead>
              <tbody id="users-table-body">

              </tbody>
            </table>
          </div>
          <center>
            <div id="chi-pagination" class="chi-pagination">

            </div>
          </center>
        </div>';
      }
  }

  // Return the HTML Output data
  return $html_output;
}

// Register the shortcode
add_shortcode( 'show_users_table', 'output_table' );

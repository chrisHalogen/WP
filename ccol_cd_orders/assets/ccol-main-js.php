<?php

// To deny anyone access to this file directly
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<script>

<?php
    echo 'let ajaxurl = "' . admin_url('admin-ajax.php') . '";'  ;
?>

jQuery( document ).ready( function($) {

  let all_sermons = [];
  let sermon_id = 0;
  let first_name = '';
  let last_name = '';
  let number_of_copies = 1;

  // Function to retrieve Sermons
  $.fn.GetSermons = function(){

    // Ajax call
    $.ajax({
      url: ajaxurl, // The wordpress Ajax URL echoed on line 4
      data: {
          // The action is the WP function that'll handle this ajax request
          'action' : 'output_sermons_ajax_request'
        },
        success:function( data ) {
          let all_sermons = data['data'];
          let wrapper = document.getElementById('select_sermon_wrapper');

          let sermons_html = "";
          for ( let i = 0; i < all_sermons.length; i++ ) {

            let id = all_sermons[i]['id'];
            let title = all_sermons[i]['title'];
            let preacher = all_sermons[i]['preacher'];

            sermons_html += '<option value="' + id + '">' + title + ' by '+ preacher +'</option>'
          }

          // Set Wrapper's innerHTML to the HTML output
          wrapper.innerHTML = sermons_html;

          sermon_id = document.getElementById('select_sermon_wrapper').value;

        },
        error: function( errorThrown ){
            window.alert( errorThrown );
        }
    });

  }

  // Function to retrieve Sermons
  $.fn.SermonOnChange = function(){
    let sermons_options = document.getElementById('select_sermon_wrapper');
    let sermon_id = sermons_options.value;

    sermons_options.addEventListener('change', function () {
      sermon_id = sermons_options.value;
    });
  }

  // Function to retrieve Sermons
  $.fn.PlaceBooking = function(){
    let booking_form = document.getElementById('booking-form');

    booking_form.addEventListener('submit', function (e) {
      e.preventDefault();
      first_name = document.getElementById('input-first-name').value;
      last_name = document.getElementById('input-last-name').value;
      number_of_copies = document.getElementById('input-copies').value;

      // Ajax call
      $.ajax({
        url: ajaxurl, // The wordpress Ajax URL echoed on line 4
        data: {
            // The action is the WP function that'll handle this ajax request
            'action' : 'create_new_booking_ajax_request',
            'fname':first_name,
            'lname':last_name,
            'sermon_id':sermon_id,
            'no_of_copies': number_of_copies
          },
          success:function( data ) {
            document.getElementById('ccol-id01').style.display='none';

            document.getElementById('ccol-cta-wrapper').innerHTML = "<p><strong>Booking was  Successful</strong></p>"

          },
          error: function( errorThrown ){
              window.alert( errorThrown );
          }
      });

    });
  }

  // Function responsible for on page load
  $.fn.OnPageLoad = function(){

    // Get all sermons
    $.fn.GetSermons();
    $.fn.SermonOnChange();
    $.fn.PlaceBooking();

    let cta_button = document.getElementById('ccol-cta-button');
    cta_button.addEventListener('click', function () {
      // console.log('Clicked');
      document.getElementById('ccol-id01').style.display='block';
    })

    let close_btn = document.getElementById('ccol-close-x');
    close_btn.addEventListener('click', function () {
      // console.log('Clicked');
      document.getElementById('ccol-id01').style.display='none';
    })

    let cancel_btn = document.getElementById('ccol-cancel-btn');
    cancel_btn.addEventListener('click', function () {
      // console.log('Clicked');
      document.getElementById('ccol-id01').style.display='none';
    })
  }

  $.fn.OnPageLoad();
})

</script>

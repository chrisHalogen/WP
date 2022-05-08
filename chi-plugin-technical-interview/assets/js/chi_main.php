<script type="text/javascript">

  // Generating the default ajax URL for WordPress using php
  <?php
    echo 'let ajaxurl = "' . admin_url('admin-ajax.php') . '";'  ;
  ?>

  // Jquery Kicks in
  jQuery( document ).ready( function($) {

    //--------------------------------------
    // Function responsible for the radio button action
    $.fn.checkRadioButton = function( unique_class ){
      let selector = "wrapper-" + unique_class;

      let radio_button_div = document.getElementById( selector );

      radio_button_div.addEventListener('click', function () {
        let selector = "#users-list-form ." + unique_class + " #select-user-role";
        document.querySelector(selector).checked = true;

      })
    }

    $.fn.checkRadioButton("ASC"); // Radio Button for Ascending Order
    $.fn.checkRadioButton("DESC"); // Radio Button for Descending Order

    //--------------------------------------
    // Declaring all the variables required for proper pagination
    // Div containing the rows
    const table_body_wrapper = document.getElementById('users-table-body');

    // Div containing the rows
    const pagination_wrapper = document.getElementById('chi-pagination');

    // Default to a current page of 1
    let current_page = 1;

    // Max number of rows per page
    let rows_per_page = 10;

    //-----------------------------------------------
    // Users Display Function
    $.fn.DisplayUsers = function( items, wrapper, rows_per_page, page ){

      // making sure that the wrapper's inner html is empty
      wrapper.innerHTML = "";

      // Decrement page by 1 to get the starting number of the content
      page--;

      // Declare your starting point for the loop
      let loop_start = page * rows_per_page;

      // The ending point for the loop
      let end = loop_start + rows_per_page;

      // Items to display based on pagination
      let paginated_items = items.slice( loop_start, end );

      // Using a for loop to build the paginated items display section
      let html_output = "";

      for ( let i = 0; i < paginated_items.length; i++ ) {

        html_output += '<tr>';
        let output_name = paginated_items[i]['name'];
        let output_email = paginated_items[i]['email'];

        // Capitalizing the first Alphabet of the role
        let output_role = paginated_items[i]['role'].charAt( 0 ).toUpperCase() + paginated_items[i]['role'].slice( 1 );

        // Building the HTML Output
        html_output += '<td>' + output_name + '</td>' + '<td>' + output_email + '</td>' + '<td>' + output_role + '</td></tr>';
      }

      // Set Wrapper's innerHTML to the HTML output
      wrapper.innerHTML = html_output;

    }

    //-----------------------------------------------
    // Pagination Button Function -> Creating individual pagination buttons
    $.fn.PaginationButton = function( page, items ){
      let button = document.createElement( 'a' );
    	button.innerText = page;

    	if (current_page == page) button.classList.add('active');

      // Event Listener for individual buttons
    	button.addEventListener( 'click' , function () {
    		current_page = page;

        $.fn.DisplayUsers( items, table_body_wrapper, rows_per_page, current_page );

    		let current_btn = document.querySelector( '.chi-pagination a.active' );
    		current_btn.classList.remove( 'active' );

    		button.classList.add( 'active' );
    	});

    	return button;
    }

    //-----------------------------------------------
    // Pagination Div Function -> Function Creating the whole pagination
    $.fn.SetupPagination = function( items, wrapper, rows_per_page ){
      wrapper.innerHTML = "";

      // Calculating the total number of pages to expect
    	let page_count = Math.ceil( items.length / rows_per_page );

    	for ( let i = 1; i < page_count + 1; i++ ) {
    		let btn = $.fn.PaginationButton( i, items );
    		wrapper.appendChild( btn );
    	}
    }

    //-----------------------------------------------
    // Query_WP_DB Function -> Function making the ajax call
    $.fn.Query_WP_DB = function( order_by, role, order ){

      // Ajax call
      $.ajax({
        url: ajaxurl, // The wordpress Ajax URL echoed on line 4
        data: {
            // The action is the WP function that'll handle this ajax request
            'action'            :'users_list_ajax_request',
            'role_selected'     : role,
            'order_by_selected' : order_by,
            'order_selected'    : order
          },
          success:function( data ) {

            // Set current page to 1 everytime the WordPress is queried successfully
            current_page = 1;

            // Display the Users
            $.fn.DisplayUsers( data['data'], table_body_wrapper, rows_per_page, current_page );

            // Display the Pagination
            $.fn.SetupPagination( data['data'], pagination_wrapper, rows_per_page );

          },
          error: function( errorThrown ){
              window.alert( errorThrown );
          }
      });

    }

    $( "#users-list-form" ).submit( function( event ) {
      // Prevent default action of form submission to URL and page reload
      event.preventDefault();

      // Mine form data
      let role_selected = $( '#select-user-role :selected' ).val();
      let order_by_selected = $( '#select-order_by :selected' ).val();
      let order_selected = $( "input[type=radio][name=list-order]:checked" ).val();

      $.fn.Query_WP_DB( order_by_selected,role_selected,order_selected );

    });

    $.fn.Query_WP_DB( "","","ASC" );
  });
</script>;

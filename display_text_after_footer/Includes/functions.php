<?php
/*
 * Add my new menu to the Admin Control Panel
 */

// Hook the 'admin_menu' action hook, run the function named 'add_admin_menu()'
add_action( 'admin_menu', 'add_admin_menu' );

function add_admin_menu()
{
      add_menu_page(
        'Footer Text', // Title of the page
        'Footer Text', // Text to show on the menu link
        'manage_options', // Capability requirement to see the link
        'includes/footer_text_admin.php' // The 'slug' - file to display when clicking the link
    );
}
